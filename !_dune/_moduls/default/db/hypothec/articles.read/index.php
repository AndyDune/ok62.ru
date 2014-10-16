<?php
		global $dbConn;
		if(empty($dbConn)) $dbConn = connectToDB();

        $array = array();
		$sql_filter = ' ';
        
	$q = '
				SELECT *
					
				FROM
					`hypothec_articles`
			     ORDER BY `order`
        		';
//print_array($sql);
					 
		$result = mysql_query($q, $dbConn);
		if(mysql_num_rows($result) > 0)
		{
    		$array = mysql_fetch_assoc($result);
		}
		  
		
		
    	$this->results['info'] = new Dune_Array_Container($array);
