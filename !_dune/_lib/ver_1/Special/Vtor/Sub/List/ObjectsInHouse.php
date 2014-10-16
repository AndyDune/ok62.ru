<?php
/**
 * 
 * Данные об объекте.
 * 
 */
class Special_Vtor_Sub_List_ObjectsInHouse implements Countable
{
    
    
    /**
     * Enter description here...
     *
     * @var Dune_MysqliSystem
     */
    protected $_DB;
    protected $_houseData      = null;
    protected $_type      = null;
    protected $_array      = array();
    
	public function __construct($data, $type)
	{
	    $this->_houseData = $data;
	    $this->_type = $type;
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
	    
        $q = 'SELECT `id`,
                     `room`,
                     `porch`,
                     `price`,
                     `rooms_count`,
                     `space_total`,
                     `space_calculation`,
                     `levels`,
                     `type`,
                     `floor`
                     

              FROM ?t WHERE type = ?i AND activity = 1 AND (`sub_house_id` = ?i ' . 
        ' OR (`street_id` = ?i AND `house_number` = ? AND `building_number` = ?))';

	    $result = $this->_DB->query($q, array(
	                                          Special_Vtor_Tables::$object,
	                                          $this->_type,
   	                                          $this->_houseData['id'],
   	                                          $this->_houseData['street_id'],
   	                                          $this->_houseData['house_number'],
   	                                          $this->_houseData['building_number'],

	                                          ), Dune_MysqliSystem::RESULT_IASSOC);
	                                          
	    if ($result and count($result))
	    {
	       $this->_array = $result;
	    }
	    return $result;
	}
	

	public function getDataForGrid()
	{
	    $resource = $this->getDatas();
	    $result = false;
	    if ($resource)
	    {
	        $result = array();
	        foreach ($resource as $value)
	        {
	            if (!$value['room'])
	               continue;
	            $result[$value['room']] = $value;
	        }
	    }
	    return $result;
	}
}