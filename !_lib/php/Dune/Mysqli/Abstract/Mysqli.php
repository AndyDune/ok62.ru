<?php
/**
 * ��������� mysqli �������������� �����������������.
 * �����������  ����������.
 * 
 * ������ ����������� ������ query. � ������� ������ �������� ��� � �������� - ���������� ������-���������.
 * ��� �������� �������������� ���������� ������ �������������� ������.
 * ������������� � �������� ���������� �� ������ goDB (http://pyha.ru/go/godb/)
 * 
 * ������ �������, ��� ������� 2-�� ��������� ������ query ������������ � ������.
 * ������� ������� �������������:
 * ---------------------------------------
 *  ? ��������� ������. ������������ �����������, ����������� � �������. 
 *  ?p ��������� ������. ����� ������ �������, ��� ������������. �� ������������.
 *  ?s ������ ��� ������������. ������������ �����������, ����������� � �������. 
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
 * | ������: 1.06                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * 
 * ������� ������:
 * -----------------
 * 
 * 1.06 (2009 ������ 22)
 * �������� ���������� ����� __toString() - ������ ��������� ������ �������.
 * 
 * 1.05 (2009 ������ 20)
 * ��������� � ��������� �������� ������ ���������� �������. ����� getQuery().
 * ����� �����������: ������������ ����� �������. ?p
 * 
 * 1.04 (2008 ������� 04)
 * ������ � ����� ������������� s ���������.
 * 
 * 1.03 (2008 ������� 03)
 * ����� ����������� ?s, ��� ������������� ������, ������������ ������������, � ���������� ��� ������.
 * 
 * ������ 1.01 -> 1.02
 * ����� �����  makeSubstitution() ����������� � ������� ������������� ��� �������.
 * 
 * ������ 1.00 -> 1.01
 * ������ � ������ ���������� - ������ ��������.
 *
 */
abstract class Dune_Mysqli_Abstract_Mysqli extends mysqli
{

   /**
     * ������� ������ �� ���������
     *
     * @var string
     */
    protected $tablePrefix = '';

    /**
     * ���������� �������
     *
     * @var bool
     */
    protected $queryDebug = false;

    /**
     * ������ ��� ������
     *
     * @var array
     */
    protected static $dbList = Array();
    
    /**
     * ���������� �������� ����� �����
     *
     * @var int
     */
    protected $qQuery = 0;

    /**
     * �������� ������ �������. ������������ ��� �����������.
     *
     * @var string
     * @access private
     */
    protected $_query = '';
    
    
    /* ��������������� ����� */
    protected $_mqPH;
    protected $_mqPrefix;      
  
    /**
     * ������������� ��������� ����������� ������. $this->insert_id
     */
    const RESULT_ID ='id';
    
    /**
     * ���������� ������. $this->affected_rows
     */
    const RESULT_AR ='ar';
    
    /**
     * ����� ����� � ����������.
     */
    const RESULT_NUM ='num';
    
    /**
     * ������ �� ����������� �������. ���������.
     */
    const RESULT_ROW ='row';

    /**
     * ������ �� �����, ������, ������ ����������. ���������.
     */
    const RESULT_ROWROW ='rowrow';
    
    /**
     * ������ �� ����������� �������. �������������..
     */
    const RESULT_ASSOC ='assoc';

    /**
     * ������ �� �����, ������, ������ ����������. �������������..
     */
    const RESULT_ROWASSOC ='rowassoc';
    
    /**
     * ������ �� ������� �� ������ ������� - �������.
     */
    const RESULT_COL ='col';
    
    /**
     * ���� ����������� ���������. ������ ������ �������, ������ ���� � �������.
     */
    const RESULT_EL ='el';
    
    /**
     * ������-�������� �� �������������� �������. ������ assoc, ������ ������ ���������� ������� ������������ ������-��������.
     */
    const RESULT_IASSOC ='iassoc';

    /**
     * ������-�������� ��� row.
     */
    const RESULT_IROW ='irow';

    /**
     * ������-�������� ��� col.
     */
    const RESULT_ICOL ='icol';
    

