<?php
/**
 * ������������ �������� ������ �� ��� ����������� ������.
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: MonthName.php                               |
 * | � ����������: Dune/Build/MonthName.php            |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 1.01                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * ������� ������:
 * -----------------
 * 
 *  ������ 1.01
 *  ������� trim() ������������ ���� ����������.
 * 
 */

class Dune_Date_MonthName
{
    
    protected $_number = null;
    protected $_arrayNames = array(
                                    1 => array(
                                                1 => '������',
                                                2 => '������',
                                               ),
                                    2 => array(
                                                1 => '�������',
                                                2 => '�������',
                                               ),
                                    3 => array(
                                                1 => '����',
                                                2 => '�����',
                                               ),
                                    4 => array(
                                                1 => '������',
                                                2 => '������',
                                               ),
                                    5 => array(
                                                1 => '���',
                                                2 => '���',
                                               ),
                                    6 => array(
                                                1 => '����',
                                                2 => '����',
                                               ),
                                    7 => array(
                                                1 => '����',
                                                2 => '����',
                                               ),
                                    8 => array(
                                                1 => '������',
                                                2 => '�������',
                                               ),
                                    9 => array(
                                                1 => '��������',
                                                2 => '��������',
                                               ),
                                    10 => array(
                                                1 => '�������',
                                                2 => '�������',
                                               ),
                                    11 => array(
                                                1 => '������',
                                                2 => '������',
                                               ),
                                    12 => array(
                                                1 => '�������',
                                                2 => '�������',
                                               ),
                                    13 => array(
                                                1 => false,
                                                2 => false,
                                               ),
                                               
                                  );
    /**
     * �����������.
     *
     * @param integer $number ���������� ����� ������
     */
    public function __construct($number)
    {
        $str = Dune_String_Factory::getStringContainer($number);
        $this->_number = (int)$str->trim(' 0');
        if ($this->_number < 1 or $this->_number > 12)
            $this->_number = 13;
    }
    
    /**
     * ������� ����� ������
     *
     * @return string
     */
    public function get()
    {
        return $this->_arrayNames[$this->_number][1];
    }
    
    /**
     * ������� ����� ������ � ����������� ������.
     * ��������: ������, �������
     *
     * @return string
     */
    public function getGenitive()
    {
        return $this->_arrayNames[$this->_number][2];
    }
    
}