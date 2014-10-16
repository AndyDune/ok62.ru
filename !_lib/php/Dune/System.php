<?php
/**
 * ����� ���������� � ���� ��������� ����������
 * ����� ��� ����� ��������� ������������
 * ���� ��������� �������� ���� ini-����
 * ����� ��������� Singletone - �������� ������ ��� � ��������� ��������� �������, ��. ��������
 * 
 * ������ � ���������� �������������� ������������ Iteratir � ArrayAccess
 * ������ � �������������� ���������� �������� � ���������� Exception
 * 
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: System.php                                  |
 * | � ����������: Dune/System.php                     |
 * | �����: ������ ����� (Dune) <dune@rznlf.ru>        |
 * | ������: 1.02                                      |
 * | ����: www.rznlf.ru                                |
 * ----------------------------------------------------

 * ������ �������� ������� ������� Dune_System::getInstance()
 * 
 * ��� ��������� ������ ������� ������������ ��������� �� ��� ��������� ������.
 * 
 * 
 * ������� ������:
 * -----------------
 * ������ 1.01 -> 1.02
 * ����� getInstance() ������ �� ��������� ���������. ���� � ����� ������ �� ������ Dune_Parameters
 * 
 * ������� ������:
 * -----------------
 * ������ 1.00 -> 1.01
 * ���������� ������ ��� �������� ������������� ����� � ������� $arrayINI. �����: offsetExists($key)
 *
 */
class Dune_System implements ArrayAccess,Iterator
{
    private $arrayINI = array();
    private $__currentKey;
    
   /**
    * ����. ��� ������ ������ ����. ������ � ������������ ��� �����������
    *
    * @var ��������� �� ������
    */
  static private $instance = NULL;

  /**
   * ������ ���������� ������ ��� ������ ������
   * ���������� ���������� ��������� ������� ��� ����������� �������
   *
   * @param string $fileName
   * @return ��������� �� ������
   */
  static function getInstance()
  {
    if (self::$instance == NULL)
    {
      self::$instance = new Dune_System(Dune_Parameters::$configFilePath);
    }
    return self::$instance;
  }
  
  // ����������� ��������� - ����� ����� ����������
  private function __construct($fileName)
  {
      if (is_file($fileName))
      {
          $this->arrayINI = parse_ini_file($fileName);
      }
      else 
        throw new Exception('���� �������� �� ���������� ���� �� ����������: '.$fileName);
  }
  
////////////////////////////////////////////////////////////////
///////////////////////////////     ������ ���������� ArrayAccess
    public function offsetExists($key)
    {
        return key_exists($key,$this->arrayINI);
    }
    public function offsetGet($key)
    {
        if (!key_exists($key,$this->arrayINI))
            //throw new Exception('������ ������ ��������� ����������: ����� '.$key.' �� ����������');
            return false;
        return $this->arrayINI[$key];
    }
    
    public function offsetSet($key, $value)
    {
        throw new Exception('�������� ������ �������� ��������� ����������');
    }
    public function offsetUnset($key)
    {
        throw new Exception('�������� ������ �������� ��������� ����������');
    }

/////////////////////////////
////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////
///////////////////////////////     ������ ���������� Iterator
  // ������������� �������� �� ������ �������
  public function rewind()
  {
    reset($this->arrayINI);
  }
  // ���������� ������� �������
  public function current()
  {
    return current($this->arrayINI);
  }
  // ���������� ���� �������� ��������
  public function key()
  {
    return key($this->arrayINI);
  }
  // ��������� � ���������� ��������
  public function next()
  {
    next($this->arrayINI);
  }
  // ���������, ���������� �� ������� ������� ����� ���������� ������ rewind ��� next
  public function valid()
  {
    if (isset($this->arrayINI[key($this->arrayINI)]))
        return true;
    else 
        return false;
  }    
/////////////////////////////
////////////////////////////////////////////////////////////////
  
}