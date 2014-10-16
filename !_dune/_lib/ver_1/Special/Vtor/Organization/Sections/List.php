<?php
/**
 * 
 * Список разделов.
 * 
 */
class Special_Vtor_Organization_Sections_List extends Dune_Mysqli_Abstract_Connect
{ 
                        
    public static $table = 'unity_organization_sections';
    
    protected $_parent = null;
    protected $_order = '';
    
	public function __construct($parent = null)
	{
        $this->_parent = $parent;
	    $this->_initDB();
	}
	
	/**
	 * Устновка типа раздела.
	 * 0 - для статей.
	 * 1 - для новостей.
	 *
	 * @param unknown_type $type
	 */
	public function setParent($parent)
	{
	    $this->_parent = $parent;
	    return $this;
	}

	/**
	 *
	 * @param string $order
	 */
	public function setOrderName($order = 'ASC')
	{
	    $this->_order .= ' ORDER BY `name` ' . $order;
	    return $this;
	}
	
	/**
	 *
	 * @param string $order
	 */
	public function setOrderOrder($order = 'ASC')
	{
	    $this->_order .= ' ORDER BY `order` ' . $order;
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
	    $q = 'SELECT * FROM `' . self::$table . '`';
	    if (!is_null($this->_parent))
	       $q .= ' WHERE parent = ' . (int)$this->_parent;
	       
	    $q .= ' ' . $this->_order . ' LIMIT ' . (int)$shift . ', ' . (int)$limit;
	    $result = $this->_DB->query($q, null, Dune_MysqliSystem::RESULT_IASSOC);
	    return $result;
	}

	public function getCout()
	{
	    $q = 'SELECT count(*) FROM `' . self::$table . '`';
	    if (!is_null($this->_parent))
	       $q .= ' WHERE parent = ' . (int)$this->_parent;
	    $result = $this->_DB->query($q, null, Dune_MysqliSystem::RESULT_EL);
	    return $result;
	}
	

}