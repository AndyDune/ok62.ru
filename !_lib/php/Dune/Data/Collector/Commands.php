<?php
/**
 * ����������� ������� ��������������� ������.
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                       |
 * | ����: Commands.php                                     |
 * | � ����������: Dune/Data/Colletor/Commands.php          |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>              |
 * | ������: 1.00                                           |
 * | ����: www.rznw.ru                                      |
 * ---------------------------------------------------------
 *
 * ������� ������:
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