<?php
// Устар

// Рассчет платежей

/*
            Входные данные:
            ---------------

            $mod->rate = $session->rate;
            $mod->creditperiod = $session->creditperiod;
            $mod->sumcredit = $session->sumcredit_bank;
            $mod->paymenttypeid = $session->paymenttypeid;
*/

/*          $this->sumcredit;
            $this->rate;
            $this->firstpayment;
            $this->creditperiod;
*/            
            $sum_all = $this->sumcredit;
            $pay_over = 0;
            if (!strcmp($this->paymenttypeid, 'DIFF'))
            {
///////////////////////////////////////////////////////////////////
/////       Рассчёт диффер

                $N = $this->creditperiod * 12;
                $PER_M = $this->sumcredit / $N;
                
                 
                 $pay_month = (int)($PER_M 
                                     + ($this->sumcredit * $this->rate/100) / 12);
                     
//                 echo $this->no_overpayment , 11;

                 if (!$this->no_overpayment)
                 {
                     $pey_over = 0;
                     $sum_lessing = $this->sumcredit;
                     $KK = $this->rate/1200;
                     for ($x = 0; $x < $N; $x++)
                     {
                         $pey_over += $sum_lessing * $KK;
                        // echo '<br />';
                         $sum_lessing = (int)($sum_lessing - $PER_M);                     
                     }
//                     die();
                     $pay_over  = $pey_over;
                 }
///////////////////////////////////////////////////////////////////
            }
            else 
            {
///////////////////////////////////////////////////////////////////
/////       Рассчёт аутентивный
                $P = $this->rate/1200;
                $N = $this->creditperiod * 12;
    
                $A = ($P * pow((1 + $P), $N))
                             /
                    (pow((1 + $P), $N) - 1);
                 
                 $pay_month = (int)($A * $sum_all);
                 if (!$this->no_overpayment)
                 {
                     $pay_over  = (int)(($N * $A - 1) * $sum_all);
                 }
///////////////////////////////////////////////////////////////////            
            }
            
            $this->results['pay_month'] = $pay_month;
            $this->results['pay_over'] = $pay_over;

            
            
            
            
/*            if (!strcmp($session->paymenttypeid, 'DIFF'))
            {
///////////////////////////////////////////////////////////////////
/////       Рассчёт диффер
                
                $N = $session->creditperiod * 12;
                $PER_M = $session->sumcredit_bank / $N;
                
                 
                 $session->pay_month = (int)($PER_M 
                                     + ($session->sumcredit_bank * $session->rate/100) / 12);
                     
                                   
                 $pey_over = 0;
                 $sum_lessing = $session->sumcredit_bank;
                 $KK = $session->rate/1200;
                 for ($x = 0; $x < $N; $x++)
                 {
                     $pey_over += $sum_lessing * $KK;
                     $sum_lessing = (int)($sum_lessing - $PER_M);                     
                 }
                 $session->pay_over  = $pey_over;
            
///////////////////////////////////////////////////////////////////
            }
            else 
            {
///////////////////////////////////////////////////////////////////
/////       Рассчёт аутентивный
                $P = $session->rate/1200;
                $N = $session->creditperiod * 12;
    
                $A = ($P * pow((1 + $P), $N))
                             /
                    (pow((1 + $P), $N) - 1);
                 
                 $session->pay_month = (int)($A * $sum_all);
                 $session->pay_over  = (int)(($N * $A - 1) * $sum_all);
///////////////////////////////////////////////////////////////////            
            }
            
*/            
            