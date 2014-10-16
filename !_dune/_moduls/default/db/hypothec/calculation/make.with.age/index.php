<?php
		$dbConn = connectToDB();

        $array = array();
        $array_all = array();
        $banks = array();
		$sql_filter = ' ';
		
		$this->results['count'] = 0;
		$this->results['count_all'] = 0;
        $this->results['sql_filter'] = '';
    	$this->results['array'] = array();
    	$this->results['array_all'] = array();		
		
		$this->sumcredit = (int)$this->sumcredit;
		$this->firstpayment = (int)$this->firstpayment;
		
		if (!$this->min_rate_can_be)
		    $this->min_rate_can_be = 9;
		
		
//        'currencyid', 'creditperiod', 'sumcredit', 'firstpayment', 'paymenttypeid'
        $sql_filter = ' AND pp.currencyid_pp = "' . mysql_real_escape_string($this->currencyid) . '"';
        $sql_filter .= ' AND pp.sumcreditmin_pp <= ' . $this->sumcredit;
        
        // !!!! Сбербанк даёт в прцентах от стоимости
        $sql_filter .= ' AND pp.sumcreditmax_pp >= ' . $this->sumcredit;
        
        
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
//            $sql_filter .= ' AND p.paymenttypeid = "' . mysql_real_escape_string($this->paymenttypeid) . '"';

            $sql_filter .= ' AND pp.rate_float_value_pp = 0';
        }
        else if ($this->paymenttypeid == 'PLAV')
            $sql_filter .= ' AND pp.rate_float_value_pp > 0';

// Установка возрастных параметров            
        $sql_filter .= ' AND p.agemax > ' . (int)$this->age;
        $sql_filter .= ' AND pp.creditperiod_min_pp <= p.agemax - ' . (int)$this->age;
            
//        $sql_filter .= ' AND pp.creditperiod_pp >= ' . (int)$this->creditperiod;
//        $sql_filter .= ' AND pp.creditperiod_min_pp <= ' . (int)$this->creditperiod;
            
            
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
    
    
    if ($this->incconfirmid > 0 and $this->incconfirmid < 3)
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

        
    
//      Выборка всего и анализ каждого на соотвествие условиям    
    
echo '<pre>';
		$sql = '
				SELECT pp.*, p.*, bank.name
					
				FROM
					`hypothec_programs` p, `hypothec_pprograms` pp, `hypothec_bank` bank
				WHERE
					`p`.`id` = `pp`.program_id
					 AND `p`.`bank_id` = `bank`.`id`'
					 . $sql_filter . '
					 ORDER BY bank.order, pp.rate_pp
		';
