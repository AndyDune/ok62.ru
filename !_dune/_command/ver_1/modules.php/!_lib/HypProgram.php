<?php

//include_once('includes/lib/EdinstvoBean.php');
//include_once('includes/lib/HypParameter.php');

class HypProgram extends EdinstvoBean {
	
	public $table_name = 'hypothec_programs';
	public $rel_parameter_table_name = 'hypothec_pp';
	
	public $bank_id;
	public $name;
	public $url;
	public $bonus;
	
	/**
	 * ����� �����
	 *
	 * @var HypBank
	 */
	public $bank;
	
	/**
	 * ����� ���������
	 *
	 * @var HypParameter
	 */
	public $parameter;
	
	
	public function __construct() {
		parent::__construct();
	}
	
	// �������� ��� ���������� � ���������
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
		
		///// !!!!! ��������� ������������ ����� ����� �������
		foreach ($row as $key => $value)
		{
		    $this->$key = $value;
		}
/*		$this->id = $row['id'];
		$this->bank_id = $row['bank_id'];
		$this->name = $row['name'];
		$this->url = $row['url'];
		$this->bonus = $row['bonus'];
*/
	}
	
	
	/**
	 * �������� ������ ��������
	 *
	 * @return array
	 */
	public function getProgramList() {
		$seedProgram = new HypProgram();
		$sql = "
			SELECT
				`id`
			FROM
				`".$seedProgram->table_name."`
		";
		return $this->retrieve_list('HypProgram', $sql);
	}
	



	/**
	 * ������������ ���� ��� ���������
	 *
	 */
	public function initBank() {
		$seedBank = new HypBank();
		if($this->bank_id) {
			$seedBank->retrieve($this->bank_id);
			$this->bank = $seedBank;
		}
	}
	
/**
	 * �������� ������ ���������� ��� ������� ���������
	 *
	 * @return array
	 */
	public function getProgramParamList() {
		$seedParameter = new HypParameter();
		$sql = "
				SELECT `".$seedParameter->table_name."`.`id` as `parameter_id`, `".$seedParameter->table_name."`.`name` as `parameter_name`, `".$this->rel_parameter_table_name."`.`value` 
				FROM `".$seedParameter->table_name."` INNER JOIN `".$this->rel_parameter_table_name."`
				ON `".$seedParameter->table_name."`.`id` = `".$this->rel_parameter_table_name."`.`id_param`
				WHERE  `".$this->rel_parameter_table_name."`.`id_program` = '".$this->id."'
				ORDER BY `sort`
		";
		$result = mysql_query($sql, $this->db);
		$return_array = array();
		while ($row = mysql_fetch_assoc($result)) {
			
			$return_array[] = array(
									'ID' => $row['parameter_id'],
									'PARAMETER_NAME' => $row['parameter_name'],
									'PARAMETER_VALUE' => $row['value'],
			);
		}
		return $return_array;
	}
	
	
	
	
	
	
	
}	
	

?>