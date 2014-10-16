<?php
/**
 * 
 * !!! Есть изменения от 2009-04-03 учет таблицы пользователей всегда. малопроверен. - проверен
 * 
 * Список данных об объекте.
 * 
 */
class Special_Vtor_Object_List
{
    /**
     * Enter description here...
     *
     * @var Dune_MysqliSystem
     */
    protected $DB;
    
    protected $_districtPlus = 0;
    
    protected $_activity = null;
    protected $_type = null;
    protected $_id;
    protected $_seller = array();
    
    protected $_sellerException = array();
    
    protected $_data = false;
    protected $_adressArray = array(
                                        'region_id'        => 1,
                                        'area_id'          => null,
                                        'settlement_id'    => null,
                                        'district_id'      => null,
                                        'street_id'        => null,
                                        'house_number'     => null,
                                        'building_number'  => null
                                    );
    
    protected $_orderString = '';
                        
    public static $tableObject          = 'unity_catalogue_object';
    public static $tableObjectType      = 'unity_catalogue_object_type';
    public static $tableObjectTypeAdd   = 'unity_catalogue_object_type_add';
    
    public static $tableObjectGroups   = 'unity_catalogue_object_groups';    
    
    public static $tableAdressRegion       = 'unity_catalogue_adress_region';
    public static $tableAdressArea         = 'unity_catalogue_adress_area';
    public static $tableAdressSettlement   = 'unity_catalogue_adress_settlement';
    public static $tableAdressDistrict     = 'unity_catalogue_adress_district';
    public static $tableAdressDistrictPlus     = 'unity_catalogue_adress_district_plus';
    public static $tableAdressStreet       = 'unity_catalogue_adress_street';
    
    
    public static $tableUser       = 'dune_auth_user_active';
    public static $tableUserTime   = 'dune_auth_user_time';
    
    
    public static $tableAdressHouse       = 'unity_catalogue_adress_house';
    public static $tableAdressComplex     = 'unity_catalogue_adress_complex';
    
    
    public static $user = 0;
    public static $edinstvo = false;
    public static $showWitoutHouseNumber = false;
    
    
    protected $_noRyazan = false;
    
    protected $_timeInterval = null;
    
    protected $_adressStreet = array();
    
    protected $_groupInList = false;
    
    protected $_userOnline = false;
    protected $_showWitoutHouseNumber = false;
    protected $_fSeller = false;
    protected $_edinstvo = false;
    
    protected $_adressFull = false;
    
    protected $_houseAndComplex = true;
    
    protected $_whereStringSpecial = '';
    
    
    protected $_payMust = null;
    
    
    protected $_districtPlusNo = null;
    
    /**
     * Идентификатор дома. Поле в таблице sub_house_id
     *
     * @var integer
     */
    protected $_houseId = null;
    
	public function __construct($id = null)
	{
	    $this->_id = $id;
	    $this->DB = Dune_MysqliSystem::getInstance();
	}
	
	
	public function setGetHouseAndComplexInfo($value = true)
	{
	    $this->_houseAndComplex = $value;
	}
	
	public function getWhereStringSpecial()
	{
	    return $this->_whereStringSpecial;
	}
	public function isUseTableUser()
	{
	    return $this->_fSeller;
	}
	public function isUseTableUserTime()
	{
	    return $this->_userOnline;
	}
	
	public function setUserOnline($value = true)
	{
	    $this->_userOnline = $value;
	    return $this;
	}
	
	/**
	 * Установка флага необходимости платежа
	 *
	 * @param unknown_type $value
	 */
	public function setPayMust($value = 1)
	{
	    $this->_payMust = $value;
	}
	
	public function setShowWithoutPayMust($value = true)
	{
	    
	}
	
	
	/**
	 * Установка разрешения формирования запроса на изъятие информации из таблмцы с учетом домов и комплексов.
	 * По умолчанию в системе учитываются дома и комплексы.
	 *
	 * @param boolean $value
	 * @return Special_Vtor_Object_List
	 */
	public function setShowWitoutHouseNumber($value = true)
	{
	    $this->_showWitoutHouseNumber = $value;
	    return $this;
	}

