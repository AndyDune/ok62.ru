<?php
/**
 * 
 * ������ ��������.
 * 
 */
class Special_Vtor_Article_Text_List extends Dune_Mysqli_Abstract_Connect
{ 
                        
    public static $table = 'unity_article_text';
    public static $tableCorr = 'unity_article_sections_corr';
    
    protected $_type = null;
    protected $_section = null;
    protected $_parent = null;
    
    protected $_order = '';
    
	public function __construct($type = null)
	{
	    if (!is_null($type))
	       $this->_type = $type;
	    $this->_initDB();
	}
	
	/**
	 * �������� ���� �������.
	 * 0 - ��� ������.
	 * 1 - ��� ��������.
	 *
	 * @param unknown_type $type
	 */
	public function setType($type)
	{
	    $this->_type = $type;
	    return $this;
	}

	
	/**
	 * �������� ��������.
	 *
	 * @param integer $value
	 */
	public function setParent($value)
	{
	    $this->_parent = $value;
	    return $this;
	}
	
	/**
	 * �������� �������.
	 *
	 * @param unknown_type $type
	 */
	public function setSection($type)
	{
	    $this->_type = $type;
	    return $this;
	}
	
	/**
	 * �������
	 *
	 * @param string $field �������� ����
	 * @param ������� $order ASC ��� DESC
	 */
	public function setOrder($field, $order = 'ASC')
	{
	    if ($this->_order)
	       $this->_order .= ', ';
	    else 
	       $this->_order .= ' ORDER BY ';
	    $this->_order .= '`text`.`' . $field . '` ' . $order;
	}
	
	public function getList($shift = 0, $limit = 100)
	{
	    $q = 'SELECT * FROM `' . self::$table . '` as `text`';
	    
//	    if (!is_null($this->_type))
//	       $q .= ' WHERE type = ' . (int)$this->_type;
	       
	    $where = new Dune_Mysqli_Collector_Where();
	    if (!is_null($this->_type))
	    {
	        $where->addSimpleField('type', 'text')->addCompare()->addSimpleData($this->_type, 'i');
	    }

	    if (!is_null($this->_parent))
	    {
	        $where->addAnd();
	        $where->addSimpleField('parent')->addCompare()->addSimpleData($this->_parent, 'i');
	    }
	    
	    $q .= $where->get();
	    $q .= $this->_order;
	    $q .= ' LIMIT ' . $shift . ', ' . $limit;
	    $result = $this->_DB->query($q, null, Dune_MysqliSystem::RESULT_IASSOC);
	    return $result;
	}

	public function getListInSection($shift = 0, $limit = 100)
	{
	    $q = 'SELECT text.* FROM `' . self::$table . '` as `text`, `' . self::$tableCorr . '` as `text_corr`';
	    
	    $where = new Dune_Mysqli_Collector_Where();
	    $where->addSimpleField('article_id', 'text_corr')->addCompare()->addSimpleField('id', 'text');
	    if (!is_null($this->_type))
	    {
	        $where->addSimpleField('type')->addCompare()->addSimpleData($this->_type, 'i');
	    }
	    if (!is_null($this->_section))
	    {
	        throw new Dune_Exception_Base('�� ������ ������ ��� �������');
	    }
	    if (!is_null($this->_parent))
	    {
	        $where->addAnd();
	        $where->addSimpleField('parent')->addCompare()->addSimpleData($this->_parent, 'i');
	    }
	    
	    $where->addAnd();
	    $where->addSimpleField('section_id', 'text_corr')->addCompare()->addSimpleData($this->_section, 'i');
	    
	    $q .= $where->get();
	    $q .= ' LIMIT ' . $shift . ', ' . $limit;
	    $result = $this->_DB->query($q, null, Dune_MysqliSystem::RESULT_IASSOC);
	    return $result;
	}
	
	public function getCount()
	{
	    $q = 'SELECT count(*) FROM `' . self::$table . '`';
	    
	    $where = new Dune_Mysqli_Collector_Where();
	    if (!is_null($this->_type))
	    {
	        $where->addSimpleField('type')->addCompare()->addSimpleData($this->_type, 'i');
	    }
	    if (!is_null($this->_parent))
	    {
            $where->addAnd();
	        $where->addSimpleField('parent')->addCompare()->addSimpleData($this->_parent, 'i');
	    }
	    
	    $q .= $where->get();
	       
	       
	    $result = $this->_DB->query($q, null, Dune_MysqliSystem::RESULT_EL);
	    return $result;
	}

	public function getCountInSection()
	{
	    $q = 'SELECT count(distinct(text.id)) FROM `' . self::$table . '` as `text`, `' . self::$tableCorr . '` as `text_corr`';
	    
	    $where = new Dune_Mysqli_Collector_Where();
	    $where->addSimpleField('article_id', 'text_corr')->addCompare()->addSimpleField('id', 'text');
	    if (!is_null($this->_type))
	    {
	        $where->addAnd();
	        $where->addSimpleField('type')->addCompare()->addSimpleData($this->_type, 'i');
	    }
	    if (!is_null($this->_parent))
	    {
	        $where->addAnd();
	        $where->addSimpleField('parent')->addCompare()->addSimpleData($this->_parent, 'i');
	    }
	    
	    if (!is_null($this->_section))
	    {
	        throw new Dune_Exception_Base('�� ������ ������ ��� �������');
	    }
	    $where->addAnd();
	    $where->addSimpleField('section_id', 'text_corr')->addCompare()->addSimpleData($this->_section, 'i');
	    
	    $q .= $where->get();
	       
	       
	    $result = $this->_DB->query($q, null, Dune_MysqliSystem::RESULT_EL);
	    return $result;
	}
	

}