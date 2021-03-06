<?php
/* Automatic model generated
 * ver 0.1
 * model for site: mvc.test
 * date create: 2017-10-20 22:29:21
*/
class model_variables extends Model
{
	function __construct($config) {
		$config = [
            "database" => "mvc",
            "prefix" => "mvc_",
            "name" => "variables",
            "engine" => "MyISAM",
            "version" => "1",
            "row_format" => "Dynamic",
            "create_time" => "2017-10-20 21:27:56",
            "collation" => "utf8_general_ci",
            "primary_key" => "var_id",
			"autoinit"  => false,
            "columns" => array(
				'var_name' => "varchar(50) NOT NULL",				'var_val' => "text NOT NULL",				
				),
			"index" => array(
				
			),
			"unique" => array(
				'var_name' => array( 'var_name' ),				
			),
			"fulltext" => array(
				
			),
			"revisions" => array(
				array(
					"version"       => "1",
					/*
					// Examples
					"before_query" => array(
						"SELECT NOW() FROM dual", "SELECT CURDATE() FROM dual"
					),
					"before_func" => "<MODEL FUNCTION NAME>",
					"del_index" => array(
						"<INDEX NAME1>", "<INDEX NAME2>"
					),
					"del_uniq" => array(
						"<UNIQ INDEX NAME1>", "<UNIQ INDEX NAME2>"
					),
					"del_fulltext" => array(
						"<FULLTEXT INDEX NAME1>", "<FULLTEXT INDEX NAME2>"
					),
					"add_columns" => array(
						"<NEW COLUMN NAME>"   => "VARCHAR(50) NOT NULL DEFAULT '' AFTER `<AFTER COLUMN>`"
					),
					"del_columns" => array(
						"<COLUMN NAME1>", "<COLUMN NAME2>"
					),
					"mod_columns" => array(
						"<COLUMN NAME1>" => array( "name"=>"<NEW COLUMN NAME1>", "type"=>"VARCHAR(50) NOT NULL DEFAULT '' AFTER `<AFTER COLUMN>`" ),
						"<COLUMN NAME2>" => array( "name"=>"<NEW COLUMN NAME2>", "type"=>"VARCHAR(50) NOT NULL DEFAULT '' AFTER `<AFTER COLUMN>`" ),
					),
					"add_index" => array(
						"<NEW INDEX NAME>"   => array( "<COLUMN NAME>" ),
					),
					"add_uniq" => array(
						"<NEW UNIQ INDEX NAME>"   => array( "<COLUMN NAME>" ),
					),
					"add_fulltext" => array(
						"<NEW FULLTEXT INDEX NAME>"   => array( "<COLUMN NAME>" ),
					),
					"engine" => "<NEW ENGINE |InnoDB|MyISAM|other>",
					"after_query" => array(
						"SELECT NOW() FROM dual", "SELECT CURDATE() FROM dual"
					),
					"after_func" => "<MODEL FUNCTION NAME>",
					*/
				),
			)
		];
		parent::__construct($config);
    }
	
	public function setVar($VAR, $val){
		return $this->InsertUpdate(array('var_name'=>$VAR, 'var_val'=>$val));
	}
	
	public function delVar($VAR){
		return $this->Delete("`var_name`='{$VAR}'");
	}
	
	public function getVar($VAR){
		$result = $this->getItemWhere("`var_name`='{$VAR}'");
		return $result['var_val'];
	}

}
?>