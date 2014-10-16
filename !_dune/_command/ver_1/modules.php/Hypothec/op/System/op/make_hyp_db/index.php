<?php


require "functions.php";

define('NUM_VALUTA',            5);
define('NUM_RATE',              6);
define('NUM_RATE_BEFORE',       7);
define('NUM_firstpayment',      8);
define('NUM_creditperiod',      9);
define('NUM_loansecurityid',    10);
define('NUM_sumcreditmin',      11);
define('NUM_sumcreditmax',      12);
define('NUM_lombard_part',      13);
define('NUM_incconfirm',        14);
define('NUM_approveperiod',     15);
define('NUM_paymenttypeid',     16);
define('NUM_advrepay',          17);
define('NUM_advrepay_min_sum',  18);
define('NUM_agemin',            19);
define('NUM_agemax',            20);
define('NUM_nationality',       21);
define('NUM_registration',      22);
define('NUM_seniority_total',   23);
define('NUM_seniority_last',    24);
define('NUM_guarantor',         25);
define('NUM_soborrower',        26);

define('NUM_examination',       27);
define('NUM_check',             28);
define('NUM_valuation',         29);
define('NUM_insurance',         30);
define('NUM_commission',        31);
define('NUM_account_commission',32);
define('NUM_lead_account',      33);
define('NUM_make_document',     34);
define('NUM_less1lemon',        35);
define('NUM_cashless',          36);
define('NUM_cash',              37);
define('NUM_safe',              38);
define('NUM_transferring',      39);
define('NUM_delinquency',       40);

define('NUM_advrepay_commission', 41);
define('NUM_notarius',          42);
        
define('NUM_url',               43);
define('NUM_email',             44);
define('NUM_phone',             45);
define('NUM_bonus',             46);





$current_bank = 0;

$this->messageText['result'] = 'Тестовая работа';
$this->messageText['miss'] = '';

//echo $this->file;

$miss_code = 0; // Код ошибки - по умолчанию - нет.
$miss_line = 0;

$kinds_array_db = array();
$incconfirm_array_db = array();
$pe_array_db = array();
$p_array_db = array();
$pp_array_db = array();

