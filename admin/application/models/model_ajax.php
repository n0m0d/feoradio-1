<?php

class model_ajax extends Model
{
	
	function get_cities($search)
	{	
		$search = htmlspecialchars(addslashes($search)); 
		return $this->db->GetAll("select city_id, TRIM(city_title) as city_title, TRIM(city_area) as city_area, TRIM(city_region) as city_region, `country`, TRIM(concat(TRIM(city_title), ', ', TRIM(city_region), ', ',  TRIM(city_area))) as fullname from `vk_cities` where TRIM(concat(TRIM(city_title), ', ', TRIM(city_region), ', ',  TRIM(city_area))) like '$search%' order by `city_id` asc LIMIT 50");
		
	}
	
	function addAttribute($at_name, $at_type, $at_key, $at_comment, $at_defval){
		$query = "insert into `mvc_attributes` (`at_name`, `at_type`, `at_key`, `at_comment`, `at_defval`) values ('{$at_name}', '{$at_type}', '{$at_key}', '{$at_comment}', '{$at_defval}')";
		$this->db->query($query);
		return $this->db->insertId();
	}
	
	function updateAttribute($at_id, $at_name, $at_type, $at_key, $at_comment, $at_defval){
		$query = "update `mvc_attributes` set `at_name` = '{$at_name}', `at_type` = '{$at_type}', `at_key` = '{$at_key}', `at_comment` = '{$at_comment}', `at_defval` = '{$at_defval}' where `at_id` = {$at_id}";
		return $this->db->query($query);
	}
	
	function deleteAttributeOption($option_id){
		if(is_array($option_id)){
			for($i=0;$i<count($option_id);$i++){	
				$where .= "`option_id` = ".$option_id[$i];
				if(isset($option_id[$i+1])) $where .= " or ";
			}
			$query = "delete from `mvc_attributes_options` where ".$where;
			return $this->db->query($query);
		}
	}
	
	function updateAttributeOption($options){
		if(is_array($options)){
			for($i=0;$i<count($options);$i++){	
				$query = "update `mvc_attributes_options` set `option_name` = '".$options[$i]['name']."', `option_key` = '".$options[$i]['key']."', `option_default` = '".$options[$i]['defval']."'  where `option_id` = ".$options[$i]['id'];
				$this->db->query($query);
			}
		}
	}
	
	function addAttributeOption($options, $at_id){
		if(is_array($options)){
			for($i=0;$i<count($options);$i++){	
				if($options[$i]['name'] != ''){
					$query = "insert into `mvc_attributes_options` (`at_id`, `option_name`, `option_key`, `option_default`) values ({$at_id}, '".$options[$i]['name']."', '".$options[$i]['key']."', '".$options[$i]['defval']."')";
					$this->db->query($query);
					$options[$i]['option_id'] = $this->db->insertId();
					$options[$i]['at_id'] = $at_id;
				}
			}
			return $options;
		}
	}
	
	function deleteAttributes($attributes){
		$query = "delete from `mvc_attributes` where `at_id` in (?a)";
		$this->db->query($query,$attributes);
	}
	
	function deleteOptions($attributes){
		$query = "delete from `mvc_attributes_options` where `at_id` in (?a)";
		$this->db->query($query, $attributes);
	}
	
	function deletePages($pages){
		$query = "delete from `mvc_posts` where `post_id` in (?a)";
		$this->db->query($query, $pages);
		
		$query = "delete from `mvc_posts_meta` where `meta_post_id` in (?a)";
		$this->db->query($query, $pages);
		
	}
	
	function deletePagesAttributes($pages){
		$query = "delete from `mvc_posts_at` where `post_id` in (?a)";
		$this->db->query($query, $pages);
	}
	
	function deleteUsers($users){
		$query = "delete from mvc_users where user_id in (?a)";
		$this->_log("Удален список пользователей id: ".implode(', ', $users), "users delete");
		$this->db->query($query, $users);
	}
	
