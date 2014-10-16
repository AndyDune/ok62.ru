<?php
/**
 * 
 * ������ ������ ������� � �������� ��������
 * 
 */
class Special_Vtor_Catalogue_Url_Collector
{
    
    protected $_districtPlus = false;
    
    protected $_type = 0;
    protected $_mode = '';
    protected $_object = 0;
    protected $_adress = array(1 => 0, 0, 0, 0, 0, 0);
    protected $_house = array(0, 0, 0);
    protected $_string = '/';
    protected $_adressFlag = false;
    protected $_adressWord = false;
    protected $_page = 0;
    
    /**
     * ��������� ��������� ����� ��� ����������.
     *
     * @param unknown_type $command
     */
	public function __construct($command = 'catalogue')
	{
	    $this->_string .= $command;
	}
	
	/**
	 * ���������� ��� �������
	 *
	 * @return string
	 */
	public function setType($value)
	{
	    $this->_type = $value;
	}
	/**
	 * ���������� ��� �������
	 *
	 * @return string
	 */
	public function setMode($value)
	{
	    $this->_mode = $value;
	    return $this;
	}

	
	/**
	 * ���������� ��� �������
	 *
	 * @return integer
	 */
	public function setAdress(Special_Vtor_Adress $value)
	{
	    $this->_adressFlag = true;
	    $this->_adress[1] = $value->getRegionId();
	    $this->_adress[2] = $value->getAreaId();
	    $this->_adress[3] = $value->getSettlementId();
	    $this->_adress[4] = $value->getDistrictId();
	    $this->_adress[5] = $value->getStreetId();
	    
	    $this->_house[0] = $value->getHouse();
	    $this->_house[1] = $value->getBuilding();
	    $this->_house[2] = $value->getGroup();
	    
	    $this->_districtPlus = $value->getDistrictPlus();
	    
	    return $this;
	}

	/**
	 * ���������� ��� �������
	 *
	 * @return integer
	 */
	public function setAdressWord($plus = false)
	{
	    $this->_adressWord = true;
	    $this->_districtPlus = $plus;
	    return $this;
	}
	
	
	/**
	 * ���������� ��� �������
	 *
	 * @return integer
	 */
	public function setRegion($value)
	{
	    $this->_adressFlag = true;
	    $this->_adress[1] = $value;
	    return $this;
	}
	
	/**
	 * ���������� ��� ������ � �������.
	 *
	 * @return integer
	 */
	public function setArea($value)
	{
	    $this->_adressFlag = true;
	    $this->_adress[2] = $value;
	    return $this;
	}

	/**
	 * ���������� ��� ������, ������, �������
	 *
	 * @return integer
	 */
	public function setSettlement($value)
	{
	    $this->_adressFlag = true;
	    $this->_adress[3] = $value;
	    return $this;
	}
	
	/**
	 * ��������� ��� ������ � ������.
	 *
	 * @return integer
	 */
	public function setDistrict($value, $plus = false)
	{
	    $this->_districtPlus = $plus;
	    $this->_adressFlag = true;
	    $this->_adress[4] = $value;
	    return $this;
	}
	/**
	 * ��������� ����� ��� ������.
	 *
	 * @return boolean
	 */
	public function setPlus($value = true)
	{
	    $this->_districtPlus = $value;
	    return $this;
	}
	
	/**
	 * �������� ��� �����.
	 *
	 * @return integer
	 */
	public function setStreet($value)
	{
	    $this->_adressFlag = true;
	    $this->_adress[5] = $value;
	    return $this;
	}

	/**
	 * ��������� ����� ����.
	 *
	 * @return integer
	 */
	public function setHouse($value)
	{
	    $this->_adressFlag = true;
	    $this->_house[0] = $value;
	    return $this;
	}

	/**
	 * ��������� ����� ������� ����.
	 *
	 * @return integer
	 */
	public function setBuilding($value)
	{
	    $this->_adressFlag = true;
	    $this->_house[1] = $value;
	    return $this;
	}

	/**
	 * ��������� ����� ������.
	 *
	 * @return integer
	 */
	public function setGroup($value)
	{
	    $this->_adressFlag = true;
	    $this->_house[2] = $value;
	    return $this;
	}
	
	/**
	 * ��������� ������ ��������
	 *
	 * @return integer
	 */
	public function setPage($value)
	{
	    $this->_page = $value;
	    return $this;
	}
	
	/**
	 * ��������� ��� �������.
	 *
	 * @return integer
	 */
	public function setObject($value)
	{
	    $this->_object = $value;
	}
	
	public function get()
	{
	    $str = $this->_string;
	    if ($this->_type)
	       $str .= '/type/' . $this->_type;
	    if ($this->_adressFlag)
	    {
	        $this->_collectHouse();
	        if ($this->_districtPlus)
	           $str .= '/adress' . Special_Vtor_Settings::$districtPlusPostFix;
	        else 
	           $str .= '/adress';
	        
	        foreach ($this->_adress as $value)
	        {
	            $str .= '/' . $value;
	        }
	    }
	    else if ($this->_adressWord)
	    {
	        if ($this->_districtPlus)
	           $str .= '/adress' . Special_Vtor_Settings::$districtPlusPostFix;
	        else 
	           $str .= '/adress';
	        
	    }
	    if ($this->_object)
	       $str .= '/object/' . $this->_object;
	    if ($this->_mode)
	       $str .= '/mode/' . $this->_mode;
	    if ($this->_page)
	       $str .= '/page/' . $this->_page;
        	    
	    return $str . '/';
	}
	
    public function __toString()
    {
    	return  $this->get();
    }
    
    protected function _collectHouse()
    {
        $str = '';
        if (isset($this->_house[0]))
        {
            $this->_house[0] = str_replace(array('/', '�', '�', '�', '�', '�', '�', '�', '�', '�'), array('.', 'a', 'b', 'c', 'd', 'e', 'f', 'f', 'g', 'i'), $this->_house[0]);
            if (!$this->_house[0])
                $this->_house[0] = 0;
        }
        else 
            $this->_house[0] = 0;
            
        if (isset($this->_house[1]))
        {
            $this->_house[1] = str_replace(array('/', '�', '�', '�', '�', '�', '�', '�', '�', '�'), array('.', 'a', 'b', 'c', 'd', 'e', 'f', 'f', 'g', 'i'), $this->_house[1]);
            if (!$this->_house[1])
                $this->_house[1] = 0;
            
        }
        else 
            $this->_house[1] = 0;
        
        if (isset($this->_house[2]))
        {
            if (!$this->_house[2])
                $this->_house[2] = 0;
            
        }
        else 
            $this->_house[2] = 0;
        
        foreach ($this->_house as $key => $value)
        {
            if ($key)
                $str .= '-';
            $str .= $value;
        }
        $this->_adress[6] = $str;
    }
	

}