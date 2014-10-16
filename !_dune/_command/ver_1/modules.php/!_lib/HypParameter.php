<?php

//include_once('includes/lib/EdinstvoBean.php');
//include_once('includes/lib/HypProgram.php');

class HypParameter extends EdinstvoBean {
	
	public $table_name = 'hypothec_parameters';
	
	public $parameter_id;
	public $parameterName;

	public function __construct() {
		parent::__construct();
	}
	
	// Получаем всю информацию о параметре
	public function retrieve($id) {
		$sql = "
				SELECT
					*
				FROM
					`".$this->table_name."`
				WHERE
					`id` = '".$id."'
				LIMIT
					1
		";
		
		$result = mysql_query($sql, $this->db);
		if(mysql_num_rows($result) != 1) return null;
		$row = mysql_fetch_array($result);
		
		$this->parameter_id = $row['id'];
		$this->parameterName = $row['name'];	
	}
}

?>