	function deleteProducts($items){
		$query = "delete from mvc_products where prod_id in (?a)";
		$this->_log("Удален список т/у id: ".implode(', ', $items), "products delete");
		$this->db->query($query, $items);
	}
	
	function deleteGroups($items){
		$query = "delete from mvc_products_groups where group_id in (?a)";
		$this->_log("Удален список групп товаров id: ".implode(', ', $items), "productgroups delete");
		$this->db->query($query, $items);
	}
	
	function deleteInvoices($items){
		$this->db->query("delete from mvc_invoices where inv_id in (?a)", $items);
		foreach($items as $i=>$item){
			$bascket = $this->get_bascket_by_inv($item);
			$this->clearBasket($bascket['bas_id']);
		}
		$this->db->query("delete from mvc_basckets where bas_inv_id in (?a)", $items);
		$this->_log("Удален список счетов id: ".implode(', ', $items), "invoices delete");
		
	}
	
	function deleteUsersContacts($users){
		$query = "delete from mvc_users_contacts where contact_user_id in (?a)";
		$this->db->query($query, $users);
	}
	
	function deleteUsersPermissions($users){
		$query = "delete from mvc_access where user_id in (?a)";
		$this->db->query($query, $users);
	}
	
	
	function addPage($page){
		$post_name = 	trim($page['post_name']);
		$post_name_ru = trim($page['post_name_ru']);
		$post_content = trim($page['post_content']);
		$post_template =  trim($page['post_template']);
		
		$data = array(
						'post_name_ru'=>$post_name_ru,
						'post_status'=>$page['post_status'],
						'post_author'=>$this->controller->uid,
						'post_type'=> 'page',
					);
					
		if(isset($page['post_name'])){ $data['post_name']=$post_name; }
		if(isset($page['post_content'])){ $data['post_content']=$post_content; }
					
		if(!empty($post_template) and $post_template !='' ){
			$data['post_template'] = $post_template;
		} else {
			$set_null_template = '`post_template` = NULL, ';
		}
		
		if ($page['post_parent'] == 'null') {
		  $sqlpart = "`post_parent` = NULL";
		} else {
		  $sqlpart = $this->db->parse("`post_parent` = ?i", $page['post_parent']);
		}
		
		$query = "insert into `mvc_posts` set `post_date` = NOW(), `post_modified` = NOW(), ".$sqlpart.", ?u";
		$this->db->query($query, $data);
		
		$post_id = $this->db->insertId();
			$data_meta = array(
						'meta_post_id' => (int)$post_id,
						'post_title' => trim($page['post_title']),
						'post_description' => trim($page['post_description']),
						'post_keywords' => trim($page['post_keywords']),
						'post_image' => trim($page['post_image'])
					);
			$query_meta = 'INSERT INTO `mvc_posts_meta` SET ?u ON DUPLICATE KEY UPDATE ?u';
			$this->db->query($query_meta, $data_meta, $data_meta);
			
		return $this->db->GetRow('select * from `mvc_posts` where `post_id` = ?i', $post_id);
	}	
	
