<?php
/**
*	Класс для инициилизации и фильтрования управляющих входных параметров
*	Анализирует массивы $_GET, $_POST, $_COOKIE
* 
* ---------------------------------------------------------
* | Библиотека: Dune                                       |
* | Файл: RequestSingleton.php                             |
* | В библиотеке: Dune/Filter/Parent/RequestSingleton.php  |
* | Автор: Андрей Рыжов (Dune) <dune@pochta.ru>            |
* | Версия: 1.00                                           |
* | Сайт: www.rznlf.ru                                     |
* ---------------------------------------------------------
* 
* 
*/

class Dune_Filter_RequestSingleton extends Dune_Filter_Parent_Request
{
    
    static private $instance = array();
    
    /**
    * Возвращает ссылку на объект
    *
    * @param string $name
    * @param mixed $def (значение по умолчанию)
    * @param string $filter (допустимы: 'd','pd','aw','awd')
    * @param string $prioritet (допустимые значение p,g,c - в любой последоваьельности)
    * @return object
    */
    static function getInstance($name,$def = 0,$filter = 'd',$prioritet = 'pg')
    {
        $key = $name . $def . $filter . $prioritet;
        if (!key_exists($key,self::$instance))
        {
            self::$instance[$key] = new Dune_Filter_RequestSingleton($name, $def, $filter, $prioritet);
        }
        return self::$instance[$key];
    }


}