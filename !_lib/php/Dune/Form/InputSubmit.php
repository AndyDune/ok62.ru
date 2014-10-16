<?php
/**
 * C������ ������, ��� ������� ������� ����������� ����� ���������� �� ������
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: InputSubmit.php                             |
 * | � ����������: Dune/Form/InputSubmit.php           |
 * | �����: ������ ����� (Dune) <dune@rznlf.ru>        |
 * | ������: 1.00                                      |
 * | ����: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * ������� ������:
 *
 * ������ 1.00 -> 1.01
 * 
 * 
 */
class Dune_Form_InputSubmit extends Dune_Form_Parent_InputSetClassId
{
    /**
     * ������ ��������� �������
     *
     * @var string
     * @access private
     */
    protected $_string = '<input type="submit">';

    
    /**
     * ����������� ��������� ��� ������.
     * ��� ����� �������� ���� ������ �������� ���� ���-��������
     * ����� ����� �� �����������.
     *
     * @param string $name ��� ������
     */
    public function __construct($name = '')
    {
        if ($name)
        {
            $this->_string = str_replace('>', ' name="' . $name . '">', $this->_string);
        }
    }
    
    
    /**
     * ������ ��������, ���������� ������� (������������ �� ��� � �����).
     * ������� ������� ���������� �� html �������������.
     *
     * @param string $value
     */
    public function setValue($value = '')
    {
        $value = str_replace('"' , '&quot;', $value);
        $this->_string = str_replace('>', ' value="' . $value . '">', $this->_string);
    }
}