	function addUser($user){
		$user_id=$user['user_id'];
		$user_login=$user['user_login'];
		$user_name=$user['user_name'];
		$user_status=$user['user_status'];
		
		if(!empty($user['user_password'])) { $password = md5($user['user_password']); } else { $password = md5(generatePassword(15,7));  }
		$user_log = $this->createUser($user_login, $user_name, $password, $user_status);
		$user_id = $user_log['user_id'];
		
		if($user_log['error']=="0"){
			
			$user_phones=explode(',', $user['user_phones']); 
			foreach($user_phones as $i=>$item){
				$val = trim($item);if( !empty($val)){
				$this->addUserContact($user_id, 'phone', $val );}
			}
			
			$user_emails=explode(',', $user['user_emails']); 
			foreach($user_emails as $i=>$item){
				$val = trim($item);if( !empty($val)){
				$this->addUserContact($user_id, 'email', $val );}
			}
			
			$user_addres=explode(',', $user['user_addres']); 
			foreach($user_addres as $i=>$item){
				$val = trim($item);if( !empty($val)){
				$this->addUserContact($user_id, 'address', $val );}
			}
			
			$user_addres_custom = $user['user_addres_custom'];
			foreach($user_addres_custom as $i=>$item){
				$val = trim($item['contact_val']);
				if( !empty($val)){
					$this->addUserContact($user_id, trim($item['contact_type']), $val);
				}
			}
			
			$user_permissions=$user['user_permissions'];
			foreach($user_permissions as $i=>$item){
				if(trim($item['ac_val'])!=0){
				$perm = array(
							'user_id' => $user_id,
							'ac_res' => trim($item['ac_res']),
							'ac_val' => trim($item['ac_val']),
						);
				$this->db->query('INSERT INTO `mvc_access` SET ?u', $perm);
				}
			}
			
			return $this->db->GetRow('select * from `mvc_users` where `user_id` = ?i',$user_id);
		}
		else return false;
	}
	
	function addProduct($product){
		$id = $product['main_id'];
		
		$data = array(
			'prod_name' => $product['main_name'],
			'prod_status' => $product['main_status'],
			'prod_cost' => $product['main_cost'],
			'prod_discount' => $product['main_discount'],
			'prod_photo' => $product['main_photo'],
			'prod_group' => $product['main_group'],
			'prod_description' => $product['main_description'],
		);
		
		$query = 'insert into `mvc_products` set prod_createdate=NOW(), ?u';
		$insert = $this->db->query($query, $data);
		
		if($insert){
			$id = $this->db->insertId();
			return $this->db->GetRow('select * from `mvc_products` where `prod_id` = ?i', $id);
		}
		else return false;
	}
	
	function addGroup($group){
		$id = $group['main_id'];
		
		$data = array(
			'group_name' => $group['main_name'],
			'group_status' => $group['main_status'],
			'group_photo' => $group['main_photo'],
			'group_parent' => $group['main_parent'],
			'group_description' => $group['main_description'],
		);
		
		$query = 'insert into `mvc_products_groups` set group_createdate=NOW(), ?u';
		$insert = $this->db->query($query, $data);
		
		if($insert){
			$id = $this->db->insertId();
			return $this->db->GetRow('select * from `mvc_products_groups` where `group_id` = ?i', $id);
		}
		else return false;
	}
	
	function add_mail_template($page){
		$data = array(
						'post_name'=>$page['post_name_ru'],
						'post_content'=>$page['post_content'],
						'post_author'=>$this->controller->uid,
						'post_status'=>1,
						'post_type'=> 'mail-tmp'
					);
	
		$query = "insert into `mvc_posts` set `post_date` = NOW(), `post_modified` = NOW(), ?u";
		$this->db->query($query, $data);
		$post_id = $this->db->insertId();
		return $this->db->GetRow('select * from `mvc_posts` where `post_id` = ?i', $post_id);
	}
	
	function updatePage($page){
		$post_name = 	trim($page['post_name']);
		$post_name_ru = trim($page['post_name_ru']);
		$post_content = trim($page['post_content']);
		$post_template =  trim($page['post_template']);
		
		$data = array(
						'post_name_ru'=>$post_name_ru,
						'post_status'=>$page['post_status']
					);
					
		if(isset($page['post_name'])){ $data['post_name']=$post_name; }
		if(isset($page['post_content'])){ $data['post_content']=$post_content; }
					
		if(!empty($post_template) and $post_template !='' ){
			$data['post_template'] = $post_template;
		} else {
			$set_null_template = '`post_template` = NULL, ';
		}
		
		if ($page['post_parent'] == 'null') {
		  $sqlpart = "`post_parent` = NULL";
		} else {
		  $sqlpart = $this->db->parse("`post_parent` = ?i", $page['post_parent']);
		}
		
		$query = 'update `mvc_posts` set `post_modified` = NOW(), '.$set_null_template.$sqlpart.', ?u where `post_id` = ?i';
		$update = $this->db->query($query, $data, $page['post_id']);
			
			$data_meta = array(
						'meta_post_id' => (int)$page['post_id'],
						'post_title' => trim($page['post_title']),
						'post_description' => trim($page['post_description']),
						'post_keywords' => trim($page['post_keywords']),
						'post_image' => trim($page['post_image'])
					);
			$query_meta = 'INSERT INTO `mvc_posts_meta` SET ?u ON DUPLICATE KEY UPDATE ?u';
			$this->db->query($query_meta, $data_meta, $data_meta);
		if($update){
			return $this->db->GetRow('select * from `mvc_posts` where `post_id` = ?i',$page['post_id']);
		}
	}
	
