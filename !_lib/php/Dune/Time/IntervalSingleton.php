<?php
/**
 * ������������ ������� �� ������� �������� �������
 * ����� - ���������. (������������� ��������� ������ Dune_Time_Interval)
 * 
 * ������ (echo) ������� �������� � �������� ���������
 * 
 * ��������� ����������: ArrayAccess,Iterator
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: IntervalSingleton.php                       |
 * | � ����������: Dune/Time/IntervalSingleton.php     |
 * | �����: ������ ����� (Dune) <dune@pochta.ru>       |
 * | ������: 1.01                                      |
 * | ����: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * ������� ������:
 * -----------------
 * 
 * ������ 1.00 -> 1.01
 * ������� ����������� ��������� ��������� Singleton'�� � �������� ������.
 * 
 *
 */

class Dune_Time_IntervalSingleton implements ArrayAccess,Iterator
{
    protected $timeBegin;
    protected $timeMarker = array();
    protected $toRound = 3;
    
    
    /**
    * ����. ��� ������ ������ ����. ������ � ������������ ��� �����������
    *
    * @var ��������� �� ������
    */
  static private $instance = array();

  /**
   * ������ ���������� ������ ��� ������ ������
   * ���������� ���������� ��������� ������� ��� ����������� �������
   *
   * @param integer $precision ����� ������ ����� �������
   * @param string $name ��� ������� �� ���������� �������
   * @return Dune_Time_IntervalSingleton
   */
  
  public static function getInstance($precision = 3, $name = 'default')
  {
        if (!key_exists($name,self::$instance))
        {
            self::$instance[$name] = new Dune_Time_IntervalSingleton($precision);
        }
        return self::$instance[$name];
  }

  /**
   * @access private
   */
    private function __construct($precision = 3)
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
  /**
   * @access private
   */
    public function offsetExists($key)
    {
        return key_exists($key,$this->timeMarker);
    }
    
  /**
   * @access private
   */
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
    public function __toString()
    {
        return (string)(round(microtime(true) - $this->timeBegin,$this->toRound));
    }    
    
    
}