	public function setFSeller($value = 3)
	{
	    $this->_fSeller = $value;
	    return $this;
	}

	
	public function setHouseId($value)
	{
	    $this->_houseId = $value;
	    return $this;
	}
	
	
	public function setUseAdressFull($value = true)
	{
	    $this->_adressFull = $value;
	    return $this;
	}
	
	
	public function setActivity($value = null)
    {
        if (is_null($value))
        {
            $this->_activity = null;
        }
        else if (is_array($value))
            $this->_activity = $value;
        else
        { 
            $this->_activity = array();
            $this->_activity[] = (int)$value;
        }
        return $this;
    }	
    
    
    public function setType($value = null)
    {
        $this->_type[] = $value;
        return $this; 
    }	
    public function clearType()
    {
        $this->_type = null;
        return $this;
    }	
    
    
    public function setAdress(Special_Vtor_Adress $object)
    {
        $this->_adressArray['region_id'] = $object->getRegionId();
        if ($object->getAreaId())
            $this->_adressArray['area_id'] = $object->getAreaId();
        if ($object->getSettlementId())
            $this->_adressArray['settlement_id'] = $object->getSettlementId();
            
        if ($object->getDistrictId())
        {
            if ($object->getDistrictPlus())
            {
                $this->_districtPlus = $object->getDistrictId();
            }
            else 
            {
                $this->_adressArray['district_id'] = $object->getDistrictId();
            }
        }
        
        if ($object->getStreetId())
            $this->_adressArray['street_id'] = $object->getStreetId();
            
        if ($object->getHouse())
            $this->_adressArray['house_number'] = $object->getHouse();

        if ($object->getBuilding())
            $this->_adressArray['building_number'] = $object->getBuilding();

        if ($object->getGroup())
            $this->_adressArray['group'] = $object->getGroup();
            
            
        return $this;
    }	
    
    
    public function setRegion($value)
    {
        $this->_adressArray['region_id'] = $value;
        return $this;
    }	
    public function setArea($value)
    {
        $this->_adressArray['area_id'] = $value;
        return $this;
    }	
    public function setSettlement($value)
    {
        $this->_adressArray['settlement_id'] = $value;
        return $this;
    }	
    
    public function setDistrict($value, $plus = false)
    {
        if ($plus)
        {
            $this->_districtPlus = $value;
        }
        else 
        {
            $this->_adressArray['district_id'] = $value;
        }
        return $this;
    }	

    public function setDistrictPlusNo($value = 0)
    {
        $this->_districtPlusNo = $value;
    }    
    
    public function setStreet($value)
    {
        if (is_array($value))
            $this->_adressStreet = $value;
        else 
            $this->_adressArray['street_id'] = $value;
        return $this;
    }	
    
    public function setHouse($value)
    {
        $this->_adressArray['house_number'] = $value;
        return $this;
    }	
    
    public function setBuilding($value)
    {
        $this->_adressArray['building_number'] = $value;
        return $this;
    }	

    public function clearSeller()
    {
        $this->_seller = array();
    }
    
    public function setSeller($value, $clear = false)
    {
        if ($clear)
            $this->_seller = array();
        if (is_array($value))
            $this->_seller = $value;
        else 
            $this->_seller[] = $value;
        return $this;
    }	

    public function setSellerException($value)
    {
        if (is_array($value))
            $this->_sellerException = $value;
        else 
            $this->_sellerException[] = $value;
        return $this;
    }	
    
    
    public function setTimeInteval($value)
    {
        $this->_timeInterval = $value;
        return $this;
    }

    public function setNoRyazan($value = true)
    {
        $this->_noRyazan = $value;
        return $this;
    }
    
    public function setEdinstvo($value = true)
    {
        $this->_edinstvo = $value;
        return $this;
    }

    
    public function resetArdress()
    {
            $this->_adressArray = array(
                                        'region_id'        => 1,
                                        'area_id'          => null,
                                        'settlement_id'    => null,
                                        'district_id'      => null,
                                        'street_id'        => null,
                                        'group'            => null,
                                        'house_number'     => null,
                                        'building_number'  => null,
                        );
            $this->_districtPlus = 0; // ТУТ встал  !!!!!
            return $this;
    }	
    

/////////////////////////////////////////////////////////////////////////////////    
    
