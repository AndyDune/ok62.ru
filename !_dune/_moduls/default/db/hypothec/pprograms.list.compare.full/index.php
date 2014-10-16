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
				SELECT pp.*, p.*, bank.name, pe.*
					
				FROM
					`hypothec_programs` p, `hypothec_bank` bank, `hypothec_pprograms` pp
				LEFT JOIN `hypothec_programs_expenses` as `pe` ON `pp`.`program_id`=`pe`.`exp_id`
				WHERE
					`p`.`id` = `pp`.program_id
					 AND `p`.`bank_id` = `bank`.`id`'
					 . $sql_filter . '
					 ORDER BY `pp`.`' . $this->order_col_name . '` ' . $this->asc_desc . '
		';

					 
		$result = mysql_query($sql, $dbConn);
		if(mysql_num_rows($result) > 0)
		{
    		while ($row = mysql_fetch_assoc($result)) 
    		{
    		    $array[] = new Dune_Array_Container($row); // Массив каждой програмы в контейнере
    		}
		}

		
    	if (count($array))
    	{
    	    foreach ($array as $key => $value)
    	    {
        	    ////////////// Соответсивеи видам страхования
                $q = 'SELECT *
                      FROM `hypothec_kinds_correspondence_pprogram` corr
                      WHERE `corr`.pprogram_id = ' . $value->pprogram_id . '
                      ';
                
        		$result = mysql_query($q, $dbConn);
        		$arr = array();
        		if(mysql_num_rows($result) > 0)
        		{
            		while ($row = mysql_fetch_assoc($result)) 
            		{
            		    $arr[] = $row['kinds'];
            		}
        		}
                $array[$key]['kinds_corr'] = new Dune_Array_Container($arr);

                
            /////////   Соответстия формам подтверждения доходов
            $q = 'SELECT *
                  FROM `hypothec_incconfirm_correspondence_pprogram` corr
                  WHERE `corr`.pprogram_id = ' . $value->pprogram_id . '
                  ';
                
        		$result = mysql_query($q, $dbConn);
        		$arr = array();
        		if(mysql_num_rows($result) > 0)
        		{
            		while ($row = mysql_fetch_assoc($result)) 
            		{
            		    $arr[] = $row['incconfirmid'];
            		}
        		}
                $array[$key]['incconfirm_corr'] = new Dune_Array_Container($arr);
                
    	    }
    	    
    	    
    	}		
		

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