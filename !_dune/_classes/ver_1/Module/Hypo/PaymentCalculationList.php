<?php

class Module_Hypo_PaymentCalculationList extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        

    $dbConn = connectToDB();

if (is_null($this->offset))
    $this->offset = 0;
if (!$this->count)    
    $this->count = 50;		
		
        $array = array();
		$sql_filter = $this->sql_filter;
		$sql = '
				SELECT pp.*, p.*, bank.name
					
				FROM
					`hypothec_programs` p, `hypothec_pprograms` pp, `hypothec_bank` bank
				WHERE
					`p`.`id` = `pp`.program_id
					 AND `p`.`bank_id` = `bank`.`id`'
					 . $sql_filter . '
					 ORDER BY `pp`.`' . $this->order_col_name . '` ' . $this->asc_desc . '
					 LIMIT ' . $this->offset . ', ' . $this->count . '
		';

					 
		$result = mysql_query($sql, $dbConn);
		if(mysql_num_rows($result) > 0)
		{
		    $session = Dune_Session::getInstance($this->session_name);
            $sum_all = $session->getFloat('sumcredit');
            $session->sumcredit_bank = $sum_all = $sum_all - $sum_all * ($session->firstpayment / 100);
		    $sum_first =  $sum_all * ($session->firstpayment / 100);
            
    		$MAIN_creditperiod = $session->creditperiod_fact;
            $mod = new Module_Hypo_PaymentCalculation();
            $mod->creditperiod = $MAIN_creditperiod;
            $mod->sumcredit = $session->sumcredit_bank;
            $mod->paymenttypeid = $session->paymenttypeid;

            
    		while ($row = mysql_fetch_assoc($result)) 
    		{

            $mod->rate = $row['rate_pp'];
            $mod->make();
            
            $row['sum_first'] = $sum_first;
            $row['sum_all'] = $sum_all;
            $row['creditperiod_fact'] = $MAIN_creditperiod;
            $row['sum_bank'] = $session->sumcredit_bank;
            $row['pay_month'] = $mod->getResult('pay_month');
            $row['pay_month_dolg'] = $mod->getResult('pay_month_dolg');
            $row['pay_over']  = $mod->getResult('pay_over');
    		    
            $row['pay_lgota'] = '';
            if ($row['bank_id'] == 1 and $row['pay_month_dolg'] and $row['pay_month_dolg'] > 0) 
            {
                if (strcmp($row['paymenttypeid_pp'], 'ANNUIT'))
                {
                    $row['pay_lgota'] = $row['pay_month_dolg'] + ($row['pay_month'] - $row['pay_month_dolg']) / 2;
                } 
    		    
    		}
    		$array[] = $row;
    		}
    		
    		
		}
	    
    	$this->results['array'] = $array;

            
            
            
            

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    