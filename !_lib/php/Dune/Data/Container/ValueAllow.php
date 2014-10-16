<?
/**
 * �����-��������� ��������� ������������ �������� � ������ �����������.
 * 
 * 
 *	 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: ValueAllow.php                              |
 * | � ����������: Dune/Data/Container/ValueAllow.php  |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 1.01                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 *  
 * ������� ������:
 * -----------------
 * 
 * 1.01 (2009 ������ 29)
 *  ����������� ������� �������.
 * 
 */

class Dune_Data_Container_ValueAllow
{
    /**
     * �������� �� ���������.
     * ��������������� ���� ���������� ��� � ������ ����������
     *
     * @var string
     * @access private
     */
    protected $_defaultValue;

    /**
     * �������� ����������.
     * ��������������� ���� ���������� ��� � ������ ����������
     *
     * @var string
     * @access private
     */
    protected $_value;
    
    
    /**
     * ���� ����������� �������� �� ���������
     * 
     * @var boolean
     * @access private
     */
    protected $_defaultRegistered = false;
    
    
    /**
     * ������ ���������� �������
     *
     * @var array
     * @access private
     */
    protected $_allowValues = array();  

    
    /**
     * ���� ����������� ���������� ������
     * 
     * @var boolean
     * @access private
     */
    protected $_allowValueRegistered = false;
    
    protected $_checked = false;
//////////////////////////////////////////////////////////////////////////
///////////         �������� ��������
    
    
    /**
     * �����������.
     * ��������� �������� ��������.
     *
     * @param string $value ��������� ��������
     */
    public function __construct($value)
    {
        $this->_value = $value;
    }

    
    /**
     * ����������� �������� - ���������� � ������ �����������.
     *
     * @param mixed $value
     */
    public function register($value)
    {
        $this->_allowValueRegistered = true;
        if (is_array($value))
        {
            foreach ($value as $run)
            {
                $this->_allowValues[] = $run;
            }
        }
        else 
        {
            $this->_allowValues[] = $value;
        }
        return $this;
    }

    /**
     * ����������� �������� �� ���������.
     * ���������� ��� ���������� ����������� �������� � ������� ����������.
     *
     * @param mixed $value
     */
    public function registerDefault($value)
    {
        $this->_defaultRegistered = true;        
        $this->_defaultValue = $value;
        return $this;
    }

    
    /**
     * ��������� �������� �� ������������.
     * ������ ���������� ������ ����� �������:
     *      registerDefault($folder)
     *      register($folder)
     *      ����� ����������.
     *
     * @return boolean ���� ������������ ���������� �������� - ��� 1-� ������, ����� false
     */
    public function check()
    {
        if ($this->_checked)
            return false;
        $this->_checked = true;
        if (!$this->_defaultRegistered or !$this->_allowValueRegistered)
            throw new Dune_Exception_Base('�� ��������������� �������� �� ��������� � ������ ���������� ��������.');
        $bool = true;
        $key = array_search($this->_value, $this->_allowValues);
        
        if ($key === false)
        {
            $this->_value = $this->_defaultValue;
            $bool = false;
        }
        return $bool;
    }
    
    /**
     * ���������� ��������.
     *
     * @return string
     */
    public function getValue()
    {
        $this->check();
        return $this->_value;
    }

}