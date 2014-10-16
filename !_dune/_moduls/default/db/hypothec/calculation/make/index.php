<?php
		$dbConn = connectToDB();

        $array = array();
        $array_all = array();
        $banks = array();
		$sql_filter = ' ';
		$this->results['count'] = 0;
		
//        'currencyid', 'creditperiod', 'sumcredit', 'firstpayment', 'paymenttypeid'
        $sql_filter = ' AND pp.currencyid_pp = "' . mysql_real_escape_string($this->currencyid) . '"';
        $sql_filter .= ' AND pp.creditperiod_pp >= ' . (int)$this->creditperiod;
        $sql_filter .= ' AND pp.creditperiod_min_pp <= ' . (int)$this->creditperiod;
        $sql_filter .= ' AND pp.sumcreditmin_pp <= ' . (int)$this->sumcredit;
        
        // !!!! Сбербанк даёт в прцентах от стоимости
        $sql_filter .= ' AND pp.sumcreditmax_pp >= ' . (int)$this->sumcredit;
        $sql_filter .= ' AND pp.firstpayment_pp <= ' . (int)$this->firstpayment;
        $sql_filter .= ' AND pp.firstpayment_max_pp >= ' . (int)$this->firstpayment;

        $sql_filter .= ' AND pp.lombard_part_pp = 0';
        
        if ($this->paymenttypeid == 'DIFF' or $this->paymenttypeid == 'ANNUIT')
        {
//            if ($this->paymenttypeid == 'DIFF')  // ВРЕМЕННО
//                $this->paymenttypeid = 'ALL';
            
            $sql_filter .= ' AND
                             (
                                 pp.paymenttypeid_pp = "' . mysql_real_escape_string($this->paymenttypeid) . '"
                                 OR
                                 pp.paymenttypeid_pp = "ALL"
                              )
                                 ';
            $sql_filter .= ' AND pp.rate_float_value_pp = 0';
        }
        else if ($this->paymenttypeid == 'PLAV')
            $sql_filter .= ' AND pp.rate_float_value_pp > 0';
            
// Установка возрастных параметров            
        $sql_filter .= ' AND p.agemax > ' . (int)$this->age;
        $sql_filter .= ' AND pp.creditperiod_min_pp <= p.agemax - ' . (int)$this->age;
            
        
        
    if ($this->status == 1 or $this->status == 2)
    {
        switch ($this->status)
        {
            case 1:
                $sql_filter .= ' AND `pp`.`pprogram_id` IN 
                                (
                                SELECT DISTINCT pprogram_id 
                                FROM `hypothec_kinds_correspondence_pprogram`
                                WHERE `kinds` = "NEW" 
                                )';
            default:
                $sql_filter .= ' AND `pp`.`pprogram_id` IN 
                                        (
                                        SELECT DISTINCT pprogram_id 
                                        FROM `hypothec_kinds_correspondence_pprogram`
                                        WHERE `kinds` != "NEW" 
                                        )';
        }
    }
    
    
    if ($this->incconfirmid > 0 and $this->incconfirmid < 3) // Учитываем подтверждение дохода
    {
        switch ($this->incconfirmid)
        {
            case 1:
                $sql_filter .= ' AND `pp`.`pprogram_id` IN 
                                (
                                SELECT DISTINCT pprogram_id 
                                FROM `hypothec_incconfirm_correspondence_pprogram`
                                WHERE `incconfirmid` = "2NDFL" 
                                )';

            break;
            default:
                $sql_filter .= ' AND `pp`.`pprogram_id` IN 
                                (
                                SELECT DISTINCT pprogram_id 
                                FROM `hypothec_incconfirm_correspondence_pprogram`
                                WHERE `incconfirmid` = "BANKFORM" OR
                                      `incconfirmid` = "FREEFORM" OR
                                )';
        }
    }

        
$this->results['sql_filter_all'] = $sql_filter; // сохраняем фильтр бля выбора всех без учеты стаки
echo '<pre>';        
		echo $sql_count_all = '
				SELECT count(*) as count
					
				FROM
					`hypothec_programs` p, `hypothec_pprograms` pp, `hypothec_bank` bank
				WHERE
					`p`.`id` = `pp`.program_id
					 AND `p`.`bank_id` = `bank`.`id`'
					 . $sql_filter . '
					 ORDER BY bank.order, pp.rate_pp
		';
echo '</pre>';

		$result = mysql_query($sql_count_all, $dbConn);
		if (!$result)
		  echo mysql_error();
		  
  		$row = mysql_fetch_assoc($result);
  	    $this->results['count_all'] = $row['count'];
        
		
        
if ($this->results['count_all'])
{
echo '<pre>';
		echo $sql = '
				SELECT pp.*, p.*, bank.name
					
				FROM
					`hypothec_programs` p, `hypothec_pprograms` pp, `hypothec_bank` bank
				WHERE
					`p`.`id` = `pp`.program_id
					 AND `p`.`bank_id` = `bank`.`id`'
					 . $sql_filter . '
					 ORDER BY bank.order, pp.rate_pp
					 LIMIT 1
		';
echo '</pre>';


		$result = mysql_query($sql, $dbConn);
		if (!$result)
		  echo mysql_error();
		$x = 0;
		if(mysql_num_rows($result) > 0)
		{
    		while ($row = mysql_fetch_assoc($result)) 
    		{
    		    if (!$x)
    		      $array = $row;
    		    else 
    		      $array_all[] = $row;
    		    $x++;
    		}

		}
}		
		
echo '<pre>';
//print_array($array);
echo '</pre>';
//die();


        if (isset($array['rate_pp']))
        {
echo '<pre>';        
            $sql_filter .= ' AND pp.rate_pp <= ' . ceil((float)$array['rate_pp']); // учитываем ставку
    		echo $sql_count = '
    				SELECT count(*) as count
    					
    				FROM
    					`hypothec_programs` p, `hypothec_pprograms` pp
    				WHERE
    					`p`.`id` = `pp`.program_id '
    					 . $sql_filter;
    					 
echo '</pre>';    					 
    		$result = mysql_query($sql_count, $dbConn);
    		if (!$result)
	       	  echo mysql_error();
    		
       		$row = mysql_fetch_assoc($result);
    	    $this->results['count'] = $row['count'];
        }    	    
        
        $this->results['sql_filter'] = $sql_filter;
    	$this->results['array'] = $array;
    	$this->results['array_all'] = $array;