// А есть ли файл
if (is_file($this->file))
{
    $count_begin = 2; // с какой строки начинается интрепретация.
    $count = 1;
    $file =  fopen ($this->file,"r");
    $program_array_o = new Dune_Array_Container(array());
    $current_program_id = 0;
    $current_pprogram_id = 0;  
    $pp_array_db = array();
    $p_array_db = array();
    
    // Перебираем строчки файла
    while (($data = fgetcsv($file, 10000, ";")) !== false) 
    {
        $miss_line = $count;
        // Пропускем первую
        if ($count < $count_begin)
        {
            $count++;
            continue;
        }
        // строка не считалась
        if (count($data) < 5)
        {
            $count++;
            continue;
        }   
//////////////////////////////////////////////////////////////////////////////////
////
///     Разбор строки из файла csv
//

// Массив в контейнер
$data_o = new Dune_Array_Container($data);



// Исли строка пустая или лишняя - игнорируется
if (strlen(trim($data_o->get(3))) < 3)
    continue;

//if ($program_array_o->count() < 5)
//    $program_array_o = $data_o;

$status = 'no';

// Если это программа
if (
       ($program_array_o->get(2) != $data_o->get(2))
       and 
       (strlen(trim($data_o->get(2))) > 3)
   )
{

    echo '<br /><strong>Найдена программа: ' . $data_o->get(2) . '</strong>';
    $program_array_o = clone $data_o;
    
    // Если в записи подпрограммы нет информ. о валюте - берём из программы.
    if (Dune_Text_Functions::strToInt($program_array_o->get(NUM_sumcreditmax)) < 100)
        $program_array_o->set(NUM_sumcreditmax, 30000000);
    $current_program_id++;
    $current_pprogram_id++;
    
    $status = 'p'; // Сохраняем статус - программа.

}
else 
{
    // Подпрограмма может быть только после программы
    if (strlen(trim($program_array_o->get(2))) < 3 )
    {
        $miss_code = 1;
        $miss_line = $count;
        break;
    }
    $current_pprogram_id++;
    echo '<br />Найдена подпрограмма: ' . $data_o->get(3);
    $status = 'pp'; // Сохраняем статус - подпрограмма.
//
///////////////////////////////////////////////////////////  
}


$data_o->set(1, Dune_Text_Functions::strToInt($data_o->get(1)));


if ($data_o->get(1) < 1 and $current_bank == 0)
{
    continue;
}
else if ($data_o->get(1) < 1)
{
    $data_o->set(1, $current_bank);
}
else 
    $current_bank = $data_o->get(1);

echo ' - ' , $data_o->get(1), ' - ';    
echo '<strong>Банк: ' . $current_bank . '</strong>';

if ($data_o->get(1) == 9)
    echo $data_o;
if ($status == 'p')
{
/////////////////////////////////////////////////////////
//
//      Обработка строки с программой
//    
    
    //  Обеспечение кредита
    $x = (int)$data_o->get(NUM_loansecurityid);
    switch ($x)
    {
        case 2:
            $loansecurityid = 'NEW';
        break;
        case 3:
            $loansecurityid = 'OWN';
        break;
        case 4:
            $loansecurityid = 'OTHER';
        break;
        default:
            $loansecurityid = 'ALL';
    }
    
    $array = bracketContent($data_o->get(NUM_loansecurityid));
    if (!count($array))
        $loansecurityid_info = '';
    else if ($array[0] === false) 
    {
        $miss_code = 2;
        break;            
    }
    else 
        $loansecurityid_info = $array[0];
        

    //  Гражданство
    $x = (int)$data_o->get(NUM_nationality);
    switch ($x)
    {
        case 2:
            $data_o->set(NUM_nationality, 'REQUIRED');
        break;
        case 3:
            $data_o->set(NUM_nationality, 'NOTREQUIRED');
        break;
        default:
            $data_o->set(NUM_nationality, 'ALL');
    }
    
    //  Регистрация
    switch ((int)$data_o->get(NUM_registration))
    {
        case 2:
            $data_o->set(NUM_registration, 'REQUIRED');
        break;
        case 3:
            $data_o->set(NUM_registration, 'NOTREQUIRED');
        break;
        default:
            $data_o->set(NUM_registration, 'ALL');
    }
      
    
    $p_one_array_db = array(
    'id' => $current_program_id,
    'bank_id' =>  $data_o->get(1),
    'name' => $data_o->get(2),
    'url' => $data_o->get(NUM_url),
    'bonus' => $data_o->get(NUM_bonus),
    'currencyid' => $data_o->get(NUM_VALUTA),
    'loansecurityid' => $loansecurityid,
    'loansecurityid_info' => $loansecurityid_info,
    'approveperiod' => (int)$data_o->get(NUM_approveperiod),
    'agemin' => (int)$data_o->get(NUM_agemin),
    'agemax' => (int)$data_o->get(NUM_agemax),
    'registration' => $data_o->get(NUM_registration),
    'nationality' => $data_o->get(NUM_nationality),
    'seniority_total' => (int)$data_o->get(NUM_seniority_total),
    'seniority_last' => (int)$data_o->get(NUM_seniority_last),
    'advrepay' => (int)$data_o->get(NUM_advrepay),
    'advrepay_min_sum' => Dune_Text_Functions::strToInt($data_o->get(NUM_advrepay_min_sum)),
    'page' => $data_o->get(NUM_url),
    'email' => $data_o->get(NUM_email),
    'phone' => $data_o->get(NUM_phone),
    );
    
    //$advrepay_min_sum_currencyid = whiteSpaceContent($data_o->get(NUM_advrepay_min_sum));
    //$p_one_array_db['advrepay_min_sum_currencyid'] = currencyFromRus($advrepay_min_sum_currencyid);

    $bracket = bracketContent($data_o->get(NUM_advrepay_min_sum));
    if (!isset($bracket[0]))
        $bracket[0] = '%';
    $p_one_array_db['advrepay_min_sum_currencyid'] = currencyFromRus($bracket[0]);
    
    
// Поручители    
    if ($data_o->get(NUM_guarantor))
    {
        $p_one_array_db['guarantor'] = 1;
        if(($pos_dot_dot = strpos($data_o->get(NUM_guarantor), ':')) !== false)
            $p_one_array_db['guarantor_comment'] = substr($data_o->get(NUM_guarantor), $pos_dot_dot + 1);
    }

// Созаёмщики
    if ($data_o->get(NUM_soborrower))
    {
        $p_one_array_db['soborrower'] = 1;
        if(($pos_dot_dot = strpos($data_o->get(NUM_soborrower), ':')) !== false)
            $p_one_array_db['soborrower_comment'] = substr($data_o->get(NUM_soborrower), $pos_dot_dot + 1);
    }

// Нотариальное оформление договора с комментариями
    if ($data_o->get(NUM_notarius))
    {
        $p_one_array_db['notarius'] = 1;
        if(($pos_dot_dot = strpos($data_o->get(NUM_notarius), ':')) !== false)
            $p_one_array_db['notarius_comment'] = substr($data_o->get(NUM_notarius), $pos_dot_dot + 1);
    }
    
    
    // Тип платежей
    $p_one_array_db['paymenttypeid'] = (int)$data_o->get(NUM_paymenttypeid);
    $p_one_array_db['paymenttypeid'] = paymenttypeidFromNumbers($p_one_array_db['paymenttypeid']);

    // Тип платежей - комментарии
    $array = bracketContent($data_o->get(NUM_paymenttypeid));
    if (!count($array))
        $p_one_array_db['paymenttypeid_comment'] = '';
    else if ($array[0] === false) 
    {
        $miss_code = 2;
        break;            
    }
    else 
        $p_one_array_db['paymenttypeid_comment'] = $array[0];
    
    
//////////////////////////      Фиксируем массив для запроса    
    $p_array_db[] = $p_one_array_db;

    //$current_program_id++;
    
/////////////////////////////////////////////////////////////////////////                     фОРМИРОВАНИЕ Т. РАСХОДОВ
/////       ФОРМИРУЕМ МАССИВ ДЛЯ СОХРАНЕНИЯ В ТАБЛИЦУ РАСХОДОВ ПО КРЕДИТУ
///// 2222

    $pe_one_array_db = array(
                                'exp_id' => $current_program_id,
                            );
 
    
//    require 'add.php';
    //function doArray($name, $num, $object, &$array_db)
    
    doArray('examination', NUM_examination, $data_o , $pe_one_array_db);
    doArray('check', NUM_check, $data_o , $pe_one_array_db);
    doArray('valuation', NUM_valuation, $data_o , $pe_one_array_db);
    doArray('insurance', NUM_insurance, $data_o , $pe_one_array_db);
    // Комиссия
    doArray('commission', NUM_commission, $data_o , $pe_one_array_db);    
    // 
    doArray('account_commission', NUM_account_commission, $data_o , $pe_one_array_db);    
    // Ведение ссудного счета
    doArray('lead_account', NUM_lead_account, $data_o , $pe_one_array_db);    

    // Оформление документов по ипотеке 
    doArray('make_document', NUM_make_document, $data_o , $pe_one_array_db);    
    // Безналичное перечисление кредитных средств
    doArray('cashless', NUM_cashless, $data_o , $pe_one_array_db);    
    // 
    doArray('cash', NUM_cash, $data_o, $pe_one_array_db);    
    // Аренда сейфа 
    doArray('safe', NUM_safe, $data_o, $pe_one_array_db);    

    // 
    doArray('transferring', NUM_transferring, $data_o, $pe_one_array_db);    
    // 
    doArray('delinquency', NUM_delinquency, $data_o, $pe_one_array_db);    
    
    // 
    doArray('less1lemon', NUM_less1lemon, $data_o, $pe_one_array_db);    
    
    // Плата за досрочное погашение кредита
    doArray('advrepay_commission', NUM_advrepay_commission, $data_o, $pe_one_array_db);
    
    
    $pe_array_db[] = $pe_one_array_db;
///// 2222      END
/////////////////////////////////////////////////////////////////////////               фОРМИРОВАНИЕ Т. РАСХОДОВ КОНЕЦ
    
    
    
    
    
}    
////////
//////////////////////////////////////////////////////////////// 

    

/////////////////////////////////////////////////
////////    Для заполнения таблицы подпрограмм    

    $array = bracketContent($data_o->get(NUM_firstpayment));
    if (!count($array))
        $firstpayment_comments_pp = '';
    else if ($array[0] === false) 
    {
        $miss_code = 2;
        break;            
    }
    else 
        $firstpayment_comments_pp = $array[0];
      
    // Если в записи подпрограммы нет информ. о валюте - берём из программы.
    if (strlen($data_o->get(NUM_VALUTA)) < 3)
        $data_o->set(NUM_VALUTA, $program_array_o->get(NUM_VALUTA));       

    // Если в записи подпрограммы нет информ. о валюте - берём из программы.
    if (strlen($data_o->get(NUM_sumcreditmin)) < 1)
        $data_o->set(NUM_sumcreditmin, $program_array_o->get(NUM_sumcreditmin));       
        
    // Если в записи подпрограммы нет информ. о валюте - берём из программы.
    if (Dune_Text_Functions::strToInt($data_o->get(NUM_sumcreditmax)) < 100)
        $data_o->set(NUM_sumcreditmax, $program_array_o->get(NUM_sumcreditmax));
        
    // Если в записи подпрограммы нет информ. о валюте - берём из программы.
    if (strlen($data_o->get(NUM_paymenttypeid)) < 1)
        $data_o->set(NUM_paymenttypeid, $program_array_o->get(NUM_paymenttypeid));

        
      
    $pp_one_array_db = array(
    'pprogram_id' => $current_pprogram_id,
    'program_id' => $current_program_id,
    'name_pp' => $data_o->get(3),
    'rate_pp' =>  Dune_Text_Functions::strToFloat($data_o->get(NUM_RATE)),
    'rate_before_pp' =>  Dune_Text_Functions::strToFloat($data_o->get(NUM_RATE_BEFORE)),
    'firstpayment_pp' => Dune_Text_Functions::strToInt($data_o->get(NUM_firstpayment)),
    'firstpayment_comments_pp' => $firstpayment_comments_pp,
    'creditperiod_pp' => Dune_Text_Functions::strToInt($data_o->get(NUM_creditperiod)),
    'sumcreditmin_pp' => Dune_Text_Functions::strToInt($data_o->get(NUM_sumcreditmin)),
    'sumcreditmax_pp' => Dune_Text_Functions::strToInt($data_o->get(NUM_sumcreditmax)),
    'paymenttypeid_pp' => (int)$data_o->get(NUM_paymenttypeid),
    'currencyid_pp'  => $data_o->get(NUM_VALUTA),
    );

    // Учёт максимума первоначального взноса
    $array = bracketContent($data_o->get(NUM_firstpayment));
    if (count($array))
        $pp_one_array_db['firstpayment_max_pp'] = $array[0];
    
    
    $array = bracketContent($data_o->get(NUM_creditperiod));
    if (count($array))
        $pp_one_array_db['creditperiod_min_pp'] = $array[0];
    
    if ($current_pprogram_id == 111)
     echo '<strong>' , new Dune_Array_Container($pp_one_array_db) , ' - ' . '</strong>';

    if (!in_array($data_o->get(NUM_VALUTA), array('RUR', 'USD', 'EUR', 'ALL')))
    {
        echo '<br /><strong>!!!Ошибка интерпретации строки';
        echo new Dune_Array_Container($pp_one_array_db);
        echo '</strong>';
        continue;
    }
     
   
    // Плавающая кредитная ставка если нашли - внедряем
    $rate_float = getRateFloat($data_o->get(NUM_RATE));
    if ($rate_float !== false)
    {
        $pp_one_array_db['rate_float_pp'] = $rate_float['rate_float_pp'];
        $pp_one_array_db['rate_float_value_pp'] = $rate_float['rate_float_value_pp'];
    }
    
    // Если указана доля от стоимости при ломбардном кредитовании.
    if ($data_o->get(NUM_lombard_part))
    {
        $pp_one_array_db['lombard_part_pp'] = Dune_Text_Functions::strToInt($data_o->get(NUM_lombard_part));
    }
    $array = bracketContent($data_o->get(NUM_lombard_part));
    if (count($array))
        $pp_one_array_db['lombard_part_comments_pp'] = $array[0];
    
    
    $pp_array_db[] = $pp_one_array_db;    
////////
////////////////////////////////////////////////////////////////    

///////////////////////////////////////////////////////////////
////////        Таблица соответствий видам кредитования
    // Если в записи Вид кредитования для подпрограммы нет данных - берём из данных программы.
    if (strlen($data_o->get(4)) < 1)
        $data_o->set(4, $program_array_o->get(4));

        
    $array = makeArrayNotEmpty($data_o->get(4));
    $array = kindsFromNumbers($array);
    foreach ($array as $value)
    {
        $kinds_array_db[] = array(
                                        'pprogram_id' => $current_pprogram_id,
                                        'kinds'       => $value,
                                     );
    }
///////
///////////////////////////////////////////////////////////////    

///////////////////////////////////////////////////////////////
////////        Таблица соответствий Подтверждение дохода
    // Если в записи Вид кредитования для подпрограммы нет данных - берём из данных программы.
    if (strlen($data_o->get(NUM_incconfirm)) < 1)
        $data_o->set(NUM_incconfirm, $program_array_o->get(NUM_incconfirm));

        
    $array = makeArrayNotEmpty($data_o->get(NUM_incconfirm));
    $array = incconfirmidFromNumbers($array);
    foreach ($array as $value)
    {
        $incconfirm_array_db[] = array(
                                        'pprogram_id'   => $current_pprogram_id,
                                        'incconfirmid'  => $value,
                                     );
    }
///////
///////////////////////////////////////////////////////////////    


        
//\
///////////////////////////////////////////////////////////


if ($miss_code)
    break;



//\
///\
////\
//////////////////////////////////////////////////////////////////////////////////
            
    if ($data_o->get(1) == 9)
    {
        echo new Dune_Array_Container($p_one_array_db);
        echo new Dune_Array_Container($pp_one_array_db);
    }

        $count++;
    }
    fclose($file);
 
}


