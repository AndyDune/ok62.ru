<?php
/**
 * 
 * Данные об объекте.
 * 
 */
class Special_Vtor_Sub_List_Complex implements Countable
{
    
    
    /**
     * Enter description here...
     *
     * @var Dune_MysqliSystem
     */
    protected $_DB;
    protected $_complex    = null;
    protected $_edinstvo   = null;
    protected $_user       = 0;
    protected $_array     = array();
    protected $_complexNo = false;
    
	public function __construct()
	{
	    $this->_DB = Dune_MysqliSystem::getInstance();
	}

	public function count()
	{
	    return count($this->_array);
	}
	
	public function setToUpdate($value = null)
	{
	    $q = 'UPDATE ?t
	          SET `to_update` = 1
	    ';
  	    return $this->_DB->query($q, array(Special_Vtor_Tables::$group), Dune_MysqliSystem::RESULT_AR);
	}
	
	
	/**
	 * Поле Единства.
	 *
	 * @param mixed $value использовать: 1 - единство, 0 - не единство, null - не учитывать флаг единства
	 */
	public function setEdinstvo($value = 1)
	{
	    $this->_edinstvo = $value;
	}

	/**
	 * Поле пользователь.
	 *
	 * @param integer $value
	 */
	public function setUser($value = 0)
	{
	    $this->_user = $value;
	}
	
	
	public function getIds()
	{
	    $q = 'SELECT `id` FROM ?t ';
	    $where = new Dune_Mysqli_Collector_Where();
	    if ($this->_complexNo)
	    {
	        $where->addSimpleField('complex_id')->addCompare()->addSimpleData(0, 'i');
	    }
	    else if ($this->_complex)
	    {
	        $where->addSimpleField('complex_id')->addCompare()->addSimpleData($this->_complex, 'i');
	    }
	    
	    if (!is_null($this->_edinstvo))
	    {
	        $where->addAnd();
	        $where->addSimpleField('edinstvo')->addCompare()->addSimpleData($this->_edinstvo, 'i');
	    }
	    else if (!$this->_user)
	    {
	        $where->addAnd();
	        $where->addSimpleField('user_id')->addCompare()->addSimpleData($this->_user, 'i');
	    }
	    
	    
	    $q .= $where->get();
	    $result = $this->_DB->query($q, array(Special_Vtor_Tables::$houses), Dune_MysqliSystem::RESULT_IASSOC);
	    if ($result)
	       $this->_array = $result;
	    return $result;
	}

	public function getDatas()
	{
	    
        $q = 'SELECT complex.*,
        	                 
        	                 region.name     as name_region,
        	                 area.name       as name_area,
        	                 settlement.name as name_settlement,
        	                 settlement.type as type_settlement,
        	                 
        	                 district.name        as name_district,
        	                 district_plus.name   as name_district_plus,
        	                 street.name          as name_street,
        	                 street.adding        as street_adding

        	                 
        	          FROM ?t as `complex`, '; 
        	            $q .= ' `' . Special_Vtor_Tables::$adressDistrictPlus . '` as `district_plus`,
        	               
        	               ?t as region,
        	               ?t as area,
        	               ?t as settlement,
        	               ?t as district,
        	               ?t as street
';	    
	    
	    
	    
	    $where = new Dune_Mysqli_Collector_Where();
        $where->addSimpleField('street_id', 'complex')->addCompare()->addSimpleField('id', 'street')->addAnd();
        $where->addSimpleField('district_id', 'complex')->addCompare()->addSimpleField('id', 'district')->addAnd();
        $where->addSimpleField('region_id', 'complex')->addCompare()->addSimpleField('id', 'region')->addAnd();
        $where->addSimpleField('area_id', 'complex')->addCompare()->addSimpleField('id', 'area')->addAnd();
        $where->addSimpleField('settlement_id', 'complex')->addCompare()->addSimpleField('id', 'settlement')->addAnd();
        $where->addSimpleField('district_plus_id', 'complex')->addCompare()->addSimpleField('id', 'district_plus');
	    
	    if (!is_null($this->_edinstvo))
	    {
	        $where->addAnd();
	        $where->addSimpleField('edinstvo', 'complex')->addCompare()->addSimpleData($this->_edinstvo, 'i');
	    }
	    else if ($this->_user)
	    {
	        $where->addAnd();
	        $where->addSimpleField('user_id', 'complex')->addCompare()->addSimpleData($this->_user, 'i');

	    }
	    
	    
	    $q .= $where->get();
	    
	    $q .= ' ORDER BY `complex`.`order`';
	    $result = $this->_DB->query($q, array(
	                                          Special_Vtor_Tables::$group,
   	                                          Special_Vtor_Tables::$adressRegion,
   	                                          Special_Vtor_Tables::$adressArea,
   	                                          Special_Vtor_Tables::$adressSettlement,
   	                                          Special_Vtor_Tables::$adressDistrict,
   	                                          Special_Vtor_Tables::$adressStreet,

	                                          ), Dune_MysqliSystem::RESULT_IASSOC);
	    if ($result)
	       $this->_array = $result;
	    return $result;
	}

	public function getDataStatistic()
	{
	    
        $q = 'SELECT complex.*
        	          FROM ?t as `complex` '; 
	    
	    
	    $where = new Dune_Mysqli_Collector_Where();
	    
	    if (!is_null($this->_edinstvo))
	    {
	        $where->addAnd();
	        $where->addSimpleField('edinstvo', 'complex')->addCompare()->addSimpleData($this->_edinstvo, 'i');
	    }
	    else if ($this->_user)
	    {
	        $where->addAnd();
	        $where->addSimpleField('user_id', 'complex')->addCompare()->addSimpleData($this->_user, 'i');

	    }
	    
	    
	    $q .= $where->get();
	    $q .= ' ORDER BY `complex`.`order`';
	    $result = $this->_DB->query($q, array(
	                                          Special_Vtor_Tables::$group
	                                          ), Dune_MysqliSystem::RESULT_IASSOC);
	    if ($result)
	       $this->_array = $result;
	    return $result;
	}	
	
	
	
}