    /**
     * Число записей с внедренными условиями
     *
     * @return integer
     */
    public function count($group = false)
    {
        
           if ($group)
           {
               $q = 'SELECT count(DISTINCT objects.group_list) FROM ' . $this->_setFromString();
//                $q .= ' GROUP BY `objects`.`group_list`';
                
           }
            else 
                $q = 'SELECT count(DISTINCT objects.id) FROM ' . $this->_setFromString();
        
                
        if ($this->_fSeller)
        {
//            $q .= ', `' . self::$tableUser . '` as user';
        }
        
        $q .= $this->_collectWhere();
                
           if ($this->_noRyazan)
            $q .= ' AND objects.settlement_id != 1';
        if ($this->_fSeller)
        {
//            $q .= ' AND user.id   = objects.saler_id';
        }
            
        
        return $this->DB->query($q, null, Dune_MysqliSystem::RESULT_EL);
    }
    
    /**
     * Список записей из таблицы с ранее указанными параметрами.
     * Возвращает объект итеретор по результатам или false.
     *
     * @param integer $shift сдвиг
     * @param integer $limit колличество записей для выборки
     * @return Dune_Mysqli_Iterator_ResultAssoc
     */
    public function getListOnly($shift = 0, $limit = 100)
    {
        $q = 'SELECT * FROM `' 
           . self::$tableObject 
           . '` as objects, `' 
           . self::$tableObjectType 
           . '` as `type`, `' 
           . self::$tableObjectTypeAdd 
           . '` as `type_add`' 
           
           . $this->_collectWhere()
           . $this->_orderString
           . ' LIMIT ?i, ?i';
        return $this->DB->query($q, array($shift, $limit), Dune_MysqliSystem::RESULT_IASSOC);
    }

    /**
     * Включение нруппировки.
     *
     * @param unknown_type $value
     * @return unknown
     */
    public function setGroupInList($value = true)
    {
        $this->_groupInList = $value;
        return $this;
    }
    
