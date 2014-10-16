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
* | Версия: 1.01                                            |
* | Сайт: www.rznlf.ru                                      |
* ----------------------------------------------------------
* 
* Версия 1.00 -> 1.01
* ----------------------
* Внедрено установка ограничения на длину входной строки
* 
*/

class Dune_Filter_Post_NoFilter extends Dune_Filter_Parent_RequestFormatPost
{

    static private $instance = array();
    
    /**
    * Возвращает ссылку на объект
    *
    * @param string $name
    * @param mixed $def (значение по умолчанию)
    * @param integer $def максимально допустимая длина, 0 - без ограничений
    * @return Dune_Filter_Post_NoFilter
    */
    static function getInstance($name, $def = '', $maxLength = 0)
    {
        $key = $name;
        if (!key_exists($key,self::$instance))
        {
            self::$instance[$key] = new Dune_Filter_Post_NoFilter($name, $def, $maxLength);
        }
        return self::$instance[$key];
    }
}