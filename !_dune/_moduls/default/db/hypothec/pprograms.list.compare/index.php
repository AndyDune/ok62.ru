<?php
		global $dbConn;
		if(empty($dbConn)) $dbConn = connectToDB();

        $array = array();
        $banks = array();
		$sql_filter = ' ';
		
if ($this->conditions)
{
        $sql_filter .= 'AND pp.pprogram_id IN ( ';
        $x = 0;
        foreach ($this->conditions as $value)
        {
            if ($x)
                $sql_filter .= ',';
            $x++;
            $sql_filter .= $value;
        }
        $sql_filter .= ')';

        
		$sql = '
				SELECT pp.*, p.*, bank.name
					
				FROM
					`hypothec_programs` p, `hypothec_pprograms` pp, `hypothec_bank` bank
				WHERE
					`p`.`id` = `pp`.program_id
					 AND `p`.`bank_id` = `bank`.`id`'
					 . $sql_filter . '
					 ORDER BY `pp`.`' . $this->order_col_name . '` ' . $this->asc_desc . '
		';

		$sql_count = '
				SELECT count(*) as count
					
				FROM
					`hypothec_programs` p, `hypothec_pprograms` pp, `hypothec_bank` bank
				WHERE
					`p`.`id` = `pp`.program_id
					 AND `p`.`bank_id` = `bank`.`id`'
					 . $sql_filter;
					 
		$result = mysql_query($sql, $dbConn);
		if(mysql_num_rows($result) > 0)
		{
    		while ($row = mysql_fetch_assoc($result)) 
    		{
    		    $array[] = $row;
    		}
		}
					 
//		$result = mysql_query($sql_count, $dbConn);
//   		$row = mysql_fetch_assoc($result);
//	    $this->results['count'] = $row['count'];

		$sql = '
				SELECT *
					
				FROM
					`hypothec_bank` bank
		';
		$result = mysql_query($sql, $dbConn);
		$banks = array();
		if(mysql_num_rows($result) > 0)
		{
    		while ($row = mysql_fetch_assoc($result)) 
    		{
    		    $banks[] = $row;
    		}
		}

}	    
        $this->results['banks'] = $banks;
    	$this->results['array'] = $array;