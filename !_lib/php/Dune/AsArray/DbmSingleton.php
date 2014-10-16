<?php
/**
 * ����� ��� ������ � DBM ��� � �������� - ����������� ��������
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
 * | ������: 1.06                                      |
 * | ����: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * 
 * ������� ������:
 * -----------------
 * 
 * ������ 1.04 -> 1.05
 * -------------------
 * ��� ���� ������ ����������� � ���������������� �����.
 * 
 * ������ 1.03 -> 1.04
 * �������� ����������� ���������. ��������� �� �����.
 * ������� ���� ��� ������� ��������.
 * 
 * ������ 1.02 -> 1.03
 * �������� ������� ��������� ��������. ���������� � ������, ����� �� �������� - ������������� ���� ������� ����������
 *
 * 
 * ������ 1.01 -> 1.02
 * ��������� �������� ������
 *
 * ������ 1.00 -> 1.01
 * �������� ������������������ �������� ���������� � �����������
 * 
 */

  /**
   * 
   * @return Dune_AsArray_DbmSingleton
   */

class Dune_AsArray_DbmSingleton  extends Dune_AsArray_Parent_Dbm
{

    static private $instance = array();
    
    static function getInstance($path,$mode = 'r')
    {
        $SYS = Dune_System::getInstance();
        if (!isset($SYS['dbm_handler']))
        {
            throw new Dune_Exception_Base('� ����� �������� �� ������ ����: dbm_handler');
        }
        $key = $path;
        if (!key_exists($key,self::$instance))
        {
            self::$instance[$key] = new Dune_AsArray_DbmSingleton($path, $mode, $SYS['dbm_handler']);
        }
        else 
        {
            if ((self::$instance[$key]->__DBA_mode != $mode) AND
                (self::$instance[$key]->__DBA_mode == 'r'))
            {
                self::$instance[$key]->__destruct();
                self::$instance[$key] = new Dune_AsArray_DbmSingleton($path, $mode, $SYS['dbm_handler']);
            }
        }
        return self::$instance[$key];
    }

}