	function updateInvoice($invoice){
		if($invoice['def_status']!="1"){
		$data = array(
						'inv_summ'=>$invoice['inv_summ'],
						'inv_uid'=>$invoice['bas_avtor'],
						'inv_status'=>$invoice['inv_status'],
						'inv_desc'=>trim($invoice['inv_desc']),
						'inv_bas_desc'=>trim($invoice['bas_desc']),
					);
		if($invoice['inv_status']=='1') {
			$data['inv_paydate'] = date('Y-m-d H:i:s');
		}
		}
		else {
			$data = array(
						'inv_desc'=>trim($invoice['inv_desc']),
					);
		}
		
		$query = 'update `mvc_invoices` set `inv_lastupdate` = NOW(), ?u where `inv_id` = ?i';			
		$update = $this->db->query($query, $data, $invoice['inv_id']);
		if($update){
			return $this->db->GetRow('SELECT *, (SELECT user_name FROM mvc_users WHERE mvc_users.user_id = mvc_invoices.inv_avtor) AS inv_avtor_name FROM mvc_invoices WHERE inv_id = ?i',$invoice['inv_id']);
		}
		else return false;
	}
	
	function createInvoice($invoice){
		$data = array(
						'inv_summ'=>$invoice['inv_summ'],
						'inv_avtor'=>$this->controller->uid,
						'inv_uid'=>$invoice['bas_avtor'],
						'inv_status'=>$invoice['inv_status'],
						'inv_desc'=>trim($invoice['inv_desc']),
						'inv_bas_desc'=>trim($invoice['bas_desc']),
						'inv_ip'=>getIp(),
						'inv_agent'=>$_SERVER['HTTP_USER_AGENT'],
					);
		if($invoice['inv_status']=='1') {
			$data['inv_paydate'] = date('Y-m-d H:i:s');
		}
		$query = 'INSERT INTO `mvc_invoices` set inv_date=NOW(), inv_lastupdate = NOW(), ?u';			
		$update = $this->db->query($query, $data);
		if($update){
			return $this->db->GetRow('SELECT *, (SELECT user_name FROM mvc_users WHERE mvc_users.user_id = mvc_invoices.inv_avtor) AS inv_avtor_name FROM mvc_invoices WHERE inv_id = ?i',$this->db->insertId());
		}
		else return false;
	}
	
	function updateBascket($bas){
		$data = array(
						'bas_uid'=>$bas['bas_avtor'],
						'bas_desc'=>trim($bas['bas_desc']),
					);
		$query = 'update `mvc_basckets` set ?u where `bas_id` = ?i';			
		$update = $this->db->query($query, $data, $bas['bas_id']);
		if($update){
			return $this->db->GetRow('select * from `mvc_basckets` where `bas_id` = ?i',$bas['bas_id']);
		}
		else return false;
	}
	
	function createBascket($inv_id, $bas){
		$data = array(
						'bas_uid'=>$bas['bas_avtor'],
						'bas_inv_id'=>$inv_id,
						'bas_desc'=>trim($bas['bas_desc']),
					);
		$query = 'INSERT INTO `mvc_basckets` SET bas_date=NOW(), ?u';			
		$update = $this->db->query($query, $data);
		if($update){
			return $this->db->GetRow('select * from `mvc_basckets` where `bas_id` = ?i',$this->db->insertId());
		}
		else return false;
	}
	
