<?php
/**
 * ����� ��� ������ � DBM ��� � �������� - ����������� ��������
 * 
 * ���������� ������:
 * Dune_Exception_Base
 * Dune_System
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Dbm.php                                     |
 * | � ����������: Dune/AsArray/Dbm.php                |
 * | �����: ������ ����� (Dune) <dune@pochta.ru>       |
 * | ������: 1.15                                      |
 * | ����: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * 
 * ������� ������:
 * 
 * ������ 1.13 -> 1.14
 * -------------------
 * ��� ���� ������ ����������� � ���������������� �����.
 * 
 * ������ 1.03 -> 1.13
 * -------------------
 * ��������� ��������� ����������� �����. (��������� �����������)
 * 
 */

class Dune_AsArray_Dbm extends Dune_AsArray_Parent_Dbm implements Iterator,ArrayAccess
{
    
    
/**
 * ����������� - ��������� ���� dbm
 *
 * @param unknown_type $path ���� � �����
 * @param unknown_type $handler ��� ���� ������, �� ��������� flatfile
 * @param unknown_type $mode ����� �������� �����, �� ��������� w
 */
    public function __construct($path,$mode = 'w')
    {
        $SYS = Dune_System::getInstance();
        if (!isset($SYS['dbm_handler']))
        {
            throw new Dune_Exception_Base('� ����� �������� �� ������ ����: dbm_handler');
        }
        parent::__construct($path, $mode, $SYS['dbm_handler']);
    }
}