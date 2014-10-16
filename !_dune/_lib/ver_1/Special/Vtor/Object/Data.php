<?php
/**
 * 
 * Данные об объекте.
 * 
 */
class Special_Vtor_Object_Data
{
    
    /**
     * Разрешение логирования сохранений объектов.
     *
     * @var unknown_type
     */
    public static $loging = 'Module_Log_SaveObject';
    
    protected $DB;
    protected $_id;
    protected $_fullInfo;
    protected $_data = false;
    protected $_dataToInsert = array();
    protected $_infoArray = array();
    protected $_infoArrayChachged = false;
    protected $_adressArrayNoHave = true;
    protected $_adressArray =  array(
                                        'region'        => 1,
                                        'area'          => 0,
                                        'settlement'    => 0,
                                        'district'      => 0,
                                        'street'        => 0,
                                        'house'         => 0,
                                        'building'      => '',
                                        
                                        'settlement_name'    => '',
                                        'street_name'        => ''
                                    );
    
    public static $tableObject          = 'unity_catalogue_object';
    public static $tableObjectType      = 'unity_catalogue_object_type';
    public static $tableObjectTypeAdd   = 'unity_catalogue_object_type_add';
    
    public static $tableObjectCondition   = 'unity_catalogue_object_condition';
    public static $tableObjectPlanning    = 'unity_catalogue_object_planning';
    
    public static $tableAdressRegion       = 'unity_catalogue_adress_region';
    public static $tableAdressArea         = 'unity_catalogue_adress_area';
    public static $tableAdressSettlement   = 'unity_catalogue_adress_settlement';
    public static $tableAdressDistrict     = 'unity_catalogue_adress_district';
    public static $tableAdressDistrictPlus = 'unity_catalogue_adress_district_plus';    
    public static $tableAdressStreet       = 'unity_catalogue_adress_street';
    
    public static $tableAdressHouse       = 'unity_catalogue_adress_house';
    public static $tableAdressComplex     = 'unity_catalogue_adress_complex';
    
    
    public static $tableObjectGroups   = 'unity_catalogue_object_groups';
    
    public static $tableDeveloper   = 'unity_catalogue_object_developer';
    
    public static $useExrption = false;
    
