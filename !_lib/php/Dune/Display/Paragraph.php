<?php
/**
 * ��������� ����� p � ��������� ����������� �������� � �������� �����.
 * 
 * ��������� � �������� ����� �������� � �����.
 * ����� �������� � �������� ����� ����������� � ���������� ������.
 * 
 * ������������ ���������� ������ __set(), __get, __toString() ��� ������ � ������.
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                    |
 * | ����: Paragraph.php                                 |
 * | � ����������: Dune/Display/Paragraph.php            |
 * | �����: ������ ����� (Dune) <dune@rznlf.ru>          |
 * | ������: 1.00                                        |
 * | ����: www.rznlf.ru                                  |
 * ----------------------------------------------------
 *
 * ������� ������:
 *
 * ������ 1.00 -> 1.01
 * 
 */
class Dune_Display_Paragraph
{
    /**
     * ������-���������� ������������� ��� ��������
     *
     * @var string
     * @access private
     */
    protected $_string = '<p>';

    /**
     * ������-���������� ����������� �����
     *
     * @var string
     * @access private
     */
    protected $_text = '';

    
    /**
     * ����������� �������� � �������� �����.
     * 10 - ����������� � �����.
     *
     * @var integer
     * @access private
     */
    protected $_count = 10;
    
    public static $isExeption = true;    
    
    /**
     * ����������� 
     * 
     * @param string $id ������������� �����
     */
    public function __construct($id = '')
    {
        if ($id)
        {
            $this->_string = str_replace('>', ' id="' . $id . '">', $this->_string);
        }
    }
    

    /**
     * ���������� ����� �����
     *
     * @param string $class
     */
    public function setClass($class)
    {
        $this->_string = str_replace('>', ' class="' . $class . '">', $this->_string);
    }

    
    /**
     * ���������� ������ - ������������� ��� �����.
     *
     * @return sting
     */
    public function begin()
    {
        $this->_count += 1;
        return $this->_string;
    }
    
    /**
     * ���������� ������ - ����������� ��� �����.
     *
     * @return sting
     */
    public function end()
    {
        $this->_count -= 1;
        return '</p>';
    }

    
    /**
     * ������������� ���������� �����.
     * ����� �������������� ������� ������ ���.
     *
     * @return sting
     */
    public function set($text)
    {
        $this->_text .= $text;
    }

    /**
     * ���������� ���� ���� � ���������� � ��������������� ������.
     *
     * @return sting
     */
    public function get()
    {
        return $this->_string . $this->_text . '</p>';
    }

    
////////////////////////////////////////////////////////////////
///////////////////////////////     ���������� ������
    
    public function __set($name, $value)
    {
        $this->_text .= $value;
    }
    public function __get($name)
    {
        return $this->_string . $this->_text . '</p>';
    }
    
    public function __toString()
    {
        return $this->_string . $this->_text . '</p>';
    }

    
////////////////////////////////////////////////////////////////
///////////////////////////////     �������� ������
    
    /**
     * �������� �����������.
     *
     * @return sting
     */
    public function check()
    {
        if ($this->_count == 10)
            $bool = true;
        else 
        {
            if (self::$isExeption)
                throw new Dune_Exception_Base('�� ������ ���� p.');
            $bool = false;
        }
        return $bool;
    }
    
}