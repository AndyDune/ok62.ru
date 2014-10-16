<?php

//include_once('includes/lib/Store.php');

class EdinstvoBean {
	
	public $id;

	public $db;
	public $table_name;
	public $object_name;
	public $object_prefix;
	public $field_array;
	
	public $date_entered;
	public $date_modified;
	
	/**
	 * ћассив соответствий свойств класса и колонок в Ѕƒ
	 *
	 * @var array
	 */
	public $column_fields;
	public $url_fasad;
	public $url_fasad_small;
	
	static $objects_array = array(
									'apartment' => 'Apartment',
									'office' => 'Office',
									'garage' => 'Garage',
									'store' => 'Store',
								);
	
	public function __construct() {
		global $dbConn;
		if(empty($dbConn)) $dbConn = connectToDB();
		$this->db = $dbConn;
	}
	
	/**
	 * ѕолучение списка экземл€ров класса из запроса
	 * ќб€зательные пол€ запроса:
	 * id - id объекта, по которому он будет идентифицирован
	 * table_name - название таблицы (дл€ офисов квартир и т.д.)
	 *
	 * @param mixed $object
	 * @param string $sql
	 * @return array
	 */
	public function retrieve_list($object, $sql) {
		
		$result = mysql_query($sql, $this->db);
		$return_array = array();
		while ($row = mysql_fetch_assoc($result)) {
			$seedObject = new $object;
			if(isset($row['table_name']))  $seedObject->table_name = $row['table_name'];
			$seedObject->retrieve($row['id']);
			$return_array[] = $seedObject;
		}
		return $return_array;
	}
	
	public function save() {
		$set_array = array();
		foreach ($this->field_array as $field_name) {
			$set_array[] = "`".$field_name."` = '".mysql_escape_string($this->$field_name)."'";
		}
		$set_array[] = "`date_modified` = NOW()";
		if(empty($this->id)) {
			$set_array[] = "`date_entered` = NOW()";
			$sql = "
					INSERT INTO
						`".$this->table_name."`
					SET
						".implode(', ', $set_array);
		} else {
			$sql = "
					UPDATE
						`".$this->table_name."`
					SET
						".implode(', ', $set_array)."
					WHERE
						`".$this->object_prefix."ID` = '".$this->id."'
			";
		}
		mysql_query($sql, $this->db);
		if(empty($this->id)) {
			$this->id = mysql_insert_id($this->db);
		}
		
	}
	
	public function get_porch_string() {
		if($this->object_name == 'Apartment' OR $this->object_name == 'Office' OR $this->object_name == 'Garage' OR $this->object_name == 'Store') {
			return $this->convert_integer_to_string_for_floor_porch($this->porch);
 		} else {
 			return '';
 		}
	}
	public function get_floor_string() {
		if($this->object_name == 'Apartment' OR $this->object_name == 'Office' OR $this->object_name == 'Garage' OR $this->object_name == 'Store') {
			return $this->convert_integer_to_string_for_floor_porch($this->floor);
 		} else {
 			return '';
 		}
	}
	
	public function convert_integer_to_string_for_floor_porch($variable) {
		switch ($variable) {
		    case "1":     { return "первом";     	break; }
		    case "2":     { return "втором";     	break; }
		    case "3":     { return "третьем";     	break; }
		    case "4":     { return "четвертом";     break; }
		    case "5":     { return "п€том";     	break; }
		    case "6":     { return "шестом";     	break; }
		    case "7":     { return "седьмом";     	break; }
		    case "8":     { return "восьмом";     	break; }
		    case "9":     { return "дев€том";     	break; }
		    case "10":    { return "дес€том";     	break; }
		    case "11":    { return "одиннадцатом";  break; }
		    case "12":    { return "двенадцатом";   break; }
		    case "13":    { return "тринадцатом";   break; }
		    case "14":    { return "четырнадцатом"; break; }
		    case "15":    { return "п€тнадцатом";   break; }
		    case "16":    { return "шестнадцатом";	break; }
		    case "17":    { return "семнадцатом";	break; }
		    case "18":    { return "восемнадцатом"; break; }
		    case "19":    { return "дев€тнадцатом"; break; }
		    case "20":    { return "двадцатом";     break; }
		}
		return $variable;   
	}
	
	protected function _get_tables_in_db() {
		static $tables_array;
		if(!empty($tables_array)) return $tables_array;
		$sql = "SHOW TABLES";
		$result = mysql_query($sql, $this->db);
		$tables_array = array();
		while ($row = mysql_fetch_array($result)) {
			$tables_array[] = $row[0];
		}
		return $tables_array;
	}

	
	
	
}

?>