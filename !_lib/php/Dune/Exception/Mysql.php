<?php
/**
 * Исключение, сохдаваемое в результате ошибки работы с базой данных Misql
 *
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Mysql.php                                   |
 * | В библиотеке: Dune/Exception/Mysql.php            |
 * | Автор: Андрей Рыжов (Dune) <dune@pochta.ru>       |
 * | Версия: 1.01                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * 
 * 
 */
class Dune_Exception_Mysql extends Exception 
{
   private $trace; // backtrace of exception
   
    public function __construct($message = false, $code = 0)
    { 
        if(!$code)
        {
            $this->code = mysql_errno();
        }
        else  
        {
            $this->code = $code; 
        }
        $this->backtrace = debug_backtrace();
        if (!$message)
        { 
            $this->message = mysql_error(); 
        } 
        $this->file = __FILE__; // of throw clause 
        $this->line = __LINE__; // of throw clause 
        $this->trace = debug_backtrace(); 
    }     
}