    public static $allowFields = array(
    
                                          'name'            => array('s', 254),
                                          'name_complex'    => array('s', 255),
                                          
                                          'activity'        => array('i', 10),
                                          'mark'            => array('i', 100),
                                          'saler_special'   => array('i', 100),
                                          
                                          
                                          'address'           => array('s', 250),
                                          'priority'          => array('i', 100000000),
                                          'region_id'         => array('i', 100000),
                                          'area_id'           => array('i', 100000000),
                                          'settlement_id'     => array('i', 100000000),
                                          'settlement_name'   => array('s', 50),
                                          'district_id'       => array('i', 100000000),
                                          'district_id_plus'  => array('i', 100000000),
                                          
                                          'street_id'       => array('i', 100000000),
                                          'street_name'     => array('s', 50),
                                          
//                                          'street_adding'   => array('i', 10),
                                          
                                          
                                          'house_number'          => array('s', 10),
                                          'house_number_comment'  => array('s', 250),
                                          'house_number_ignore'   => array('i', 100),
                                          
                                          'building_number' => array('s', 3),
                                          
                                          'floor'           => array('i', 200),
                                          'floor_2'         => array('i', 200),
                                          'floors_total'    => array('i', 1000),
                                          
                                          'porch'           => array('i', 100),
                                          'porch_text'      => array('s', 100),
                                          
                                          'room'            => array('i', 1000),
                                          'type'            => array('i', 100),
                                          'type_add'        => array('i', 100),
                                          'type_house'      => array('i', 100),
                                          'type_wall'       => array('i', 100),
                                          'type_heating'    => array('i', 100),
                                          'type_water_cold' => array('i', 100),
                                          'type_sewer'      => array('i', 100),
                                          
                                          'order'           => array('i', 1000),
                                          
                                          'deal'            => array('i', 100), // Покупка аренда или все сразу - один код.
                                          'haggling'        => array('i', 100), // Торг
                                          
                                          'price'             => array('i', 100000000),
                                          'price_old'         => array('i', 100000000),
                                          'price_one'         => array('f', 100000000),
                                          'price_one_old'     => array('i', 100000000),
                                          'price_rent'        => array('i', 100000000),
                                          'price_rent_day'    => array('i', 100000000),
                                          'price_rent_metre'  => array('i', 100000000),
                                          
                                          'price_contractual' => array('i', 100),
                                          
//                                          'info_array'      => array('s', 1000),
                                          'info_text'           => array('s', 10000),
                                          'info_show_condition' => array('s', 10000),
                                          
                                          'time_insert'     => array('s', 30),
                                          'time_close'     => array('s', 30),
                                          'info_comment'    => array('s', 10000),
                                          'info_contact'    => array('s', 10000),
                                                                                    
                                          'time_change'     => array('s', 30),
                                          'status'          => array('i', 100),
                                          'saler_id'        => array('i', 100000000),
                                          'pics'            => array('i', 100),
                                          
                                          'space_total'         => array('f', 1000),
                                          'space_living'        => array('f', 1000),
                                          'space_kitchen'       => array('f', 1000),
                                          'space_calculation'   => array('f', 1000),
                                          'space_loggia'        => array('f', 1000),
                                          'space_balcony'       => array('f', 1000),
                                          'space_land'          => array('f', 100000),
                                          
                                          'condition'       => array('i', 100),
                                          'planning'        => array('i', 100),
                                          'balcony'         => array('i', 10),
                                          'loggia'          => array('i', 10),
                                          
                                          'levels'          => array('i', 101),
                                          'rooms_count'     => array('i', 100),
//                                          'land_area'       => array('i', 10000),
                                          'garage'          => array('i', 10),
                                          
                                          'have_phone'               => array('i', 10),
                                          'have_panorama'            => array('i', 100),
                                          'have_plan'                => array('i', 10),
                                          'have_situa'               => array('i', 10),
                                          'have_land'                => array('i', 10),
                                          'have_bath'                => array('i', 10),
                                          'have_photo_house'         => array('i', 100),
                                          'have_hypothec_privilege'  => array('i', 100),
                                          
                                          'new_building_flag' => array('i', 10),
                                          'new_building_text' => array('s', 100),
                                          
                                          'height_ceiling'    => array('f', 100),
                                          
                                          'panorama'    => array('i', 100000),
                                          
                                          'group_list'     => array('i', 10000),
                                          
                                          'gm_x'     => array('s', 20),
                                          'gm_y'     => array('s', 20),
                                          
                                          'developer'        => array('i', 254),
                                          
                                          'windows_type'     => array('i', 254),
                                          'corner_room'      => array('i', 254),
                                          
                                          'pay_must'      => array('i', 10),
                                          'pay_time_end'  => array('s', 20),
                                          'pay_version'   => array('i', 1000000),
                                          
                                       );
    
