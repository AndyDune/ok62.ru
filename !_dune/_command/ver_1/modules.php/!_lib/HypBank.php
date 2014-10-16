<?php

//include_once('includes/lib/EdinstvoBean.php');
//include_once('includes/lib/HypProgram.php');

class HypBank extends EdinstvoBean {
	
	public $table_name = 'hypothec_bank';
	public $rel_cond_table_name = 'hypothec_bc';
	
	public $bankName;
	public $bankNovostroi;
	public $bankVtor;
	public $novostroi;
	public $bankDiscription;
	public $bankLogoUrl;
	public $bankUrl;
	
	public function __construct() {
		parent::__construct();
	}
	
	// Получаем всю информацию о банке
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
		$this->bankName = $row['name'];
		$this->bankNovostroi= $row['novostroi'] == 1 ? true : false;
		$this->bankVtor = $row['vtor'] == 1 ? true : false;
		$this->bankDiscription = $row['discription'];
		$this->bankLogoUrl = $row['logo_url'];
		$this->bankUrl = $row['bank_url'];
	}
	
	/**
	 * Получаем список банков
	 *
	 * @return array
	 */
	public function getBankList() {
		$sql = "
				SELECT
					`id`
				FROM
					`".$this->table_name."`
			    ORDER BY `order`
		";
		return $this->retrieve_list('HypBank', $sql);
		
	}
	
	// Получаем список банков, работающих с первичкой
	public function getNovostroiBankList() {
	$sql = "
				SELECT
					`id`
				FROM
					`".$this->table_name."`
				WHERE
					`novostroi` = '1'
		";
		return $this->retrieve_list('HypBank', $sql);
	
	}

	// Получаем список банков, работающих со вторичкой
	public function getVtorBankList() {
	$sql = "
				SELECT
					`id`
				FROM
					`".$this->table_name."`
				WHERE
					`vtor` = '1';
		";
		return $this->retrieve_list('HypBank', $sql);
	
	}
	
	/**
	 * Получить список программ текущего банка
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
			WHERE
				`bank_id` = '".$this->id."'
		";
		return $this->retrieve_list('HypProgram', $sql);
	}
	

	/**
	 * Получить число программ текущего банка
	 *
	 * @return array
	 */
	
	public function getProgramCount() {
		$seedProgram = new HypProgram();
		$sql = "
			SELECT
				count(`id`) as count
			FROM
				`".$seedProgram->table_name."`
			WHERE
				`bank_id` = '".$this->id."'
		";
	    $result = mysql_query($sql, $this->db);
	    $row = mysql_fetch_assoc($result);
		return $row['count'];
	}

	/**
	 * Получить число программ текущего банка
	 *
	 * @return array
	 */
	
	public function getPProgramCount() {
		$seedProgram = new HypProgram();
		$row = array('count' => 0);
		$sql = '
			SELECT
				count(`pp`.`pprogram_id`) as `count`
			FROM
				`hypothec_pprograms` pp, `hypothec_programs` p
			WHERE
			     `p`.`id` =  `pp`.`program_id` AND
				`p`.`bank_id` = ' . $this->id;
	    $result = mysql_query($sql, $this->db);
	    if (!$result)
	       echo 'Упс!!';
	    else 
	       $row = mysql_fetch_assoc($result);
		return $row['count'];
	}
	
	/**
	 * Получить список условий кредитования текущего банка
	 *
	 * @return array
	 */
	
	public function getConditionsList() {
		$seedCondition = new HypCondition();
		$sql = "
			SELECT
				`id`
			FROM
				`".$seedCondition->table_name."`
			WHERE
				`bank_id` = '".$this->id."'
		";
		//print_array($sql, 1);
		return $this->retrieve_list('HypCondition', $sql);
	}
	
	public function getCondValueList() {
		$seedCondition = new HypCondition();
		$sql = "
				SELECT `".$seedCondition->table_name."`.`id` as `cond_id`, `".$seedCondition->table_name."`.`name` as `cond_name`, `".$this->rel_cond_table_name."`.`value` 
				FROM `".$seedCondition->table_name."` INNER JOIN `".$this->rel_cond_table_name."`
				ON `".$seedCondition->table_name."`.`id` = `".$this->rel_cond_table_name."`.`cond_id`
				WHERE  `".$this->rel_cond_table_name."`.`bank_id` = '".$this->id."'
		";
	

		$result = mysql_query($sql, $this->db);
		$return_array = array();
		while ($row = mysql_fetch_assoc($result)) {
			
			$return_array[] = array(
									'ID' => $row['cond_id'],
									'NAME' => $row['cond_name'],
									'VALUE' => $row['value'],
			);
		}
		//	print_array($sql);
		return $return_array;
	}
	
}

?>