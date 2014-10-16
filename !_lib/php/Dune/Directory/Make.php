<?php
/**
 * �������� ���������� � ������ ���������.
 * �������� ������������ ����� �� ���������� ������.
 * 
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Make.php                                    |
 * | � ����������: Dune/Directory/Make.php             |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 0.91                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * ������� ������:
 *
 * ������ 0.91 (2009 ��� 15)
 * ������� trim ����� �����-���������.
 * 
 * ������ 0.90 ������� ������. �� ������� ������� � ������������.
 * 
 * 
 */


class Dune_Directory_Make
{

	protected $_directoryName = '';
	protected $_directoryNameArray = array();
	protected $_isDir = false;
	protected $_nesting = 0;
	
	/**
	 * ��������� ��� ���������� �� ����� �����.
	 *
	 * @param string $name ��� ���������� �� ����� ����� !
	 */
	public function __construct($name)
	{
	    $str = Dune_String_Factory::getStringContainer($name);
	    $name = $str->trim('/\\');

	    $this->_directoryName = $name;
	    $this->_directoryNameArray = new Dune_String_Explode($name, '/', 1);
	    if (is_dir($_SERVER['DOCUMENT_ROOT'] . '/' . $name))
	       $this->_isDir = true;
	}
	
    public function make($from_level = 1, $mode = 0777)
    {
        $levels = count($this->_directoryNameArray);
        if ($levels < $from_level)
        {
            return $this->_isDir;
        }
        $cumul = '';
        foreach ($this->_directoryNameArray as $key => $value)
        {
            $cumul .= '/' . $value;
            if ($key < $from_level)
                continue;
            $temp = $_SERVER['DOCUMENT_ROOT'] . $cumul;
            if (is_dir($temp))
                continue;
            if (!mkdir($temp, $mode))
                return false;
        }
        return true;
    }
}