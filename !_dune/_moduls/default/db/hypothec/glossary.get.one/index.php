<?php
		global $dbConn;
		if(empty($dbConn)) $dbConn = connectToDB();

		$sql = '
				SELECT id, name, text
					
				FROM
					`hypothec_glossary`
				WHERE id = ' . $this->id;
		$result = mysql_query($sql, $dbConn);
		
		$name = '';
		$text = '';
		if(mysql_num_rows($result) > 0)
		{
    		$row = mysql_fetch_assoc($result);
    		$name = $row['name'];
    		$text = $row['text'];
		}

	    
        $this->results['name'] = $name;
        $this->results['text'] = $text;        