    /**
     * Список записей из таблицы с ранее указанными параметрами.
     * Извлекаются данные и из сязанных таблиц (типы, подтипы).
     * Возвращает объект итеретор по результатам или false.
     *
     * @param integer $shift сдвиг
     * @param integer $limit колличество записей для выборки
     * @return Dune_Mysqli_Iterator_ResultAssoc
     */
    public function getListCumulate($shift = 0, $limit = 100, $exception_saler = null)
    {
        $where = $this->_collectWhere();
        
        $not_in = '';
        if ($exception_saler and is_array($exception_saler))
        {
            foreach ($exception_saler as $value) 
            {
                if ($not_in)
                    $not_in .= ', ';
                $not_in .= $value;
            }
            if ($not_in)
                $not_in = ' AND objects.saler_id NOT IN (' . $not_in . ') ';
        }
        
        $select_add = '';
        $bool_join_hc = true;
        
        
        $q = 'SELECT DISTINCT(objects.id),
                        objects.*,
                      ';
if ($this->_groupInList)    
    $q .= '           COUNT(DISTINCT(objects.id)) as count_in_group,';

$q .= '              type.name as name_type,
                     type_add.name as name_type_add,
                     
  	                 region.name     as name_region,
   	                 area.name       as name_area,
   	                 settlement.name as name_settlement,
   	                 settlement.type as type_settlement,
   	                 district.name   as name_district,
   	                 district_plus.name as name_district_plus,
   	                 street.name     as name_street,
   	                 street.adding   as street_adding,
   	                 
   	                 user.name            as name_user,
   	                 user.phone           as user_phone,
   	                 user.contact_name    as user_contact_name,
   	                 user.mail            as user_mail,
   	                 
   	                 groups.id              as group_id,
   	                 groups.name            as group_name,
   	                 groups.type            as group_type,
   	                 groups.gm_x            as group_gm_x,
   	                 groups.gm_y            as group_gm_y,
   	                 
   	                 
   	                 house.id          as house_id,
   	                 house.name        as house_name,
   	                 house.gm_x        as house_gm_x,
   	                 house.gm_y        as house_gm_y' . $select_add . '
   	                 

             FROM '
           . $this->_setFromString($bool_join_hc)
//           . ', `' . self::$tableUser . '` as user' 
           
           . $where
           . $not_in;
//           . ' AND user.id   = objects.saler_id';
           if ($this->_noRyazan)
            $q .= ' AND objects.settlement_id != 1'
//           . ' GROUP BY `objects`.`id` '
           ;
           if ($this->_groupInList)
           {
                $q .= ' GROUP BY `objects`.`group_list`';
           }
        $q .= $this->_orderString           
           . ' LIMIT ?i, ?i';

        $result =  $this->DB->query($q, array($shift, $limit), Dune_MysqliSystem::RESULT_IASSOC);
        
/*        echo '<pre>';
        echo $this->DB->getQuery();
        echo '<pre>';
        die();
*/        
        return $result;
    }
    

    
    /**
     * Список записей из таблицы с ранее указанными параметрами.
     * Группировка по адресу дома.
     * 
     * Извлекаются данные и из сязанных таблиц (типы, подтипы).
     * Возвращает объект итеретор по результатам или false.
     *
     * @param integer $shift сдвиг
     * @param integer $limit колличество записей для выборки
     * @return Dune_Mysqli_Iterator_ResultAssoc
     */
    public function getListCumulateGroupInHouse($shift = 0, $limit = 100, $exception_saler = null)
    {
        $where = $this->_collectWhere();
        
        $not_in = '';
        if ($exception_saler and is_array($exception_saler))
        {
            foreach ($exception_saler as $value) 
            {
                if ($not_in)
                    $not_in .= ', ';
                $not_in .= $value;
            }
            if ($not_in)
                $not_in = ' AND objects.saler_id NOT IN (' . $not_in . ') ';
        }
        
        $select_add = '';
        $bool_join_hc = true;

        
        
        $q = 'SELECT DISTINCT(objects.id),
                        objects.*,
                     CONCAT(objects.group, objects.settlement_id, objects.street_id, objects.house_number, objects.building_number) as house_adress,
                     COUNT(DISTINCT(objects.id)) as count_in_group,
                     type.name as name_type,
                     type_add.name as name_type_add,
                     
                     MIN(objects.price) as price_min,
                     MAX(objects.price) as price_max,
                     MIN(objects.space_total) as space_min,
                     MAX(objects.space_total) as space_max,
                     MIN(objects.rooms_count) as rooms_count_min,
                     MAX(objects.rooms_count) as rooms_count_max,
                     
  	                 region.name     as name_region,
   	                 area.name       as name_area,
   	                 settlement.name as name_settlement,
   	                 settlement.type as type_settlement,
   	                 
   	                 settlement.gm_x as settlement_gm_x,
   	                 settlement.gm_y as settlement_gm_y,
   	                 
   	                 district.name   as name_district,
   	                 district_plus.name as name_district_plus,
   	                 street.name     as name_street,
   	                 street.adding   as street_adding,
   	                 
   	                 user.name            as name_user,
   	                 user.phone           as user_phone,
   	                 user.contact_name    as user_contact_name,
   	                 user.mail            as user_mail,

   	                 
   	                 groups.id              as group_id,
   	                 groups.name            as group_name,
   	                 groups.image           as group_image,
   	                 groups.type            as group_type,
   	                 
   	                 groups.gm_x              as group_gm_x,
   	                 groups.gm_y              as group_gm_y,
   	                 groups.gm_image          as group_gm_image,
   	                 groups.gm_shadow         as group_gm_shadow,
   	                 groups.gm_iconSize_x     as group_gm_iconSize_x,
   	                 groups.gm_iconSize_y     as group_gm_iconSize_y,
   	                 groups.gm_shadowSize_x   as group_gm_shadowSize_x,
   	                 groups.gm_shadowSize_y   as group_gm_shadowSize_y,
   	                 groups.gm_iconAnchor_x   as group_gm_iconAnchor_x,
   	                 groups.gm_iconAnchor_y   as group_gm_iconAnchor_y,
   	                 
   	                 
   	                 
   	                 house.id          as house_id,
   	                 house.name        as house_name,
   	                 house.image       as house_image,
   	                 house.gm_x        as house_gm_x,
   	                 house.gm_y        as house_gm_y,

   	                 house.gm_image          as house_gm_image,
   	                 house.gm_shadow         as house_gm_shadow,
   	                 house.gm_iconSize_x     as house_gm_iconSize_x,
   	                 house.gm_iconSize_y     as house_gm_iconSize_y,
   	                 house.gm_shadowSize_x   as house_gm_shadowSize_x,
   	                 house.gm_shadowSize_y   as house_gm_shadowSize_y,
   	                 house.gm_iconAnchor_x   as house_gm_iconAnchor_x,
   	                 house.gm_iconAnchor_y   as house_gm_iconAnchor_y
   	                 
   	                 ' . $select_add . '
   	                 

             FROM '
           . $this->_setFromString($bool_join_hc)
//           . ', `' . self::$tableUser . '` as user' 
           
           . $where
           . $not_in;
//           . ' AND user.id   = objects.saler_id';
           if ($this->_noRyazan)
            $q .= ' AND objects.settlement_id != 1';
            
            
           $q .= ' AND (
                      (house.gm_x IS NOT NULL AND house.gm_x != "")
                   OR (objects.gm_x IS NOT NULL AND objects.gm_x != "")
                   OR (groups.gm_x != "")
                   OR (settlement.gm_x != "")
                   ';
           $q .= ' )';
           
           
           
           $q .= ' AND objects.house_number IS NOT NULL
                   AND objects.building_number IS NOT NULL';
           
           $q .= ' AND ( objects.house_number != ""
                         OR objects.type NOT IN (1,4,5)
                         OR objects.region_id NOT IN (1)
                        )
                         '; // Не указан дом - не выводим
           
//           . ' GROUP BY `objects`.`id` '
           
