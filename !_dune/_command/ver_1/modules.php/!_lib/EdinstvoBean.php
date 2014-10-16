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
	 * ������ ������������ ������� ������ � ������� � ��
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
	 * ��������� ������ ���������� ������ �� �������
	 * ������������ ���� �������:
	 * id - id �������, �� �������� �� ����� ���������������
	 * table_name - �������� ������� (��� ������ ������� � �.�.)
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
		    case "1":     { return "������";     	break; }
		    case "2":     { return "������";     	break; }
		    case "3":     { return "�������";     	break; }
		    case "4":     { return "���������";     break; }
		    case "5":     { return "�����";     	break; }
		    case "6":     { return "������";     	break; }
		    case "7":     { return "�������";     	break; }
		    case "8":     { return "�������";     	break; }
		    case "9":     { return "�������";     	break; }
		    case "10":    { return "�������";     	break; }
		    case "11":    { return "������������";  break; }
		    case "12":    { return "�����������";   break; }
		    case "13":    { return "�����������";   break; }
		    case "14":    { return "�������������"; break; }
		    case "15":    { return "�����������";   break; }
		    case "16":    { return "������������";	break; }
		    case "17":    { return "�����������";	break; }
		    case "18":    { return "�������������"; break; }
		    case "19":    { return "�������������"; break; }
		    case "20":    { return "���������";     break; }
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