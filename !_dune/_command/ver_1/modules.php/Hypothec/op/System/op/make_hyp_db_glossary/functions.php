<?php

function getRateFloat($str)
{
    $result = false;
    $array = Dune_Text_Functions::makeArrayNotEmpty($str, '+');
    if (count($array) == 3)
    {
        $result = array();
        $result['rate_float_pp'] = substr($array[1], 0, 6);
        $result['rate_float_value_pp'] = Dune_Text_Functions::strToFloat($array[2]);
    }
    return $result;
}


// —троку с разделител€ми в массив - пустые удал€ютс€
function makeArrayNotEmpty($str, $char = ',')
{
    $str = trim($str);
    $array_result = array();
    if ($str)
    {
        $array_begin = explode($char, $str);
        foreach ((array)$array_begin as $value)
        {
            $x = trim($value);
            if ($x)
            {
                $array_result[] = $x;
            }
        }
    }
    return $array_result;
}



// ¬иды кредита из числа (exel) в таблицу (система)
function kindsFromNumbers($array)
{
    $array_result = array();
    if (!count($array))
        return $array_result;
    foreach ($array as $value)
    {
        switch ($value)
        {
            case 1:
                $array_result[] = 'VTOR';
            break;
            case 2:
                $array_result[] = 'NOCITYALL';
            break;
            case 3:
                $array_result[] = 'NOCITYVTOR';
            break;
            case 4:
                $array_result[] = 'NOCITYNEW';
            break;
            case 5:
                $array_result[] = 'HYP';
            break;
            case 6:
                $array_result[] = 'PAWNSHOP';
            break;
            case 7:
                $array_result[] = 'NEW';
            break;
            case 8:
                $array_result[] = 'REFINANCING';
            break;
            case 9:
                $array_result[] = 'IMPROVE';
            break;
            case 10:
                $array_result[] = 'ROOM';
            break;
            case 11:
                $array_result[] = 'REMONT';
            break;
            case 12:
                $array_result[] = 'EARTH';
            break;
            case 13:
                $array_result[] = 'NOAIM';
            break;
            
        }
    }
    return $array_result;
}

function incconfirmidFromNumbers($array)
{
    $array_result = array();
    if (!count($array))
        return $array_result;
    foreach ($array as $value)
    {
        switch ($value)
        {
            case 1:
                $array_result[] = 'ANY';
            break;
            case 2:
                $array_result[] = 'NOTREQUIRED';
            break;
            case 3:
                $array_result[] = '2NDFL';
            break;
            case 4:
                $array_result[] = '3NDFL';
            break;
            case 5:
                $array_result[] = 'HISTORY';
            break;
            case 6:
                $array_result[] = 'FREEFORM';
            break;
            case 7:
                $array_result[] = 'BANKFORM';
            break;
            case 8:
                $array_result[] = 'OTCH';
            break;
            case 9:
                $array_result[] = 'VERBAL';
            break;
            case 10:
                $array_result[] = 'WHATEVER';
            break;
        }
    }
    return $array_result;
}

  function doArray($name, $num, $object, &$array_db)
    {
       if ($object->get($num))
        {
            $array_db[$name . '_value'] = Dune_Text_Functions::strToFloat($object->get($num));
            
            //$currencyid = whiteSpaceContent($object->get($num));
            $array_db[$name . '_value_unit'] = currencyFromRus('р');
            
            
            $array = bracketContent($object->get($num));
            if (!count($array))
            {
                $miss_code = 3;
                //$miss_line = $count;
                return;
                //break;            
            }
            else if ($array[0] === false) 
            {
                $miss_code = 2;
                //break;            
                return;
            }
            else if (isset($array[0]))
            {
                if (isset($array[0]))
                {
                    $array_db[$name . '_value_unit'] = currencyFromRus($array[0]);
                }
                
                if (isset($array[1]))
                {
                    $array_db[$name . '_periodicity'] = timeFromRus($array[1]);
                }
                if (isset($array[2]))
                {
                    $array_db[$name . '_info'] = $array[2];
                }
                
            }
        }
    }        
    
// ¬озвращает масссив с текстовыми блоками, которые были в скобках
function bracketContent($text)
{
    $result = array();
    $continuation = true;
    $position = 0;
    while ($continuation)
    {
        $skob_1 = strpos($text, '(', $position);
        if ($skob_1 !== false)
        {
            $position = $skob_1 + 1;
            $skob_2 = strpos($text, ')', $position);
            if (!$skob_2 or $skob_2 < $skob_1)
            {
                $result[] = false;
            }
            else 
                $result[] = substr($text, $skob_1 + 1, $skob_2 - $skob_1 - 1);
        }
        else 
        {
            $continuation = false;
        }
    }
    return $result;
}

// ¬озвращает текст после первого пробела до следующего пробела
function whiteSpaceContent($text)
{
    $result = '';
    $position = 0;
    $skob_1 = strpos($text, ' ');
    if ($skob_1 !== false)
    {
        $result = trim(substr($text, $skob_1 + 1));
        $skob_2 = strpos($result, ' ');
        if ($skob_2)
            $result = substr($result, 0, $skob_2);
    }
    return $result;
}


function currencyFromRus($text)
{
    $x = trim(strtolower($text));
    if (!isset($x[0]))
        return 'PERCENT';
    $result = '';
    switch ($x[0])
    {
        case 'р':
        case 'rur':
            $result = 'RUR';
        break;
        case 'д':
        case 'usd':
            $result = 'USD';
        break;
        case 'е':
        case 'eur':
            $result = 'EUR';
        break;
        default:
            $result = 'PERCENT';
    }
    return $result;
}

function timeFromRus($text)
{
    $x = trim($text);
    if (!isset($x[0]))
        return 'PERCENT';
    $result = '';
    switch ($x[0])
    {
        case 'д':
            $result = 'DAY';
        break;
        case 'н':
            $result = 'WEEK';
        break;
        case 'м':
            $result = 'MONTH';
        break;
        case 'к':
            $result = 'QUARTER';
        break;
        case 'г':
            $result = 'YEAR';
        break;
        
        default:
            $result = 'ONCE';
    }
    return $result;
}

function paymenttypeidFromNumbers($num)
{
    switch ($num)
    {
        case 1:
            $res = 'ALL';
        break;
        case 2:
            $res = 'ANNUIT';
        break;
        case 3:
            $res = 'DIFF';
        break;
        default:
            $res = 'OTHER';
    }
    return $res;
}
