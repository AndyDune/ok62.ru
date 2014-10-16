<?php
/**
 * Составитель массива задействованных команд.
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                       |
 * | Файл: Commands.php                                     |
 * | В библиотеке: Dune/Data/Colletor/Commands.php          |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>              |
 * | Версия: 1.00                                           |
 * | Сайт: www.rznw.ru                                      |
 * ---------------------------------------------------------
 *
 * История версий:
 *
 * 
 */
class Dune_Data_Collector_Commands
{
 
    
    static protected $_arrayCommands = array();
    static protected $_commandNumberToAdd = 1;
  
    
    static public function addCommand($name)
    {
        self::$_arrayCommands[self::$_commandNumberToAdd] = $name;
        self::$_commandNumberToAdd++;
    }
    
    static public function getCommands()
    {
        return self::$_arrayCommands;
    }
    
    
}