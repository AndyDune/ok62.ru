<?php
/**
 * ��������� mysqli �������������� �����������������.
 * �����������  ����������.
 * 
 * ������ ����������� ������ query. � ������� ������ �������� ��� � �������� - ���������� ������-���������.
 * ��� �������� �������������� ���������� ������ �������������� ������.
 * ������������� � �������� ���������� �� ������ goDB (http://pyha.ru/go/godb/)
 * 
 * ������ �������, ��� ������� 2-�� ��������� ������ query ������������� � ������.
 * ������� ������� �������������:
 * ---------------------------------------
 *  ? ��������� ������. ������������ �����������, ����������� � �������. 
 *  ?i ������������� ������. ������������� ���������� � ������ �����. 
 *  ?n, ?ni ������ � ��������� NULL. � ������ ��������� ���������� php-�������� null, � ������ ����������� NULL. � ������ ������� ����� ����, ��� ������� �?�, �?i�.  
 *  ?a, ?ai ������ ������. �� ����� ������� ������ � ������������� � ������ ��������� ��� ������������� ������. 
 *  ?t ��� �������. ����������� ��� ������� � �������������� ��������. ����������� � ���������. 
 *  ?c ��� �������. ����������� ��� �������, ����������� � ���������. �� ����� ����� ���� ������ Array(�������, �������). 
 *  ?ia, ?in ������������ ������� ������������� ����� ������ � ����� ������� (?ia === ?ai). 
 *  ?;, ?ia; �� ��������� ���������������, ������������ ����� ��������� ������ � �������. 
 *  ?? ��� ���������������� ������� ������� ��������������� ���� ��� ������� �������. 
 *
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Mysqli.php                                  |
 * | � ����������: Dune/Mysqli/Abstract/Mysqli.php     |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 1.00                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * 
 * ������� ������:
 * -----------------
 * ������ 1.00 -> 1.01
 *
 */
class Dune_Mysqli_Query_Substitution
{


    /**
     * ���������� �������
     *
     * @var bool
     */
    protected $queryDebug = false;
    
    protected $_string = '';
    protected $_data = array();


    /* ��������������� ����� */
    protected $_mqPH;
    protected $_mqPrefix = '';      
  
    

    /**
     * ���������� ������� � ����
     */
    public function make($data = null)
    {   
        if ($data != null)
            $this->_data = $data;
    	$query = $this->makeQuery($this->string, $this->_data);
    	return $query;
    }    
  
    /**
     * ������������ �������
     *
     * @param string $pattern ������-������ � ��������������
     * @param array  $data    ������ ������� ������
     * @param string $prefix  [optional] ������� ������
     */
    public function makeQuery($pattern, $data)
    {
        $this->_mqPH = $data;
        $q = @preg_replace_callback('/\?([int?ca]?[ina]?);?/', Array($this, '_makeQuery'), $pattern);
        if (sizeOf($this->_mqPH) > 0) 
        {
            throw new Dune_Exception_Mysqli('It is too much data.');
        }
        return $q;
    }    
  
  

    /**
     * ���������� �������� �������
     *
     * @param bool $debug
     */
    public function setDebug($debug = true)
    {
        $this->queryDebug = $debug;
        return true;
    }
    
    
/////////////////////////////////////////////////////////////////////

//////////////////////////////      ��������� ������    
    /**
     * ��������������� ������� ��� ������������ �������
     *
     * @param  array  $ph
     * @return string
     */
    protected function _makeQuery($ph)
    {
        if ($ph[1] == '?') 
        {
            return '?';
        }
        if (sizeOf($this->_mqPH) == 0) 
        {
            throw new Dune_Exception_Mysqli('It is not enough data');
        }
        $el = array_shift($this->_mqPH);
        switch ($ph[1]) {
            case ('i'):
                 return intVal($el);
            case ('t'): 
                return '`'.$this->_mqPrefix.$el.'`';
            case ('c'):
                if (is_array($el)) 
                {
                    return '`'.$this->_mqPrefix.$el[0].'`.`'.$el[1].'`';
                }
                return '`'.$el.'`';
            case ('n'): 
                return is_null($el) ? 'NULL' : ('"'.$this->_DB->real_escape_string($el).'"');
            case ('ni'):
            case ('in'): 
                return is_null($el) ? 'NULL' : intVal($el);
            case ('a'):
                foreach ($el as &$e) 
                {
                    $e = '"'.$this->_DB->real_escape_string($e).'"';
                }
                return implode(',', $el);
            case ('ai'):
            case ('ia'):
                foreach ($el as &$e) {
                    $e = intVal($e);
                }
                return implode(',', $el);
        }
        return '"'.$this->_DB->real_escape_string($el).'"';
    }
  


  protected function __construct($string)
  {
      $this->_DB = Dune_MysqliSystem::getInstance();
      $this->_string = $string;
  }
}