<?php
/**
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: InputCheckBox.php                           |
 * | � ����������: Dune/Form/InputCheckBox.php         |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 1.00                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * ������� ������:
 *
 * ������ 1.00 -> 1.01
 * 
 * 
 */
class Dune_Form_InputCheckBox extends Dune_Form_Parent_InputSetClassId
{
    /**
     * ������ ��������� �������
     *
     * @var string
     * @access private
     */
    protected $_string = '<input type="checkbox">';


    /**
     * ���� ���������� ������������ ��������� �����
     *
     * @access private
     */
    protected $ready = false;
    
    
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
     * ������ ��������� ��������� ��� ����.
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
     * ���������� ������ - ����� ��������� �������.
     *
     * @return sting
     */
    public function get()
    {
        if (!$this->ready)
            throw new Dune_Exception_Base('�� ��������� ������������ �������� ��� ���� ����� checkbox');
        return $this->_string;
    }
}