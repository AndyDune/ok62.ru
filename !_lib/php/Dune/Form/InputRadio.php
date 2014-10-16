<?php
/**
  * ������� ���� ����� ��� ���������, ������� ��������� ���� �������� �� ���������� ���������. 
  * 
 * ��� ������ (radio buttons) � ������ ������ ����� ���������� �����, �� ������ ��������� ������ � ������ ������� ���� name/value, ������� ����� ������� �� ������.
 *  ��� � ��� ����� CHECKBOX, ������� CHECKED ������������; �� ����� ���� ����������� ��� ����������� ���������� ������ � ������ ������ (radio button).
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: InputRadio.php                              |
 * | � ����������: Dune/Form/InputRadio.php            |
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
class Dune_Form_InputRadio extends Dune_Form_Parent_InputSetClassId
{
    /**
     * ������ ��������� �������
     *
     * @var string
     * @access private
     */
    protected $_string = '<input type="radio">';


    /**
     * ���� ���������� ������������ ��������� �����
     *
     * @access private
     */
    protected $ready = false;
    
    
    /**
     * ����������� ��������� ��� ���� Radio.
     *
     * @param string $name ��� ��������� �������
     */
    public function __construct($name)
    {
        $this->_string = str_replace('>', ' name="' . $name . '">', $this->_string);
    }
    
    
    /**
     * ������ ��������� ��������� ��� ���� radio.
     * ������� ������� ���������� �� html �������������.
     *
     * @param string $value
     */
    public function setValue($value = '')
    {
        $this->ready = true;
        $value = str_replace('"' , '&quot;', $value);
        $this->_string = str_replace('>', ' value="' . $value . '">', $this->_string);
    }

    /**
     * ���������� �������������� ������� CHECKED, ������� ��������� �� ��, ��� ���� ��������������
     *
     */
    public function setChecked()
    {
        $this->_string = str_replace('>', ' checked="checked">', $this->_string);
    }
    
    /**
     * ���������� ������ - ����� ���� Radio.
     *
     * @return sting
     */
    public function get()
    {
        if (!$this->ready)
            throw new Dune_Exception_Base('�� ��������� ������������ �������� ��� ���� ����� radio');
        return $this->_string;
    }
}