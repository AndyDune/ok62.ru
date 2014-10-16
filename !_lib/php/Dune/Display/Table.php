<?php
/**
 * ����������� �������
 * 
 * ��������� � �������� ����� �������� � �����.
 * 
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                    |
 * | ����: Table.php                                     |
 * | � ����������: Dune/Display/Table.php                |
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
class Dune_Display_Table
{
    /**
     * ������-���������� ������������� ��� ��������
     *
     * @var string
     * @access private
     */
    protected $_string = '<table>';

    /**
     * ������-���������� ����������� �������
     *
     * @var string
     * @access private
     */
    protected $_text = '';

    
    /**
     * ��������� ��������� ���� �������
     *
     * @var boolean
     * @access private
     */
    protected $openedTR = false;

    /**
     * ������������ ����� ����� � ���� �� ���� �������
     *
     * @var integer
     * @access private
     */
    protected $_countMaxTD = 0;

    
    /**
     * ����� ����� � ������� ����
     *
     * @var unteger
     * @access private
     */
    protected $_countTD = 0;
    
    
    public static $isExeption = true;    
    
    /**
     * ����������� 
     * 
     * @param string $id ������������� �������
     */
    public function __construct($id = '')
    {
        if ($id)
        {
            $this->_string = str_replace('>', ' id="' . $id . '">', $this->_string);
        }
    }
    

    /**
     * ���������� ����� ��� ���� �������
     *
     * @param string $class
     */
    public function setClass($class)
    {
        $this->_string = str_replace('>', ' class="' . $class . '">', $this->_string);
    }

    public function addSummary($text)
    {
        $this->_string = str_replace('>', ' summary="' . $text . '">', $this->_string);        
    }
    
    /**
     * �������� ��� �������.
     *
     * @return sting
     */
    public function beginTR($class = '')
    {
        $this->_checkTDinTR();
        if ($class)
            $class = ' class="' . $class . '"';
        $this->_text .= '<tr' . $class . '>';
        $this->openedTR = true;
    }
    
    /**
     * ����� ��������� ���� �������.
     * �� ����������� ��������� - ��� ������������� ������������ ��� ������ ������ ��� ��� ������ �������.
     *
     * @return sting
     */
    public function endTR()
    {
        $this->_checkTDinTR();
    }

    
    /**
     * ���������� ������ � ��� �������.
     * ��� ������ ���� ������ - ����� ����������.
     *
     * @param string $content ���������� ������
     * @param string $class ����� ������, ���� ����������
     */
    public function addTD($content = '', $class = '')
    {
        if (!$this->openedTR)
            throw new Dune_Exception_Base('����� ����������� ������ ���� ���������� ��� �������.');
        $this->_countTD += 1;
        if ($class)
            $class = ' class="' . $class . '"';
        $this->_text .= '<td' . $class . '>' . $content . '</td>';
    }

    /**
     * ���������� ������-��������� � ��� �������.
     * ��� ������ ���� ������ - ����� ����������.
     *
     * @param string $content ���������� ������
     * @param string $class ����� ������, ���� ����������
     */
    public function addTH($content = '', $class = '')
    {
        if (!$this->openedTR)
            throw new Dune_Exception_Base('����� ����������� ������ ���� ���������� ��� �������.');
        $this->_countTD += 1;
        if ($class)
            $class = ' class="' . $class . '"';
        $this->_text .= '<th' . $class . '>' . $content . '</th>';
    }
    
    /**
     * ���������� ���� ���� � ���������� � ��������������� ������.
     *
     * @return sting
     */
    public function get()
    {
        $this->_checkTDinTR();        
        return $this->_string . $this->_text . '</table>';
    }

    
////////////////////////////////////////////////////////////////
///////////////////////////////     ���������� ������
    
   
    public function __toString()
    {
        $this->_checkTDinTR();        
        return $this->_string . $this->_text . '</table>';
    }

    
////////////////////////////////////////////////////////////////
///////////////////////////////     �������� ������
    
    /**
     * �������� �����������.
     *
     * @access private
     * @return sting
     */
    protected function _checkTDinTR()
    {
        if ($this->openedTR)
        {
            if (($this->_countMaxTD) and ($this->_countMaxTD != $this->_countTD))
            {
                throw new Dune_Exception_Base('����� ����� � ������� ���� �� ������������� ������������ �����.');
            }
            else 
            {
                $this->_countMaxTD = $this->_countTD;
                $this->_countTD = 0;
                $this->_text .= '</tr>';
            }
            $this->openedTR = false;
        }
    }    
}