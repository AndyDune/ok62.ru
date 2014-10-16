<?php
/**
 * Dune Framework
 * 
 * ��������� ������ ��� �������� ������ ������.
 * ��������� ����������� ������:
 *  �� �������� ����� �� �����;
 *  �� �������� ������ ����� ��������� � ��������� ����;
 *  �� �������� �����, �������, ���������, ����� � �������, ������������� ������ �� ����������� �����.
 *  �������� ���������� ��������� ������ �� ���������� ������������ (����� �����)
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: CutShort.php                                |
 * | � ����������: Dune/String/CutShort.php            |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 0.92                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * ������� ������:
 *
 * 0.92 (2008 ������ 28)
 * !! ���������� �� ������.
 * ������ �� �������� ����� ������ ������.
 * 
 * 0.91 (2008 ������� 04)
 * ������ ������ �� ��������� ���� ����� ������ $_spaces - �.�. ��� ������ ���������� �������.
 * 
 */

class Dune_String_CutShort
{
	protected $_string;
	/**
	 * ������ ��������� ������.
	 *
	 * @var Dune_String_Interface_Container
	 */
	protected $_stringObject;
	protected $_stringLength;
	protected $_result = '';
	protected $_direction = true;
    
	protected $_words = array('�', '�', '�', '�', '�', '�' , '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�'
	 );
	protected $_spaces = array(' ', "\r", "\n");
	
	public function __construct($string)
	{
	    $this->_string = $string;
	    $this->_stringObject = Dune_String_Factory::getStringContainer($string);
	    $this->_stringLength = $this->_stringObject->len();
	    
	}

	/**
	 * ������� ���������� ������ ��� ����� �� �������.
	 *
	 * @param integer $length
	 * @return string
	 */
	public function cutBrute($length)
	{
	    return $this->_stringObject->substr(0, $length);
//	    return substr($this->_string, 0, $length);
	}

	/**
	 * �������� ������.
	 * ����� ������� ����� ������ ����� ������� ������� � ������ ���������� ��������.
	 *
	 * @param unknown_type $length
	 * @return unknown
	 */
	public function cut($length)
	{
	    if ($length >= $this->_stringLength)
	    {
	       $this->_result = $this->_string;
	       return false;
	    }
	    $pointer =  $this->_cutNoWordDivision($length);
	    
	    //return $this->_result;
	    return true;
	}

	
	public function getResultString()
	{
	    return $this->_result;
	}
	public function getResultStringLength()
	{
	    $string = Dune_String_Factory::getStringContainer($this->_result);
	    return $string->len();
//	    return strlen($this->_result);
	}
	
	
	/**
	 * ������� ������ ��� ����� ����.
	 * ������������ ����� �������������� ������..
	 *
	 * @param integer $length
	 * @return integer ��������� �� ������� ������� � ������-���������
	 */
	protected function _cutNoWordDivision($length)
	{
	    $pointer = $length - 1;
    // $string =  substr($this->_string, 0, $length);
	    $string = $this->_stringObject->substr(0, $length);
	    $str = Dune_String_Factory::getStringContainer($string[$pointer]);
	    $last_word = $str->tolower();
//	    $last_word = strtolower($string[$pointer]);
	    $corrected_length = $length;
	    $no_find_end_of_word = true;
	    if (!in_array($string[$pointer], $this->_spaces) and !in_array($this->_string[$length], $this->_spaces))
	    {
	        if ($this->_direction) // ����������� ������� - ���������� ������
	        {
	            for ($run = $length; $run < $this->_stringLength; $run++)
	            {
	                if (in_array($this->_string[$run], $this->_spaces))
	                {
	                    $corrected_length = $run; // � ������� ������� �� �����
	                    $no_find_end_of_word = false;
	                    break;
	                }
	                $no_find_end_of_word = true;
	            }
	            
	            if ($no_find_end_of_word)
	            {
	                $length = $this->_stringLength;
	            }
	            else 
	               $length = $corrected_length;
	               
//	            $string =  substr($this->_string, 0, $length);
	            $string = $this->_stringObject->substr(0, $length);
	            $pointer = $length - 1;
	        }
	        else // ����������� ������� - ���������� ������.
	        {
	            for ($run = $length; $run > 0; $run--)
	            {
	                if (in_array($this->_string[$run], $this->_spaces))
	                {
	                    $corrected_length = $run; // � ������� ������� �� �����
	                    $no_find_end_of_word = false;
	                    break;
	                }
	                $no_find_end_of_word = true;
	            }
	            
	            if (!$no_find_end_of_word)
	               $length = $corrected_length;
	               
	            //$string =  substr($this->_string, 0, $length);
	            $string = $this->_stringObject->substr(0, $length);
	            $pointer = $length - 1;
	            
	        }
	    }
	    $this->_result = $string;
	    return $pointer;
	}
	
}

