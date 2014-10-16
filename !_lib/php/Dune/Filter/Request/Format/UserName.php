<?php
/**
*   
*	Класс для инициилизации и фильтрования управляющих входных параметров
*	Анализирует массивы $_GET, $_POST, $_COOKIE
* 
* --------------------------------------------------------
* | Библиотека: Dune                                      |
* | Файл: UserName.php                                    |
* | В библиотеке: Dune/Filter/Request/Format/UserName.php |
* | Автор: Андрей Рыжов (Dune) <dune@pochta.ru>           |
* | Версия: 1.00                                          |
* | Сайт: www.rznlf.ru                                    |
* --------------------------------------------------------
* 
*
* Версия 1.00 -> 1.01
* ----------------------
* 
*/

class Dune_Filter_Request_Format_UserName  extends Dune_Filter_Parent_RequestFormat
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
    static function getInstance($name, $def = '', $prioritet = 'pg')
    {
        $key = $name;
        if (!key_exists($key,self::$instance))
        {
            self::$instance[$key] = new Dune_Filter_Request_Format_UserName($name, $def, $prioritet);
        }
        return self::$instance[$key];
    }



// Проверка на соответствие ключа фильтра предустановленным
protected function makeFilter($value)
{
    // Первая буква в имени
    $res = preg_match("|^[a-zа-яё0-9][- !.,a-zа-яё0-9'*_@)(%]{1,29}$|i", $value, $array);
    if ($res)
    {
        $array['empty'] = false;
        $array['value'] = $value;
    }
    else 
    {
        $array['empty'] = true;
        $array['value'] = $this->defaultValue;
    }
    
    return $array;
}

}