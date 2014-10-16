<?php
/**
 * ����������� ������ �������. �������� ��� ������������ ������ � ����������.
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Url.php                                     |
 * | � ����������: Dune/Data/Colletor/Abstract/Url.php |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 1.02                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * ������� ������:
 *
 * ������ 1.02
 * ����� ����� getExeptLastFolder($count = 1) ������� ������ ������� ��� ��������� ����� ��������� ������ (�����).
 * 
 * ������ 1.00 -> 1.01
 * �������� ����� getFolder() - ������� �����(�������). �������, ���� � �������.
 * �������� �������� ��������� ����� � ������� - ������ ����� ����������. ����� ����������.
 * 
 */
abstract class Dune_Data_Collector_Abstract_Url
{
	protected $_domain = '/';
	
	protected $_foldersArray = array(1 => '', '', '', '', '', '');
	protected $_currentFolderNumber = 0;
	protected $_foldersString = '';

	protected $_string = '';
	protected $_parametersString = '';
	protected $_parametersArray = array();
	
	protected $_actionFile = '';
	
	protected function __construct()
	{
	    
	}
	
	/**
	 * ��������� ������ � �������. !!! ���� � ����� �� ������������.
	 * �� ��������� ����� "/".
	 * 
	 *
	 * @param string $domain
	 */
	public function setDomain($domain)
	{
		$this->_domain = 'http://' . $domain . '/';
	}

	/**
	 * ��������� �����-����������� �������.
	 * �� ��������� �� �������.
	 *
	 * @param string $file
	 */
	public function setActionFile($file)
	{
	    $this->_actionFile = $file;
	}
	
	/**
	 * ��������� ����� ����� �� �������, ������� � ����� �����.
	 * ��������� � 1.
	 *
	 * @param string $name
	 * @param integer $position
	 */
	public function setFolder($name, $position = 1)
	{
	    if ($position > $this->_currentFolderNumber)
	       throw new Dune_Exception_Base('��������� ����� ������ ����� ����������.');
	    $this->_string = '';
		$this->_foldersArray[$position] = $name;
	}

	/**
	 * ���������� �����, ��������� �� �������.
	 * ����� ������� ������������.
	 *
	 * @param string $name
	 */
	public function addFolder($name)
	{
	    $this->_string = '';
	    ++$this->_currentFolderNumber;
		$this->_foldersArray[$this->_currentFolderNumber] = $name;
	}

	/**
	 * ������� ����� (�������) � ���������� �������. ��� �������� ������ 0(����) - ������� ��������� �����������.
	 * ���� ������ �����, ����������� ����� ����� ����������� - ������� ����������.
	 * 
	 * @param integer $number ������� ����� � �������, ������� � 1 (0 - ������� ��������� �����������)
	 */
	public function getFolder($number = 0)
	{
	    if (!$this->_currentFolderNumber)
	       return false;
	    if (($number > 0) and ($name <= $this->_currentFolderNumber))
	    {
	        $string = $this->_foldersArray[$number];
	    }
	    else 
	    {
	        $string = $this->_foldersArray[$this->_currentFolderNumber];
	    }
	    return $string;
	}
	
	/**
	 * ���������� ��������� � ������ �������.
	 * �� ��������� �������� ��������� ���������� urlencode().
	 *
	 * @param string $name
	 * @param mixed $value
	 * @param boolean $urlencode ���� ���������� ������� urlencode() � ��������
	 */
	public function addParameter($name, $value, $urlencode = true)
	{
	    $this->_string = '';
		if ($urlencode)
			$this->_parametersArray[$name] = urlencode($value);
	    else 
	    	$this->_parametersArray[$name] = $value;
	}

	/**
	 * ���������� ��� ������ �������.
	 * ��������� ����������, �� ������������ ���������� ����� ����������, ����� � �.�.
	 *
	 * @return string
	 */
	public function get()
	{
		if (!$this->_string)
		{
            $this->_string = $this->_domain
						   . $this->_collectFolders()
						   . $this->_actionFile
						   . $this->_collectParameters();
		}
		return $this->_string;
	}

	/**
	 * ���������� ��� ������ �������, ��������� ��������� �������.
	 * ��������� ����������, �� ������������ ���������� ����� ����������, ����� � �.�.
	 *
	 * @return string
	 */
	public function getExeptLastFolder($count = 1)
	{
//		if (!$this->_string)
//		{
            $this->_string_ex = $this->_domain
						   . $this->_collectFoldersExeptLast($count)
						   . $this->_actionFile
						   . $this->_collectParameters();
//		}
		return $this->_string_ex;
	}
	
////////////////////////////////////////////////
///     ��������� ������	
	public function __toString()
	{
	    return $this->get();
	}

////////////////////////////////////////////////
///     ��������� ������	
	
	protected function _collectFolders()
	{
		$string = '';
		foreach ((array)$this->_foldersArray as $value)
		{
			if ($value != '')
    			$string .= $value . '/';
		}
		
		return $string;
	}

	protected function _collectFoldersExeptLast($count)
	{
		$string = '';
		$x = $count;
		foreach ((array)$this->_foldersArray as $value)
		{
		    if ($x == $this->_currentFolderNumber)
		      break;
			if ($value != '')
			{
    			$string .= $value . '/';
			}
			$x++;
		}
		
		return $string;
	}
	
	
	protected function _collectParameters()
	{
		$string = '';
		foreach ((array)$this->_parametersArray as $key => $value)
		{
			if ($string)
    			$string .= '&';
    	   else 
    	       $string .= '?';
    	   $string .= $key . '=' . $value;
		}
		return $string;
	}
	
}