echo '</pre>';


		$result = mysql_query($sql, $dbConn);
		if (!$result)
		  echo mysql_error();
		  $count_all = mysql_num_rows($result);
		if($count_all > 0)
		{
            $last_rate = 0;
            $last_ = 0;

            $pay = new Data_Edinstvo_Payment($this->paymenttypeid);
            $pay->setOverpayment();
            $pay->setSumcredit($this->sumcredit);
            
            
            $monthpay_last_good = 0;
            $creditperiod_last_good = 0;
            $FIND_ONE = false;
            
            $rate_good = 0;
            $rate_temp = 0;
            
            
                $monthpay_total_good = 0;
                $creditperiod_total_good = 0;
            
                
    		while ($row = mysql_fetch_assoc($result)) 
    		{ 
   		        $array_all[] = $row;
                 //print_array($row);
/////////////////////////////////////////////////////////////       Подбор процентов и срока под ежемесц        
                
                $befor_max_age = $row['agemax'] - (int)$this->age;
                if ($befor_max_age > $row['creditperiod_pp'])
                    $creditperiodmax  = $row['creditperiod_pp'];
                else 
                    $creditperiodmax  = $befor_max_age;
                    
                //echo $creditperiodmax, '<br />';
                if (!$row['creditperiod_min_pp'])
                    $row['creditperiod_min_pp'] = 1;
                    
                $creditperiodmin  = $row['creditperiodmin'];
                $creditperiodlevels  = $creditperiodmax - $row['creditperiodmin'];
                
                $creditperiodlook = $creditperiodmax;
                $creditperiodmax_temp = $creditperiodmax;
                $creditperiodmin_temp = $creditperiodmin;
                
                
                
                $chech_max = false;
                $chech_min = false;
                $bigger = 0; // Нейтраль
                
                $pay->setRate($row['rate_pp']);
                
                $rate_temp = $row['rate_pp'];
                if ($rate_good and $rate_good < $rate_temp)
                    break;
                
                for ($x = 1; $x < $creditperiodlevels; $x++)
                {
                    $pay->setCreditperiod($creditperiodlook);
                    $pay->make();
                    // Если не подошёл с начала
                    if ($x == 1)                    
                    {
                        if ($pay->getPayPerMonth() > ($this->monthpay - 5))
                        {
                            break;
                        }
                    }
                   // echo ' -', $rate_good, '- ';
                    // 1-я итерация
                    if (!$bigger)
                    {
                        
                        if ($pay->getPayPerMonth() > $monthpay_total_good and ($rate_temp <= $rate_good or !$rate_good))
                        {
                            $rate_good = $rate_temp;
                            $monthpay_total_good = $pay->getPayPerMonth();
                            echo '====================', $creditperiod_total_good = $creditperiodlook;
                            $array = $row;
                        }        
                        
                        $bigger = 1; // Наша цифра больше чем в базе
                        $interval = $creditperiodmax_temp - $creditperiodmin_temp;
                        $creditperiodlook = round($interval / 2);
                        if ($creditperiodlook == $creditperiodmax_temp)
                            $creditperiodlook--;
                        continue;
                    }
                    
                    
                    
                    if ($pay->getPayPerMonth() < $this->monthpay) // Найденное меньше введенного с формы
                    {
                        $monthpay_last_good = $pay->getPayPerMonth();
                        $creditperiod_last_good = $creditperiodlook;
                        
                        //$creditperiodmax_temp = $creditperiodlook;
                        
                        $creditperiodmax_temp = $creditperiodlook;
                        
                        $bigger = 1; // Наша цифра больше чем в базе
                    }
                    else 
                    {
                        $pay->setCreditperiod($creditperiodlook + 1);
                        $pay->make();
                        $monthpay_last_good = $pay->getPayPerMonth();
                        $creditperiod_last_good = $creditperiodlook + 1;
                        
                        
//                        echo '[-';
                        $creditperiodmin_temp = $creditperiodlook;
//                        echo '-]';
                        $bigger = 2; // Наша цифра меньше чем в базе
                    }

                    
                    
                    
//                   echo 'Интервал:(';
                   $interval = $creditperiodmax_temp - $creditperiodmin_temp;
//                   echo ')';
                    if ($interval < 2)
                    {
                        $array_temp = $row;
                        $FIND_ONE = true;
                        break;
                    }
                    else 
                    {
//                        echo 'Смотрим(';
                        $creditperiodlook = $creditperiodmin_temp + round($interval / 2);
//                        echo ')';
                        if ($creditperiodlook == $creditperiodmax_temp)
                            $creditperiodlook--;
                    }
                } // END for
                
                
//                echo '<br /><br />Следующая запись<br />';
                if ($FIND_ONE)
                {
                    if ($monthpay_last_good > $monthpay_total_good and ($rate_temp <= $rate_good or!$rate_good))
                    {
                        $monthpay_total_good = $monthpay_last_good;
                        $creditperiod_total_good = $creditperiod_last_good;
                        $array = $row;
                    }
                    $FIND_ONE = false;
                }

/////////////////////////////////////////////////////////////   END    Подбор процентов и срока под ежемесц            
   		      
    		}
		}
		
    
    $this->results['count_all'] = $count_all;
    //     
    $this->results['sql_filter_all'] = $sql_filter;


		

        if ($rate_good)
        {
echo '<pre>';        
            $sql_filter .= ' AND pp.rate_pp <= ' . ceil((float)$rate_good);
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
    	
    	if ($creditperiod_total_good > 2)
    	{
    	    $go = true;
    	    $temp = $creditperiod_total_good - 1;
    	    while ($go)
    	    {
                $pay = new Data_Edinstvo_Payment($this->paymenttypeid);
                $pay->setOverpayment();
                $pay->setSumcredit($this->sumcredit);
                $pay->setRate($rate_good);
                $pay->setCreditperiod($temp);
                $pay->make();
                if ($pay->getPayPerMonth() < $this->monthpay)
                {
                    echo $creditperiod_total_good = $temp;
                }
                else 
                {
                    $go = false;
                }
                $temp--;
                if (!$temp)
                    break;
    	    }
    	    
    	}
        $this->results['creditperiod'] = $creditperiod_total_good;