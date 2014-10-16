<?php
/**
 * ����������� ������� ��� �������� ������ �� ������������ ������� ������
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: StylesList.php                              |
 * | � ����������: Dune/Static/StylesList.php          |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 1.05                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * ������� ������:
 * -----------------
 * 
 * ������ 1.05 (2009 ������ 30)
 * ������������� ���������� ��� ie7
 * 
 * ������ 1.04
 * �������� ����� ������ ����������� ������.
 * 
 * ������ 1.02 -> 1.03
 * �������� ������ ������� ��� ������ �� ��������.
 * 
 * ������ 1.01 -> 1.02
 * ����� ���� � ���������� ������.
 *  
 * ������ 1.00 -> 1.01
 * ������� ���������� ��� �������� ���� ������ ������.
 * ���� � ������ ������ ������������ ����������� ������ Dune_Parameters
 * $templateSpace
 * $templateRealization
 * 
 */

abstract class Dune_Static_StylesList
{
    
    /**
     * ������ ���� ������ � ������� �����������
     *
     * @var array
     * @access private
     */
    protected static $_stylesList = array();
    
    /**
     * ������ �����
     *
     * @var array
     * @access private
     */
    protected static $_stylesGroups = array();

    
    /**
     * ��������� ����� �����
     *
     * @var integer
     * @access private
     */
    protected static $_beginGroupNumber = 100;
    
    /**
     * �������� ����� �����
     *
     * @var integer
     * @access private
     */
    protected static $_endGroupNumber = 100;

    
    const MODE_IE6_STYLES = 'ie6';
    const MODE_IE7_STYLES = 'ie7';
    
    /**
     * ���������� ����� css ��� ����������� � �������.
     * ����� �������������.
     *
     * @param string $name ��� ����� ��� ����������
     * @param integer $group ������� ��� ������ �� ��������� 100
     * @param ����� $mode ������������ ��������� ������
     */
    public static function add($name, $group = null, $mode = '')
    {
        if (!$group)
        {
            $group = 100;
        }
        $name = str_replace(array(':', '/', '\\'), '/', $name);
        self::$_stylesList[$name]['file'] = $name . '.css';
        self::$_stylesList[$name]['mode'] = $mode;
        self::$_stylesGroups[$group][] = &self::$_stylesList[$name];
    }
    
    
    public static function clear()
    {
         self::$_stylesList = array();
         self::$_stylesGroups = array();
    }
    
    /**
     * ���������� ����� ��� �����������.
     *
     * @return string
     */
    public static function get()
    {
        ksort(self::$_stylesGroups);
        $string = '';
        $ie6_string = '';
        $folder = '/viewfiles/' 
        		. Dune_Parameters::$templateSpace 
        		. '/' 
        		. Dune_Parameters::$templateRealization 
        		. '/styles/';
        if (count(self::$_stylesList))
        {
            foreach (self::$_stylesGroups as $value)
            {
                foreach ((array)$value as $run)
                {
                    if ($run['mode'] === self::MODE_IE7_STYLES)
                    {
                        $ie6_string .= '<!--[if IE 7]><link href="' 
                           			 . $folder 
                           			 . $run['file'] 
                           			 . '" rel="stylesheet" type="text/css" /><![endif]-->';
                    }
                    else if  ($run['mode'] === self::MODE_IE6_STYLES)
                    {
                        $ie6_string .= '<!--[if lt IE 7]><link href="' 
                           			 . $folder 
                           			 . $run['file'] 
                           			 . '" rel="stylesheet" type="text/css" /><![endif]-->';
                    }
                    else 
                    {
                        $string .= '<link href="' 
                        		 . $folder 
                        		 . $run['file'] 
                        		 . '" rel="stylesheet" type="text/css" />';
                    }
                    
                    
                }
            }
        }
        return $string . $ie6_string;
    }
}