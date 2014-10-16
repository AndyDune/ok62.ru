<?php
/**
 * ��������� ���������� ������� (��������).
 * �����������.
 * 
 * -------------------------------------------------------
 * | ����������: Dune                                     |
 * | ����: Result.php                                     |
 * | � ����������: Dune/Mysqli/Iterator/Parent/Result.php |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>            |
 * | ������: 1.02                                         |
 * | ����: www.rznw.ru                                    |
 * -------------------------------------------------------
 *
 * ������:
 * 
 * 1.02 (2009 ���� 13)  ����������� ��������� ������������ � �������������� �����������.
 * 
 * 1.01 (2008 ������ 13) ���������� ��������� Countable
 * 
 */
abstract class Dune_Mysqli_Iterator_Parent_Result implements Iterator, ArrayAccess, Countable
{
	
	protected $result, $numRows, $count = 0;
	
	protected $_resultArray = array();
	protected $_afterUnserialize = false;
	
    abstract protected function getEl();
    
	/**
	 * ��������� ������ result ����� ������ ������ query, ������ mysqli
	 *
	 * @param mysqli $result
	 */
    public function __construct($result)
    {
        $this->result  = $result;
        $this->numRows = $result->num_rows;
    }

    public function __destruct()
    {
        if (is_resource($this->result)) {
            $this->result->free();
        }
    }
    
////////////////////////////////////////////////////////////////
///////////////////////////////     ������ ���������� Iterator
	/**
	 * ������������ �������� �� ������ �������
	 *
	 * @return boolean
	 */
    public function rewind()
    {
        $this->count = 0;
        return true;
    }
	
    /**
     * ���������� ������� �������
     *
     * @return mixed
     */
    public function current()
    {
        if ($this->_afterUnserialize)
        {
            return $this->_resultArray[$this->count];
        }
        else 
        {
            $this->result->data_seek($this->count);
            return $this->getEl();
        }
    }

    /**
     * ���������� ���� �������� ��������
     *
     * @return mixed
     */
    public function key()
    {
        return $this->count;
    }
	
    /**
     * ��������� � ���������� ��������
     *
     * @return Dune_Mysqli_Iterator_Parent_Result
     */
    public function next()
    {
        $this->count++;
//        return $this->current();
        return $this;
    }
	
    /**
     * ���������, ���������� �� ������� ������� ����� ���������� ������ rewind ��� next
     *
     * @return boolean
     */
    public function valid()
    {
        if ($this->_afterUnserialize)
        {
            if (isset($this->_resultArray[$this->count]))
                return true;
            else 
                return false;
        }
        else if ($this->count >= $this->numRows)
        {
            return false;
        }
        return true;
    }

    /**
     * ���������� ����� ����� � �������
     *
     * @return integer
     */
    public function count()
    {
        return $this->numRows;
    }

    /**
     * ���������� �������� �� ������ �������, ����������� � ������.
     *
     * @param integer $num ����� ������ � ���������� �������
     * @param mixed $index ������ � ������� �� ������ ���� � �������
     * @return misxed
     */
    public function get($num, $index = false)
    {
        if ($num >= $this->numRows) {
            return false;
        }
        $this->result->data_seek($num);
        $r = $this->getEl();
        if ($index === false)
        {
            return $r;
        }
        if (!is_array($r)) 
        {
            return false;
        }
        if (!isSet($r[$index])) 
        {
            return false;
        }
        return $r[$index];
    }

////////////////////////////////////////////////////////////////
///////////////////////////////     ������ ���������� ArrayAccess
    
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }
    public function offsetSet($offset, $value)
    {
        return false;
    }
    public function offsetExists($offset)
    {
        return (($offset >= 0) && ($offset < $numRows));
    }
    public function offsetUnset($offset)
    {
        return false;
    }

    public function __sleep()
    {
        if ($this->numRows)
        {
            $this->_resultArray = array();
            foreach ($this as $value)
            {
                $this->_resultArray[] = $value;
            }
        }
        return array('_resultArray', 'numRows', 'count');
    }
    public function __wakeup()
    {
        $this->_afterUnserialize = true;
    }
    
}