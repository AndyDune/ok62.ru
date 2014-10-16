<?php
/**
*   Выбирает значения изх переменных. Не фильтует.
* 
* 	Класс для инициилизации и фильтрования управляющих входных параметров
* 
* ----------------------------------------------------------
* | Библиотека: Dune                                        |
* | Файл: NoFilter.php                                      |
* | В библиотеке: Dune/Filter/Post/NoFilter.php             |
* | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>              |
* | Версия: 1.00                                            |
* | Сайт: www.rznlf.ru                                      |
* ----------------------------------------------------------
* 
* Версия 1.00 -> 1.01
* ----------------------
* 
*/

class Dune_Filter_Get_HtmlSpecialChars extends Dune_Filter_Parent_RequestFormatGet
{

    static private $instance = array();
    
    /**
    * Возвращает ссылку на объект
    *
    * @param string $name
    * @param mixed $def (значение по умолчанию)
    * @return Dune_Filter_Get_NoFilter
    */
    static function getInstance($name, $def = '', $maxLength = 0)
    {
        $key = $name;
        if (!key_exists($key,self::$instance))
        {
            self::$instance[$key] = new Dune_Filter_Get_HtmlSpecialChars($name, $def, $maxLength);
        }
        return self::$instance[$key];
    }
    // Проверка на соответствие ключа фильтра предустановленным
    protected function makeFilter($value)
    {
        $this->value = htmlspecialchars($value);
    }
    
}