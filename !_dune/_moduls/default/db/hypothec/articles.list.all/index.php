<?php
		global $dbConn;
		if(empty($dbConn)) $dbConn = connectToDB();

        $array = array();
		$sql_filter = ' ';
        
	$q = '
				SELECT `id`, `url`, `name`, `parent`, `notice`
					
				FROM
					`hypothec_articles`
			     ORDER BY `order`
        		';
//print_array($sql);
					 
		$result = mysql_query($q, $dbConn);
		
		$array_o = new Dune_Mysql_Iterator_ResultAssoc($result);
		
		if($array_o->count() > 0)
		{
		    $go_next = true;
		}
		else 
		  $go_next = false;
		  
	    
		if ($go_next)
		{
		    // Выбираем родителей
		    foreach ($array_o as $value)
		    {
		        if ($value['parent'])
		        {
		            //  Массив детей
		            $array_children[$value['id']] = $value;
		            
		        }
		        else 
		        {
		            // Массив родителей
		            $array_parents[$value['id']]['info'] = $value;
		            $array_parents[$value['id']]['children'] = array();
		        }
		    }
		    if (count($array_children))
		    {
		        foreach ($array_children as $value)
		        {
		            if (key_exists($value['parent'], $array_parents))
		            {
		                $array_parents[$value['parent']]['children'][] = $value;
		            }
		        }
		    }
		    
		    
		    $array = $array_parents;
		}
		
		
    	$this->results['list'] = new Dune_Array_Container($array);
