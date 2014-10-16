<?php
/**
 * 
 * Данные об объекте.
 * 
 */
class Special_Vtor_Sub_Data_House
{
    
    
    protected $DB;
    protected $_id;
    protected $_fullInfo;
    protected $_data = false;
    protected $_dataToInsert = array();
    
	public function __construct($id = 0)
	{
	    $this->DB = Dune_MysqliSystem::getInstance();
	    $this->_id = (int)$id;
	    if ($id)
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
        	                 

        	                 group.gm_x           as complex_gm_x,
        	                 group.gm_y           as complex_gm_y,
        	                 group.name           as complex_name,
        	                 group.panorama_id    as complex_panorama_id,
        	                 group.have_photo     as complex_have_photo,
        	                 group.have_situa     as complex_have_situa,
        	                 group.have_fasad     as complex_have_fasad,
        	                 group.have_gen_plan  as complex_have_gen_plan,
        	                 
        	                 
        	                 
        	                 group.gm_x        as group_gm_x,
        	                 group.gm_y        as group_gm_y,
        	                 group.name        as group_name,
        	                 group.panorama_id    as group_panorama_id,
        	                 group.have_photo     as group_have_photo,
        	                 group.have_situa     as group_have_situa,
        	                 group.have_fasad     as group_have_fasad,
        	                 group.have_gen_plan  as group_have_gen_plan,
        	                 
        	                 
        	                 grid.room     as grid_room,
        	                 grid.nolife   as grid_nolife
        	                 
        	                 

        	                 
        	          FROM ?t as `house`'; 
        	            $q .= ' LEFT JOIN `' . Special_Vtor_Tables::$group . '` as `group` ON `house`.`complex_id` = `group`.`id`';
        	            $q .= ' LEFT JOIN `' . Special_Vtor_Tables::$grid . '` as `grid` ON `house`.`grid_id` = `grid`.`id`,';
//        	            $q .= ',';
        	               
//        	            $q .= ' `' . Special_Vtor_Tables::$group . '` as `group`,';
        	            $q .= ' `' . Special_Vtor_Tables::$adressDistrictPlus . '` as `district_plus`,
        	               
        	               ?t as region,
        	               ?t as area,
        	               ?t as settlement,
        	               ?t as district,
        	               ?t as street
        	               
        	          WHERE `house`.`id` = ?i
        	                AND
        	                house.street_id = street.id
        	                AND
        	                house.district_id = district.id
        	                AND
        	                house.region_id = region.id
        	                AND
        	                house.area_id = area.id
        	                AND
        	                house.settlement_id = settlement.id
        	                AND
        	                house.district_id_plus = district_plus.id ';
        	            
//        	        $q .= ' AND house.complex_id = group.id ';
        	        $q .= '  LIMIT 1';
        	    $this->_data = $this->DB->query($q,
        	                                    array(Special_Vtor_Tables::$houses,
        	                                          Special_Vtor_Tables::$adressRegion,
        	                                          Special_Vtor_Tables::$adressArea,
        	                                          Special_Vtor_Tables::$adressSettlement,
        	                                          Special_Vtor_Tables::$adressDistrict,
        	                                          Special_Vtor_Tables::$adressStreet,
        	                                          $id),
        	                                    Dune_MysqliSystem::RESULT_ROWASSOC);
    	    
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
        {
            if ($iterator)
                return new Dune_Array_Container($this->_data);
            else 
                return $this->_data;
        }
        else 
            return false;
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
                                        'house'         => $this->_data['number'],
                                        'building'      => $this->_data['building'],
                                        
                        );
            $this->_adressArrayNoHave = false;
            
        }
        return $this->_adressArray;
    }

    public function getAdressObject($plus = false)
    {
        if ($this->_data !== false)
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
                                        'house'         => $this->_data['number'],
                                        'building'      => $this->_data['building'],
                        );
            $this->_adressArrayNoHave = false;
            
            $adress = new Special_Vtor_Adress($this->_adressArray);
            if ($plus)
            {
                $adress->setDistrictPlus();
            }
            return $adress;
        }
    }
    
    /**
     * Обновить статистические данные
     *
     * @param boolean $special 
     * @return boolean
     */
    public function update($type = 1)
    {
        $street_id = 0;
        if ($this->_data === false)
            return false;
        if ($this->_data['address_house_id'])
        {
            $q = 'SELECT * FROM ?t WHERE id = ?i LIMIT 1';
      	    $data = $this->DB->query($q,
       	                                    array(
       	                                          Special_Vtor_Tables::$adressHouse,
       	                                          $this->_data['address_house_id']),
       	                                    Dune_MysqliSystem::RESULT_ROWASSOC);
       	   if ($data)
       	   {
       	       $street_id = $data['street_id'];
       	       $house_number = (string)$data['house_number'];
       	       $building_number = (string)$data['building_number'];
       	   }
            
        }
        if ($street_id)
        {
            $where = ' WHERE type = ?i AND activity = 1 AND (sub_house_id = ' . (int)$this->_data['id'] . 
                     ' OR (street_id =' . (int)$street_id . ' AND house_number ="' . $house_number . '" AND building_number = "' . $building_number . '"))';
        }
        else 
        {
            $where = ' WHERE type = ?i AND activity = 1 AND sub_house_id = ' . (int)$this->_data['id'];
        }
            $q = 'SELECT count(`id`) as `count`,
                         MAX(`price_one`) as `price_max_metre`,
                         MIN(`price_one`) as `price_min_metre`,
                         MAX(`space_total`) as `space_total_max`,
                         MIN(`space_total`) as `space_total_min`,
                         MAX(`price`) as `price_max`,
                         MIN(`price`) as `price_min`
                         FROM ?t
                          ' . $where;
      	    $data = $this->DB->query($q,
       	                                    array(
       	                                        Special_Vtor_Tables::$object,
       	                                          $type,
       	                                          ),
       	                                    Dune_MysqliSystem::RESULT_ROWASSOC);
       	    if ($data)
       	    { 
       	        $rooms_count = array(1 => 0, 0, 0, 0);
       	        if (isset($data['count']) and $data['count'] and $type == 1)
       	        {
       	            
                    $q = 'SELECT count(`id`) as `count`
                                 FROM ?t
                                  ' . $where . ' AND `rooms_count` = ?i';
                    
              	    $rooms_count[1] = (int)$this->DB->query($q,
               	                                    array(
               	                                        Special_Vtor_Tables::$object,
               	                                        $type,
               	                                          1,
               	                                          ),
               	                                    Dune_MysqliSystem::RESULT_EL);
              	    $rooms_count[2] = (int)$this->DB->query($q,
               	                                    array(
               	                                        Special_Vtor_Tables::$object,
               	                                        $type,
               	                                          2,
               	                                          ),
               	                                    Dune_MysqliSystem::RESULT_EL);
              	    $rooms_count[3] = (int)$this->DB->query($q,
               	                                    array(
               	                                        Special_Vtor_Tables::$object,
               	                                        $type,
               	                                          3,
               	                                          ),
               	                                    Dune_MysqliSystem::RESULT_EL);

                    $q = 'SELECT count(`id`) as `count`
                                 FROM ?t
                                  ' . $where . ' AND `rooms_count` > ?i';
              	    $rooms_count[4] = (int)$this->DB->query($q,
               	                                    array(
               	                                        Special_Vtor_Tables::$object,
               	                                        $type,
               	                                          3,
               	                                          ),
               	                                    Dune_MysqliSystem::RESULT_EL);
       	            
       	            
       	        }
       	        
       	        $this->_update($type, $data, $rooms_count);
       	    }
       	    return $data;
        
    }
    
    public function setUpdateDone()
    {
        if ($this->_data === false)
            return false;
        $q = 'UPDATE ?t SET `to_update` = 0 WHERE id = ?i LIMIT 1';
  	    $data = $this->DB->query($q,
   	                                    array(
   	                                          Special_Vtor_Tables::$houses,
   	                                          $this->_data['id']),
   	                                    Dune_MysqliSystem::RESULT_AR);
    }

    public function setUpdateToDo($id = null)
    {
        if (is_null($id))
        {
            if ($this->_data === false)
                return false;
            $id = $this->_data['id'];
        }
        $q = 'UPDATE ?t SET `to_update` = 1 WHERE id = ?i LIMIT 1';
  	    $data = $this->DB->query($q,
   	                                    array(
   	                                          Special_Vtor_Tables::$houses,
   	                                          $id),
   	                                    Dune_MysqliSystem::RESULT_AR);
   	    return $data;
    }
    
    
    protected function _update($type, $data, $rooms_count)
    {
        $set = new Dune_Mysqli_Collector_Set($this->DB);
        if ($type == 1)
        {
            $count_name = 'count_room';
            $price_max_metre = 'price_max_metre_room';
            $price_min_metre = 'price_min_metre_room';
            $space_total_max = 'space_total_max_room';
            $space_total_min = 'space_total_min_room';
        }
        else if ($type == 4)
        {
            $count_name = 'count_nolife';
            $price_max_metre = 'price_max_metre_nolife';
            $price_min_metre = 'price_min_metre_nolife';
            $space_total_max = 'space_total_max_nolife';
            $space_total_min = 'space_total_min_nolife';
        }
        else if ($type == 5)
        {
            $count_name = 'count_pantry';
            $price_max_metre = 'price_max_metre_pantry';
            $price_min_metre = 'price_min_metre_pantry';
            $space_total_max = 'space_total_max_pantry';
            $space_total_min = 'space_total_min_pantry';
        }
        
        else 
        return false;
        
        if ($type == 1)
        { 
            $set->assign('count_room_1', $rooms_count[1] , 'i');
            $set->assign('count_room_2', $rooms_count[2] , 'i');
            $set->assign('count_room_3', $rooms_count[3] , 'i');
            $set->assign('count_room_4', $rooms_count[4] , 'i');
        }
        
        $set->assign($count_name, $data['count'] , 'i');
        $set->assign($price_max_metre, $data['price_max_metre'] , 'i');
        $set->assign($price_min_metre, $data['price_min_metre'] , 'i');
        $set->assign($space_total_max, $data['space_total_max'] , 'i');
        $set->assign($space_total_min, $data['space_total_min'] , 'i');
        
        $q = 'UPDATE ?t 
        ' . $set->get()  . ' 
        WHERE id = ?i LIMIT 1';
        
  	    $data = $this->DB->query($q,
   	                                    array(
   	                                          Special_Vtor_Tables::$houses,
   	                                          $this->_data['id']),
   	                                    Dune_MysqliSystem::RESULT_AR);
//    echo $this->DB;
//    die();
    }
    
////////////////////////////////////////////////////////////////
///////////////////////////////     Магические методы
    public function __set($name, $value)
    {
        throw new Dune_Exception_Base('Низя');
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
    

}