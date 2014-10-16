<?php
/**
 * ����� ��� ������ � DBM ��� � �������� - ����������� ��������.
 * ���������� ��������� ���������.
 * ��������� ����� Dune_AsArray_Parent_Dbm �� ����������
 * 
 * ���������� ������:
 * Dune_Exception_Base
 * Dune_System
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: DbmSingleton.php                            |
 * | � ����������: Dune/AsArray/DbmSingleton.php       |
 * | �����: ������ ����� (Dune) <dune@pochta.ru>       |
 * | ������: 1.00                                      |
 * | ����: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * 
 * ������� ������:
 * -----------------
 * 
 * ������ 1.00 -> 1.01
 * 
 */

  /**
   * 
   * @return Dune_AsArray_DbmSingleton
   */

class Dune_AsArray_DbmSingletonSystem  extends Dune_AsArray_Parent_Dbm
{

    static private $instance = false;
    
    static function getInstance($mode = 'r')
    {
        $SYS = Dune_System::getInstance();
        if (!isset($SYS['dbm_handler']))
        {
            throw new Dune_Exception_Base('� ����� �������� �� ������ ����: dbm_handler');
        }
        $key = Dune_Parameters::$systemDbmPath;
        if (!self::$instance)
        {
            self::$instance = new Dune_AsArray_DbmSingletonSystem($key, $mode, $SYS['dbm_handler']);
        }
        else 
        {
            if ((self::$instance->__DBA_mode != $mode) AND
                (self::$instance->__DBA_mode == 'r'))
            {
                self::$instance->__destruct();
                self::$instance = new Dune_AsArray_DbmSingletonSystem($key, $mode, $SYS['dbm_handler']);
            }
        }
        return self::$instance;
    }

}