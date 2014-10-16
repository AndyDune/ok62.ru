<?php
		global $dbConn;
		if(empty($dbConn)) $dbConn = connectToDB();

if (!$this->offset)
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
					 AND `p`.`bank_id` = `bank`.`id`
		             AND `p`.`bank_id` = ' . (int)$this->bank_id . ' '
					 . $sql_filter . '
					 ORDER BY `pp`.`' . $this->order_col_name . '` ' . $this->asc_desc . '
					 LIMIT ' . $this->offset . ', ' . $this->count . '
		';

		$sql_count = '
				SELECT count(*) as count
					
				FROM
					`hypothec_programs` p, `hypothec_pprograms` pp, `hypothec_bank` bank
				WHERE
					`p`.`id` = `pp`.program_id
					 AND `p`.`bank_id` = `bank`.`id`
					 AND `p`.`bank_id` = ' . (int)$this->bank_id . ' '
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

    	$this->results['array'] = $array;
//    	$this->results['count'] = count($array);