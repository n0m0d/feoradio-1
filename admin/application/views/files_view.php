<?php
	$files = $data['files'];
	$page = (int)((isset($_GET['page']))?$_GET['page']:1);
	$n=$files[0]['n'];
	$maxrows=$files[0]['limit'];

?>
<script>
$(function(){
	$('#all-check').change(function(){
		var prop = $(this).prop("checked");
		if(prop) {
			$('.ch').prop("checked", true);
		} else { 
			$('.ch').prop("checked", false); 
		}
	});
	
	$('#delete-pages').click(function(){
		var pages = [];
		$('.ch').each(function(index){
			if($(this).prop("checked")) pages.push($(this).val());	
		});
		
		if(pages.length > 0){
		xhr = $.ajax({
			url : "/admin/ajax",
			type : "post",
			data : { "ajax_action" : "delete_files", "pages" : pages},
			beforeSend: function( jqXHR, settings ){ if(xhr != null){ xhr.abort();console.log('ajax is aborting');	} },
			complete: function(){ xhr = null; },
			success: function(data){
				for( var i in pages){
					$('#raw_'+pages[i]).remove();
				}
				console.log(data);
			}
		});
		}
		
	});
});
</script>
<div id="icon-edit-pages" class="icon32 icon32-posts-page"><br></div><h2>Медиафайлы</h2>
<div id="wrap-main">
	<div>
		<h3>Основные действия над медиафайлами</h3>
		<a href="/admin/files/?id=new" class="button-controls add">Добавить медиафайл</a>
		<button id="delete-pages" class="button-controls delete">Удалить отмеченные медиафайлы</button>
	</div>
	<div class="page-view">
		<form action="/admin/files/" method="get">
		<table style="width:100%;"><tr>
		<td><input name="search" id="search" style="height:30px; text-align:left !important;" type="text" value="<?= $_GET['search']; ?>"></td>
		<td style="width:50px;"><button style="height:29px; text-align:left !important;">Поиск</button></td>
		</tr></table>
		</form>
	</div>
	<table class="main-table" >
		<thead>
			<tr>
				<td class='all-align-center'><input type="checkbox" id="all-check" /></td>
				<td>ID</td>
				<td>Название/URL/Расположение</td>
				<td>Автор</td>
				<td>Дата</td>
			</tr>
		</thead>
		<tbody>
			
			<?php 
				foreach($files as $i => $f)
				{
					$alt = ($i%2 ==0)? "alt":"";
					$file = json_decode($f['post_content'], true);
		echo "
			<tr id='raw_{$f['post_id']}'>
				<td class=\"{$alt} all-align-center\"><input class=\"ch\" type=\"checkbox\" value=\"{$f['post_id']}\" /></td>
				<td class=\"{$alt}\">{$f['post_id']}</td>
				<td class=\"{$alt}\">
					<div><a href=\"/admin/files/?id={$f['post_id']}\">"._(apply_filters('name-ru', $f['post_name_ru']))."</a></div>
					<div><a href=\"{$file['url']}\" target=\"_blank\">{$file['url']}</a></div>
					<div>{$file['destination']}</div>
				</td>
				<td class=\"{$alt}\">{$f['user_name']}</td>
				<td class=\"{$alt}\">{$f['post_date']}</td>
			</tr>";
					
				}
			?>
			
		</tbody>
	</table>
		<?php
		echo do_shortcode('[pagenavigation n="'.$n.'" limit="'.$maxrows.'" page="'.$page.'"]');
		?>
</div>
