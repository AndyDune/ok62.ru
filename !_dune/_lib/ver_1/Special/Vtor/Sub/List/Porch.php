<?php
/**
 * 
 * Äàííûå îá îáúåêòå.
 * 
 */
class Special_Vtor_Sub_List_Porch implements Countable
{
    
    
    /**
     * Enter description here...
     *
     * @var Dune_MysqliSystem
     */
    protected $_DB;
    protected $_house      = null;
    protected $_type       = 1;
    protected $_array      = array();
    
	public function __construct($house)
	{
	    $this->_house = $house;
	    $this->_DB = Dune_MysqliSystem::getInstance();
	}

	public function count()
	{
	    return count($this->_array);
	}
	
	public function setHouse($value)
	{
	    $this->_house = $value;
	}

	public function setType($value)
	{
	    $this->_type = $value;
	}
	
	
	public function getIds()
	{
	    $q = 'SELECT `id` FROM ?t ';
	    $where = new Dune_Mysqli_Collector_Where();
	    
	    if ($this->_house)
	    {
	        $where->addSimpleField('complex_id')->addCompare()->addSimpleData($this->_complex, 'i');
	    }
	    
	    
	    $q .= $where->get();
	    $result = $this->_DB->query($q, array(Special_Vtor_Tables::$houses), Dune_MysqliSystem::RESULT_IASSOC);
	    if ($result)
	       $this->_array = $result;
	    return $result;
	}

	public function getDatas()
	{
	    
        $q = 'SELECT * FROM ?t WHERE `house_id` = ?i AND `type_id` = ?i';

	    $result = $this->_DB->query($q, array(
	                                          Special_Vtor_Tables::$gridPorch,
   	                                          $this->_house,
   	                                          $this->_type

	                                          ), Dune_MysqliSystem::RESULT_IASSOC);
	    if ($result)
	       $this->_array = $result;
	    return $result;
	}
	
	
}