	public function __construct($id = 0, $full_info = true)
	{ 
	    $this->DB = Dune_MysqliSystem::getInstance();
	    $this->_id = (int)$id;
	    $this->_fullInfo = $full_info;
	    if ($id)
	    {
    	    if ($full_info)
    	    {
        	    $q = 'SELECT object.*,
        	                 type.name      as name_type,
        	                 type.code      as code_type,
        	                 type_add.name  as name_type_add,
        	                 condition.name as name_condition,
        	                 planning.name  as name_planning,
        	                 
        	                 region.name     as name_region,
        	                 area.name       as name_area,
        	                 settlement.name as name_settlement,
        	                 settlement.type as type_settlement,
        	                 
        	                 settlement.gm_x as settlement_gm_x,
        	                 settlement.gm_y as settlement_gm_y,
        	                 
        	                 district.name        as name_district,
        	                 district_plus.name   as name_district_plus,
        	                 street.name          as name_street,
        	                 street.adding        as street_adding,
        	                 
        	                 house.id          as house_id,
        	                 house.gm_x        as house_gm_x,
        	                 house.gm_y        as house_gm_y,
        	                 house.pd          as house_pd,
        	                 
        	                 
        	                 house_sub.name    as house_sub_name,

        	                 group.gm_x        as complex_gm_x,
        	                 group.gm_y        as complex_gm_y,
        	                 group.name        as complex_name,
        	                 
        	                 group.gm_x        as group_gm_x,
        	                 group.gm_y        as group_gm_y,
        	                 group.name        as group_name,

        	                 developer.name    as developer_name,
        	                 developer.text    as developer_text,
        	                 developer.logo    as developer_logo,
        	                 developer.site    as developer_site,
        	                 developer.gm      as developer_gm
        	                 
        	                 
        	                 
        	          FROM ?t as `object` 
        	               LEFT JOIN `' . self::$tableAdressHouse . '` as `house` USING(street_id, house_number, building_number)
        	               LEFT JOIN `' . Special_Vtor_Tables::$houses . '` as `house_sub` ON `house_sub`.`id` = `object`.`sub_house_id`
        	               LEFT JOIN `' . self::$tableDeveloper . '` as `developer` ON `developer`.`id` = `object`.`developer`,
        	               `' . self::$tableObjectGroups . '` as `group`,
        	               `' . self::$tableAdressDistrictPlus . '` as `district_plus`,
        	               ?t as type,
        	               ?t as type_add,
        	               ?t as `condition`,
        	               ?t as planning,
        	               
        	               ?t as region,
        	               ?t as area,
        	               ?t as settlement,
        	               ?t as district,
        	               ?t as street
        	               
        	          WHERE `object`.`id` = ?i
        	                AND
        	                object.type = type.id
        	                AND
        	                object.type_add = type_add.id
        	                AND
        	                object.condition = condition.id
        	                AND
        	                object.planning = planning.id
        	                AND
        	                object.street_id = street.id
        	                AND
        	                object.district_id = district.id
        	                AND
        	                object.region_id = region.id
        	                AND
        	                object.area_id = area.id
        	                AND
        	                object.settlement_id = settlement.id
        	                AND
        	                object.district_id_plus = district_plus.id
        	                AND
        	                object.group = group.id
        	                
        	          LIMIT 1';
        	    $this->_data = $this->DB->query($q,
        	                                    array(self::$tableObject,
        	                                          self::$tableObjectType,
        	                                          self::$tableObjectTypeAdd,
        	                                          self::$tableObjectCondition,
        	                                          self::$tableObjectPlanning,
        	                                          
        	                                          self::$tableAdressRegion,
        	                                          self::$tableAdressArea,
        	                                          self::$tableAdressSettlement,
        	                                          self::$tableAdressDistrict,
        	                                          self::$tableAdressStreet,
        	                                          $id),
        	                                    Dune_MysqliSystem::RESULT_ROWASSOC);
    	    }
    	    else 
    	    {
        	    $q = 'SELECT object.*, type.name as name_type, type_add.name as name_type_add
        	          FROM ?t as object,
        	               ?t as type,
        	               ?t as type_add
        	          WHERE object.id = ?i
        	                AND
        	                object.type = type.id
        	                AND
        	                object.type_add = type_add.id
        	                
        	          LIMIT 1';
        	    $this->_data = $this->DB->query($q,
        	                                    array(self::$tableObject, self::$tableObjectType, self::$tableObjectTypeAdd, $this->_id),
        	                                    Dune_MysqliSystem::RESULT_ROWASSOC);
    	    }
    	    
    	    $this->_infoArray = @unserialize($this->_data['info_array']);
    	    if (!is_array($this->_infoArray))
    	       $this->_infoArray = array();
	    }
	}

    public function check()
    {
        if ($this->_data === false)
            return false;
        return true;
    }
    