           $q .= ' GROUP BY `house_adress` DESC';
        $q .= $this->_orderString           
           . ' LIMIT ?i, ?i';

        $result =  $this->DB->query($q, array($shift, $limit), Dune_MysqliSystem::RESULT_IASSOC);
        
        
   

/*        if ($this->_adressArray['settlement_id'] == 21 or true)
        {
            $file = Dune_AsArray_File_String::getInstance(Dune_Variables::$pathToArrayFiles);
            Dune_BeforePageOut::registerObject($file);
            $file['query'] = $this->DB->getQuery();
            $file->commit();
        }
*/    
        
        
        return $result;
    }
    
    
    /**
     * Список записей из таблицы с ранее указанными параметрами.
     * Извлекаются данные и из сязанных таблиц (типы, подтипы).
     * Возвращает объект итеретор по результатам или false.
     *
     * @param integer $shift сдвиг
     * @param integer $limit колличество записей для выборки
     * @return Dune_Mysqli_Iterator_ResultAssoc
     */
    public function getListCumulateInGroup($id)
    {
        $where = $this->_collectWhere();
        
        $more = ' AND `objects`.`group_list` = ' . (int)$id;
        
        
        $select_add = '';
        $bool_join_hc = true;
        
        
        $q = 'SELECT DISTINCT(objects.id),
                        objects.*,
                     type.name as name_type,
                     type_add.name as name_type_add,
                     
  	                 region.name     as name_region,
   	                 area.name       as name_area,
   	                 settlement.name as name_settlement,
   	                 settlement.type as type_settlement,
   	                 district.name   as name_district,
   	                 district_plus.name as name_district_plus,
   	                 street.name     as name_street,
   	                 street.adding   as street_adding,
   	                 
   	                 user.name            as name_user,
   	                 user.contact_name    as user_contact_name,
   	                 
   	                 groups.id              as group_id,
   	                 groups.name            as group_name,
   	                 groups.type            as group_type,
   	                 
   	                 house.id          as house_id,
   	                 house.gm_x        as house_gm_x,
   	                 house.gm_y        as house_gm_y' . $select_add . '

             FROM '
           . $this->_setFromString($bool_join_hc)
//           . ', `' . self::$tableUser . '` as user' 
           
           . $where
           . $more
//           . ' AND user.id   = objects.saler_id'
//           . ' GROUP BY `objects`.`id` '
           ;
        $q .= $this->_orderString           
           ;

        $result = $this->DB->query($q, null, Dune_MysqliSystem::RESULT_IASSOC);
//        echo '<pre>', $this->DB->getQuery(), '</pre>'; die();

        return $result;
    }
    
    
    
    
    /**
     * Список записей из таблицы с ранее указанными параметрами.
     * Извлекаются данные и из сязанных таблиц (типы, подтипы).
     * Возвращает объект итеретор по результатам или false.
     *
     * @param integer $shift сдвиг
     * @param integer $limit колличество записей для выборки
     * @return Dune_Mysqli_Iterator_ResultAssoc
     */
    public function getFromListCumulatePriceMinMax()
    {
        $where = $this->_collectWhere();
        
        $not_in = '';
               
        $q = 'SELECT MIN(objects.price) as min, MAX(objects.price) as max

             FROM '
           . $this->_setFromString();
           
        if ($this->_fSeller)
        {
//            $q .= ', `' . self::$tableUser . '` as user';
        }
           
           
           $q .= $where
           . $not_in
           . ' AND objects.price > 10';
           
           if ($this->_noRyazan)
            $q .= ' AND objects.settlement_id != 1';
           

        return $this->DB->query($q, null, Dune_MysqliSystem::RESULT_ROWASSOC);
    }
    
    
    
    protected function _addWhereSpecial()
    {
        return '';
    }

    protected function _setFromString($add_join = false)
    {
        $str = 
           ' `' .  self::$tableObject . '` as objects '; 
           if ($add_join)
           {
            $str .= 
        	   ' LEFT JOIN `' . self::$tableAdressHouse . '` as `house` USING(street_id, house_number, building_number), ';
           }
           else 
           {
               $str .= ', ';
           }
           $str .= ' `' . self::$tableObjectType . '` as type,' 
           . ' `' . self::$tableObjectTypeAdd . '` as type_add,' 
           
           . ' `' . self::$tableObjectGroups . '` as groups,' 
           
           . ' `' . self::$tableAdressRegion . '` as region,' 
           . ' `' . self::$tableAdressArea . '` as area,' 
           . ' `' . self::$tableAdressSettlement . '` as settlement,' 
           . ' `' . self::$tableAdressDistrict . '` as district,' 
           . ' `' . self::$tableAdressDistrictPlus . '` as district_plus,' 
           . ' `' . self::$tableAdressStreet . '` as street,' 
           
           . ' `' . self::$tableUser . '` as user' 
           ;
           
         if ($this->_userOnline)
            $str .= ', `' . self::$tableUserTime . '` as time' ;
            
           $spec_str = $this->_setFromStringSpecial();
        if ($spec_str)
           $spec_str = ' , ' . $spec_str;
        return $str . $spec_str;
    }

    protected function _setFromStringSpecial()
    {
        return '';
    }
    
