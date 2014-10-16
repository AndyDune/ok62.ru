<?php
/**
 * 
 * Контейнер адреса..
 * 
 */
class Special_Vtor_Adress
{
    
    protected $_districtPlus = false;
    protected $DB = null;
    protected $_adressArrayNoHave = true;
    protected $_adressArray =  array(
                                        'region'        => 1,
                                        'area'          => 0,
                                        'settlement'    => 0,
                                        'district'      => 0,
                                        'street'        => 0,
                                        'house'         => 0,
                                        
                                        'group'         => 0,
                                        
                                        'building'      => '',
                                        
                                        'settlement_name'    => '',
                                        'street_name'        => ''
                                    );
    

    protected $_adressArrayNames =  array(
                                        'region'        => '',
                                        'area'          => '',
                                        'settlement'    => '',
                                        'district'      => '',
                                        'street'        => ''
                                    );
                                    
    public static $tableObject          = 'unity_catalogue_object';
                                        
    public static $tableAdressRegion       = 'unity_catalogue_adress_region';
    public static $tableAdressArea         = 'unity_catalogue_adress_area';
    public static $tableAdressSettlement   = 'unity_catalogue_adress_settlement';
    public static $tableAdressDistrict     = 'unity_catalogue_adress_district';
    public static $tableAdressDistrictPlus = 'unity_catalogue_adress_district_plus';
    public static $tableAdressStreet       = 'unity_catalogue_adress_street';
    
    
    protected $_settlementType = null;
    
	public function __construct($array = array(), $array_names = array())
	{
	    if (count($array))
	    {
	        foreach ($array as $key => $value)
	        {
	            if (isset($this->_adressArray[$key]))
	               $this->_adressArray[$key] = $value;
	            else
	               throw new Dune_Exception_Base('В массиве адресов неразрешённый параметр: ' . $key);
	        }
	        $this->_adressArrayNoHave = false;
	    }
	    if (count($array_names))
	    {
	        foreach ($array as $key => $value)
	        {
	            if (isset($this->_adressArrayNames[$key]))
	               $this->_adressArrayNames[$key] = $value;
	            else
	               throw new Dune_Exception_Base('В массиве имен адресов неразрешённый параметр: ' . $key);
	        }
	    }

	}

	
	public function getCacheTag()
	{
	    return   $this->_adressArray['region']
	           . $this->_adressArray['area']
	           . $this->_adressArray['settlement']
	           . $this->_adressArray['district']
	           . $this->_adressArray['street']
	           . (int)$this->_adressArray['house']
	           . (int)$this->_adressArray['building']
               . (int)$this->_adressArray['group']
               . (string)$this->_districtPlus
	           ;
	}
	
//////////////////////////////////////////////////////////	
/////  Работа с областью
	public function setRegion($id, $name = '')
	{
	    $this->_adressArray['region'] = $id;
	    $this->_adressArrayNames['region'] = $name;
	}
	public function getRegionId()
	{
	    return $this->_adressArray['region'];
	}
	
