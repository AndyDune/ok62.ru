<?php
/**
 * 
 * Список разделов.
 * 
 */
class Special_Vtor_Organization_Parents_List extends Dune_Mysqli_Abstract_Connect
{ 
                        
    public static $tableSection = 'unity_organization_sections';
    public static $tableText = 'unity_organization_text';
    public static $tableCorr = 'unity_organization_sections_corr';
    
    protected $_section = null;
    
    
    protected $_array = array();
    protected $_maxIter = 10;
    protected $_currentIter = 0;
    
	public function __construct($section = null)
	{
        $this->_section = $section;
	    $this->_initDB();
	}
	
	/**
	 * Устновка типа раздела.
	 * 0 - для статей.
	 * 1 - для новостей.
	 *
	 * @param unknown_type $type
	 */
	public function setSection($section)
	{
	    $this->_section = $section;
	    return $this;
	}

	/**
	 * @param string $type
	 */
	public function setSectionCode($section_code)
	{
	    $q = 'SELECT * FROM `' . self::$tableSection . '` WHERE `name_code` LIKE ?';
	    $result = $this->_DB->query($q, array($section_code), Dune_MysqliSystem::RESULT_ROWASSOC);
	    if ($result)
	    {
	        $this->_section = $result['id'];
	        return true;
	    }
	    return false;
	}
	
	
	public function getIdArray()
	{
	    $this->_currentIter = 0;
	    $this->_array = array();
	    $this->_checkSection();
	    $this->_getIdArray($this->_section);
	    return $this->_array;
	}

	public function _getIdArray($id)
	{
	    $this->_currentIter++;
	    $q = 'SELECT `parent` FROM `' . self::$tableSection . '` WHERE id = ?i';
	    $result = $this->_DB->query($q, array($id), Dune_MysqliSystem::RESULT_EL);
	    if ($result and $this->_currentIter < $this->_maxIter)
	    {
	        $this->_array[] = $result;
	        $this->_getIdArray($result);
	    }
	    return true;
	}

	public function getDataArray($sort_from_top = false)
	{
	    $this->_currentIter = 0;
	    $this->_array = array();
	    $this->_checkSection();
	    $this->_getDataArray($this->_section);
	    if ($sort_from_top)
	       krsort($this->_array);
	    return $this->_array;
	}

	public function getLink()
	{
	    $this->_currentIter = 0;
	    $this->_array = array();
	    $this->_checkSection();
	    $this->_getDataArray($this->_section);
	    $str = '';
	    $array = $this->_array;
	    krsort($array);
	    foreach ($array as $value)
	    {
	        if ($str)
	           $str .= '/';
	        $str .= $value['name_code'];
	    }
	    return $str;
	}
	
	
	public function _getDataArray($id)
	{
	    $this->_currentIter++;
	    $q = 'SELECT * FROM `' . self::$tableSection . '` WHERE id = ?i';
	    $result = $this->_DB->query($q, array($id), Dune_MysqliSystem::RESULT_ROWASSOC);
	    if ($result)
	    {
	       $this->_array[] = $result;
	    }
	    if ($result and $result['parent'] and $this->_currentIter < $this->_maxIter)
	    {
	        $this->_getDataArray($result['parent']);
	    }
	    return true;
	}
	
	
	public function getCout()
	{
	    $q = 'SELECT count(*) FROM `' . self::$table . '`';
	    if (!is_null($this->_parent))
	       $q .= ' WHERE parent = ' . (int)$this->_parent;
	    $result = $this->_DB->query($q, null, Dune_MysqliSystem::RESULT_EL);
	    return $result;
	}
	
	
	protected function _checkSection()
	{
	    if (is_null($this->_section))
	       throw new Dune_Exception_Base('Не указан ID раздела для которого ищем родителей.');
	}

}