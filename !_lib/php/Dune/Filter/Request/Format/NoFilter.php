<?php
/**
*   Выбирает значения изх переменных. Не фильтует.
* 
* 	Класс для инициилизации и фильтрования управляющих входных параметров
*	Анализирует массивы $_GET, $_POST, $_COOKIE
* 
* ----------------------------------------------------
* | Библиотека: Dune                                       |
* | Файл: NoFilter.php                                     |
* | В библиотеке: Dune/Filter/Request/NoFilter.php         |
* | Автор: Андрей Рыжов (Dune) <dune@pochta.ru>            |
* | Версия: 1.00                                           |
* | Сайт: www.rznlf.ru                                     |
* ----------------------------------------------------
* 
* Версия 1.00 -> 1.01
* ----------------------
* 
*/

class Dune_Filter_Request_Format_NoFilter  extends Dune_Filter_Parent_RequestFormat
{

    static private $instance = array();
    
    /**
    * Возвращает ссылку на объект
    *
    * @param string $name
    * @param mixed $def (значение по умолчанию)
    * @return object
    */
    static function getInstance($name, $def = '', $prioritet = 'gp')
    {
        $key = $name;
        if (!key_exists($key,self::$instance))
        {
            self::$instance[$key] = new Dune_Filter_Request_Format_NoFilter($name, $def, $prioritet);
        }
        return self::$instance[$key];
    }
}