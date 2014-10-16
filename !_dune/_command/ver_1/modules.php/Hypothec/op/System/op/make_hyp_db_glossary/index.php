<?php


require "functions.php";

define('NUM_ID',            0);
define('NUM_NAME',          1);
define('NUM_NOTICE',        2);
define('NUM_TEXT',          3);

define('NUM_creditperiod',      9);
define('NUM_loansecurityid',    10);





$current_bank = 0;

$this->messageText['result'] = 'Тестовая работа';
$this->messageText['miss'] = '';

//echo $this->file;

$miss_code = 0; // Код ошибки - по умолчанию - нет.
$miss_line = 0;

$kinds_array_db = array();
$incconfirm_array_db = array();
$array_db = array();
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
        if (count($data) < 2)
        {
            $count++;
            continue;
        }   
//////////////////////////////////////////////////////////////////////////////////
////
///     Разбор строки из файла csv
//

// Массив в контейнер
echo $data_o = new Dune_Array_Container($data);



// Исли строка пустая или лишняя - игнорируется
if (!trim($data_o->get(NUM_ID)))
    continue;

//if ($program_array_o->count() < 5)
//    $program_array_o = $data_o;

$status = 'no';

    if (!$data_o->get(NUM_NOTICE))
        $data_o->set(NUM_NOTICE, $data_o->get(NUM_TEXT));
        
    echo $one_array_db['id'] = (int)$data_o->get(NUM_ID);
    $one_array_db['notice'] = $data_o->get(NUM_NOTICE);
    $one_array_db['name'] = $data_o->get(NUM_NAME);
    $one_array_db['TEXT'] = $data_o->get(NUM_TEXT);
    
    $array_db[] = $one_array_db;
    unset($one_array_db);
///// 2222      END
/////////////////////////////////////////////////////////////////////////               фОРМИРОВАНИЕ Т. РАСХОДОВ КОНЕЦ
    


//\
///\
////\
//////////////////////////////////////////////////////////////////////////////////
            

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
    
    insertToTable('hypothec_glossary', $array_db, true);
    
    $this->results['done'] = true;
}

/*
$session = Dune_Session::getInstance();
$session->openZone('to_db');
*/