	public function getRegionName()
	{
	    if ($this->_adressArrayNames['region'])
	    {
	        return $this->_adressArrayNames['region'];
	    }
	    else if ($this->_adressArray['region']) 
	    {
	        // Запрос в базу за именем
	        $db = $this->getDB();
	        $q = 'SELECT name FROM ?t WHERE id = ?i';
	        return $this->_adressArrayNames['region'] = $db->query($q, 
	                                                        array(
	                                                               self::$tableAdressRegion,
	                                                               $this->_adressArray['region']
	                                                              ),
	                                                        Dune_MysqliSystem::RESULT_EL);
	    }
	    else 
	       return false;
	}
/////
//////////////////////////////////////////////////////////	


//////////////////////////////////////////////////////////	
/////  Работа с районом
	public function setArea($id, $name = '')
	{
	    $this->_adressArray['area'] = $id;
	    $this->_adressArrayNames['area'] = $name;
	    return $this;
	}
	public function getAreaId()
	{
	    return $this->_adressArray['area'];
	}
	public function getAreaName()
	{
	    if ($this->_adressArrayNames['area'])
	    {
	        return $this->_adressArrayNames['area'];
	    }
	    else if ($this->_adressArray['area']) 
	    {
	        // Запрос в базу за именем
	        $db = $this->getDB();
	        $q = 'SELECT name FROM ?t WHERE id = ?i';
	        return $this->_adressArrayNames['area'] = $db->query($q, 
	                                                        array(
	                                                               self::$tableAdressArea,
	                                                               $this->_adressArray['area']
	                                                              ),
	                                                        Dune_MysqliSystem::RESULT_EL);
	    }
	    else 
	       return false;
	}
/////
//////////////////////////////////////////////////////////	


//////////////////////////////////////////////////////////	
/////  Работа с поселком
	public function setSettlement($id = 0, $name = '')
	{
	    $this->_adressArray['settlement'] = $id;
	    $this->_adressArrayNames['settlement'] = $name;
  	    if (!$this->_adressArray['settlement_name'])
	       $this->_adressArray['settlement_name'] = $name;
	    return $this;
	    
	}
	public function getSettlementId()
	{
	    return $this->_adressArray['settlement'];
	}
	
	public function getSettlementName()
	{
	    if ($this->_adressArrayNames['settlement'])
	    {
	        return $this->_adressArrayNames['settlement'];
	    }
	    else if ($this->_adressArray['settlement']) 
	    {
	        // Запрос в базу за именем
	        $db = $this->getDB();
	        $q = 'SELECT name,type FROM ?t WHERE id = ?i';
	        $result = $db->query($q, 
	                                                        array(
	                                                               self::$tableAdressSettlement,
	                                                               $this->_adressArray['settlement']
	                                                              ),
	                                                        Dune_MysqliSystem::RESULT_ROWASSOC);
            $this->_settlementType = $result['type'];
	        return $this->_adressArrayNames['settlement'] = $result['name'];
	                                                        
	    }
	    else 
	       return $this->_adressArray['settlement_name'];
	}
	
	public function getSettlementType()
	{
	    if (is_null($this->_settlementType))
	    {
	        $this->getSettlementName();
	    }
	    return $this->_settlementType;
	}
	
/////
//////////////////////////////////////////////////////////	

//////////////////////////////////////////////////////////	
/////  Работа с районом города

	public function setDistrictPlus($value = true)
	{
	    $this->_districtPlus = $value;
	    return $this;
	}
	public function getDistrictPlus()
	{
	    return $this->_districtPlus;
	}


	public function setDistrict($id, $name = '')
	{
	    $this->_adressArray['district'] = $id;
	    $this->_adressArrayNames['district'] = $name;
	    return $this;
	}
	
