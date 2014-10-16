<?php
/**
 * Репозиторий функция для обработки строки.
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Functions.php                               |
 * | В библиотеке: Dune/Text/Functions.php             |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>        |
 * | Версия: 1.00                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 */

abstract class Dune_Text_Functions
{
	/**
	 * Преобразует стоку в массив по разделителю. Удаляет пустые
	 *
	 * @param unknown_type $str
	 * @param unknown_type $char
	 * @return unknown
	 */
    static public function makeArrayNotEmpty($str, $char = ',')
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

    /**
     * Преобразует строку в число float.
     * Учитывает есть ли пробелы между разрядами.
     * Заменяет запятую в строке на точку.
     *
     * @param string $str
     * @return float
     */
    static function strToFloat($str)
    {
        $str = trim($str);
        $temp = str_replace(' ', '', $str); // Числе могут быть с пробелами между порядками
        $temp = str_replace(',', '.', $temp); // Дробь может быть отделена запятой
        
        return (float)$temp;
    }
    
    
    /**
     * Преобразует строку в число Int.
     * Учитывает есть ли пробелы между разрядами.
     * 
     * @param string $str
     * @return integer
     */
    static function strToInt($str)
    {
        $str = trim($str);
        $temp = str_replace(' ', '', $str); // Числе могут быть с пробелами между порядками
        return (int)$temp;
    }
    
    
}

