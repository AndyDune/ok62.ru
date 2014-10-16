<?php
/**
 * ��������� ���������� ������� (��������).
 * �����������.
 * 
 * ������������ � ����������� ����������. � ����������� mysql.
 * 
 * -------------------------------------------------------
 * | ����������: Dune                                     |
 * | ����: Result.php                                     |
 * | � ����������: Dune/Mysql/Iterator/Parent/Result.php |
 * | �����: ������ ����� (Dune) <dune@rznlf.ru>           |
 * | ������: 1.00                                         |
 * | ����: www.rznlf.ru                                   |
 * -------------------------------------------------------
 *
 */
abstract class Dune_Mysql_Iterator_Parent_Result implements Iterator, ArrayAccess
{

    protected $result = false;
    protected $numRows = 0;
    protected $count = 0;
    
    protected $error = '';
    
	
    abstract protected function getEl();
    
   
    public function __construct($result, $exeption = true)
    {
        if ($result === false)
        {
            if ($exeption)
                throw new Dune_Exception_Mysql('������ � ���������� �������');
            else 
                $this->error = '������ � ���������� �������';
        }
        else 
        {
            $this->result  = $result;
            $this->numRows = mysql_num_rows($result);
        }
    }

    public function __destruct()
    {
        if ($this->result)
        {
            unset($this->result);
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
        mysql_data_seek($this->result, $this->count);
        return $this->getEl();
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
     * @return mixed
     */
    public function next()
    {
        $this->count++;
        //return $this->current(); // ������ ������ ����������
    }
	
    /**
     * ���������, ���������� �� ������� ������� ����� ���������� ������ rewind ��� next
     *
     * @return unknown
     */
    public function valid()
    {
        if ($this->count >= $this->numRows) {
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
        mysql_data_seek($this->result, $num);
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



}