<?php
/**
*   Выбирает значения изх переменных. Не фильтует.
* 
* 	Класс для инициилизации и фильтрования управляющих входных параметров
* 
* ----------------------------------------------------
* | Библиотека: Dune                                       |
* | Файл: UrlCommand.php                                   |
* | В библиотеке: Dune/Filter/Get/UrlCommand.php           |
* | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>             |
* | Версия: 1.00                                           |
* | Сайт: www.rznlf.ru                                     |
* ----------------------------------------------------
* 
* Версия 1.00 -> 1.01
* ----------------------
* 
*/

class Dune_Filter_Get_UrlCommand  extends Dune_Filter_Parent_RequestFormatGet
{

    static private $instance = array();
    
    /**
    * Возвращает ссылку на объект
    *
    * @param string $name
    * @param mixed $def (значение по умолчанию)
    * @return object
    */
    static function getInstance($name, $def = '')
    {
        $key = $name;
        if (!key_exists($key,self::$instance))
        {
            self::$instance[$key] = new Dune_Filter_Get_UrlCommand($name, $def);
        }
        return self::$instance[$key];
    }
    
    // Проверка на соответствие ключа фильтра предустановленным
    protected function makeFilter($value)
    {
        $this->value = preg_replace('|[^-a-zA-Z0-9_]|i','',$value);
    }
    
}