<?php
/**
 * Dune Framework
 * 
 * �������������� ������
 * ��������� ������:
 *  �������� ������ ��������� �����
 *  ������ ������������������ �� 3-� ����� �������� &#8230;
 *  ������� ������� �� ������� ������
 *  ������ ������ ������� ����. 
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Transform.php                               |
 * | � ����������: Dune/String/Transform.php           |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 0.95                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * ������� ������:
 *
 * 0.95 (2009 ���� 1)
 * ��� ������ ������ �� ������ ������������� ������ ���������� � ��� ������������� ���������� ����.
 * 
 * 0.94 (2009 ��� 13)
 * ������������������ ������ �������. ���� �� ���������� �������.
 * ����� ����� linkNofollow() ��������� ������ ��� ���������.
 * 
 * 0.93 (2009 ��� 12)
 * ��� ������ ������� ������� �������� - ������������� ������� � �����.
 * 
 * 0.92 (2009 ������� 06)
 * ����� ������ ��������� ����� �� brake
 * 
 * 0.91 (2009 ������ 23)
 * ��� �������-������� ����������� ����������� ���������� "�������";
 * 
 * 0.90 (2009 ������ 15)
 * ������ � ������� ������������.
 * 
 */

class Dune_String_Transform
{
	protected $_stringSourse;
	protected $_stringResult = '';
	
	public function __construct($string)
	{
	    $this->_stringResult = $this->_stringSourse = $string;
	}

	/**
	 * ������� ��������� ������ ������ �������� ����� ������.
	 * ���������� ������ �� ������������� ���� ������� ������ ��.
	 *
	 * @param integer $count ������� �������� ����� ������ ��������
	 * @return Dune_String_Transform
	 */
	public function deleteLineFeed($count = 1)
	{
	    $needle = false;
	    if (strpos($this->_stringResult, "\r\n")) // ����� ������ � Win
	    {
	        $needle = "\r\n";
	    }
	    else if (strpos($this->_stringResult, "\n")) // ����� ������ � Unix
	    {
	        $needle = "\n";
	    }
	    else if (strpos($this->_stringResult, "\r")) // ����� ������ � Mac
	    {
	        $needle = "\r";
	    }
	    
	    $rep = '';
	    if ($count)
	    {
	        for ($x = 1; $x <= $count; $x++ )
	           $rep .= $needle;
	    }
	    if ($needle)
	    {
	        $count++;
	        $this->_stringResult = preg_replace('/(' . $needle . '){' . $count . ',}/', $rep, $this->_stringResult);
	    }
	    return $this;
	}
	
    /**
	 * �������� �������� ����� �� ������ <br />
	 * ���������� ������ �� ������������� ���� ������� ������ ��.
	 *
	 * @param integer $count ������� �������� ����� ������ ��������
	 * @return Dune_String_Transform
	 */
	public function setLineFeedToBreak()
	{
	    $needle = false;
	    if (strpos($this->_stringResult, "\r\n")) // ����� ������ � Win
	    {
	        $needle = "\r\n";
	    }
	    else if (strpos($this->_stringResult, "\n")) // ����� ������ � Unix
	    {
	        $needle = "\n";
	    }
	    else if (strpos($this->_stringResult, "\r")) // ����� ������ � Mac
	    {
	        $needle = "\r";
	    }
	    
	    $rep = '<br />';

	    if ($needle)
	    {
	        $this->_stringResult = preg_replace('/(' . $needle . ')/', $rep, $this->_stringResult);
	    }
	    return $this;
	    
	}
	
	/**
	 * ������������������ �� ���� ����� �������� �� ������ &#8230;
	 * 
	 * @return Dune_String_Transform
	 *
	 */
	public function correctOmissionPoints($backward = false)
	{
	    if ($backward)
	       $this->_stringResult = preg_replace('&#8230;', '...', $this->_stringResult);
	    else 
	       $this->_stringResult = preg_replace('/\.{3}/', '&#8230;', $this->_stringResult);
	    return $this;
	}	

	/**
	 * ��������� ������ ������ �����.
	 * ���������� <noindex> � rel="external nofollow"
	 * @return Dune_String_Transform
	 *
	 */
	public function linkNofollow()
	{
	    $this->_stringResult = preg_replace('/(<a )/', '<noindex>$1rel="external nofollow" ', $this->_stringResult);	
	    $this->_stringResult = preg_replace('/(\/a>)/', '$1</noindex> ', $this->_stringResult);	
	    return $this;
	}
	
	/**
	 * �������� ���������� ����������� �������-������ �� ������� �������.
	 *
	 * @return Dune_String_Transform
	 */
	public function setQuoteRussian()
	{
	    $this->_stringResult = preg_replace('/(\S)&quot;([ .,?!]|$)/', '$1&raquo;$2', $this->_stringResult);	
	    $this->_stringResult = preg_replace('/(^|\s|>)&quot;(\S)/', '$1&laquo;$2', $this->_stringResult);
//	    $this->_stringResult = preg_replace('/"+\s*"+/', '"', $this->_stringResult);
	    $this->_stringResult = $this->_quotesOutTags($this->_stringResult);
//	    $this->_stringResult = preg_replace('/(\S)"([ .,?!]|$)/', '$1&raquo;$2', $this->_stringResult);	
//        $this->_stringResult = preg_replace('/(^|\s)"(\S)/', '$1&laquo;$2', $this->_stringResult);
        return $this;
	}
	