/////////////////////////////////////////////////////////////////////////////////    
///////     Метды установки порядка выборки


    /**
     * Добавление порядка выборки. Время внесения записи.
     *
     * @param string $order направление ADC или DESC
     */
    public function setOrder($field, $order = 'ASC', $table = 'objects')
    {
        if (!$this->_orderString)
            $this->_orderString = ' ORDER BY ';
        else 
            $this->_orderString .= ', ';
        $this->_orderString .=  $table. '.' . $field . ' ' . $order;
        return $this;
    }

    /**
     * Добавление порядка выборки. Время внесения записи.
     *
     * @param string $order направление ADC или DESC
     */
    public function setOrderTimeInsert($order = 'ASC')
    {
        if (!$this->_orderString)
            $this->_orderString = ' ORDER BY';
        $this->_orderString .= ' objects.time_insert ' . $order;
        return $this;
    }
    
    /**
     * Добавление порядка выборки. Время изменения записи.
     *
     * @param string $order направление ADC или DESC
     */
    public function setOrderTimeChange($order = 'ASC')
    {
        if (!$this->_orderString)
            $this->_orderString = ' ORDER BY';
        $this->_orderString .= ' objects.time_change ' . $order;
        return $this;
     }
    
    /**
     * Добавление порядка выборки. Цена.
     *
     * @param string $order направление ADC или DESC
     */
    public function setOrderPrice($order = 'ASC')
    {
        if (!$this->_orderString)
            $this->_orderString = ' ORDER BY';
        $this->_orderString .= ' objects.price ' . $order;
        return $this;
     }
    
    /**
     * Добавление порядка выборки. Поле порядка..
     *
     * @param string $order направление ADC или DESC
     */
    public function setOrderOrder($order = 'ASC')
    {
        if (!$this->_orderString)
            $this->_orderString = ' ORDER BY';
        $this->_orderString .= ' objects.order ' . $order;
        return $this;
    }
    
    /**
     * Сбросить порядок.
     */
    public function resetOrder()
    {
        $this->_orderString = '';
        return $this;
    }
    
