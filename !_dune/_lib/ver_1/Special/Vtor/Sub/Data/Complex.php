<?php
/**
 * 
 * Данные об объекте.
 * 
 */
class Special_Vtor_Sub_Data_Complex
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
        	    $q = 'SELECT complex.*,
        	                 
        	                 region.name     as name_region,
        	                 area.name       as name_area,
        	                 settlement.name as name_settlement,
        	                 settlement.type as type_settlement,
        	                 
        	                 district.name        as name_district,
        	                 district_plus.name   as name_district_plus,
        	                 street.name          as name_street,
        	                 street.adding        as street_adding
        	                 
        	                 
        	          FROM ?t as `complex`'; 
        	            $q .= ',';
        	               
//        	            $q .= ' `' . Special_Vtor_Tables::$group . '` as `group`,';
        	            $q .= ' `' . Special_Vtor_Tables::$adressDistrictPlus . '` as `district_plus`,
        	               
        	               ?t as region,
        	               ?t as area,
        	               ?t as settlement,
        	               ?t as district,
        	               ?t as street
        	               
        	          WHERE `complex`.`id` = ?i
        	                AND
        	                complex.street_id = street.id
        	                AND
        	                complex.district_id = district.id
        	                AND
        	                complex.region_id = region.id
        	                AND
        	                complex.area_id = area.id
        	                AND
        	                complex.settlement_id = settlement.id
        	                AND
        	                complex.district_plus_id = district_plus.id ';
        	            
//        	        $q .= ' AND house.complex_id = group.id ';
        	        $q .= '  LIMIT 1';
        	    $this->_data = $this->DB->query($q,
        	                                    array(Special_Vtor_Tables::$group,
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
            return new Dune_Array_Container($this->_data);
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
        $results = array(
            'count_room_total'   => 0,
            'count_nolife_total' => 0,
            'count_pantry_total' => 0,
            'count_room'   => 0,
            'count_nolife' => 0,
            'count_pantry' => 0,
        );
        $houses = new Special_Vtor_Sub_List_House();
        $houses->setComplex($this->_id);
        
        $list_houses = $houses->getDataStatistic();
        unset($houses);
        
        if (count($list_houses))
        {
            foreach ($list_houses as $one_house)
            {
                if ($one_house['to_update'])
                {
                    $house = new Special_Vtor_Sub_Data_House($one_house['id']);
                    $data = $house->getInfo();
                    if ($data['count_room_total'])
                    {
                        $house->update(1);
                    }
                    if ($data['count_nolife_total'])
                    {
                        $house->update(4);
                    }
                    if ($data['count_pantry_total'])
                    {
                        $house->update(5);
                    }
                    $house->setUpdateDone();
                    $house = new Special_Vtor_Sub_Data_House($one_house['id']);
                    $data = $house->getInfo(false);
                }
                else 
                {
                    $data = $one_house;
                }
                foreach ($results as $key => $value)
                {
                    $results[$key] = $value + (int)$data[$key];
                }
            }
            $results['count_house'] = count($list_houses);
            $this->_update($results);
        }
        
       	return true;
        
    }
    

    protected function _update($data)
    {
        $set = new Dune_Mysqli_Collector_Set($this->DB);
        foreach ($data as $key => $value)
        {
            $set->assign($key, $value , 'i');
        }
        $set->assign('to_update', 0 , 'i');
        $q = 'UPDATE ?t 
        ' . $set->get()  . ' 
        WHERE id = ?i LIMIT 1';
        
  	    $data = $this->DB->query($q,
   	                                array(
   	                                      Special_Vtor_Tables::$group,
   	                                      $this->_id
   	                                      ),
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