<?php
/**
*   Выбирает значения изх переменных. Приводит к целому числу.
* 
* 	Класс для инициилизации и фильтрования управляющих входных параметров
* 
* ----------------------------------------------------------
* | Библиотека: Dune                                        |
* | Файл: Digit.php                                         |
* | В библиотеке: Dune/Filter/Post/Digit.php                |
* | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>              |
* | Версия: 1.00                                            |
* | Сайт: www.rznlf.ru                                      |
* ----------------------------------------------------------
* 
* Версия 1.00 -> 1.01
* ----------------------
* 
*/

class Dune_Filter_Post_Digit extends Dune_Filter_Parent_RequestFormatPost
{

    static private $instance = array();
    
    /**
    * Возвращает ссылку на объект
    *
    * @param string $name
    * @param mixed $def (значение по умолчанию)
    * @return Dune_Filter_Post_Digit
    */
    static function getInstance($name, $def = '')
    {
        $key = $name;
        if (!key_exists($key,self::$instance))
        {
            self::$instance[$key] = new Dune_Filter_Post_Digit($name, $def);
        }
        return self::$instance[$key];
    }
    
    // Проверка на соответствие ключа фильтра предустановленным
    protected function makeFilter($value)
    {
        $this->value = (int)$value;
    }
}
