<?php
/**
*   Применяет к входным данным функцию HtmlSpecialChars()
* 
* 	Класс для инициилизации и фильтрования управляющих входных параметров
*	Анализирует массивы $_GET, $_POST, $_COOKIE
* 
* ----------------------------------------------------
* | Библиотека: Dune                                       |
* | Файл: HtmlSpecialChars.php                             |
* | В библиотеке: Dune/Filter/Request/HtmlSpecialChars.php |
* | Автор: Андрей Рыжов (Dune) <dune@pochta.ru>            |
* | Версия: 1.00                                           |
* | Сайт: www.rznlf.ru                                     |
* ----------------------------------------------------
* 
* Версия 1.00 -> 1.01
* ----------------------
* 
*/

class Dune_Filter_Request_Format_HtmlSpecialChars  extends Dune_Filter_Parent_RequestFormat
{

    static private $instance = array();
    
    /**
    * Возвращает ссылку на объект
    *
    * @param string $name
    * @param mixed $def (значение по умолчанию)
    * @param string $prioritet (допустимые значение p,g,c - в любой последоваьельности)
    * @return object
    */
    static function getInstance($name, $def = '', $prioritet = 'pg')
    {
        $key = $name;
        if (!key_exists($key,self::$instance))
        {
            self::$instance[$key] = new Dune_Filter_Request_Format_HtmlSpecialChars($name, $def, $prioritet);
        }
        return self::$instance[$key];
    }



    // Проверка на соответствие ключа фильтра предустановленным
    protected function makeFilter($value)
    {
        $array['empty'] = false;
        $array['value'] = htmlspecialchars($value);
        return $array;
    }
}