	function clearBasket($id, $inv_id){
		do_action('admin-invoice-clearBasket', $id, $inv_id);
		return $this->db->query('DELETE FROM mvc_basckets_items WHERE item_bas_id = ?i OR item_inv_id=?i',$id, $inv_id);
	}
	
	function addToBasket($id, $inv_id, $array, $send){
		foreach($array as $i => $item){
			$data = array(
				'item_bas_id' => $id,
				'item_inv_id' => $inv_id,
				'item_uid' => $send['bas_avtor'],
				'item_prod_id' => $item['prod_id'],
				'item_amount' => $item['amount'],
				'item_cost' => $item['cost'],
				'item_discount' => $item['discount'],
			);
			$query_meta = 'INSERT INTO mvc_basckets_items SET ?u';
			$this->db->query($query_meta, $data);
			$array[$i]['item_id'] = $this->db->insertId();
			$array[$i]['item_bas_id'] = $id;
			$array[$i]['item_inv_id'] = $inv_id;
			$array[$i]['item_uid'] =  $send['bas_avtor'];
			do_action('admin-invoice-addTobasket', $array[$i], $inv_id, $send);
		}
		return $array;
	}
	
	function updateUser($user){
		$user_id=$user['user_id'];
		$user_login=$user['user_login'];
		$user_name=$user['user_name'];
		$user_status=$user['user_status'];
		
		$data = array(
			'user_login' => $user_login,
			'user_name' => $user_name,
			'user_status' => $user_status,
		);
		
		if(!empty($user['user_password'])) { $data['user_password'] = md5($user['user_password']); }
		
		$query = 'update `mvc_users` set ?u where `user_id` = ?i';
		$update = $this->db->query($query, $data, $user_id);
		
		$this->db->query('DELETE FROM mvc_users_contacts WHERE contact_user_id = ?i', $user_id);
		
		$user_phones=explode(',', $user['user_phones']); 
		foreach($user_phones as $i=>$item){
			$val = trim($item);if( !empty($val)){
			$this->addUserContact($user_id, 'phone', $val );}
		}
		
		$user_emails=explode(',', $user['user_emails']); 
		foreach($user_emails as $i=>$item){
			$val = trim($item);if( !empty($val)){
			$this->addUserContact($user_id, 'email', $val );}
		}
		
		$user_addres=explode(',', $user['user_addres']); 
		foreach($user_addres as $i=>$item){
			$val = trim($item);if( !empty($val)){
			$this->addUserContact($user_id, 'address', $val );}
		}

		$user_addres_custom = $user['user_addres_custom'];
		foreach($user_addres_custom as $i=>$item){
			$val = trim($item['contact_val']);
			if( !empty($val)){
				$this->addUserContact($user_id, trim($item['contact_type']), $val);
			}
		}
		
		$this->db->query('DELETE FROM mvc_access WHERE user_id = ?i', $user_id);
		$user_permissions=$user['user_permissions'];
		foreach($user_permissions as $i=>$item){
				if(trim($item['ac_val'])!=0){
				$perm = array(
							'user_id' => $user_id,
							'ac_res' => trim($item['ac_res']),
							'ac_val' => trim($item['ac_val']),
						);
				$this->db->query('INSERT INTO `mvc_access` SET ?u', $perm);
				}
		}
		
		
		if($update){
			return $this->db->GetRow('select * from `mvc_users` where `user_id` = ?i',$user_id);
		}
	}
	
