<?php
/**
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Select.php                                  |
 * | � ����������: Dune/Form/Select.php                |
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
class Dune_Form_Select extends Dune_Form_Parent_InputSetClassId
{
    /**
     * ������ ���������� ���� select
     *
     * @var string
     * @access private
     */
    protected $_string = '<select>';
    
    /**
     * ������ ����������� select
     *
     * @var string
     * @access private
     */
    protected $_stringOption = '';


    /**
     * ��������� ������ ������
     *
     * @var boolean
     * @access private
     */
    protected $_optGroupOpened = false;
    
    
    /**
     * ����������� ��������� ��� ������������ ������.
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
     * �������� ������.
     * � ����� �������� ��� �������������: ��� �������� ����� ������ � ��� ������ ���������� ����-��������
     *
     * @param string $label �������� ������
     */
    public function beginOptGroup($label)
    {
        $this->_closeOptGroup();
        $this->_stringOption .= '<optgroup label="' . $label . '">';
        $this->_optGroupOpened = true;
    }

    /**
     * ��������� ����� ��� ��������� �������� ������.
     *
     * @param string $label �������� ������
     */
    public function setClassOptGroup($class)
    {
        if ($this->_optGroupOpened)
        {
            $pos = strrpos($this->_stringOption, 'label');
            $this->_stringOption = substr($this->_stringOption, 0, $pos) . 'class="' . $class . '" ' .
                                   substr($this->_stringOption, $pos);
        }
    }
    
    
    /**
     * ����� �������� ������
     */
    public function endOptGroup()
    {
        $this->_closeOptGroup();
        $this->_optGroupOpened = false;
    }
    
    public function setOption($value, $text, $selected = false)
    {
        if ($selected)
            $sel = ' selected="selected"';
        else 
            $sel = '';
        $this->_stringOption .= '<option value="' . $value . '"' . $sel . '>'
                                                  . $text . '</option>';
    }
    
    /**
     * ���������� ������ - ���� �������� ����� .
     *
     * @return sting
     */
    public function get()
    {
        $this->_closeOptGroup();
        return $this->_string . $this->_stringOption . '</select>';
    }
    /**
     * ���������� ������ - ����� ����.
     *
     * @return sting
     */
    public function __toString()
    {
        return $this->get();
    }
    
    /**
     * ������� �������� ������
     *
     * @access private
     */
    protected function _closeOptGroup()
    {
        if ($this->_optGroupOpened)
            $this->_stringOption .= '</optgroup>';
    }
    
}