function _makeSetString($arrays)
    {
       	// Создаём строку SET
       	$set_str = '';
       	$x = 0;
       	foreach ((array)$arrays as $r_rey => $contents)
       	{
       		if ($x == 0)
       			$set_str.= ' SET `'.$r_rey.'`="' . mysql_real_escape_string($contents) . '"';
       		else
       			$set_str.= ', `'.$r_rey.'`="' . mysql_real_escape_string($contents) . '"' . "\n";
       		$x++;
       	}
        return $set_str;
    }




function insertToTable($tableName, $array, $drop = false)
{
	global $dbConn;
	if(empty($dbConn)) $dbConn = connectToDB(); 

    $q = 'TRUNCATE TABLE ' . $tableName;
    $result = mysql_query($q, $dbConn);
	if($result)
	{
	    foreach ($array as $value)
	    {
	       if (is_array($value))
	       {
    	       $set = _makeSetString($value);
    	       echo '<br />';
               echo $q = 'INSERT INTO ' . $tableName . $set;
               echo '<br />';
               if(!($result = mysql_query($q, $dbConn)))
                echo '<strong>' .  mysql_error() . '</strong><br /><br />';
	       }
	       else 
	           echo 'ДОЛЖЕН МАССИВ';
	    }
	}
	else 
	  $go_next = false;
}


if ($miss_code)
{
    switch ($miss_code)
    {
        case 1:
            $this->messageText['miss'] = 'Ошибка!!! Не была выбрана программа для подпрограммы. Cтрока: ' . $miss_line;
        break;
        case 2:
            $this->messageText['miss'] = 'Ошибка!!! Нет парной скобки. Cтрока: ' . $miss_line;
        break;
        
        default:
            $this->messageText['miss'] = 'Ошибка в строке: ' . $miss_line;
    }
    $this->results['done'] = false;
}
else 
{

/*
$kinds_array_db = array();
$incconfirm_array_db = array();
$pe_array_db = array();
$p_array_db = array();
$pp_array_db = array();
*/
    
    insertToTable('hypothec_incconfirm_correspondence_pprogram', $incconfirm_array_db, true);
    insertToTable('hypothec_kinds_correspondence_pprogram', $kinds_array_db, true);
    
    insertToTable('hypothec_pprograms', $pp_array_db, true);
    insertToTable('hypothec_programs', $p_array_db, true);
    insertToTable('hypothec_programs_expenses', $pe_array_db, true);
    
    $this->results['done'] = true;
}

/*
$session = Dune_Session::getInstance();
$session->openZone('to_db');
*/
