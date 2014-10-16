<?php
/**
 * ����������� ������� ��� ��������, ������ ��������
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Alloy.php                                   |
 * | � ����������: Dune/Static/Alloy.php               |
 * | �����: ������ ����� (Dune) <dune@rznlf.ru>        |
 * | ������: 1.00                                      |
 * | ����: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 */

abstract class Dune_Static_Alloy
{
    /**
     * ���� � ����� ������������ dbm
     *
     * @var string
     */
    static public $configFile;
    
    /**
     * ���� ��������� ������ - ����� �������� ������ ����������� ��� ��������� � true
     *
     * @var string
     */
    static public $testMode = false;
    
    /**
     * ���������� ���� ����������� ����������� ����� �������������.
     *
     * @return boolean
     */
    static public function canUserRegister()
    {
        if (self::$testMode)
            return true;
        $dbm = Dune_AsArray_DbmSingleton::getInstance(self::$configFile);
        if (isset($dbm['alloy_user_register']) and ($dbm['alloy_user_register']))
            $result = true;
        else 
            $result = false;
        return $result;
    }
    
    /**
     * ������/���������� ����������� �������������
     *
     * @param boolean $bool ���������� ��� ������
     */
    static public function setUserRegister($bool = true)
    {
        $dbm = Dune_AsArray_DbmSingleton::getInstance(self::$configFile, 'w');
        $dbm['alloy_user_register'] = $bool;
    }
}