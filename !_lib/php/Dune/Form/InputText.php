<?php
/**
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: InputText.php                               |
 * | � ����������: Dune/Form/InputText.php             |
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
class Dune_Form_InputText extends Dune_Form_Parent_InputSetClassId
{
    /**
     * ������ ��������� �������
     *
     * @var string
     * @access private
     */
    protected $_string = '<input type="text">';

    /**
     * ������ ����������� ��������� �������
     *
     * @var string
     * @access private
     */
    protected $_value = '';

    /**
     * ����������� ��������� ��� ��������� �������.
     *
     * @param string $name ��� ��������� �������
     */
    public function __construct($name)
    {
        $this->_string = str_replace('>', ' name="' . $name . '">', $this->_string);
    }
    

    /**
     * ���������� ������ ���� � ��������.
     *
     * @param integer $size
     */
    public function setSize($size)
    {
        $this->_string = str_replace('>', ' size="' . $size . '">', $this->_string);
    }
    
    /**
     * ���������� ������������ ���������� ��������, ������� ����� ������ � ��������� ����.
     * ��� ����� ���� ������, ��� ���������� ��������, ��������� � ��������� SIZE, � ���� ������ ���� ����� �������������� (scroll).
     * �� ��������� ���������� �������� �� ����������.
     *
     * @param integer $maxlength
     */
    public function setMaxLength($maxlength)
    {
        $this->_string = str_replace('>', ' maxlength="' . $maxlength . '">', $this->_string);
    }

    
    /**
     * ������ ��������� ��������� ��� ����.
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