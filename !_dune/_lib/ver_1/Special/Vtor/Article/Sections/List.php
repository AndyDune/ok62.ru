<?php
/**
 * 
 * Список разделов.
 * 
 */
class Special_Vtor_Article_Sections_List extends Dune_Mysqli_Abstract_Connect
{ 
                        
    public static $table = 'unity_article_sections';
    
    protected $_type = null;
    
	public function __construct($type = null)
	{
	    if (!is_null($type))
	       $this->_type = $type;
	    $this->_initDB();
	}
	
	/**
	 * Устновка типа раздела.
	 * 0 - для статей.
	 * 1 - для новостей.
	 *
	 * @param unknown_type $type
	 */
	public function setType($type)
	{
	    $this->_type = $type;
	    return $this;
	}
	
	public function getList()
	{
	    $q = 'SELECT * FROM `' . self::$table . '`';
	    if (!is_null($this->_type))
	       $q .= ' WHERE type = ' . (int)$this->_type;
	    $result = $this->_DB->query($q, null, Dune_MysqliSystem::RESULT_IASSOC);
	    return $result;
	}

	public function getCout()
	{
	    $q = 'SELECT count(*) FROM `' . self::$table . '`';
	    if (!is_null($this->_type))
	       $q .= ' WHERE type = ' . (int)$this->_type;
	    $result = $this->_DB->query($q, null, Dune_MysqliSystem::RESULT_EL);
	    return $result;
	}
	

}