    public function getInfo($iterator = true)
    {
        if ($this->_data)
            return new Dune_Array_Container($this->_data);
        else 
            return false;
    }	

    
    /**
     * Число комментов
     *
     * @return integer
     */
    public function countComments()
    {
        if ($this->check())
        {
            $q = 'SELECT count(*) FROM `unity_catalogue_object_public_talk`  WHERE object_id = ?i';
            return $this->DB->query($q, array($this->_data['id']), Dune_MysqliSystem::RESULT_EL);
        }
        return null;
    }
    
    
    public function getAdressArray($plus = false)
    {
        if ($this->_data !== false and ($this->_adressArrayNoHave))
        {
            if ($plus)
            {
                $district = $this->_data['district_id_plus'];
            }
            else 
            {
                $district = $this->_data['district_id'];
            }
            
            $this->_adressArray = array(
                                        'region'        => $this->_data['region_id'],
                                        'area'          => $this->_data['area_id'],
                                        'settlement'    => $this->_data['settlement_id'],
                                        'district'      => $district,
                                        'street'        => $this->_data['street_id'],
                                        'house'         => $this->_data['house_number'],
                                        'building'      => $this->_data['building_number'],
                                        
                                        'settlement_name'    => $this->_data['settlement_name'],
                                        'street_name'        => $this->_data['street_name'],
                        );
            $this->_adressArrayNoHave = false;
            
        }
        return $this->_adressArray;
    }

    public function getAdressObject($plus = false)
    {
        if ($this->_data !== false and ($this->_adressArrayNoHave))
        {
            if ($plus)
            {
                $district = $this->_data['district_id_plus'];
            }
            else 
            {
                $district = $this->_data['district_id'];
            }
            $this->_adressArray = array(
                                        'region'        => $this->_data['region_id'],
                                        'area'          => $this->_data['area_id'],
                                        'settlement'    => $this->_data['settlement_id'],
                                        'district'      => $district,
                                        'street'        => $this->_data['street_id'],
                                        'house'         => $this->_data['house_number'],
                                        'building'      => $this->_data['building_number'],
                                        
                                        'settlement_name'    => $this->_data['settlement_name'],
                                        'street_name'        => $this->_data['street_name'],
                        );
            $this->_adressArrayNoHave = false;
            
        }
        $adress = new Special_Vtor_Adress($this->_adressArray);
        if ($plus)
        {
            $adress->setDistrictPlus();
        }
        return $adress;
    }
    
    
    public function add()
    {
        if (count($this->_dataToInsert) < 1)
            return false;
            
        if (count($this->_infoArray) > 1)
            $this->_dataToInsert['info_array'] = $this->DB->real_escape_string(serialize($this->_infoArray));
            
        $set = ' SET';
        $x = 0;
        if (!isset($this->_dataToInsert['time_insert']))
            $this->_dataToInsert['time_insert'] = 'NOW()';
        if (!isset($this->_dataToInsert['time_change']))
            $this->_dataToInsert['time_change'] = 'NOW()';
            
        foreach ($this->_dataToInsert as $key => $value)
        {
            if ($x)
                $set .= ',';
            $x++;
            $set .= ' `' . $key .'` = ' . $value;
        }
        $q = 'INSERT INTO `' . self::$tableObject . '` ' . $set;
        $id =  $this->DB->query($q, null, Dune_MysqliSystem::RESULT_ID);
        
        $q = 'UPDATE `' . self::$tableObject . '` SET `group_list` = ?i WHERE `id` = ?i';
        $this->DB->query($q, array($id, $id), Dune_MysqliSystem::RESULT_AR);
        
        return $id;
    }

    
    public function copy()
    {
        if (count($this->_data) < 1)
            return false;
        
        $this->_dataToInsert = array();
        foreach ($this->_data as $key => $value)
        {
            $this->$key = $value;
        }
        $this->_dataToInsert['info_array'] = '"' . $this->_data['info_array'] . '"';
            
        
        $set = ' SET';
        $x = 0;
        $this->_dataToInsert['time_insert'] = 'NOW()';
        $this->_dataToInsert['time_change'] = 'NOW()';
            
        foreach ($this->_dataToInsert as $key => $value)
        {
            if ($x)
                $set .= ',';
            $x++;
            $set .= ' `' . $key .'` = ' . $value;
        }
        $q = 'INSERT INTO `' . self::$tableObject . '` ' . $set;
        $id =  $this->DB->query($q, null, Dune_MysqliSystem::RESULT_ID);
        
        $q = 'UPDATE `' . self::$tableObject . '` SET `group_list` = ?i WHERE `id` = ?i';
        $this->DB->query($q, array($id, $id), Dune_MysqliSystem::RESULT_AR);
        
        return $id;
    }
    
    
    public function save()
    {
        if (count($this->_dataToInsert) < 1)
            return false;
            
        if (count($this->_infoArray) > 1)
            $this->_dataToInsert['info_array'] = $this->DB->real_escape_string(serialize($this->_infoArray));
            
        $set = ' SET';
        $x = 0;
        if (!isset($this->_dataToInsert['time_change']))
            $this->_dataToInsert['time_change'] = 'NOW()';
            
            
        if (self::$loging)
        {
            $module = new self::$loging();
            $module->data = $this->_dataToInsert;
            $module->data_was = $this->_data;
            $module->id = $this->_id;
            $module->make();
        }
        
            
        foreach ($this->_dataToInsert as $key => $value)
        {
            if ($x)
                $set .= ',';
            $x++;
            $set .= ' `' . $key .'` = ' . $value;
        }
        if (!isset($this->_dataToInsert['have_panorama']))
        {
            $set .= ',  `have_panorama` = NULL';
        }
        
        $q = 'UPDATE `' . self::$tableObject . '` ' . $set . ' WHERE id=?i LIMIT 1';
        return $this->DB->query($q, array($this->_id), Dune_MysqliSystem::RESULT_ID);
    }

