<?php
/**
 * ����� ��� ������ � DBM ��� � �������� - ����������� ��������
 * ������������ ��� ���� �������. �����������
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Dbm.php                                     |
 * | � ����������: Dune/AsArray/Parent/Dbm.php         |
 * | �����: ������ ����� (Dune) <dune@pochta.ru>       |
 * | ������: 1.04                                      |
 * | ����: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * 
 * ������� ������:
 * 
 * ������ 1.03 -> 1.04
 * ��� ���������� ���������� �� ����� Dune_Exception_Base
 * 
 * ������ 1.02 -> 1.03
 * �������� ��������� ��� ������������.
 * ������� ����������� ������������ ������� ������ 'r' > 'w' �������������
 * ������� ������� close() - ��������������� �������� ����������. �������������� �������� �� ��������� ����� ��������.
 * 
 * ������ 1.01 -> 1.02
 * �������� �������� ��� ������. � ������ ������ � dbm "r" ��������� ����������.
 * 
 * ������ 1.00 -> 1.01
 * �������� ������������������ �������� ���������� � �����������
 * 
 */

abstract class Dune_AsArray_Parent_Dbm implements Iterator,ArrayAccess
{
    protected $__maxRandOtimize = 100;

    protected $__switchReadModeToWrite = true; // ����������� ������������ ������ 'r' > 'w' �������������
                                               // ���� ��������� - ���. ����������
    protected $__DBA;
    protected $__DBA_path;
    protected $__DBA_mode;
    protected $__DBA_handler;
    protected $__defaultValue = '';
    protected $__getLastRecord = true;
    protected $__currentKey;
    protected $__currentValue = false;

    
    protected function connectDBA()
    {
        $this->__DBA = @dba_open($this->__DBA_path,$this->__DBA_mode,$this->__DBA_handler);
        if (!$this->__DBA)
            $this->__DBA = @dba_open($this->__DBA_path,'n',$this->__DBA_handler);
        if (!$this->__DBA)
            throw new Dune_Exception_Base('�� ������� ������� ���� DBM. ��������� ����: <strong>'.$this->__DBA_path.'</strong>');
        
    }  
    protected function checkDBA()
    {
        if (!$this->__DBA)
        {
            throw new Dune_Exception_Base('���������� � ����� ������ DBM ���� ������������� �������. ������ ����������.');
        }
        
    }
    
    
/**
 * ����������� - ��������� ���� dbm
 *
 * @param unknown_type $path ���� � �����
 * @param unknown_type $handler ��� ���� ������, �� ��������� flatfile
 * @param unknown_type $mode ����� �������� �����, �� ��������� w
 */
    protected function __construct($path,$mode = 'r',$handler = 'flatfile')
    {
        $this->__DBA_path = $path;
        $this->__DBA_mode = $mode;
        $this->__DBA_handler = $handler;
        $this->connectDBA();
        
        if (rand(1,$this->__maxRandOtimize) == 1)
            $this->optimize();
    }
    
    
    public function __destruct()
    {
        if ($this->__DBA)
            dba_close($this->__DBA);
    }
    
   /**
    * ��������� ��������, ����������� ������������� ����� � ����
    *
    * @param mixed $value
    */
    public function setDefaultValue($value = '')
    {
        $this->__defaultValue = $value;
    }
    
