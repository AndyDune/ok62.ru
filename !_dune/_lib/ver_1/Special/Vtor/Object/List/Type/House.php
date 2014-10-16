<?php
/**
 * 
 * ������ ������ �� �������.
 * 
 */
class Special_Vtor_Object_List_Type_House extends Special_Vtor_Object_List
{
    protected $_roomsCount = array(1 => 1, 2 => 1, 3 => 1, 4 => 1);
    protected $_floors     = array(0 => 0, 1 => 0, 2 => 0);
    
    protected $_houseType = array();
    
    protected $_condition = array();
    
    protected $_levels = 0;
    protected $_pics = 0;
    protected $_phone = 0;
    protected $_floorTo = 0;
    protected $_floorFrom = 0;

    protected $_valueFrom = 0;
    protected $_valueTo = 0;
    protected $_priceFrom = 0;
    protected $_priceTo = 0;
    protected $_deal = null;

    protected $_newBuilding = null;
    protected $_panorama = null;
    protected $_plan = null;
    
    protected $_typeAdd = array();
    
    protected $_land = null;
    protected $_garage = null;
    protected $_bath = null;
    protected $_wall = null;
    
    public function setHouseType($value)
    {
        if (is_array($value))
            $this->_houseType = $value;
        else 
        {
            $this->_houseType[] = (int)$value;
        }
    }
    
    public function setRoomsCountArray($array)
    {
        $this->_roomsCount = $array;
    }

    public function setFloors($array)
    {
        $this->_floors = $array;
    }
    
    
    public function setDeal($value = null)
    {
        $this->_deal = $value;
    }
    
    
    public function setConditionArray($array)
    {
        $this->_condition = $array;
    }

    public function setLevels($value = 1)
    {
        $this->_levels = $value;
    }

    public function setPhoto($value = 1)
    {
        $this->_pics = $value;
    }
    
    public function setPhone($value = 1)
    {
        $this->_phone = $value;
    }

    /**
     * ���������� ����.
     *
     * @param integer $value �����, �������� �� ����
     */
    public function setPlan($value = 1)
    {
        $this->_plan = $value;
    }

    /**
     * ���� ����.
     *
     * @param integer $value �����, �������� �� ����
     */
    public function setBath($value = true)
    {
        $this->_bath = $value;
    }
    
    /**
     * ����� ����.
     *
     * @param integer $value �����, �������� �� ����
     */
    public function setLand($value = true)
    {
        $this->_land = $value;
    }

    /**
     * ����� ����.
     *
     * @param integer $value �����, �������� �� ����
     */
    public function setGarage($value = 1)
    {
        $this->_garage = (int)$value;
    }

    /**
     * �������� ������ ���.
     *
     * @param integer $value �����, �������� �� ����
     */
    public function setWall($value)
    {
        $this->_wall[] = (int)$value;
        return $this;
    }

    
    /**
     * �������� ������ ���.
     *
     * @param integer $value �����, �������� �� ����
     */
    public function setTypeAdd($value)
    {
        $this->_typeAdd[] = (int)$value;
        return $this;
    }
    
    
    /**
     * �������� ����.
     *
     * @param integer $value �����, �������� �� ����
     */
    public function setPanorama($value = 1)
    {
        $this->_panorama = $value;
    }

    /**
     * ���� ����� ���� ������.
     *
     * @param integer $value
     */
    public function setNewBuilding($value = 0)
    {
        $this->_newBuilding = (int)$value;
    }
    
    
    public function setFloorTo($value = -1)
    {
        $this->_floorTo = $value;
    }
    
    public function setFloorFrom($value = -1)
    {
        $this->_floorFrom = $value;
    }

    public function setValueTo($value = 0)
    {
        $this->_valueTo = $value;
    }
    
    public function setValueFrom($value = 0)
    {
        $this->_valueFrom = $value;
    }

    public function setPriceTo($value = 0)
    {
        $this->_priceTo = $value;
    }
    
