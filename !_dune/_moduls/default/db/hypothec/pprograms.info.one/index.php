<?php
		global $dbConn;
		if(empty($dbConn)) $dbConn = connectToDB();

        $array = array();
		$sql_filter = ' ';
        
	$sql = '
				SELECT pp.*, p.*, bank.name
					
				FROM
					`hypothec_programs` p, `hypothec_pprograms` pp, `hypothec_bank` bank
				WHERE
					`p`.`id` = `pp`.program_id
					 AND `p`.`bank_id` = `bank`.`id`'
					 . $sql_filter . '
					 AND `pp`.`pprogram_id` = ' . (int)$this->id . '
		';
//print_array($sql);
					 
		$result = mysql_query($sql, $dbConn);
		if(mysql_num_rows($result) > 0)
		{
		    $go_next = true;
    		$array = mysql_fetch_assoc($result);
		}
		else 
		  $go_next = false;
	    
    	$this->results['info'] = new Dune_Array_Container($array);
    	
    	
    	if ($go_next)
    	{
    	    ////////////// Соответсивеи видам страхования
            $q = 'SELECT *
                  FROM `hypothec_kinds_correspondence_pprogram` corr
                  WHERE `corr`.pprogram_id = ' . (int)$this->id . '
                  ';
            
    		$result = mysql_query($q, $dbConn);
    		$array = array();
    		if(mysql_num_rows($result) > 0)
    		{
        		while ($row = mysql_fetch_assoc($result)) 
        		{
        		    $array[] = $row['kinds'];
        		}
    		}
            $this->results['kinds_corr'] = new Dune_Array_Container($array);
            
            
            /////////   Соответстия формам подтверждения доходов
            $q = 'SELECT *
                  FROM `hypothec_incconfirm_correspondence_pprogram` corr
                  WHERE `corr`.pprogram_id = ' . (int)$this->id . '
                  ';
    		$result = mysql_query($q, $dbConn);
    		$array = array();
    		if(mysql_num_rows($result) > 0)
    		{
        		while ($row = mysql_fetch_assoc($result)) 
        		{
        		    $array[] = $row['incconfirmid'];
        		}
    		}
            $this->results['incconfirm_corr'] = new Dune_Array_Container($array);
        
    	}
    	else 
    	{
        	$this->results['kinds_corr'] = new Dune_Array_Container(array());
        	$this->results['incconfirm_corr'] = new Dune_Array_Container(array());
    	}
