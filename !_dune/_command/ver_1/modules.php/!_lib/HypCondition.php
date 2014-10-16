<?php

//include_once('includes/lib/EdinstvoBean.php');
//include_once('includes/lib/HypBank.php');

class HypCondition extends EdinstvoBean {
	
	public $table_name = 'hypothec_conditions';
	public $rel_condition_table_name = 'hypothec_bc';
	
	public $name;
	
	public function __construct() {
		parent::__construct();
	}
	
	// Получаем всю информацию об условии
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
		
		$this->id = $row['id'];
		$this->name = $row['name'];
		
	}
	
	/**
	 * Получаем список условий
	 *
	 * @return array
	 */
	public function getCondList($banks_ids) {
		$sql = "
				SELECT DISTINCT
					`cond_id` as `id`
				FROM
					`".$this->rel_condition_table_name."`
				WHERE
					 `bank_id` IN (".implode(",", $banks_ids).")
			   ";
		//print_array($sql);
		return $this->retrieve_list('HypCondition', $sql);
		
	}
	
	
	
	/**
	 * Получить список банков для текущего условия
	 *
	 * @return array
	 */
	public function getBankCondList() {
		$seedBank = new HypBank();
		$sql = "
				SELECT `".$seedBank->table_name."`.`id` as `bank_id`, `".$seedBank->table_name."`.`name` as `bank_name`, `".$this->rel_condition_table_name."`.`value`, `".$seedBank->table_name."`.`logo_url` as `bank_logo_url`
				FROM `".$seedBank->table_name."` INNER JOIN `".$this->rel_condition_table_name."`
				ON `".$seedBank->table_name."`.`id` = `".$this->rel_condition_table_name."`.`bank_id`
				WHERE  `".$this->rel_condition_table_name."`.`cond_id` = '".$this->id."'
		";
		$result = mysql_query($sql, $this->db);
		$return_array = array();
		while ($row = mysql_fetch_assoc($result)) {
			
			$return_array[$row['bank_id']] = array(
									'ID' => $row['bank_id'],
									'BANK_NAME' => $row['bank_name'],
									'BANK_VALUE' => $row['value'],
									'BANK_LOGO_URL' => $row['bank_logo_url'],
			);
		}
		return $return_array;
	}
	
	
}
?>