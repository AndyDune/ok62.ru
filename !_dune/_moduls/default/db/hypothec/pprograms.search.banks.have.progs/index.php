<?php
		global $dbConn;
		if(empty($dbConn)) $dbConn = connectToDB();

        $array = array();
					 
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