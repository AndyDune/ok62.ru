<?php
/**
 * 
 * Список разделов.
 * 
 */
class Special_Vtor_Organization_Sections_Corr extends Dune_Mysqli_Abstract_Connect
{ 
                        
    public static $table = 'unity_organization_sections';
    public static $tableCorr = 'unity_organization_sections_corr';
    
    protected $_organazation = null;
    protected $_order = '';
    
	public function __construct($organazation = null)
	{
        $this->_organazation = $organazation;
	    $this->_initDB();
	}
	
	/**
	 *
	 * @param unknown_type $type
	 */
	public function setOrganagation($value)
	{
	    $this->_organazation = $value;
	    return $this;
	}

    public function getOneFirst()
    {
        if (is_null($this->_organazation))
            return false;
            
	    $q = 'SELECT `sections`.* FROM `' . self::$table . '` as `sections`, `' . self::$tableCorr . '` as `corr`';
        $q .= ' WHERE `sections`.`id` = `corr`.`section_id`';
        $q .= ' AND `corr`.`text_id` = ?i';
	       
	    $q .= ' ' . $this->_order . ' LIMIT 1';
	    $result = $this->_DB->query($q, array($this->_organazation), Dune_MysqliSystem::RESULT_ROWASSOC);
	    return $result;
    }
    
    public function clearCorr()
    {
        if (is_null($this->_organazation))
            return false;
        $q = 'DELETE FROM `' . self::$tableCorr . '` WHERE `text_id` = ?i';
        $result = $this->_DB->query($q, array($this->_organazation), Dune_MysqliSystem::RESULT_AR);
    }

    public function setCorrOne($section)
    {
        if (is_null($this->_organazation))
            return false;
        $q = 'INSERT INTO `' . self::$tableCorr . '` SET `text_id` = ?i, `section_id` = ?i';
        $result = $this->_DB->query($q, array($this->_organazation, $section), Dune_MysqliSystem::RESULT_AR);
    }

    

}