	public function getDistrictId()
	{
	    return $this->_adressArray['district'];
	}
	public function getDistrictName()
	{
	    if ($this->_adressArrayNames['district'])
	    {
	        return $this->_adressArrayNames['district'];
	    }
	    else if ($this->_adressArray['district']) 
	    {
	        if ($this->_districtPlus)
	           $table = self::$tableAdressDistrictPlus;
	        else 
	           $table = self::$tableAdressDistrict;

	        // Запрос в базу за именем
//	        echo $this->_adressArray['district']; die();
	        $db = $this->getDB();
	        $q = 'SELECT name FROM ?t WHERE id = ?i';
	        return $this->_adressArrayNames['district'] = $db->query($q, 
	                                                        array(
	                                                               $table,
	                                                               $this->_adressArray['district']
	                                                              ),
	                                                        Dune_MysqliSystem::RESULT_EL);
	    }
	    else 
	       return false;
	}
/////
//////////////////////////////////////////////////////////	



//////////////////////////////////////////////////////////	
/////  Работа с улицей города
	public function setStreet($id = 0, $name = '')
	{
	    $this->_adressArray['street'] = $id;
	    $this->_adressArrayNames['street'] = $name;
	    if (!$this->_adressArray['street_name'])
	       $this->_adressArray['street_name'] = $name;
	    return $this;
	}
	public function getStreetId()
	{
	    return $this->_adressArray['street'];
	}
	public function getStreetName()
	{
	    if ($this->_adressArrayNames['street'])
	    {
	        return $this->_adressArrayNames['street'];
	    }
	    else if ($this->_adressArray['street']) 
	    {
	        // Запрос в базу за именем
	        $db = $this->getDB();
	        $q = 'SELECT name FROM ?t WHERE id = ?i';
	        return $this->_adressArrayNames['street'] = $db->query($q, 
	                                                        array(
	                                                               self::$tableAdressStreet,
	                                                               $this->_adressArray['street']
	                                                              ),
	                                                        Dune_MysqliSystem::RESULT_EL);
	    }
	    else 
	       return $this->_adressArray['street_name'];
	}
/////
//////////////////////////////////////////////////////////	



//////////////////////////////////////////////////////////	
/////  Работа с номером дома
	public function setHouse($number)
	{
	    $this->_adressArray['house'] = $number;
	    return $this;
	}
	public function getHouse()
	{
	    return $this->_adressArray['house'];
	}
/////
//////////////////////////////////////////////////////////	


//////////////////////////////////////////////////////////	
/////  Работа с группой
	public function setGroup($number)
	{
	    $this->_adressArray['group'] = (int)$number;
	    return $this;
	}
	public function getGroup()
	{
	    return $this->_adressArray['group'];
	}
/////
//////////////////////////////////////////////////////////	



//////////////////////////////////////////////////////////	
/////  Работа с номером дома
	public function setBuilding($number)
	{
	    $this->_adressArray['building'] = $number;
	    return $this;
	}
	public function getBuilding()
	{
	    return $this->_adressArray['building'];
	}
/////
//////////////////////////////////////////////////////////	


    public function getSetQuery($tableAlias = null)
    {
        if (is_null($tableAlias))
            $tableAlias = self::$tableObject;
        $db = $this->getDB();
        $q = ' ' . $tableAlias . '.`region` = '      . (int)$this->_adressArray['region']
           . ', ' . $tableAlias . '.`area` = '       . (int)$this->_adressArray['area']
           . ', ' . $tableAlias . '.`settlement` = ' . (int)$this->_adressArray['settlement']
           . ', ' . $tableAlias . '.`district` = '   . (int)$this->_adressArray['district']
           . ', ' . $tableAlias . '.`street` = '     . (int)$this->_adressArray['street']
           . ', ' . $tableAlias . '.`house` = '      . (int)$this->_adressArray['house']
           . ', ' . $tableAlias . '.`building` = "'   . $db->real_escape_string($this->_adressArray['building']) . '"';
           
        if ($this->_adressArray['settlement_name'])
            $q .= ', ' . $table . '.`settlement_name` = "'   . $db->real_escape_string($this->_adressArray['settlement_name']) . '"';
        if ($this->_adressArray['street_name'])
            $q .= ', ' . $table . '.`street_name` = "'   . $db->real_escape_string($this->_adressArray['street_name']) . '"';
         
         return $q;
    }
	
////////////////////////////////////////////////////////////////
///////////////////////////////     Магические методы
    public function __set($name, $value)
    {
        if (isset($this->_adressArray[$name]))
            $this->_adressArray[$name] = $value;
        else 
            throw new Dune_Exception_Base('Установка несуществующего ключа в масссив адресов');
    }
    public function __get($name)
    {
       if (isset($this->_adressArray[$name]))
            return $this->_adressArray[$name];
        else 
            throw new Dune_Exception_Base('Нед данных для вывода.');
    }
    public function __toString()
    {
    	$string = '<pre>';
    	ob_start();
    	print_r($this->_adressArray);
    	$string .= ob_get_clean();
    	return  $string . '</pre>';
    }
/////////////////////////////
////////////////////////////////////////////////////////////////

    /**
     * Enter description here...
     *
     * @return Dune_MysqliSystem
     */
    protected function getDB()
    {
        if (is_null($this->DB))
            $this->DB = Dune_MysqliSystem::getInstance();
        return $this->DB;
    }
}