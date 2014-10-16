<?php
/**
 * 
 * Список организаций.
 * 
 */
class Special_Vtor_Organization_List extends Dune_Mysqli_Abstract_Connect
{ 
                        
    public static $tableSection = 'unity_organization_sections';
    public static $tableText    = 'unity_organization_text';
    public static $tableCorr    = 'unity_organization_sections_corr';
    
    public static $tableUser   = 'dune_auth_user_active';
    
    protected $_section = null;
    protected $_user = null;
    protected $_FW = array();
    
    
    protected $_parent = null;
    protected $_order = '';
    
	public function __construct($section = null)
	{
        $this->_section = $section;
	    $this->_initDB();
	}
	
	/**
	 *
	 * @param unknown_type $type
	 */
	public function setSection($section)
	{
	    $this->_section = $section;
	    return $this;
	}

	/**
	 *
	 * @param unknown_type $type
	 */
	public function setUser($value)
	{
	    $this->_user = $value;
	    return $this;
	}
	
	
	/**
	 *
	 * @param string $order
	 */
	public function setOrderName($order = 'ASC')
	{
	    $this->_order .= ' ORDER BY `text`.`name` ' . $order;
	    return $this;
	}

	/**
	 *
	 * @param string $order
	 */
	public function setOrder($field, $order = 'ASC')
	{
	    $this->_order .= ' ORDER BY `text`.`' . $field . '` ' . $order;
	    return $this;
	}
	
	/**
	 *
	 * @param string $order
	 */
	public function setOrderOrder($order = 'ASC')
	{
	    $this->_order .= ' ORDER BY `text`.`order` ' . $order;
	    return $this;
	}

	/**
	 *
	 */
	public function clearOrder()
	{
	    $this->_order = '';
	    return $this;
	}
	
	
	public function getList($shift = 0, $limit = 1000)
	{
	    $q = 'SELECT `text`.*, `corr`.`section_id` as `section_id` ';
       
	    $q .= $this->_collectFromAndWhere(true);
	    
	    $q .= ' GROUP BY `text`.`id`';
	    $q .= ' ' . $this->_order . ' LIMIT ' . (int)$shift . ', ' . (int)$limit;
	    $result = $this->_DB->query($q, null, Dune_MysqliSystem::RESULT_IASSOC);
	    return $result;
	}
	
	protected function _collectFromAndWhere($corr = false)
	{
	    if (is_null($this->_section))
	    {
	        $key = 'no';
	    }
	    else 
	       $key = $this->_section;
	       
	    if (key_exists($key, $this->_FW))
	    {
	        $result = $this->_FW[$key];
	    }
	    else 
	    {
    	    $from = new Dune_Mysqli_Collector_From();
    	    $from->addTable(self::$tableText, 'text');
    	    $where = new Dune_Mysqli_Collector_Where($this->_DB);
    	    
    	    $from->addJoinLeft(self::$tableUser, 'user');
    	    $from->addJoinConditionOn('id', 'user_id', 'text');

    	    
    	    if (!is_null($this->_section))
    	    {
    	        $from->addTable(self::$tableCorr, 'corr');    	        
    	    }
    	    else
    	    {
    	        $from->addJoinLeft(self::$tableCorr, 'corr');
    	        $from->addJoinConditionOn('text_id', 'id', 'text');
    	    }
    	    
    	    if (!is_null($this->_section))
    	    {
    	        $sections = new Special_Vtor_Organization_Children_List($this->_section);
    	        $str = $sections->getIdArray(true);
    	        
//    	        $from->addTable(self::$tableCorr, 'corr');
    	        
    	        $where->addAnd();
    	        $where->addSimpleField('id', 'text')->addCompare()->addSimpleField('text_id', 'corr');
    	        $where->addAnd();
                $where->addOneWholly('`corr`.`section_id` IN ('. $str . ')');
    	    }
    	    if (!is_null($this->_user))
    	    {
    	        $where->addAnd();
    	        $where->addSimpleField('user_id', 'text')->addCompare()->addSimpleData($this->_user, 'i');
    	        
    	    }    	    
    	    
    	    $result = $from->get(true) . $where->get();
    	    $this->_FW[$key] = $result;
	     }
	    return $result;
	}

	public function getCout()
	{
	    $q = 'SELECT count(DISTINCT(`text`.`id`))';
	    
	    $q .= $this->_collectFromAndWhere();
	    
//	    $q .= ' GROUP BY `text`.`id`';
	    
	    $result = $this->_DB->query($q, null, Dune_MysqliSystem::RESULT_EL);
	    return $result;
	}
	

}