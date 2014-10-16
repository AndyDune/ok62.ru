<?
/**
 * ����� �������� ������. �������� 3 ����� ����� ������������.
 * 
 *	������ ����� ������������ �� ��������.
 *  ������� ������ ��������� ���� �������� �������� � ��������.
 * 
 *	 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: UserName.php                                |
 * | � ����������: Dune/Data/Container/UserName.ph     |
 * | �����: ������ ����� (Dune) <dune@rznlf.ru>        |
 * | ������: 1.00                                      |
 * | ����: www.rznlf.ru                                |
 * ----------------------------------------------------
 * 
 */

class Dune_Data_Container_UserName implements ArrayAccess
{
  private $array = array();
    
  // ������ ������� ����
  private $rus = array("�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�",
                       "�", "�", "�", "�", "�", "�");
  // ������ ���������� ����
  private $eng = array("A", "a", "B", "E", "e", "K", "M", "H", "O", "o", "P",
                       "p", "C", "c", "T", "X", "x");
                       
  public function __construct($name)
  {
      $this->array['original'] = $name;
      $this->array['russian'] = str_replace($this->eng, $this->rus, $name);
      $this->array['english'] =  str_replace($this->rus, $this->eng, $name);
  }
  

////////////////////////////////////////////////////////////////
///////////////////////////////     ������ ���������� ArrayAccess
    public function offsetExists($key)
    {
        return key_exists($key,$this->array);
    }
    public function offsetGet($key)
    {
        if (!key_exists($key,$this->array))
          throw new Dune_Exception_Base('������ ������ ����������: ����� '.$key.' �� ����������. ����������: original, russian, english');
          //return false;
        return $this->array[$key];
    }
    
    public function offsetSet($key, $value)
    {
        throw new Dune_Exception_Base('�������� ������ �������� ����������');
    }
    public function offsetUnset($key)
    {
        throw new Dune_Exception_Base('�������� ������ �������� ����������');
    }

/////////////////////////////
////////////////////////////////////////////////////////////////
  
  
////////////////////////////////////////////////////////////////
///////////////////////////////     ���������� ������

    public function __set($key, $val)
    {
        throw new Dune_Exception_Base('�������� ������ �������� ����������');
    }
    public function __get($key)
    {
        if (!key_exists($key,$this->array))
            throw new Dune_Exception_Base('������ ������ ����������: '.$key.' �� ����������. ����������: original, russian, english');
        return $this->array[$key];
    }
    
}