<?php

  function doArray($name, $num, $object, &$array_db)
  { echo  11;
        
       if ($object->get($num))
        {
            $array_db[$name . '_value'] = (float)$object->get($num);
            
            $currencyid = whiteSpaceContent($object->get($num));
            $array_db[$name . '_value_unit'] = currencyFromRus($currencyid);
            
            
            $array = bracketContent($object->get($num));
            if (!count($array))
            {
                $miss_code = 3;
                $miss_line = $count;
                break;            
            }
            else if ($array[0] === false) 
            {
                $miss_code = 2;
                break;            
            }
            else if (isset($array[0]))
            {
                if (isset($array[0]))
                {
                    $array_db[$name . '_periodicity'] = timeFromRus($array[0]);
                }
                if (isset($array[1]))
                {
                    $array_db[$name . '_info'] = $array[1];
                }
                
            }
        }
    }        
        

/*
  `exp_id` int(10) unsigned NOT NULL default '0',
  `examination_value` float default NULL,
  `examination_periodicity` set('DAY','WEEK','MONTH','QUARTER','YEAR','ONCE') default 'ONCE',
  `examination_value_unit` set('PERCENT','RUR','USD','EUR') default 'RUR',
  
  `check_value` float unsigned default NULL,
  `check_periodicity` set('DAY','WEEK','MONTH','QUARTER','YEAR','ONCE') default 'ONCE',
  `check_value_unit` set('PERCENT','MONEY') default 'MONEY',
  `check_info` text,
  
  `valuation_value` float unsigned default NULL,
  `valuation_periodicity` set('DAY','WEEK','MONTH','QUARTER','YEAR','ONCE') NOT NULL default 'ONCE',
  `valuation_value_unit` set('PERCENT','RUR','USD','EUR') NOT NULL default 'RUR',
  `valuation_info` text NOT NULL,
  
  `insurance_value` float unsigned default NULL,
  `insurance_periodicity` set('DAY','WEEK','MONTH','QUARTER','YEAR','ONCE') NOT NULL default 'ONCE',
  `insurance_value_unit` set('PERCENT','RUR','USD','EUR') NOT NULL default 'RUR',
  `insurance_info` text NOT NULL,
  
  `commission_value` float unsigned default NULL,
  `commission_periodicity` set('DAY','WEEK','MONTH','QUARTER','YEAR','ONCE') NOT NULL default 'ONCE',
  `commission_value_unit` set('PERCENT','RUR','USD','EUR') NOT NULL default 'RUR',
  `commission_info` text NOT NULL,
  
  `account_commission_value` float unsigned default NULL,
  `account_commission_periodicity` set('DAY','WEEK','MONTH','QUARTER','YEAR','ONCE') NOT NULL default 'ONCE',
  `account_commission_value_unit` set('PERCENT','RUR','USD','EUR') NOT NULL default 'RUR',
  `account_commission_info` text NOT NULL,
  
  `lead_account_value` float unsigned default NULL,
  `lead_account_periodicity` set('DAY','WEEK','MONTH','QUARTER','YEAR','ONCE') NOT NULL default 'ONCE',
  `lead_account_value_unit` set('PERCENT','RUR','USD','EUR') NOT NULL default 'RUR',
  `lead_account_info` text NOT NULL,
  
  `make_document_value` float unsigned default NULL,
  `make_document_periodicity` set('DAY','WEEK','MONTH','QUARTER','YEAR','ONCE') NOT NULL default 'ONCE',
  `make_document_value_unit` set('PERCENT','RUR','USD','EUR') NOT NULL default 'RUR',
  `make_document_info` text NOT NULL,
  
  `cashless_value` float unsigned default NULL,
  `cashless_periodicity` set('DAY','WEEK','MONTH','QUARTER','YEAR','ONCE') NOT NULL default 'ONCE',
  `cashless_value_unit` set('PERCENT','RUR','USD','EUR') NOT NULL default 'RUR',
  `cashless_info` text NOT NULL,
  
  `cash_value` float unsigned default NULL,
  `cash_periodicity` set('DAY','WEEK','MONTH','QUARTER','YEAR','ONCE') NOT NULL default 'ONCE',
  `cash_value_unit` set('PERCENT','RUR','USD','EUR') NOT NULL default 'RUR',
  `cash_info` text NOT NULL,
  
  `safe_value` float unsigned default NULL,
  `safe_periodicity` set('DAY','WEEK','MONTH','QUARTER','YEAR','ONCE') NOT NULL default 'ONCE',
  `safe_value_unit` set('PERCENT','RUR','USD','EUR') NOT NULL default 'RUR',
  `safe_info` text NOT NULL,
  
  `transferring_value` float unsigned default NULL,
  `transferring_periodicity` set('DAY','WEEK','MONTH','QUARTER','YEAR','ONCE') NOT NULL default 'ONCE',
  `transferring_value_unit` set('PERCENT','RUR','USD','EUR') NOT NULL default 'RUR',
  `transferring_info` text NOT NULL,
  
  `delinquency_value` float unsigned default NULL,
  `delinquency_periodicity` set('DAY','WEEK','MONTH','QUARTER','YEAR','ONCE') NOT NULL default 'ONCE',
  `delinquency_value_unit` set('PERCENT','RUR','USD','EUR') NOT NULL default 'RUR',
  `delinquency_info` text NOT NULL,

*/

   // Рассмотрение кредитной заявки
    if ($data_o->get(26))
    {
        $pe_one_array_db['examination_value'] = (int)$data_o->get(26);
        
        $currencyid = whiteSpaceContent($data_o->get(26));
        $pe_one_array_db['examination_value_unit'] = currencyFromRus($currencyid);
        
        
        $array = bracketContent($data_o->get(26));
        if (!count($array))
        {
            $miss_code = 3;
            $miss_line = $count;
            break;            
        }
        else if ($array[0] === false) 
        {
            $miss_code = 2;
            break;            
        }
        else if (isset($array[0]))
        {
            if (isset($array[0]))
            {
                $pe_one_array_db['examination_periodicity'] = timeFromRus($array[0]);
            }
        }
    }

    // Проверка документов и объекта ипотеки 
    if ($data_o->get(27))
    {
        $pe_one_array_db['check_value'] = (float)$data_o->get(27);
        
        $currencyid = whiteSpaceContent($data_o->get(27));
        $pe_one_array_db['check_value_unit'] = currencyFromRus($currencyid);
        
        
        $array = bracketContent($data_o->get(27));
        if (!count($array))
        {
            $miss_code = 3;
            $miss_line = $count;
            break;            
        }
        else if ($array[0] === false) 
        {
            $miss_code = 2;
            break;            
        }
        else if (isset($array[0]))
        {
            if (isset($array[0]))
            {
                $pe_one_array_db['check_periodicity'] = timeFromRus($array[0]);
            }
            if (isset($array[1]))
            {
                $pe_one_array_db['check_info'] = $array[1];
            }
            
        }
    }    

    
    // Оценка объекта ипотеки 
    if ($data_o->get(28))
    {
        $pe_one_array_db['valuation_value'] = (float)$data_o->get(28);
        
        $currencyid = whiteSpaceContent($data_o->get(28));
        $pe_one_array_db['valuation_value_unit'] = currencyFromRus($currencyid);
        
        
        $array = bracketContent($data_o->get(28));
        if (!count($array))
        {
            $miss_code = 3;
            $miss_line = $count;
            break;            
        }
        else if ($array[0] === false) 
        {
            $miss_code = 2;
            break;            
        }
        else if (isset($array[0]))
        {
            if (isset($array[0]))
            {
                $pe_one_array_db['valuation_periodicity'] = timeFromRus($array[0]);
            }
            if (isset($array[1]))
            {
                $pe_one_array_db['valuation_info'] = $array[1];
            }
            
        }
    }        
    
    // Страховка
    if ($data_o->get(29))
    {
        $pe_one_array_db['insurance_value'] = (float)$data_o->get(29);
        
        $currencyid = whiteSpaceContent($data_o->get(29));
        $pe_one_array_db['insurance_value_unit'] = currencyFromRus($currencyid);
        
        
        $array = bracketContent($data_o->get(29));
        if (!count($array))
        {
            $miss_code = 3;
            $miss_line = $count;
            break;            
        }
        else if ($array[0] === false) 
        {
            $miss_code = 2;
            break;            
        }
        else if (isset($array[0]))
        {
            if (isset($array[0]))
            {
                $pe_one_array_db['insurance_periodicity'] = timeFromRus($array[0]);
            }
            if (isset($array[1]))
            {
                $pe_one_array_db['insurance_info'] = $array[1];
            }
            
        }
    }
    
  