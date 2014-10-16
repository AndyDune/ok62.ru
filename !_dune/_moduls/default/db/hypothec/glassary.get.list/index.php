<?php
		global $dbConn;
		if(empty($dbConn)) $dbConn = connectToDB();

		$sql = '
				SELECT *
					
				FROM
					`hypothec_glossary`
				ORDER BY `name`
		';
		$result = mysql_query($sql, $dbConn);
		$banks = array();
		if(mysql_num_rows($result) > 0)
		{
    		while ($row = mysql_fetch_assoc($result)) 
    		{
    		    $array[$row['id']] = $row;
    		}
		}

	    
        $this->results['array'] = $array;
