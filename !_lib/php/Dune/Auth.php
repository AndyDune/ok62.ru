<?php
/**
 * �����-������� ��� �������� ��������������.
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Autho.php                                   |
 * | � ����������: Dune/Auth.php                       |
 * | �����: ������ ����� (Dune) <dune@rznlf.ru>        |
 * | ������: 0.98                                      |
 * | ����: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * ������ 0.98 -> 0.99
 * 
 */
abstract class Dune_Auth
{
    protected static $availableMode = array('MailMysqli');
    
    
    /**
     * ��������� ������ ����� �����, ��������� �� ���������� ����, ��������, 'ZendPlatform'.
     * ����� ������� �� ����� �������, ���������� ����� � ������� ������������, �����, ��� ������ (' '), ���� ('-'), ��� �����.
     *
     * @param string $mode
     * @param array $options
     * @return Dune_Auth_MailMysqli
     */
    public static function factory($mode, $options = array())
    {
        $mode = self::_normalizeName($mode);
        if (!in_array($mode, self::$availableMode))
        {
            throw new Dune_Exception_Base('������������ ����� ('. $mode . ')');
        }
        
        $mode = 'Dune_Auth_' . $mode;
        $object = new $mode($options);
        return $object;
    }
    
    /**
     * Normalize frontend and backend names to allow multiple words TitleCased
     *
     * @param  string $name
     * @return string
     */
    protected static function _normalizeName($name)
    {
        $name = ucfirst(strtolower($name));
        $name = str_replace(array('-', '_', '.'), ' ', $name);
        $name = ucwords($name);
        $name = str_replace(' ', '', $name);
        return $name;
    }
    
}