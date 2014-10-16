<?php
		global $dbConn;
		if(empty($dbConn)) $dbConn = connectToDB();


		$sql = '
				SELECT
					`p`.`id` as id, `p`.`name` as name, `np`.`complexTypeString` as type, `p`.`type_id` as type_id
				FROM
					`unity_panorama` p, `complex` np
				WHERE
					`p`.`activity` > 0
					 AND `p`.`type` = "complex"
					 AND `p`.`type_id` = `np`.`complexID`
		';
		$result = mysql_qw($sql, $dbConn);
		$array_panorama_complex = array();
		if(mysql_num_rows($result) > 0)
		{
    		while ($row = mysql_fetch_assoc($result)) {
    			$run_array['id'] = $row['id'];
    			$run_array['name'] = $row['name'];
    			$run_array['type'] = $row['type'];
    			$run_array['type_id'] = $row['type_id'];
    			$array_panorama_complex[] = $run_array;
    		}
    		$this->results['complex'] = $array_panorama_complex;
		}


		$sql = '
				SELECT
					`p`.`id` as id, `p`.`name` as name, `np`.`houseTypeString` as type, `p`.`type_id` as type_id
				FROM
					`unity_panorama` p, `house` np
				WHERE
					`p`.`activity` > 0
					 AND `p`.`type` = "house"
					 AND `p`.`type_id` = `np`.`houseID`
		';
		$result = mysql_qw($sql, $dbConn);
		$array_panorama_house = array();
		if(mysql_num_rows($result) > 0)
		{
    		while ($row = mysql_fetch_assoc($result)) {
    			$run_array['id'] = $row['id'];
    			$run_array['name'] = $row['name'];
    			$run_array['type'] = $row['type'];
    			$run_array['type_id'] = $row['type_id'];
		        $array_panorama_house[] = $run_array;
    		}
		}
		
    	$this->results['complex'] = $array_panorama_complex;
    	$this->results['house'] = $array_panorama_house;