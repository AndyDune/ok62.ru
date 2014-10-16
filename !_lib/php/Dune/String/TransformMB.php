<?php
/**
 * Dune Framework
 * 
 * �������������� ������ ������ UTF. 
 * � �������� ���������� Dune_String_Transform
 * 
 * ----------------------------------------------------
 *  UTF-8
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: TransformMB.php                             |
 * | � ����������: Dune/String/TransformMB.php         |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 2.00                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * ������� ������:
 *
 * 
 */

class Dune_String_TransformMB extends Dune_String_Transform
{

	/**
	 * ������������������ �� ���� ����� �������� �� ������ &#8230;
	 *
	 */
	public function correctOmissionPoints($backward = false)
	{
	    if ($backward)
	       $this->_stringResult = preg_replace('&#8230;|' . $this->uniChr(0x8230), '...', $this->_stringResult);
	    else 
	       $this->_stringResult = preg_replace('/\.{3}/', $this->uniChr(0x8230), $this->_stringResult);
	    return $this;
	}	

	
    /**
     * Return unicode char by its code
     *
     * ������: http://ru2.php.net/manual/en/function.chr.php
     * 
     * @param int $u
     * @return char
     */
    public function uniChr($u)
    {
        return mb_convert_encoding('&#' . intval($u) . ';', 'UTF-8', 'HTML-ENTITIES');
    }	
    
}

