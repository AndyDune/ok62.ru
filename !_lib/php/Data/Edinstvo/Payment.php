<?php
// ������� ��������

/*
            ������� ������:
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

class Data_Edinstvo_Payment
{
    protected $paymenttypeid;
    
    protected $sumcredit;
    protected $creditperiod;
    protected $rate;
    protected $overpayment = true;
    
    protected $pay_month = 0;
    protected $pay_over = 0;
    
    
    public function __construct($paymenttypeid = 'ANNUIT')
    {
        $this->paymenttypeid = $paymenttypeid;
    }
    
    
    public function setSumcredit($value)
    {
        $this->sumcredit = $value;
    }

    public function setCreditperiod($value)
    {
        $this->creditperiod = $value;
    }

    public function setRate($value)
    {
        $this->rate = $value;
    }
    
    public function setOverpayment($value = false)
    {
        $this->overpayment = $value;
    }
    
    public function getPayPerMonth()
    {
        return $this->pay_month;
    }
    
    public function getOverpayment()
    {
        return $this->pay_over;
    }

    public function make()
    {
            $sum_all = $this->sumcredit;
            $pay_over = 0;
            if (!strcmp($this->paymenttypeid, 'DIFF'))
            {
///////////////////////////////////////////////////////////////////
/////       ������� ������
                
                $N = $this->creditperiod * 12;
                $PER_M = $sum_all / $N;
                
                 
                 $pay_month = (int)($PER_M 
                                     + ($sum_all * $this->rate/100) / 12);
                     
                 if ($this->overpayment)
                 {
                     $pey_over = 0;
                     $sum_lessing = $this->sumcredit;
                     $KK = $this->rate/1200;
                     for ($x = 0; $x < $N; $x++)
                     {
                         $pey_over += $sum_lessing * $KK;
                         $sum_lessing = (int)($sum_lessing - $PER_M);                     
                     }
                     $pay_over  = $pey_over;
                 }
///////////////////////////////////////////////////////////////////
            }
            else 
            {
///////////////////////////////////////////////////////////////////
/////       ������� �����������
                $P = $this->rate/1200;
                $N = $this->creditperiod * 12;
    
                $A = ($P * pow((1 + $P), $N))
                             /
                    (pow((1 + $P), $N) - 1);
                 
                 $pay_month = (int)($A * $sum_all);
                 if ($this->overpayment)
                 {
                     $pay_over  = (int)(($N * $A - 1) * $sum_all);
                 }
///////////////////////////////////////////////////////////////////            
            }
            
            $this->pay_month = $pay_month;
            $this->pay_over = $pay_over;
    }
            
}         
            
            
/*            if (!strcmp($session->paymenttypeid, 'DIFF'))
            {
///////////////////////////////////////////////////////////////////
/////       ������� ������
                
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
/////       ������� �����������
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
            