    public function setPriceFrom($value = 0)
    {
        $this->_priceFrom = $value;
    }
    
    
    protected function _addWhereSpecial()
    {
        $q = '';
        $str = '';
        
        if ($this->_levels)
            $q = ' objects.levels > 1';

        if ($this->_pics)
        {
            if ($q)
                $q .= ' AND ';
            $q .= ' (objects.pics > 0 OR objects.have_photo_house > 0)';
        }

        if (count($this->_typeAdd))
        {
            if ($q)
                $q .= ' AND ';
            $temp = implode(',', $this->_typeAdd);

             $q .= ' objects.type_add IN (' . $temp . ')' ;
        }

        if (count($this->_wall))
        {
            if ($q)
                $q .= ' AND ';
            $temp = implode(',', $this->_wall);

             $q .= ' objects.type_wall IN (' . $temp . ')' ;
        }
        
        
        if ($this->_plan)
        {
            if ($q)
                $q .= ' AND ';
            $q .= ' objects.have_plan > 0';
        }

        if ($this->_garage)
        {
            if ($q)
                $q .= ' AND ';
            $q .= ' objects.garage > 0';
        }
        if ($this->_bath)
        {
            if ($q)
                $q .= ' AND ';
            $q .= ' objects.have_bath = 1';
        }
        if ($this->_land)
        {
            if ($q)
                $q .= ' AND ';
            $q .= ' objects.have_land = 1';
        }

        
        
        if ($this->_panorama)
        {
            if ($q)
                $q .= ' AND ';
            //$q .= ' objects.have_panorama > 0';
            $q .= ' (objects.have_panorama > 0 OR objects.panorama > 0)';
        }

        if (!is_null($this->_newBuilding))
        {
            if ($q)
                $q .= ' AND ';
            $q .= ' objects.new_building_flag = ' . (int)$this->_newBuilding;
        }
        
        
        
        if (!is_null($this->_deal) and $this->_deal < 2)
        {
            if ($q)
                $q .= ' AND ';
            $q .= ' (objects.deal = ' . (int)$this->_deal . ' OR objects.deal = 2)';
        }
        
        
        if ($this->_valueFrom)
        {
            if ($q)
                $q .= ' AND ';
            $q .= ' objects.space_total >= ' . (int)$this->_valueFrom;
        }

        if ($this->_valueTo)
        {
            if ($q)
                $q .= ' AND ';
            $q .= ' objects.space_total <= ' . (int)$this->_valueTo;
        }

        $price_to = false;
        if ($this->_priceTo)
        {
            if ($q)
                $q .= ' AND ';
            $q .= ' objects.price <= ' . $this->_priceTo;
            $price_to = true;
        }
        
        
        if ($this->_priceFrom)
        {
            if ($q)
                $q .= ' AND ';
            $q .= ' objects.price >= ' . $this->_priceFrom;
        }
        else if ($price_to)
        {
            $q .= ' AND ';
            $q .= ' objects.price >= 500';
        }
        
        
        
        if ($this->_floorFrom != 0)
        {
            if ($q)
                $q .= ' AND ';
            if ($this->_floorFrom > 0)
                $q .= ' objects.floor >= ' . (int)$this->_floorFrom;
            else 
                $q .= ' objects.floor > 1';
        }

        if ($this->_floorTo != 0)
        {
            if ($q)
                $q .= ' AND ';
            if ($this->_floorTo > 0)
                $q .= ' objects.floor <= ' . (int)$this->_floorTo;
            else 
                $q .= ' objects.floor < objects.floors_total';
        }
        
        
        if ($this->_phone)
        {
            if ($q)
                $q .= ' AND ';
            $q .= ' objects.have_phone > 0';
        }
            
        foreach ($this->_roomsCount as $key => $value)
        {
            if ($value)
            {
                if ($str)
                    $str .= ', ';
                $str .= (int)$key;
            }
        }
        if ($str)
        {
            if ($q)
                $q .= ' AND ';
            $q .= ' objects.rooms_count IN (' . $str . ')';
        }
    
        $str = '';
        if ($this->_floors[0])
            $str .= ' objects.floors_total > 2 ';
        if ($this->_floors[1])
        {
            if ($str)
                $str .= ' OR';
            $str .= ' objects.floors_total= 1 ';
        }
        if ($this->_floors[2])
        {
            if ($str)
                $str .= ' OR';
            $str .= ' objects.floors_total = 2 ';
        }            
        
        if ($str)
        {
            if ($q)
                $q .= ' AND';
            $q .= ' (' . $str . ')';
        }
        
        
        $str = '';
        foreach ($this->_houseType as $key => $value)
        {
                if ($str)
                    $str .= ', ';
                $str .= (int)$value;
        }
        if ($str)
        {
            if ($q)
                $q .= ' AND ';
            $q .= ' objects.type_house  IN (' . $str . ')';
        }   
        
        
        $str = '';
        foreach ($this->_condition as $key => $value)
        {
                if ($str)
                    $str .= ', ';
                $str .= (int)$value;
        }
        if ($str)
        {
            if ($q)
                $q .= ' AND ';
            $q .= ' objects.condition  IN (' . $str . ')';
        }   
        
        
        return $q;
    }
    
}