    /**
     * ���������� ������� � ����
     *
     * 
     * @param  string $pattern sql-������ ��� ������-������ � ��������������
     * @param  array  $data    [optional] ������ ������� ������
     * @param  string $fetch   [optional] ������ ����������. ����������� ��������� ������.
     * @param  string $prefix  [optional] ������� ���� ������
     * @return mixed  ��������� ������� � �������� �������     
     */
    public function query($pattern, $data = null, $fetch = null, $prefix = null)
    {        
		$this->qQuery++;
    	$query = $data ? $this->makeQuery($pattern, $data, $prefix) : $pattern;
        if ($this->queryDebug) {
        	if ($this->queryDebug === true) {
            	print '<pre>'.htmlSpecialChars($query).'</pre>';
        	} else {
        		call_user_func($this->queryDebug, $query);
        	}
        }
        $this->_query = $query;
        $result = parent::query($query, MYSQLI_STORE_RESULT);
        if ($this->errno) {
            throw new Dune_Exception_Mysqli('Error in query: ' . $query . '<br /> ' . $this->error, $this->errno);
        }
        $return = $this->fetch($result, $fetch);
        if ((!is_object($return)) && (is_object($result))) 
        {
            $result->free();
        }
        return $return;
    }    
  
    
    /**
     * ���������� ����������� � ������ ��� ��������� �� � ������ �������.
     * ������� ��� ������ ����������� ������.
     * 
     * @param string $string
     * @param array $data
     * @return string
     */
    public function makeSubstitution($string, $data = null)
    {   
    	$query = $this->makeQuery($string, $data);
    	return $query;
    }    
    
    
    /**
     * ������������ �������
     *
     * @param string $pattern ������-������ � ��������������
     * @param array  $data    ������ ������� ������
     * @param string $prefix  [optional] ������� ������
     */
    public function makeQuery($pattern, $data, $prefix = '')
    {
        $prefix = ($prefix === null) ? $this->tablePrefix : $prefix;    
        $this->_mqPH = $data;
        $this->_mqPrefix = $prefix;
        $q = @preg_replace_callback('/\?([psint?ca]?[ina]?);?/', Array($this, '_makeQuery'), $pattern);
        if (sizeOf($this->_mqPH) > 0) 
        {
            throw new Dune_Exception_Mysqli('It is too much data.');
        }
        return $q;
    }    
  
  
    /**
     * ������ ���������� � ������ �������
     *
     * @param  mysqli_result $result ���������
     * @param  string        $fetch  ������
     * @return mixed
     */
    public function fetch($result, $fetch)
    {
        $fetch = strToLower($fetch);
        if ((!$fetch) || ($fetch == 'no')) {
            return $result;
        }
        if ($fetch == 'id') {
            return $this->insert_id;
        }
        if ($fetch == 'ar') {
            return $this->affected_rows;
        }
        $numRows = $result->num_rows;
        if ($fetch == 'num') {
            return $numRows;
        }
        if ($fetch == 'row') {
            $A = Array();
            for ($i = 0; $i < $numRows; $i++) {
                $A[] = $result->fetch_row();
            }
            return $A;
        }
        if ($fetch == 'assoc') {
            $A = Array();
            for ($i = 0; $i < $numRows; $i++) {
                $A[] = $result->fetch_assoc();
            }
            return $A;
        }
        if ($fetch == 'col') {
            $A = Array();
            for ($i = 0; $i < $numRows; $i++) {
                $r = $result->fetch_row();
                $A[] = $r[0];
            }
            return $A;
        }

        if ($fetch == 'irow') {
            return new Dune_Mysqli_Iterator_ResultRow($result);
        }
        if ($fetch == 'iassoc') {
            return new Dune_Mysqli_Iterator_ResultAssoc($result);
        }
        if ($fetch == 'icol') {
            return new Dune_Mysqli_Iterator_ResultCol($result);
        }

        if ($numRows == 0) 
        {
            return false;
        }
        if ($fetch == 'rowrow')
        {
            return $result->fetch_row();
        }
        if ($fetch == 'rowassoc') 
        {
            return $result->fetch_assoc();
        }
        if ($fetch == 'el') 
        {
            $r = $result->fetch_row();
            return $r[0];
        }
        return true;
    }

    /**
     * ��������� �������� ������
     *
     * @param string $prefix
     */
    public function setPrefix($prefix)
    {
        $this->tablePrefix = $prefix;
        return true;
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
    
	/**
	 * �������� ���������� �������� ����� ������ �����
	 *
	 * @return int
	 */
    public function getQQuery()
    {
    	return $this->qQuery;
    }

	/**
	 * �������� ����� ���������� �������.
	 *
	 * @return int
	 */
    public function getQuery()
    {
    	return $this->_query;
    }
    
    public function __toString()
    {
        return $this->getQuery();
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
            
            case ('s'):
                 $el = serialize($el);
                 return '"'.$this->real_escape_string($el).'"';
            case ('p'):
                 return $el;
                 
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
                return is_null($el) ? 'NULL' : ('"'.$this->real_escape_string($el).'"');
            case ('ni'):
            case ('in'): 
                return is_null($el) ? 'NULL' : intVal($el);
            case ('a'):
                foreach ($el as &$e) 
                {
                    $e = '"'.$this->real_escape_string($e).'"';
                }
                return implode(',', $el);
            case ('ai'):
            case ('ia'):
                foreach ($el as &$e) {
                    $e = intVal($e);
                }
                return implode(',', $el);
        }
        return '"'.$this->real_escape_string($el).'"';
    }


  protected function __construct($host,$username,$passwd=null,$dbname=null,$port=null, $socket=null)
  {
      parent::__construct($host,$username,$passwd,$dbname,$port, $socket);
  }
////////// ����� �������� ��������� �������
///////////////////////////////////////////////////////////////  
}