<?php
/**
 * 
 * Список разделов.
 * 
 */
class Special_Vtor_Organization_Children_List extends Dune_Mysqli_Abstract_Connect
{ 
                        
    public static $tableSection = 'unity_organization_sections';
    public static $tableText    = 'unity_organization_text';
    public static $tableCorr    = 'unity_organization_sections_corr';
    
    protected $_section = null;
    
    protected $_haveTexts = false;
    
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

	public function setHaveTexts($value = true)
	{
	    $this->_haveTexts = $value;
	    return $this;
	}

	
	public function getIdArray($string = false)
	{
	    $this->_currentIter = 0;
	    $this->_array = array();
	    $this->_checkSection();
	    $this->_getIdArray($this->_section);
	    if ($string)
	    {
	       $result =  $this->_section;
           if (count($this->_array))
	           $result .= ',' . implode(',', $this->_array);
	       return $result;
	    }
	    return $this->_array;
	}

	public function _getIdArray($id)
	{
	    $this->_currentIter++;
	    $q = 'SELECT * FROM `' . self::$tableSection . '` WHERE parent = ?i';
	    $result = $this->_DB->query($q, array($id), Dune_MysqliSystem::RESULT_IASSOC);
	    if ($result)
	    {
	        foreach ($result as $value)
	        {
	            if (!in_array($value['id'], $this->_array))
	            {
	               $this->_array[] = $value['id'];
	               if ($value['count_children'])
	                   $this->_getIdArray($value['id']);
	            }
	        }
	    }
	    return true;
	}

	public function getDataArray()
	{
	    $this->_currentIter = 0;
	    $this->_array = array();
	    $this->_checkSection();
	    $q = 'SELECT * FROM `' . self::$tableSection . '` WHERE parent = ?i';
	    if ($this->_haveTexts)
	       $q .= ' AND count_text > 0';
	    $result = $this->_DB->query($q, array($this->_section), Dune_MysqliSystem::RESULT_IASSOC);
	    return $result;
	}
	
	public function getCount($id = null)
	{
	    if (is_null($id))
	    {
	       $this->_checkSection();
	       $id = $this->_section;
	    }
	    $q = 'SELECT count(`id`) FROM `' . self::$tableSection . '` WHERE parent = ?i';
	    if ($this->_haveTexts)
	       $q .= ' AND count_text > 0';
	    
	    $result = $this->_DB->query($q, array($id), Dune_MysqliSystem::RESULT_EL);
	    return $result;
	}
	
	public function refreshCountChildren()
	{
	    $q = 'SELECT * FROM `' . self::$tableSection . '`';
	    $result = $this->_DB->query($q, null, Dune_MysqliSystem::RESULT_IASSOC);
	    if ($result)
	    {
	        foreach ($result as $value)
	        {
	            $count = $this->getCount($value['id']);
        	    $q = 'UPDATE `' . self::$tableSection . '` SET count_children = ?i WHERE id = ?i LIMIT 1';
	            $this->_DB->query($q, array($count, $value['id']), Dune_MysqliSystem::RESULT_AR);
	        }
	    }
	}

	public function refreshCountText()
	{
	    $q = 'SELECT * FROM `' . self::$tableSection . '`';
	    $result = $this->_DB->query($q, null, Dune_MysqliSystem::RESULT_IASSOC);
	    $texts = new Special_Vtor_Organization_List();
	    if ($result)
	    {
	        foreach ($result as $value)
	        {
//	            $count = $this->getCount($value['id']);
	            $texts->setSection($value['id']);
	            $count = $texts->getCout();
        	    $q = 'UPDATE `' . self::$tableSection . '` SET count_text = ?i WHERE id = ?i LIMIT 1';
	            $this->_DB->query($q, array($count, $value['id']), Dune_MysqliSystem::RESULT_AR);
	        }
	    }
	}
	
	
	protected function _checkSection()
	{
	    if (is_null($this->_section))
	       throw new Dune_Exception_Base('Не указан ID раздела для которого ищем родителей.');
	}

}