////////////////////////////////////////////////////////////////////////
////////////        Защищённые методы
    protected function _collectWhere()
    {
        $where = '';
        $where = $this->_addWhereSpecial();
        
        // Какие продаватели
        $str = '';
        if (count($this->_seller))
        {
            foreach ($this->_seller as $key => $value)
            {
                if ($str)
                    $str .= ', ';
                $str .= (int)$value;
            }
            $str = '(objects.saler_id IN (' . $str . ') ';
        }

        if ($this->_fSeller)
        {
            if ($str)
                $str = $str . ' OR ';
            else 
                $str .= ' (';
            $str .=  'user.status < 11';
        }
        
        
        if ($this->_edinstvo or self::$edinstvo)
        { //die();
            if ($where)
                $where .= ' AND ';
            if ($str)
                $str = $str . ' OR';
            else 
                $str .= ' (';
            $where .= $str . ' objects.edinstvo = 1)';
        }
        else if ($str)
        {
            $str = $str . ') ';
            if ($where)
                $where .= ' AND ';
            $where .= $str;
        }
        

        if (!is_null($this->_timeInterval))
        {
            if ($where)
                $where .= ' AND ';
            $time = time() - (int)$this->_timeInterval;
            $where .= ' objects.time_insert > FROM_UNIXTIME(' . $time . ')';
        }

        if (!is_null($this->_payMust))
        {
            if ($where)
                $where .= ' AND ';
            $where .= ' objects.pay_must = ' . $this->_payMust . '';
        }
        

        if (count($this->_sellerException))
        {
            $not_in = '';
            foreach ($this->_sellerException as $value) 
            {
                if ($not_in)
                    $not_in .= ', ';
                $not_in .= $value;
            }
            if ($not_in)
            {
                if ($where)
                    $where .= ' AND';
                $where .= ' objects.saler_id NOT IN (' . $not_in . ') ';
            }
        }
        
        if (self::$user)
        {
            if ($where)
                $where .= ' AND ';
            $where .= ' objects.saler_id = ' . self::$user;
        }

        
        if (!is_null($this->_houseId))
        {
            if ($where)
                $where .= ' AND ';
            $where .= ' objects.sub_house_id = ' . $this->_houseId . '';
        }
        
        
        $spec_filter = $where;        
        
        foreach ($this->_adressArray as $key => $value)
        {
            if (!is_null($value))
            {
                if ($key == 'building_number' or $key == 'house_number')
                {
                    if (!$value or !$this->_adressFull)
                        continue;
                    if ($where)
                        $where .= ' AND';
                    $where .= ' objects.`' . $key . '` = "' . $this->DB->real_escape_string($value) . '"';
                }
                else if ($key == 'group')
                {
                    if (!$value or !$this->_adressFull)
                        continue;
                    if ($where)
                        $where .= ' AND';
                    $where .= ' objects.`' . $key . '` = ' . (int)$value;
                }
                else 
                {
                    if ($where)
                        $where .= ' AND';
                    $where .= ' objects.`' . $key . '` = ' . (int)$value;
                }
            }
        }
       
        if ($this->_districtPlus) // Дистрикты плюс
        {
            if ($where)
                $where .= ' AND';
                
            if ($this->_districtPlus == 16) // Малый центр - часть большого
                $str = ' IN (10, 16)';
            else
                $str = ' = ' . (int)$this->_districtPlus;
                
            $where .= ' objects.`district_id_plus`' . $str;
        }

        
        if (!is_null($this->_districtPlusNo)) // Дистрикты плюс не установлен
        {
            if ($where)
                $where .= ' AND';
            $where .= ' objects.`district_id_plus` = ' . (int)$this->_districtPlusNo;
        }
        
        
        if (!$this->_showWitoutHouseNumber and !self::$showWitoutHouseNumber) // Добавлено 2009-02-26 не показывать объявления без номера дома (для квартир и нежилых помещений)
        {
            if ($where)
                $where .= ' AND ';
//            $where .= '( (objects.house_number IS NOT NULL AND objects.house_number != "") OR objects.type NOT IN (1, 2, 4))';
            $where .= '(user.house_number_ignore = 1 OR (objects.house_number IS NOT NULL AND objects.house_number != "") OR objects.type NOT IN (1, 2, 4))';            
        }
        
        if (!is_null($this->_activity))
        {
            if ($where)
                $where .= ' and ';
            if (is_array($this->_activity) and count($this->_activity) > 0)
            {
                $where .= 'objects.activity IN (' . implode(',', $this->_activity) .')';
            }
        }
        
        if (!is_null($this->_type) and is_array($this->_type))
        {
            if ($where)
                $where .= ' and ';
            $str = '';
            foreach ($this->_type as $key => $value)
            {
                if ($str)
                    $str .= ', ';
                $str .= $value;
            }
            
            $where .= ' objects.type IN (' . $str . ') ';
            
            //$where .= ' objects.type = ' . $this->_type;
        }
        
        
        
        if (count($this->_adressStreet))
        {
            $not_in = '';
            foreach ($this->_adressStreet as $value) 
            {
                if ($not_in)
                    $not_in .= ', ';
                $not_in .= $value;
            }
            if ($not_in)
            {
                if ($where)
                    $where .= ' AND';
                $where .= ' objects.street_id IN (' . $not_in . ') ';
            }
        }
        
        if ($where)
            $where = ' WHERE ' . $where;
            
        if (!$where)
            $where = ' WHERE';
        else 
            $where .= ' AND';
            
        $where .= ' type.id = objects.type';
        $where .= ' AND type_add.id = objects.type_add';
        
        $where .= ' AND objects.region_id = region.id';
        $where .= ' AND objects.area_id   = area.id';
        $where .= ' AND objects.settlement_id   = settlement.id';
       
        $where .= ' AND objects.street_id   = street.id';
        
        $where .= ' AND objects.district_id        = district.id';
        $where .= ' AND objects.district_id_plus   = district_plus.id';
        
        $where .= ' AND objects.group = groups.id';
            
        $where .= ' AND user.id   = objects.saler_id'; // пользователь всегда
        
         if ($this->_userOnline)
         {
            $where .= ' AND time.id = objects.saler_id';
            $where .= ' AND time.last_visit > "' . date('Y-m-d H:i:s', time() - 400) . '"';
            
            if ($spec_filter)
                $spec_filter .= ' AND ';
            $spec_filter .= ' time.id = objects.saler_id';
            $spec_filter .= ' AND time.last_visit > "' . date('Y-m-d H:i:s', time() - 400) . '"';
         }
        
         $this->_whereStringSpecial = $spec_filter;
         
        return $where;
    }    
}