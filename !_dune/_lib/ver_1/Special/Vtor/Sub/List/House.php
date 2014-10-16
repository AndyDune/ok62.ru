<?php
/**
 * 
 * Данные об объекте.
 * 
 */
class Special_Vtor_Sub_List_House implements Countable
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
    
    protected $_order = '';
    
    
	public function __construct()
	{
	    $this->_DB = Dune_MysqliSystem::getInstance();
	}

	public function count()
	{
	    return count($this->_array);
	}
	
	public function setComplex($value)
	{
	    $this->_complex = $value;
	}

	public function setToUpdate($value = null)
	{
	    $q = 'UPDATE ?t
	          SET `to_update` = 1
	    ';
  	    return $this->_DB->query($q, array(Special_Vtor_Tables::$houses), Dune_MysqliSystem::RESULT_AR);
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

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $field
	 * @param string $order
	 * @param unknown_type $table
	 * @return Dlib_Text_List
	 */
	public function setOrder($field, $order = 'ASC', $table = 'house')
	{
	    if ($this->_order)
	       $this->_order .= ', ';
	    else 
	       $this->_order = ' ORDER BY ';
	    $this->_order .= '`' . $table . '`.`' . $field . '` ' . $order;
	    return $this;
	}
	

	/**
	 *
	 * @return Dlib_Text_List
	 */
	public function clearOrder()
	{
	    $this->_order = '';
	    return $this;
	}	
	
	
	public function setComplexNo($value = true)
	{
	    $this->_complexNo = $value;
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
	    
	    
        $q = 'SELECT house.*,
        	                 
        	                 region.name     as name_region,
        	                 area.name       as name_area,
        	                 settlement.name as name_settlement,
        	                 settlement.type as type_settlement,
        	                 
        	                 district.name        as name_district,
        	                 district_plus.name   as name_district_plus,
        	                 street.name          as name_street,
        	                 street.adding        as street_adding,
        	                 

        	                 group.gm_x         as complex_gm_x,
        	                 group.gm_y         as complex_gm_y,
        	                 group.name         as complex_name,
        	                 
        	                 
        	                 group.panorama_id    as complex_panorama_id,
        	                 group.have_photo     as complex_have_photo,
        	                 group.have_situa     as complex_have_situa,
        	                 group.have_gen_plan  as complex_have_gen_plan,
        	                 
        	                 
        	                 group.gm_x        as group_gm_x,
        	                 group.gm_y        as group_gm_y,
        	                 group.name        as group_name,
        	                 
        	                 
        	                 group.panorama_id    as group_panorama_id,
        	                 group.have_photo     as group_have_photo,
        	                 group.have_situa     as group_have_situa,
        	                 group.have_gen_plan  as group_have_gen_plan

        	                 
        	          FROM ?t as `house`'; 
        	            $q .= ' LEFT JOIN `' . Special_Vtor_Tables::$group . '` as `group` ON `house`.`complex_id` = `group`.`id`,';
        	            $q .= ' `' . Special_Vtor_Tables::$adressDistrictPlus . '` as `district_plus`,
        	               
        	               ?t as region,
        	               ?t as area,
        	               ?t as settlement,
        	               ?t as district,
        	               ?t as street
';	    
	    
	    
	    
	    
	    
	    $where = new Dune_Mysqli_Collector_Where();
        $where->addSimpleField('street_id', 'house')->addCompare()->addSimpleField('id', 'street')->addAnd();
        $where->addSimpleField('district_id', 'house')->addCompare()->addSimpleField('id', 'district')->addAnd();
        $where->addSimpleField('region_id', 'house')->addCompare()->addSimpleField('id', 'region')->addAnd();
        $where->addSimpleField('area_id', 'house')->addCompare()->addSimpleField('id', 'area')->addAnd();
        $where->addSimpleField('settlement_id', 'house')->addCompare()->addSimpleField('id', 'settlement')->addAnd();
        $where->addSimpleField('district_id_plus', 'house')->addCompare()->addSimpleField('id', 'district_plus');
	    if ($this->_complexNo)
	    {
	        $where->addAnd();
	        $where->addSimpleField('complex_id', 'house')->addCompare()->addSimpleData(0, 'i');
	    }
	    else if ($this->_complex)
	    {
	        $where->addAnd();
	        $where->addSimpleField('complex_id', 'house')->addCompare()->addSimpleData($this->_complex, 'i');
	    }
	    
	    if (!is_null($this->_edinstvo))
	    {
	        $where->addAnd();
	        $where->addSimpleField('edinstvo', 'house')->addCompare()->addSimpleData($this->_edinstvo, 'i');
	    }
	    else if ($this->_user)
	    {
	        $where->addAnd();
	        $where->addSimpleField('user_id', 'house')->addCompare()->addSimpleData($this->_user, 'i');

	    }
	    
	    
	    $q .= $where->get();
   	    $q .= ' ' . $this->_order;

	    $result = $this->_DB->query($q, array(
	                                          Special_Vtor_Tables::$houses,
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
	    
	    
        $q = 'SELECT `house`.*

        	          FROM ?t as `house` '; 
	    
	    
	    $where = new Dune_Mysqli_Collector_Where();
	    if ($this->_complexNo)
	    {
	        $where->addAnd();
	        $where->addSimpleField('complex_id', 'house')->addCompare()->addSimpleData(0, 'i');
	    }
	    else if ($this->_complex)
	    { 
	        $where->addAnd();
	        $where->addSimpleField('complex_id', 'house')->addCompare()->addSimpleData($this->_complex, 'i');
	    }
	    
	    if (!is_null($this->_edinstvo))
	    {
	        $where->addAnd();
	        $where->addSimpleField('edinstvo', 'house')->addCompare()->addSimpleData($this->_edinstvo, 'i');
	    }
	    else if ($this->_user)
	    {
	        $where->addAnd();
	        $where->addSimpleField('user_id', 'house')->addCompare()->addSimpleData($this->_user, 'i');

	    }
	    
	    
	    $q .= $where->get();
	    $result = $this->_DB->query($q, array(
	                                          Special_Vtor_Tables::$houses,
	                                          ), Dune_MysqliSystem::RESULT_IASSOC);
	    if ($result)
	       $this->_array = $result;
	    return $result;
	}	
	
}