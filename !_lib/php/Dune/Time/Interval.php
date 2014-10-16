<?php
/**
 * ������������ ������� �� ������� �������� �������
 * ������ (echo) ������� �������� � �������� ���������
 * 
 * ��������� ����������: ArrayAccess,Iterator
 * ���������� ��������� ������: __toString - ������ ��������� � ����������� ��� ���������� ��������
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Interval.php                                |
 * | � ����������: Dune/Time/Interval.php              |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 1.00                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * 
 */

class Dune_Time_Interval implements ArrayAccess, Iterator
{
    protected $timeBegin;
    protected $timeMarker = array();
    protected $toRound = 3;
    
    public function __construct($precision = 3)
    {
        $this->toRound = $precision;
        $this->timeBegin = microtime(true);
    }
    /**
     * ���������� �������� � ����������� � ������� � ��������� ������
     *
     * @param mixed $val
     * @return float
     */
    public function getTime($keyName = null)
    {
        if (empty($keyName))
            return $this->timeMarker[] = round(microtime(true) - $this->timeBegin,$this->toRound);
        else 
            return $this->timeMarker[$keyName] = round(microtime(true) - $this->timeBegin,$this->toRound);
    }
    
    
////////////////////////////////////////////////////////////////
///////////////////////////////     ������ ���������� ArrayAccess
    public function offsetExists($key)
    {
        return key_exists($key,$this->timeMarker);
    }
    public function offsetGet($key)
    {
        if (!key_exists($key,$this->timeMarker))
            throw new Exception('������ ������ ��������� �����: ����� '.$key.' �� ����������');
        return $this->timeMarker[$key];
    }
    
    public function offsetSet($key, $value)
    {
        throw new Exception('�������� ������ �������� ��������� �����');
    }
    public function offsetUnset($key)
    {
        throw new Exception('�������� ������ �������� ��������� �����');
    }

/////////////////////////////
////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////
///////////////////////////////     ������ ���������� Iterator
  // ������������� �������� �� ������ �������
  public function rewind()
  {
    reset($this->timeMarker);
  }
  // ���������� ������� �������
  public function current()
  {
    return current($this->timeMarker);
  }
  // ���������� ���� �������� ��������
  public function key()
  {
    return key($this->timeMarker);
  }
  // ��������� � ���������� ��������
  public function next()
  {
    next($this->timeMarker);
  }
  // ���������, ���������� �� ������� ������� ����� ���������� ������ rewind ��� next
  public function valid()
  {
    if (isset($this->timeMarker[key($this->timeMarker)]))
        return true;
    else 
        return false;
  }    
/////////////////////////////
////////////////////////////////////////////////////////////////    
    
    
//////////////////////////////////////////////////////////////////////
//////////////////  ��������� ������
    private function __toString()
    {
        return (string)(round(microtime(true) - $this->timeBegin,$this->toRound));
    }

}