<?php
/**
 * ����������� ������� ��� �������� ������ �� ������������ ���� JavaScripts
 * 
 * 
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: JavaScriptsList.php                         |
 * | � ����������: Dune/Static/JavaScriptsList.php     |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 1.04                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * ������� ������:
 * -----------------
 * 
 *  1.04 ��������� ����������� ���������� ��������� ������. ����� �����������, ������� ����� ������ ��� ������� ���� �� �������������.
 * 
 * ������ 1.02 -> 1.03
 * ���������� ������ ���������� ��������
 * ����� ���� � ���������� ������.
 * 
 * ������ 1.01 -> 1.02
 * ��������� ����������� �������� ������� ����������� ������ � ������������ ������ ��������
 * 
 * ������ 1.00 -> 1.01
 * ���� � ������ �������� ������������ ����������� ������ Dune_Parameters
 * $templateSpace
 * $templateRealization
 * 
 * 
 */

abstract class Dune_Static_JavaScriptsList
{
    /**
     * ��� �����-������������ ��� ������������ ������ ������.
     * ��� ������������ ����������� � ����� styles
     *
     * @var string
     */
    public static $javaScriptsFolder = 'js';
    
    /**
     * ������ ���� ������ � ������� �����������
     *
     * @var array
     * @access private
     */
    protected static $_jsList = array();

    
    /**
     * ������ ���� ������ � ������� �����������. � ��������� ���������� ������.
     *
     * @var array
     * @access private
     */
    protected static $_jsListInOrder = array();
    
    
    protected static $_jsListDependent = array();
    
    /**
     * ���������� ����� js ��� ����������� � �������.
     * ����� �������������.
     *
     * @param string $name ��� ����� ��� ����������
     * @param integer $order ������� � ��������� ������
     */
    public static function add($name, $order = 500)
    {
        if (!key_exists($name, self::$_jsList))
        {
            self::$_jsList[$name] = $order;//$name;
            self::$_jsListInOrder[$order][$name] = &self::$_jsList[$name];
        }
    }

    /**
     * ���������� ��������� ������. �������������� ���� ���� ��������� �������.
     * 
     * @param string $name ��� ����� ��� ����������
     */
    public static function addDependent($name, $path = '')
    {
            self::$_jsListDependent[$name] = $path;
    }
    
    
    
    /**
     * ���������� ������ ��� ����������� ��� ����� �������.
     *
     * @return string
     */
    public static function getWithNoOrder()
    {
        $string = '';
        $folder = '/viewfiles/' 
        		. Dune_Parameters::$templateSpace 
        		. '/' 
        		. Dune_Parameters::$templateRealization 
        		. '/js/';
        if (count(self::$_jsList))
        {
            $string = self::getDependent();
            foreach (self::$_jsList as $key => $run)
            {
                $string .= '<script src="' . $folder . $key . '.js" type="text/javascript"></script>';
            }
        }
        return $string;
    }
    
    /**
     * ���������� ������ ��� ����������� � ������ �������.
     *
     * @return string
     */
    public static function get()
    {
        $string = '';
        $folder = '/viewfiles/' . Dune_Parameters::$templateSpace . '/' . Dune_Parameters::$templateRealization . '/js/';
        if (count(self::$_jsList))
        { 
            $string = self::getDependent();
            //ksort(self::$_jsListInOrder);
            foreach (self::$_jsListInOrder as $run)
            {
                foreach ($run as $key => $run2)
                {
                    $string .= '<script src="' 
                    		 . $folder 
                    		 . $key 
                    		 . '.js" type="text/javascript"></script>';
                }
            }
        }
        return $string;
        
        
        
        
        
        
/*        $string = '';
        $folder = '/js/' . Dune_Parameters::$templateSpace . '/' . Dune_Parameters::$templateRealization . '/';
        if (count(self::$_jsList))
        {
        	asort(self::$_jsList);
            foreach (self::$_jsList as $key => $run)
            {
                $string .= '<script src="' . $folder . $key . '.js" type="text/javascript"></script>';
            }
        }
        return $string;
*/ 
    }
   
    protected static function getDependent()
    {
        $string = '';
        $folder = '/viewfiles/' . Dune_Parameters::$templateSpace . '/' . Dune_Parameters::$templateRealization . '/js/';
        if (count(self::$_jsListDependent))
        { 
            foreach (self::$_jsListDependent as $key => $value)
            {
                if ($value)
                    $value .= '/';
                $string .= '<script src="' 
                 		 . $folder 
                 		 . $value 
                   		 . $key 
                   		 . '.js" type="text/javascript"></script>';

            }
        }
        return $string;
    }
    
}