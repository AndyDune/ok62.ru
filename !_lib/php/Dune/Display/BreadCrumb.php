<?php
/**
 * �������� ������ (����. Breadcrumb) � ������� ��������� �� �����, �������������� ����� ���� �� ����� �� ��� ������� �� ������� ��������, �� ������� ��������� ������������.
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                    |
 * | ����: BreadCrumb.php                                |
 * | � ����������: Dune/Display/BreadCrumb.php           |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>           |
 * | ������: 1.03                                        |
 * | ����: www.rznw.ru                                   |
 * ----------------------------------------------------
 *
 * ������� ������:
 *
 * 
 * 1.03(2009 ������ 17)
 * ��������� ������ ������.
 *
 * 1.02(2009 ������ 23)
 * ��� set-������� ����������� ����������� ���������� "�������";
 * 
 * 1.01
 * �� ��������� ������ ��� ��������� �������, ���� ���� ���� �����������.
 * 
 * 
 */
class Dune_Display_BreadCrumb
{
    
    /**
     * �����-���������� "������� ������"
     *
     * @var array
     * @access private
     */
    protected $_array = array();
    protected $_separator = '>';
    protected $_minCount = 0;
    
    /**
     * ����������� ����������
     *
     * @var object
     * @access private
     */
    static private $instance = array();   
     
   /**
    * ������ ���������� ������ ��� ������ ������
    * ���������� ���������� ��������� ������� ��� ����������� �������
    *
    * @return Dune_Display_BreadCrumb
    */
    static public function getInstance($key = 'default')
    {
        if (!key_exists($key, self::$instance))
        {
            self::$instance[$key] = new Dune_Display_BreadCrumb();
        }
        return self::$instance[$key];
    }
    
    protected function __construct()
    {
        
    }
    
    /**
     * �������� ������
     *
     * @param string $name ��� ������
     * @param string $link ������ �� ������� - ���� ��� - ������ �� ��������
     */
    public function addCrumb($name, $link = '')
    {
        $this->_array[] = array(
                               'name' => $name,
                               'link' => $link
                              );
        return $this;
    }
    /**
     * ������� ��� ������ � ��������
     *
     * @return array
     */
    public function getArray()
    {
        return $this->_array;
    }

    /**
     * ������ ����� ��������� ����� ��������
     *
     * @param string $string
     */
    public function setSeparator($string)
    {
        $this->_separator = $string;
        return $this;
    }

    /**
     * ������ ����������� ����� ������, ������ �������� ����� �� ���������
     *
     * @param integer $string
     */
    public function setMinCount($number = 0)
    {
        $this->_minCount = $number;
        return $this;
    }
    
    
    /**
     * ������� ������ � �������� ������ ��� ����������� �� �����.
     * 
     * ���������� ������ ������, ���������� ����������� (����������� ���������).
     * ���� ��� ������ �� ������� ������ - ��� ����������� � span (������� ���).
     * 
     * ���� �� ���� ��������� �� ����� ������ - ������� ������ ������.
     *
     * @param string $befor �������, ���������� �� ��������������� ������� ������
     * @param string $after �������, ���������� ����� ��������������� ������� ������
     * @return string
     */
    public function getString($befor = '', $after = '')
    {
        $string = '';
        $count = count($this->_array);
        if (count($this->_array) > $this->_minCount)
        {
            $curr = 1;
            foreach ($this->_array as $value)
            {
                if ($string)
                    $string .= ' ' . $this->_separator . ' ';
                if ($value['link'] and ($curr != $count))
                {
                    $string .= '<a href="' . $value['link'] . '">' . $value['name'] . '</a>';
                }
                else 
                {
                    $string .= '<span>' . $value['name'] . '</span>';
                }
                $curr++;
            }
            $string = $befor . $string . $after;
        }
        return $string;
    }
    
////////////////////////////////////////////////////////////////
///////////////////////////////     ���������� ������
    
    
    public function __toString()
    {
        return $this->getString();
    }

    
////////////////////////////////////////////////////////////////
///////////////////////////////     �������� ������
    
}