<?php
/**
 * ��������� ����� Zend_Config_Ini ��� ���������� �������� ������ � ����� ��������.
 * ��������� ������� ���������.
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Ini.php                                     |
 * | � ����������: Dune/Zend/Config/Ini.php            |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 1.00                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * 
 */
class Dune_Zend_Config_Ini extends Zend_Config_Ini
{
    /**
     * ������ �� ������, ���������.
     *
     * @var Dune_Zend_Config_Ini
     * @access private
     */
    static private $instance = null;
    
    /**
     * @var string
     * @access private
     */
    static private $instanceName = null;

    static $filename = '';
    
    /**
     * ���������� ������ ������ Dune_Zend_Config_Ini
     *
     * @param  string|null   $section
     * @param  boolean|array $options
     * @return Dune_Zend_Config_Ini
     */
    static function getInstance($section = null, $options = false)
    {
        if (self::$instance === null)
        {
            self::$instance = new Dune_Zend_Config_Ini(self::$filename, $section, $options);
            self::$instanceName = $section;
        }
        else if (($section != null or !$section)  and $section != self::$instanceName)
        {
            self::$instance = new Dune_Zend_Config_Ini(self::$filename, $section, $options);
            self::$instanceName = $section;
        }
        return self::$instance;
    }

}
