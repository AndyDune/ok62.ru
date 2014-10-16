<?php
		global $dbConn;
		if(empty($dbConn)) $dbConn = connectToDB();

		$sql = '
				SELECT id, name
					
				FROM
					`hypothec_glossary`
				ORDER BY `name`
		';
		$result = mysql_query($sql, $dbConn);
		$banks = array();
		$current_word = '';
		$words = array();
		$words_id = 0;
		if(mysql_num_rows($result) > 0)
		{
    		while ($row = mysql_fetch_assoc($result)) 
    		{
/////////////////////////////////////////////////////////    		    
                $current_name = ucfirst(trim($row['name']));
                if (!strlen($current_name))
                    continue;
                if ($current_word != $current_name[0])
                {
                    $words_id++;
                    $words[$words_id] = $current_word = $current_name[0];
                }
                $array[$words_id][] = $row;
////////////////////////////////////////////////////////    		    
    		}
		}

	    
        $this->results['array'] = $array;
        $this->results['words'] = $words;        
