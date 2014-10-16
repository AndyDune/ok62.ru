<?php
/**
 * ����������, ����������� � ���������� ������ ������ � ����� ������ Misql
 *
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Mysql.php                                   |
 * | � ����������: Dune/Exception/Mysql.php            |
 * | �����: ������ ����� (Dune) <dune@pochta.ru>       |
 * | ������: 1.01                                      |
 * | ����: www.rznlf.ru                                |
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