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
        
        
    if ($this->kinds)
    {
        $sql_filter .= ' AND `pp`.`pprogram_id` IN 
                        (
                        SELECT DISTINCT pprogram_id 
                        FROM `hypothec_kinds_correspondence_pprogram`
                        WHERE `kinds` = "' . mysql_real_escape_string($this->kinds) . '" 
                        )';
    }
    if ($this->incconfirmid)
    {
        $sql_filter .= ' AND `pp`.`pprogram_id` IN 
                        (
                        SELECT DISTINCT pprogram_id 
                        FROM `hypothec_incconfirm_correspondence_pprogram`
                        WHERE `incconfirmid` = "' . mysql_real_escape_string($this->incconfirmid) . '" 
                        )';
    }
    
        
	echo $sql = '
				SELECT pp.*, p.*, bank.name
					
				FROM
					`hypothec_programs` p, `hypothec_pprograms` pp, `hypothec_bank` bank
				WHERE
					`p`.`id` = `pp`.program_id
					 AND `p`.`bank_id` = `bank`.`id`'
					 . $sql_filter . $this->filter_add . '
					 ORDER BY `pp`.`' . $this->order_col_name . '` ' . $this->asc_desc . '
					 LIMIT ' . $this->offset . ', ' . $this->count . '
		';
//print_array($sql);
		$sql_count = '
				SELECT count(*) as count
					
				FROM
					`hypothec_programs` p, `hypothec_pprograms` pp, `hypothec_bank` bank
				WHERE
					`p`.`id` = `pp`.program_id
					 AND `p`.`bank_id` = `bank`.`id`'
					 . $sql_filter . $this->filter_add;
					 
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

	    
        $this->results['banks'] = $banks;
    	$this->results['array'] = $array;