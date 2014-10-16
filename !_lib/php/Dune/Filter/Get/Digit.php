<?php
/**
*   Возвращает целое число из массива $_GET.
* 
* 	Класс для инициилизации и фильтрования управляющих входных параметров
* 
* ----------------------------------------------------
* | Библиотека: Dune                                       |
* | Файл: Digit.php                                        |
* | В библиотеке: Dune/Filter/Get/Digit.php                |
* | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>             |
* | Версия: 1.00                                           |
* | Сайт: www.rznlf.ru                                     |
* ----------------------------------------------------
* 
* Версия 1.00 -> 1.01
* ----------------------
* 
*/

class Dune_Filter_Get_Digit  extends Dune_Filter_Parent_RequestFormatGet
{

    static private $instance = array();
    
    /**
    * Возвращает ссылку на объект
    *
    * @param string $name
    * @param mixed $def (значение по умолчанию)
    * @return Dune_Filter_Get_Digit
    */
    static function getInstance($name, $def = 0)
    {
        $key = $name;
        if (!key_exists($key,self::$instance))
        {
            self::$instance[$key] = new Dune_Filter_Get_Digit($name, $def);
        }
        return self::$instance[$key];
    }
    
    // Проверка на соответствие ключа фильтра предустановленным
    protected function makeFilter($value)
    {
        $this->value = (int)$value;
    }
    
}