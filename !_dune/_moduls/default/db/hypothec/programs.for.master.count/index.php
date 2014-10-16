<?php
// Колличество прогамм с введёнными условиями
// Исходные данными - объект класса Dune_Session с открытой нужной зоной

		$dbConn = connectToDB();

$conditions = array();

$vars = Dune_Variables::getInstance();

if (!$vars->pensia_age)
    $vars->pensia_age = 65;

// Составление массива для изготовленияф фильтра запроса
if ($this->data->bank_id)
{
    $conditions[] = array(
                            'field' => 'p.bank_id',
                            'corr' => '=',
                            'digit' => 1,
                            'value' => $this->data->bank_id
                          );
}
if ($this->data->rate)
{
    $conditions[] = array(
                            'field' => 'pp.rate_pp',
                            'corr' => '<=',
                            'digit' => 1,
                            'value' => $this->data->rate
                          );
}

if ($this->data->firstpayment)
{
    $conditions[] = array(
                            'field' => 'pp.firstpayment_pp',
                            'corr' => '<=',
                            'digit' => 1,
                            'value' => $this->data->firstpayment
                          );
}

if ($this->data->currencyid and $this->data->currencyid != 'ALL')
{
    $conditions[] = array(
                            'field' => 'pp.currencyid_pp',
                            'corr' => '=',
                            'digit' => 0,
                            'value' => $this->data->currencyid
                          );
}
if ($this->data->age)
{
    $conditions[] = array(
                            'field' => 'p.agemin',
                            'corr' => '<=',
                            'digit' => 1,
                            'value' => $this->data->age
                          );
    $conditions[] = array(
                            'field' => 'p.agemax',
                            'corr' => '>=',
                            'digit' => 1,
                            'value' => $this->data->age
                          );
                          
                          
}
if ($this->data->paymenttypeid and $this->data->paymenttypeid  != 'ALL')
{
    $conditions[] = array(
                            'field' => 'p.paymenttypeid',
                            'corr' => '=',
                            'digit' => 0,
                            'value' => $this->data->paymenttypeid
                          );
}
if ($this->data->advrepay)
{
    $conditions[] = array(
                            'field' => 'p.advrepay',
                            'corr' => '<=',
                            'digit' => 1,
                            'value' => $this->data->advrepay
                          );
}

// Необхдимо для не треб регистрации учиывать и не важно
if ($this->data->registration and $this->data->registration  == 'NOTREQUIRED')
{
    $conditions[] = array(
                            'field' => 'p.registration',
                            'corr' => '<>',
                            'digit' => 0,
                            'value' => 'REQUIRED'
                          );
}
else if ($this->data->registration and $this->data->registration  != 'ALL')
{
    $conditions[] = array(
                            'field' => 'p.registration',
                            'corr' => '=',
                            'digit' => 0,
                            'value' => $this->data->registration
                          );
}


if ($this->data->nationality and $this->data->nationality  == 'NOTREQUIRED')
{
    $conditions[] = array(
                            'field' => 'p.nationality',
                            'corr' => '<>',
                            'digit' => 0,
                            'value' => 'REQUIRED'
                          );
}
else if ($this->data->nationality and $this->data->nationality  != 'ALL')
{
    $conditions[] = array(
                            'field' => 'p.nationality',
                            'corr' => '=',
                            'digit' => 0,
                            'value' => $this->data->nationality
                          );
}

if ($this->data->approveperiod)
{
    $conditions[] = array(
                            'field' => 'p.approveperiod',
                            'corr' => '<=',
                            'digit' => 1,
                            'value' => $this->data->approveperiod
                          );
}


if ($this->data->sumcredit)
{
    $conditions[] = array(
                            'field' => 'pp.sumcreditmin_pp',
                            'corr' => '<=',
                            'digit' => 1,
                            'value' => $this->data->sumcredit
                          );
    $conditions[] = array(
                            'field' => 'pp.sumcreditmax_pp',
                            'corr' => '>=',
                            'digit' => 1,
                            'value' => $this->data->sumcredit
                          );
                          
}
if ($this->data->creditperiodmin)
{
    $conditions[] = array(
                            'field' => 'pp.creditperiod_pp',
                            'corr' => '<=',
                            'digit' => 1,
                            'value' => $this->data->creditperiodmin
                          );
}
if ($this->data->creditperiodmax)
{
    $conditions[] = array(
                            'field' => 'pp.creditperiod_pp',
                            'corr' => '>=',
                            'digit' => 1,
                            'value' => $this->data->creditperiodmax
                          );
}
if ($this->data->loansecurityid and $this->data->loansecurityid  != 'ALL')
{
    $conditions[] = array(
                            'field' => 'p.loansecurityid ',
                            'corr' => '=',
                            'digit' => 0,
                            'value' => $this->data->loansecurityid
                          );
}

		
		
		
		
        $array = array();
		$sql_filter = ' ';
        if (count($conditions))
        {
            foreach ($conditions as $value)
            {
                $sql_filter .= 'AND ' . $value['field'] . ' ' . $value['corr'] . ' "' . mysql_real_escape_string($value['value']) . '" ';
            }
        }
        
        
    if ($this->data->kinds and $this->data->kinds  != 'NOLIMIT')
    {
        $sql_filter .= ' AND `pp`.`pprogram_id` IN 
                        (
                        SELECT DISTINCT pprogram_id 
                        FROM `hypothec_kinds_correspondence_pprogram`
                        WHERE `kinds` = "' . mysql_real_escape_string($this->data->kinds) . '" 
                        )';
    }
    if ($this->data->incconfirmid and $this->data->incconfirmid  != 'ANY')
    {
        $sql_filter .= ' AND `pp`.`pprogram_id` IN 
                        (
                        SELECT DISTINCT pprogram_id 
                        FROM `hypothec_incconfirm_correspondence_pprogram`
                        WHERE `incconfirmid` = "' . mysql_real_escape_string($this->data->incconfirmid) . '" 
                        )';
    }

    
// необходимо учитывать время отдачи кредита
if ((int)$this->data->age > 25)
{
        $sql_filter_age .= ' AND `pp`.`pprogram_id` IN 
                        (
                        SELECT DISTINCT pp.pprogram_id 
                        FROM `hypothec_pprograms` pp, `hypothec_programs` p
                        WHERE pp.`creditperiod_min_pp` < p.agemax - ' . (int)$this->data->age . ' 
                        )';
    
}
else 
    $sql_filter_age = '';
    
        
//print_array($sql);
		$sql_count = '
				SELECT count(*) as count
					
				FROM
					`hypothec_programs` p, `hypothec_pprograms` pp, `hypothec_bank` bank
				WHERE
					`p`.`id` = `pp`.program_id
					 AND `p`.`bank_id` = `bank`.`id`'
					 . $sql_filter . $sql_filter_age;
					 
	
		$result = mysql_query($sql_count, $dbConn);
   		$row = mysql_fetch_assoc($result);
   		
	    $this->results['count'] = $row['count'];
//	    $this->setResult('count', $row['count']);
	    
    	$this->results['array'] = $array;
//    	$this->setResult('array', $array);