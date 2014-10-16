<?php
/**
 * ������������ �����
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                    |
 * | ����: InputsetClassId.php                           |
 * | � ����������: Dune/Form/Parent/InputsetClassId.php  |
 * | �����: ������ ����� (Dune) <dune@rznlf.ru>          |
 * | ������: 1.00                                        |
 * | ����: www.rznlf.ru                                  |
 * ----------------------------------------------------
 *
 * ������� ������:
 *
 * ������ 1.00 -> 1.01
 * 
 * 
 */
abstract class Dune_Form_Parent_InputSetClassId
{
    /**
     * ������ ��������� �������
     *
     * @var string
     * @access private
     */
    protected $_string = '<input>';

    
    /**
     * ���������� ����� ����
     *
     * @param string $class
     */
    public function setClass($class)
    {
        $this->_string = str_replace('>', ' class="' . $class . '">', $this->_string);
    }

    /**
     * ���������� ID ��� ����
     *
     * @param string $id
     */
    public function setId($id)
    {
        $this->_string = str_replace('>', ' id="' . $id . '">', $this->_string);
    }
    
    /**
     * ���������� ������ - ����� ����.
     *
     * @return sting
     */
    public function get()
    {
        return $this->_string;
    }
    /**
     * ���������� ������ - ����� ����.
     *
     * @return sting
     */
    public function __toString()
    {
        return $this->_string;
    }
    
}