<?php
/**
 * Dune Framework
 * 
 * ��������� ������. �������-������� ��� ������������.
 * ����: ����������� �������� ������� �� utf-8.
 * � ����������� ������� �� php6.
 * ��� ��������� ������� � �������� ����� ���� �����.
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Container.php                               |
 * | � ����������: Dune/String/Container.php           |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 0.94                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * ������� ������:
 * 
 * 
 *  0.94 (2009 ���� 28)
 *  �������� ucfirst()
 * 
 *  0.93 (2009 ������ 28)
 *  ���������� ��� ������� tolower() � toupper().
 * 
 *  0.92 (2009 ������ 27)
 *  ��������� ��� ������ setString().
 * 
 *  0.90 (2009 ������ 06)
 *  ��������� �� ��� �������.
 * 
 *  0.91 (2009 ������ 13)
 *  �������� �������: rpos -> posr, istr -> stri.
 * 
 */

interface Dune_String_Interface_Container
{
	
	/**
	 * ��������� �����.
	 *
	 * @param string $str ���������� � ���� string.
	 * @param  $min ����������� ����� �������� � ������.
	 * @return boolean
	 */
	public function equal($str, $min = 0);
	
	/**
	 * ����� ������.
	 *
	 * @return integer
	 */
	public function len();
	
	
	/**
	 * ���������� �������� ������� ������� ��������� $string.
	 *
	 * @param string $string
	 * @param integer $offset
	 * @return mixed
	 */
	public function pos($string, $offset = 0);

	/**
	 * ���������� �������� ������� ���������� ��������� $string.
	 *
	 * �������������� �������� offset ��������� �������, � ������ ������� ������� ������ haystack �������� �����.
	 * ������������ ������ ������� ������������ ������ ������ haystack.
	 * 
	 * @param string $string
	 * @param integer $offset
	 * @return mixed
	 */
	public function posr($string, $offset = null);
	
	/**
	 * ���������� ����� ������ haystack �� ������� ��������� needle �� ����� haystack.
     *
     * ���� needle �� ������, ���������� FALSE.
     * ���� needle �� ������, �� �������������� � integer � ����������� ��� ���������� �������� �������.
	 *
	 * @param unknown_type $string
	 * @return unknown
	 */
	public function str($string);

	/**
	 *  ����� str() ��� ����� ��������.
	 *
	 * @param unknown_type $string
	 * @return unknown
	 */
	public function stri($string);
	
	/**
	 * ���������� ����� ������.
	 * 
	 * ���� start �������������, ������������ ������ ���������� �� start'����� �������, ������ �� ����� ������ string.
	 * 
	 * ���� length ����� � �������������, ������������ ������ ����� ��������� �������� length ��������,
	 *  ������� �� start (� ����������� �� ����� ������ string. ���� string ������ start, ������������ FALSE).
     *
     * ���� length ����� � ����������, �� ��� ���������� �������� ����� ���������,
     *  ������� � ����� string (����� ���������� ��������� �������, ����� start ����������). ���� start ����� ������� �� ��������� ����� ��������, ������������ ������ ������.
	 *
	 * @param integer $start ���� start �������������, ������������ ������ ���������� �� start'����� �������, ������ �� ����� ������ string.
	 * @param integer $length
	 * @return string
	 */
	public function substr($start, $length = null);
	
	/**
	 * ��������� �������������� ������
	 *
	 * @param unknown_type $string
	 */
	public function setString($string);
	
	public function trim($charlist = '');
	public function trimr($charlist = '');
	public function triml($charlist = '');
	
	public function tolower();
	public function toupper();
	
	
	
	/**
	 *  ����������� ������ ������ ������ � ������� �������
	 *
	 */
	public function ucfirst();
	
}

