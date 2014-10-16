<?php
/**
*   ������������ ����������� ����� ��� ���� ������� ������ � �������
* 
* ---------------------------------------------------------
* | ����������: Dune                                       |
* | ����: Containet.php                                    |
* | � ����������: Dune/Text/Parent/Containet.php           |
* | �����: ������ ����� (Dune) <dune@pochta.ru>            |
* | ������: 1.00                                           |
* | ����: www.rznlf.ru                                     |
* ---------------------------------------------------------
* 
*
* ������ 1.00 -> 1.01
* ----------------------
* 
*/

abstract class Dune_Text_Parent_Containet
{
    /**
     * �������� �����
     *
     * @var string
     * @access private
     */
    protected $_text = '';
    
    /**
     * �������������� �����
     *
     * @var string
     * @access private
     */
    protected $_textResult = '';
    
    /**
     * ������� ���������.
     *
     * @var string
     * @access private
     */
    protected $_coding = '';
    
    
    const ENC_UTF8 = 'utf-8';
    const ENC_WIN  = 'windows-1251';
    
    
    /**
     * �����������.
     *
     * @param string $text
     * @param string $coding ���������, ����������� ��������� ������
     */
    protected function __construct($text, $coding = 'windows-1251')
    {
    	$this->_text = $text;
    	$this->_coding = $coding;
    }
    

    /**
     * ��������� ������� ������.
     * ������: text � html
     *
     * @return string
     */
    public function setFormat($format = 'text')
    {
    	return $this->_textFormat = $format;
    }
    
    
    /**
     * ���������� ������������ �����.
     *
     * @return string
     */
    public function get()
    {
    	return $this->_textResult;
    }
    
	public function replaceWindowsCodes()
	{
		$after = array('&#167;', '&#169;', '&#174;', '&#8482;', '&#176;', '&#171;', '&#183;',
				       '&#187;', '&#133;', '&#8216;', '&#8217;', '&#8220;', '&#8221;', '&#164;', '&#166;',
				       '&#8222;', '&#8226;', '&#8211;', $this->plusmn, $this->tire, $this->number, '&#8240;',
				       '&#8364;', '&#182;', '&#172;');

		$before = array('�', '�',  '�', '�',  '�', '�', '�',
			            '�', '�', '�', '�', '�', '�', '�', '�',
			            '�', '�', '�', '�', '�', '�', '�',
			            '�', '�', '�');

		$this->_text = str_replace($before, $after, $this->_text);
	}
    
    
}