	/**
	 * ������� � ������. ������ ����� �� ��������������.
	 *
	 * @param string $str
	 * @return string
	 * @access private
	 */
    protected function _quotesOutTags($str)
    {
        $pos = 0;
        $str_o = Dune_String_Factory::getStringContainer($str);
        $len = $str_o->len();

        $tokens = array(
            '"' => 1, // 0 - �������
            '<' => 2, // 1 - �������� ������� ������
            '>' => 3  // 2 - �������� ������� ������
                      // 3 - ������
            );
        
        
        $find_tag_open = false;
        $find_quote = false;
        
        $cur = 0;
        $result = '';
        $pos_max = $len - 1;
        while ($pos < $len)
        {
            $ch = $str[$pos];
            
            $token = 0;
            
            if (isset($tokens[$ch]))
                $token = $tokens[$ch];
             switch ($token)
             {
                 case 1: // �������
                    if (!$find_tag_open)
                    {
                        if ( !$pos or
                                (
                                    $pos < $pos_max
                                    and 
                                    in_array($str[$pos - 1], array(' ', "\n", "\r", '>'))
                                )
                           )
                        {
                            $result .= '&laquo;';
                        }
                        else 
                            $result .= '&raquo;';
                        $find_quote = !$find_quote;
                    }
                    else 
                        $result .= $ch;
                 break;
                 case 2:
                     $find_tag_open = true;
                     $result .= $ch;
                 break;
                 case 3:
                     $find_tag_open = false;
                     $result .= $ch;
                 break;
                 default:
                     $result .= $ch;
                 break;
                 
             }
             $pos++;
        }
    
        return $result;
    }	
	

    /**
     * �������� �� �������� ��������� - �� ���������� � ������ ��� ��������� �����������.
     *
     * @param unknown_type $str
     * @return unknown
     * @access private
     */
    protected  function _quotesOutTagsKA($str)
    {
        $pos = 0;
        $str_o = Dune_String_Factory::getStringContainer($str);
        $len = $str_o->len();
    
        $tokens = array(
            '"' => 0, // 0 - �������
            '<' => 1, // 1 - �������� ������� ������
            '>' => 2  // 2 - �������� ������� ������
                      // 3 - ������
            );
        $flags = array(
            //�������: 0   1   2   3
            0 => array(1,  4,  0,  0), // ������ ��������; ��������� ����� ������
            1 => array(2,  1,  2,  2), // ����������� �������
            2 => array(3,  2,  2,  2), // ��������� ������ �������; ��������� ����� ������� ���� �� �������� ��������� (�����������) �������
            3 => array(1,  4,  0,  0), // ����������� ����������� �������
            4 => array(5,  5,  6,  5), // ����������� �������� ���� (����������� ������� ������)
            5 => array(5,  5,  6,  5), // ��������� ������ ����; ��������� ����� ������� ���� �� �������� ����������� ������� ������
            6 => array(1,  4,  0,  0)  // ����������� ����������� ������
        );
    
        $cur = 0;
        $result = '';
        $pos_max = $len - 1;
        while ($pos < $len)
        {
            $ch = $str[$pos];
            
            $token = 3;
            if (isset($tokens[$ch]))
                $token = $tokens[$ch];
            $flag = $flags[$cur][$token];
            
            switch ($flag)
            {
                case 1:
                    $result .= '&laquo;';
                    break;
                case 3:
                    if (
                        $pos < $pos_max
                        and 
                        in_array($str[$pos - 1], array(' ', "\n", "\r"))
                       )
                    {
                        $result .= '&laquo;';
                        $flag = 2;
                    }
                    else 
                        $result .= '&raquo;';
                    break;
                default:
                    $result .= $ch;
                    break;            
            }
    
            $cur = $flag;
            $pos++;
        }
    
        return $result;
    }	
    
    
	/**
	 * ������ ������ ������� ����.
	 *
	 */
	public function correctDash()
	{
	    $this->_stringResult = preg_replace(' - ', '&nbsp;&#8212; ', $this->_stringResult);
	    return $this;
	}	
	
	
	/**
	 * ������� �������������� ������.
	 *
	 * @return ctring
	 */
	public function getResult()
	{
	    return $this->_stringResult;
	}

	/**
	 * ������� ������ � ��������������� ����.
	 *
	 */
	public function clearResult()
	{
	    $this->_stringResult = $this->_stringSourse;
	    return $this;
	}
	
	
////////////////////////////////////////////////////////////////////
////////        ���������� ������	

	// ������ ������ - ����������.
    public function __toString()
    {
    	return  $this->_stringResult;
    }
	
	
}

