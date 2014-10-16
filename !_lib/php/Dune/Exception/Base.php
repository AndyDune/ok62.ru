<?php
/**
 * Основное исключение библиотеки
 *
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Base.php                                    |
 * | В библиотеке: Dune/Exception/Base.php             |
 * | Автор: Андрей Рыжов (Dune) <dune@pochta.ru>       |
 * | Версия: 1.01                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * 
 * 
 */
class Dune_Exception_Base extends Exception 
{
//    protected $trace;
    
//    public function getTrace()
//    {
//        return $this->trace;
//    }
    public function __construct($string = '', $code = 0)
    {
        parent::__construct($string, $code);
    }
}