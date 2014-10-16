<?php
		global $dbConn;
		if(empty($dbConn)) $dbConn = connectToDB();

        $array = array();
					 
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