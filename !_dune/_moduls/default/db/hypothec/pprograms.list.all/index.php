<?php

//$this->offset;
//$this->count;

		global $dbConn;
		if(empty($dbConn)) $dbConn = connectToDB();

if ($this->order_col_name == 'name_pp')		
{
    $add_order = '`bank`.`order` ' . $this->asc_desc . ', `pp`.`order` ' . $this->asc_desc . ', ';
}
else 
    $add_order = '';
		
if (is_null($this->offset))
    $this->offset = 0;
if (!$this->count)    
    $this->count = 50;		
		
        $array = array();
		$sql_filter = ' ';
        if (count($this->conditions))
        {
            foreach ($this->conditions as $value)
            {
                $sql_filter .= 'AND ' . $value['field'] . ' ' . $value['corr'] . ' "' . mysql_real_escape_string($value['value']) . '" ';
            }
        }
        
		$sql = '
				SELECT pp.*, p.*, bank.name
					
				FROM
					`hypothec_programs` p, `hypothec_pprograms` pp, `hypothec_bank` bank
				WHERE
					`p`.`id` = `pp`.program_id
					 AND `p`.`bank_id` = `bank`.`id`'
					 . $sql_filter . '
					 ORDER BY ' . $add_order . ' `pp`.`' . $this->order_col_name . '` ' . $this->asc_desc . '
					 LIMIT ' . $this->offset . ', ' . $this->count . '
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
					 
	
		$result = mysql_query($sql_count, $dbConn);
   		$row = mysql_fetch_assoc($result);
	    $this->results['count'] = $row['count'];

	    if (HYPOTHEC_SHOW_ALL_BANKS)
		$sql = '
				SELECT *
					
				FROM
					`hypothec_bank` bank
		';
		else 
		$sql = '
				SELECT bank.*
					
				FROM
					`hypothec_bank` bank,
					`hypothec_programs` p
			     WHERE
			         bank.id = p.bank_id
			      GROUP BY bank.id
					
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

	    
        $this->results['banks'] = $banks;
    	$this->results['array'] = $array;