    /**
     * Год вставки объекта в систему
     *
     * @return string
     */
    public function getInsertYear()
    {
        if ($this->_data === false)
            return false;        
        return substr($this->_data['time_insert'], 0, 4);
    }

    /**
     * Устанавливает метку наличия картинок объекта.
     *
     * @return integer
     */
    public function setPicturesAvailability($count = 0)
    {
        if ($this->_data === false)
            return false;        
        $q = 'UPDATE ?t SET pics = ?i, time_change = NOW() WHERE id= ?i LIMIT 1';
        return $this->DB->query($q, array(self::$tableObject, $count, $this->_id), Dune_MysqliSystem::RESULT_AR);
    }
    
    
    public function getInfoArray($key = false, $default = '')
    {
        if ($key === false)
            return $this->_infoArray;
        if (isset($this->_infoArray[$key]))
            return $this->_infoArray[$key];
        else 
            $default;
    }
    public function setInfoArray($key, $value)
    {
        $this->_infoArray[$key] = $value;
        return $this;
    }
    public function clearInfoArray()
    {
        $this->_infoArray = array();
        return $this;
    }
    
////////////////////////////////////////////////////////////////
///////////////////////////////     Магические методы
    public function __set($name, $value)
    {
        if (key_exists($name, self::$allowFields))
        {
            if (self::$allowFields[$name][0] == 'i')
            {
                $value = (int)str_replace(' ', '', $value);
                if ($value > self::$allowFields[$name][1])
                    $value = self::$allowFields[$name][1];
            }
            else if (self::$allowFields[$name][0] == 'f')
            {
                $value = (float)str_replace(array(' ',','), array('','.'), $value);
                if ($value > self::$allowFields[$name][1])
                    $value = self::$allowFields[$name][1];
            }
            
            else 
            {
                if ($name == 'building_number')
                    $value = $this->fromRusToEng($value);
                $value =  '"' . $this->DB->real_escape_string(substr($value, 0, self::$allowFields[$name][1])) . '"';
            }
            $this->_dataToInsert[$name] = $value;
        }
        else 
        {
            if (self::$useExrption)
                throw new Dune_Exception_Base('Установка несуществующего ключа в масссив данных объекта');
        }
    }
    public function __get($name)
    {
       if (isset($this->_data[$name]))
            return $this->_data[$name];
        else
        {
            if (self::$useExrption)
                throw new Dune_Exception_Base('Нед данных для вывода.');
            return null;
        }
    }
    public function __toString()
    {
    	$string = '<pre>';
    	ob_start();
    	print_r($this->_data);
    	$string .= ob_get_clean();
    	return  $string . '</pre>';
    }
/////////////////////////////
////////////////////////////////////////////////////////////////
    
    protected function fromRusToEng($word)
    {
        $word = str_replace(array('а', 'б', 'в', 'г', 'д'), array('a', 'b', 'c', 'd', 'e'), $word);
        return $word;
    }

}