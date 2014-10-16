<?php
/**
 * 
 * Список разделов.
 * 
 */
class Special_Vtor_Article_Text_ListSectionsCorr extends Dune_Mysqli_Abstract_Connect
{ 
    public static $table = 'unity_article_sections_corr';
    
    protected $_type = null;
    protected $_section = null;
    protected $_text = null;
    
	public function __construct($type = null)
	{
	    if (!is_null($type))
	       $this->_type = $type;
	    $this->_initDB();
	}

	/**
	 * Устновка раздела.
	 *
	 * @param unknown_type $type
	 */
	public function setSection($value)
	{
	    $this->_section = $value;
	    return $this;
	}

	/**
	 * Устновка статьи или новости.
	 *
	 * @param unknown_type $type
	 */
	public function setText($value)
	{
	    $this->_text = $value;
	    return $this;
	}
	
	
	public function getListText($shift = 0, $limit = 100)
	{
	    $q = 'SELECT * FROM `' . self::$table . '`';
	    
//	    if (!is_null($this->_type))
//	       $q .= ' WHERE type = ' . (int)$this->_type;
	       
	    $where = new Dune_Mysqli_Collector_Where();
	    if (!is_null($this->_section))
	    {
	        $where->addAnd();
	        $where->addSimpleField('section_id')->addCompare()->addSimpleData($this->_section, 'i');
	    }
	    
	    $q .= $where->get();
	    $result = $this->_DB->query($q, null, Dune_MysqliSystem::RESULT_IASSOC);
	    return $result;
	}

	public function getCoutText()
	{
	    $q = 'SELECT count(*) FROM `' . self::$table . '`';
	    
	    $where = new Dune_Mysqli_Collector_Where();
	    if (!is_null($this->_section))
	    {
	        $where->addAnd();
	        $where->addSimpleField('section_id')->addCompare()->addSimpleData($this->_section, 'i');
	    }
	    
	    $q .= $where->get();
	       
//	    echo $q; die();
	       
	    $result = $this->_DB->query($q, null, Dune_MysqliSystem::RESULT_EL);
	    return $result;
	}

	
	public function getListSection($shift = 0, $limit = 100)
	{
	    $q = 'SELECT * FROM `' . self::$table . '`';
	    
	    $where = new Dune_Mysqli_Collector_Where();
	    if (!is_null($this->_text))
	    {
	        $where->addAnd();
	        $where->addSimpleField('article_id')->addCompare()->addSimpleData($this->_text, 'i');
	    }
	    
	    $q .= $where->get();
	    $result = $this->_DB->query($q, null, Dune_MysqliSystem::RESULT_IASSOC);
	    return $result;
	}

	public function getCoutSection()
	{
	    $q = 'SELECT count(*) FROM `' . self::$table . '`';
	    
	    $where = new Dune_Mysqli_Collector_Where();
	    if (!is_null($this->_text))
	    {
	        $where->addAnd();
	        $where->addSimpleField('article_id')->addCompare()->addSimpleData($this->_text, 'i');
	    }
	    
	    $q .= $where->get();
	       
//	    echo $q; die();
	       
	    $result = $this->_DB->query($q, null, Dune_MysqliSystem::RESULT_EL);
	    return $result;
	}
	

}