	function updateProduct($product){
		$id = $product['main_id'];
		
		$data = array(
			'prod_name' => $product['main_name'],
			'prod_status' => $product['main_status'],
			'prod_cost' => $product['main_cost'],
			'prod_discount' => $product['main_discount'],
			'prod_photo' => $product['main_photo'],
			'prod_group' => $product['main_group'],
			'prod_description' => $product['main_description'],
		);
		
		$query = 'update `mvc_products` set ?u where `prod_id` = ?i';
		$update = $this->db->query($query, $data, $id);
		
		if($update){
			return $this->db->GetRow('select * from `mvc_products` where `prod_id` = ?i', $id);
		}
		else return false;
	}
	
	function updateGroup($group){
		$id = $group['main_id'];
		
		$data = array(
			'group_name' => $group['main_name'],
			'group_status' => $group['main_status'],
			'group_photo' => $group['main_photo'],
			'group_parent' => $group['main_parent'],
			'group_description' => $group['main_description'],
		);
		
		$query = 'update `mvc_products_groups` set ?u where `group_id` = ?i';
		$update = $this->db->query($query, $data, $id);
		
		if($update){
			return $this->db->GetRow('select * from `mvc_products_groups` where `group_id` = ?i', $id);
		}
		else return false;
	}
	
	function update_mail_template($page){
		$data = array(
						'post_name'=>$page['post_name_ru'],
						'post_content'=>$page['post_content'],
						'post_author'=>$this->controller->uid,
						'post_status'=>1,
						'post_type'=> 'mail-tmp'
					);
					
		$query = 'update `mvc_posts` set `post_modified` = NOW(), ?u where `post_id` = ?i';
		$update = $this->db->query($query, $data, $page['post_id']);
		return $this->db->GetRow('select * from `mvc_posts` where `post_id` = ?i',$page['post_id']);
	}
	
	function deletePageAttribute($at){
		if(is_array($at)){
			$query = "delete from `mvc_posts_at` where `id` in (?a)";
			return $this->db->query($query, $at);
		}
	}

	function updatePageAttribute($at){
		if(is_array($at)){
			for($i=0;$i<count($at);$i++){	
				$data = array(
						'option_filter'=>$at[$i]['option_filter']
					);
				$query = "update `mvc_posts_at` set ?u  where `id` = ?i";
				$this->db->query($query, $data, $at[$i]['id']);
			}
		}
	}
	
	function addPageAttribute($at, $post_id){
		if(is_array($at)){
			for($i=0;$i<count($at);$i++){
				$data = array(
						'post_id'=>$post_id,
						'at_id'=>$at[$i]['at_id'],
						'option_filter'=>$at[$i]['option_filter']
					);
				$query = "insert into `mvc_posts_at` set ?u ON DUPLICATE KEY UPDATE ?u";
				$this->db->query($query, $data, $data);
				$at[$i]['id'] = $this->db->insertId();
				$at[$i]['post_id'] = $post_id;
				$query="select * from `mvc_posts_at` as `pa`, `mvc_attributes` as `a` where `a`.`at_id`=`pa`.`at_id` and `id`= ?i";
				$result = $this->db->GetRow($query, $this->db->insertId());
				$result['locale_name'] = apply_filters('name-ru', $result['at_name']);
				$at[$i]['attr'] = $result;
			}
		

			return $at;
		}
	}
	
	function addMediaFile($name, $orig_name, $file, $url, $type){
		$array1 = stat($file);
		$array2 = array(
			"url" => $url,
			"destination" => $file,
			"mime_type" => $type
		);
		$result = array_merge ($array1, $array2);
		
		$result = json_encode($result);
		$data = array(
			'post_name' => $name,
			'post_name_ru' => $orig_name,
			'post_content' => $result,
			'post_author' => $this->controller->uid,
			'post_status'=>1,
			'post_type'=> 'file'
		);
		$query="INSERT INTO `mvc_posts` SET `post_date`=NOW(), ?u";
		$this->db->query($query, $data);
		return $this->db->insertId();
	}
	
	function get_uniq_contacts($table, $type, $search){
		return $this->db->GetCol("select contact_val from ".$table." where `contact_type` = ?s AND contact_val LIKE '%".$search."%' GROUP BY contact_val LIMIT 10", $type);
	}
}
