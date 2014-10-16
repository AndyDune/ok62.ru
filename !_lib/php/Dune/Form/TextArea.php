<?php
/**
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: TextArea.php                                |
 * | � ����������: Dune/Form/TextArea.php              |
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
class Dune_Form_TextArea extends Dune_Form_Parent_InputSetClassId
{
    /**
     * ������ ��������� �������
     *
     * @var string
     * @access private
     */
    protected $_string = '<textarea>';

    /**
     * ������ ����������� ��������� �������
     *
     * @var string
     * @access private
     */
    protected $_value = '';
    
    /**
     * ���� ���������� ������������ ��������� �����
     *
     * @access private
     */
    protected $ready = false;

    const WRAP_OFF = 'off';
    const WRAP_VIRTUAL = 'virtual';
    const WRAP_PHYSICAL = 'physical';

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
     * ���������� ������ �������� ���� � ����������� ������ ����������� �����.
     * ���������� ��������� ������ ��������������� ��������� ������
     *
     * @param string $wrap
     */
    public function setWrap($wrap = self::WRAP_VIRTUAL)
    {
        $this->_string = str_replace('>', ' wrap="' . $wrap . '">', $this->_string);
    }

    /**
     * ���������� ���������� ����� ������, ������� �� ������.
     *
     * @param integer $rows
     */
    public function setRows($rows)
    {
        $this->_string = str_replace('>', ' rows="' . $rows . '">', $this->_string);
    }
    
    /**
     * ���������� ���������� ����� ������, ������� �� ������.
     *
     * @param integer $cols
     */
    public function setCols($cols)
    {
        $this->_string = str_replace('>', ' cols="' . $cols . '">', $this->_string);
    }

    
    /**
     * ���������� ���������� ��������� �������.
     * �������� ������� < � > �������������� �� html.
     *
     * @param string $value
     */
    public function setValue($value = '')
    {
        $this->_value = str_replace(array('>','<'), array('&gt;','&lt;'), $value);
    }

    
    /**
     * ���������� ������ - ����� ��������� �������.
     *
     * @return sting
     */
    public function get()
    {
        return $this->_string . $this->_value . '</textarea>';
    }
}