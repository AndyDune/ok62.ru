<?php

//$this->offset;
//$this->count;

		global $dbConn;
		if(empty($dbConn)) $dbConn = connectToDB();

if (is_null($this->offset))
    $this->offset = 0;
if (!$this->count)    
    $this->count = 50;		
		
        $array = array();
		$sql_filter = $this->sql_filter;
		$sql = '
				SELECT pp.*, p.*, bank.name
					
				FROM
					`hypothec_programs` p, `hypothec_pprograms` pp, `hypothec_bank` bank
				WHERE
					`p`.`id` = `pp`.program_id
					 AND `p`.`bank_id` = `bank`.`id`'
					 . $sql_filter . '
					 ORDER BY `pp`.`' . $this->order_col_name . '` ' . $this->asc_desc . '
					 LIMIT ' . $this->offset . ', ' . $this->count . '
		';

					 
		$result = mysql_query($sql, $dbConn);
		if(mysql_num_rows($result) > 0)
		{
    		while ($row = mysql_fetch_assoc($result)) 
    		{
    		    $array[] = $row;
    		}
		}
					 

	    
    	$this->results['array'] = $array;