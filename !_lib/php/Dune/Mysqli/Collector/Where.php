<?php
/**
 * ��������� ������� � WHERE ��� �������� � BD
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Where.php                                   |
 * | � ����������: Dune/Mysqli/Collector/Where.php     |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 0.92                                      |
 * | ����: www.dune.rznw.ru                            |
 * ----------------------------------------------------
 *
 *  ������ ������:
 * 
 * 0.92 (2009 ������ 16)
 *  � ������ get() �������� ������ ������.
 *  ������ ���������� ������ � ����� addSimpleData()
 * 
 * 0.91 (2009 ������ 10)
 *  ������� ����� ���������� ��� ������� AND, OR. �����.
 * 
 * 0.90 (2009 ������ 09)
 *  ���������� ����.
 * 
 */

class Dune_Mysqli_Collector_Where extends Dune_Mysqli_Abstract_Connect
{
    protected $_accumulator = '';
    protected $_bracketCount = 0;
    
    protected $_canAddAndOr  = false;
    protected $_needAddAndOr = false;
    protected $_openAddAndOr = false;
    protected $_exception    = false;
    protected $_haveLeft     = false;
    protected $_haveAndOr    = false;
    
    protected $_comares = array('=', '>', '<', '>=', '<=', '<>', '!=', '<=>');
    
    public function __construct()
    {
        
    }
    
    /**
     * ������� ������.
     *
     * @return Dune_Mysqli_Collector_Where
     */
    public function bracketBegin()
    {
        $this->_canAddAndOr = false;
        $this->_bracketCount++;
        $this->_needAddAndOr = false;
        
        if (!$this->_openAddAndOr and Dune_String_Functions::len($this->_accumulator) > 1)
        {
            throw new Dune_Exception_Base('�� ������� ������� ���������� (OR, AND) ������ � ������� � ����������� ���������.');
        }
        $this->_accumulator .= ' (';
        
        return $this;
    }

    /**
     * ������� ������.
     * 
     * ���������� ��� �������� ��� ���������� ��������.
     *
     * @return Dune_Mysqli_Collector_Where
     */
    public function bracketEnd()
    {
        if ($this->_bracketCount == 0)
            throw new Dune_Exception_Base('������� �������� ������. �������� ���.');
        if ($this->_openAddAndOr)
            throw new Dune_Exception_Base('����������� ������� �������� (OR, AND) �������� ��������.');
            
        $this->_bracketCount--;
        $this->_canAddAndOr = true;
        $this->_needAddAndOr = true;
        $this->_accumulator .= ')';
        return $this;
    }
    

    /**
     * ��������� ��������� ���������� �� ����������� ��������.
     *
     * @return Dune_Mysqli_Collector_Where
     */
    public function setExceptionThrow($value = true)
    {
        $this->_exception = $value;
        return $this;
    }

    /**
     * �������� AND
     *
     * @return Dune_Mysqli_Collector_Where
     */
    public function addAnd($exception_on_empty = false)
    {
        $this->_addAndOr('AND', $exception_on_empty);
        return $this;
    }

    /**
     * �������� OR
     *
     * @return Dune_Mysqli_Collector_Where
     */
    public function addOr($exception_on_empty = false)
    {
        $this->_addAndOr('OR', $exception_on_empty);
        return $this;
    }

    /**
     * �������� �������.
     * �������� �� ������������ � ���������� ����� ����� ������ ��������.
     *
     * @param string $value ���������� ����������: >, <, >=, <=, <>, <=>
     * @return Dune_Mysqli_Collector_Where
     */
    public function addCompare($value = '=')
    {
        if (!in_array($value, $this->_comares))
        {
            throw new Dune_Exception_Base('������� �������� ������� ��� ���������: ' . $value);
        }
        
        if (!$this->_haveLeft)
        {
            throw new Dune_Exception_Base('������ ������� ������� ���������. ����� ����� �� �������.');
        }
        $this->_accumulator .= ' ' . $value;
        $this->_openAddAndOr = false;
        return $this;
    }
    
