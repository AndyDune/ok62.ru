<?php
/**
 * ���� ����� ���� �� ������������ �� ������ ��������, ��� ��������� ���������� "���������" ���������� � ������ �����.
 * 
 * ���������� ����� ���� ���������� �� ������ � ���� name/value ������ � ��������� ����������� �����.
 * ���� ��� ����� ���� ����������� ��� �������� ���������� � �������������� ������/������.
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: InputHidden.php                             |
 * | � ����������: Dune/Form/InputHidden.php           |
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
class Dune_Form_InputHidden
{
    /**
     * ������ ��������� �������
     *
     * @var string
     * @access private
     */
    protected $_string = '<input type="hidden">';


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
     * ���������� ������ - ����� ���� Radio.
     *
     * @return sting
     */
    public function get()
    {
        if (!$this->ready)
            throw new Dune_Exception_Base('�� ��������� ������������ �������� value ��� ���� ����� hidden');
        return $this->_string;
    }
    
    public function __toString()
    {
        return $this->_string;
    }
    
}