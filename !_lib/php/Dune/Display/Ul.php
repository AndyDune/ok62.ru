<?php
/**
 * ����������� ������
 * 
 * 
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                    |
 * | ����: Ul.php                                        |
 * | � ����������: Dune/Display/Ul.php                   |
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
class Dune_Display_Ul
{
    /**
     * ������-���������� ������������� ��� ��������
     *
     * @var string
     * @access private
     */
    protected $_string = '<ul>';

    /**
     * ������-���������� ����������� �������
     *
     * @var string
     * @access private
     */
    protected $_text = '';

    
    public static $isExeption = true;    
    
    /**
     * ����������� 
     * 
     * @param string $id ������������� ������
     */
    public function __construct($id = '')
    {
        if ($id)
        {
            $this->_string = str_replace('>', ' id="' . $id . '">', $this->_string);
        }
    }
    

    /**
     * ���������� ����� ��� ����� ������
     *
     * @param string $class
     */
    public function setClass($class)
    {
        $this->_string = str_replace('>', ' class="' . $class . '">', $this->_string);
    }

    
    /**
     * ���������� �������� ������
     *
     * @param string $content ���������� ��������
     * @param string $class ����� ��������, ���� ����������
     */
    public function addLi($content = '', $class = '')
    {
        if ($class)
            $class = ' class="' . $class . '"';
        $this->_text .= '<li' . $class . '>' . $content . '</li>';
    }

    
    /**
     * ���������� ���� ���� � ���������� � ��������������� ������.
     *
     * @return sting
     */
    public function get()
    {
        return $this->_string . $this->_text . '</ul>';
    }

    
////////////////////////////////////////////////////////////////
///////////////////////////////     ���������� ������
    
   
    public function __toString()
    {
        return $this->_string . $this->_text . '</ul>';
    }

    
////////////////////////////////////////////////////////////////
///////////////////////////////     �������� ������
    
}