    /**
     * �������� �������� ��� ������ �������.
     *
     * @param mixed $value
     * @param string $format
     * @return Dune_Mysqli_Collector_Where
     */
    public function addSimpleData($value, $format = 's')
    {
        switch ($format)
        {
            case 'i':
                $this->_accumulator .= ' ' . (int)$value;
            break;
            case 'f':
                $this->_accumulator .= ' ' . (float)$value;
            break;
            default:
                $this->_initDB();
                $this->_accumulator .= ' "' . $this->_DB->real_escape_string($value) . '"';
                
        }
        if ($this->_haveLeft)
        {
            $this->_haveLeft = false;
            $this->_canAddAndOr = true;
            $this->_needAddAndOr = true;
        }
        else 
        {
            $this->_needAddAndOr = false;
            $this->_haveLeft = true;
            $this->_canAddAndOr = false;
        }
        $this->_openAddAndOr = false;
        return $this;
    }
    
    /**
     * Enter description here...
     *
     * @param unknown_type $field
     * @param unknown_type $table
     * @return Dune_Mysqli_Collector_Where
     */
    public function addSimpleField($field, $table = '')
    {
        if ($table)
            $this->_accumulator .= ' `' . $table .'`.';
        else 
            $this->_accumulator .= ' ';
        $this->_accumulator .= '`' . $field .'`';
        
        if ($this->_haveLeft)
        {
            $this->_haveLeft = false;
            $this->_canAddAndOr = true;
            $this->_needAddAndOr = true;
        }
        else 
        {
            $this->_haveLeft = true;
            $this->_canAddAndOr = false;
            $this->_needAddAndOr = false;
        }
        $this->_openAddAndOr = false;
        return $this;

    }
    
    /**
     * ���������� ������ ������� �������.
     *
     * @param string $value
     * @return Dune_Mysqli_Collector_Where
     */
    public function addOneWholly($value)
    {
        $this->_accumulator .= ' ' . $value;
        $this->_canAddAndOr = true;
        $this->_needAddAndOr = true;
        $this->_openAddAndOr = false;
        return $this;
    }

    
    /**
     * ������� ���� ������.
     *
     * @param boolean $where ���������� ������������ ����� WHERE � ������.
     * @return string
     */
    public function get($where = true)
    {
        
        if ($this->_bracketCount)
            throw new Dune_Exception_Base('���� ���������� ������.');
        if ($this->_haveLeft)
            throw new Dune_Exception_Base('���� ������������ ���������.');
           
        if ($where and $this->_accumulator)
            return ' WHERE ' . $this->_accumulator;
        return $this->_accumulator;
    }

    /**
     * ��������� AND ��� OR.
     * ����������, ���� ������� ����� �������� (��� �������).
     * 
     * ����������� ��������� - ���������� ��� ������� �������.
     *
     * @param string $value
     * @access private
     */
    protected function _addAndOr($value = 'AND', $exception_when_empty = false)
    {
        if (Dune_String_Functions::len($this->_accumulator) < 2)
        {
            if ($exception_when_empty)
                throw new Dune_Exception_Base('���������� ������� ���������� �� ����� - ��� ����� ��������� �������.');
            return $this;
        }
        if ($this->_openAddAndOr)
        {
            throw new Dune_Exception_Base('��������� ���������� ��������� ���������� �������.');
        }
        if (!$this->_needAddAndOr)
        {
            throw new Dune_Exception_Base('��������� ��������� ������: ' . $value . '. �� ����� �� �����.');
        }
        
        if ($this->_haveLeft)
        {
            throw new Dune_Exception_Base('������ ������� ������� ����������. ���� ������ �������� ������ �������� �������. ����� ����� �������.');
        }
        if (!$this->_canAddAndOr)
        {
            if ($this->_exception)
                throw new Dune_Exception_Base('���������� AND ��� OR �� ���������.');
        }
        else 
            $this->_accumulator .= ' ' . $value;
        $this->_openAddAndOr = true;
    }
    
}