    /**
     * ������� ���������� � �����.
     *
     */
    public function close()
    {
        $this->checkDBA();
        dba_close($this->__DBA);
        $this->__DBA = null;
    }
    
    
/**
 * ����� ����������� ����� (������� �� �������� �������)
 * 
 * �������� �� ����� ����������� ������
 * ���� ������ ������ - ������������ ���� "�����������"
 * 
 * �������� ������ ����� �������� ����� ��� �������� ������� � ���������� ������.
 * ����� ������ ���� ���������
 * ��������� ���� ����������������� - �������� ��� �������������� �������
 * 
 * ���� ��� ������ � ������� db3,bd4 - ������������ ����������� ��������
 * 
 */
    public function optimize()
    {
        if (($this->__DBA_handler != 'db3') AND ($this->__DBA_handler != 'db4'))
        {
            $temp_name = dirname($this->__DBA_path).'/'.uniqid().'.dbt';
            $temp_dba = dba_open($temp_name,'c',$this->__DBA_handler);
            if (!$temp_dba)
                throw new Dune_Exception_Base('�� ������� ������� ��������� ���� ��� ����������� DBM. ��������� ����:<strong>'.$temp_name).'</strong>';
            
            $key = dba_firstkey($this->__DBA);
            while ($key)
            {
                dba_insert($key,dba_fetch($key,$this->__DBA),$temp_dba);
                $key = dba_nextkey($this->__DBA);
            }
            dba_close($this->__DBA);
            dba_close($temp_dba);
            if (unlink($this->__DBA_path))
                rename($temp_name,$this->__DBA_path);
            else 
                throw new Dune_Exception_Base('�� ������� ������� ���� dbm ��� ������ ����������������. ��������� ����:<strong>'.$temp_name).'</strong>';
            $this->connectDBA();
        }
        else 
            dba_optimize($this->__DBA);
    }
    
    
////////////////////////////////////////////////////////////////
///////////////////////////////     ���������� ������
/**
 * Enter description here...
 *
 * @access private
 * @param unknown_type $name
 * @param unknown_type $value
 * @return unknown
 */
    public function __set($name, $value)
    {
        $this->checkDBA();
        if ($this->__DBA_mode == 'r')
        {
            if ($this->__switchReadModeToWrite)
            {
                $this->__DBA_mode = 'w';
                $this->close();
                $this->connectDBA();
            }
            else 
                throw new Dune_Exception_Base('������� ������ � ���� ������ dbm, �������� ������ ��� ������.');
        }
        return dba_replace($key,$value,$this->__DBA);
    }
    /**
     * Enter description here...
     *
     * @access private
     * @param unknown_type $name
     * @return unknown
     */
    public function __get($name)
    {
        $this->checkDBA();
        if (dba_exists($name,$this->__DBA))
        {
            return dba_fetch($name, $this->__DBA);            
        }
        else 
            return $this->__defaultValue;
    }
/////////////////////////////
////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////
///////////////////////////////     ������ ���������� Iterator
  // ������������� �������� �� ������ �������
  public function rewind()
  {
    $this->checkDBA();
    return $this->__currentKey = dba_firstkey($this->__DBA);
  }
  // ���������� ������� �������
  public function current()
  {
      $this->checkDBA();
      return dba_fetch($this->__currentKey, $this->__DBA);;
  }
  // ���������� ���� �������� ��������
  public function key()
  {
      $this->checkDBA();
      return key($this->__currentKey);
  }
  // ��������� � ���������� ��������
  public function next()
  {
      $this->checkDBA();
      return $this->__currentKey = dba_nextkey($this->__DBA);
  }
  // ���������, ���������� �� ������� ������� ����� ���������� ������ rewind ��� next
  public function valid()
  {
      return $this->__currentKey;  
  }    
/////////////////////////////
////////////////////////////////////////////////////////////////    



////////////////////////////////////////////////////////////////
///////////////////////////////     ������ ���������� ArrayAccess
    /**
     * @param mixed $key
     * @return mixed
     * @access private
     */
    public function offsetExists($key)
    {
        $this->checkDBA();
        return dba_exists($key,$this->__DBA);
    }
    public function offsetGet($key)
    {
        $this->checkDBA();
        if (dba_exists($key,$this->__DBA))
        {
            return dba_fetch($key, $this->__DBA);
        }
        else 
            return $this->__defaultValue;
    }
    
    public function offsetSet($key, $value)
    {
        $this->checkDBA();
        if ($this->__DBA_mode == 'r')
        {
            if ($this->__switchReadModeToWrite)
            {
                $this->__DBA_mode = 'w';
                $this->close();
                $this->connectDBA();
            }
            else 
                throw new Dune_Exception_Base('������� ������ � ���� ������ dbm, �������� ������ ��� ������.');
        }
        return dba_replace($key,$value,$this->__DBA);
    }
    public function offsetUnset($key)
    {
        $this->checkDBA();
        if ($this->__DBA_mode == 'r')
        {
            if ($this->__switchReadModeToWrite)
            {
                $this->__DBA_mode = 'w';
                $this->close();
                $this->connectDBA();
            }
            else 
                throw new Dune_Exception_Base('������� ������ � ���� ������ dbm, �������� ������ ��� ������.');
        }
        return dba_delete($key,$this->__DBA);
    }

/////////////////////////////
////////////////////////////////////////////////////////////////
}