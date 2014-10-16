<?php
/**
 * 
 * Контейнер адреса..
 * 
 */
class Special_Vtor_AdressLine
{
    protected $DB = null;
    protected $_beginPoint;
    protected $_id;
    
    protected $_dataStreet      = false;
    protected $_dataArea        = false;
    protected $_dataRegion      = false;
    protected $_dataDistrict    = false;
    protected $_dataSettlement  = false;
    
                                    
    public static $tableObject          = 'unity_catalogue_object';
                                        
    public static $tableAdressRegion       = 'unity_catalogue_adress_region';
    public static $tableAdressArea         = 'unity_catalogue_adress_area';
    public static $tableAdressSettlement   = 'unity_catalogue_adress_settlement';
    public static $tableAdressDistrict     = 'unity_catalogue_adress_district';
    public static $tableAdressStreet       = 'unity_catalogue_adress_street';
    
    const POINT_STREET     = 'street';
    const POINT_DISTRICT   = 'district';
    const POINT_SETTLEMENT = 'settlement';
    const POINT_AREA       = 'area';
    const POINT_REGION     = 'region';
    
	public function __construct($id, $begin_point = 'street')
	{
        $this->DB = Dune_MysqliSystem::getInstance();
        $this->_beginPoint = $begin_point;
        $this->_id = $id;
        $this->_get();
	}


	
	public function getDataRegion()
	{
	    return $this->_dataRegion;
	}
	public function getDataArea()
	{
	    return $this->_dataArea;
	}
	public function getDataSettlement()
	{
	    return $this->_dataSettlement;
	}
	public function getDataDistrict()
	{
	    return $this->_dataDistrict;
	}
	public function getDataStreet()
	{
	    return $this->_dataStreet;
	}

	
	
	
	protected function _get()
	{
		$id = $this->_id;
	    switch ($this->_beginPoint)
	    {
	        case 'street':
                $q = 'SELECT * 
                      FROM ?t
                      WHERE id = ?i
                      ';
                $this->_dataStreet = $this->DB->query($q, array(self::$tableAdressStreet, $id), Dune_MysqliSystem::RESULT_ROWASSOC);
                if ($this->_dataStreet)
                {
                    $id_settlement = $this->_dataStreet['settlement_id'];
                    $id = $this->_dataStreet['district_id'];
                }
                else 
                    break;
                    
        
	        case 'district':
	            if ($id)
	            {
                    $q = 'SELECT * 
                          FROM ?t
                          WHERE id = ?i
                          ';
                    $this->_dataDistrict = $this->DB->query($q, array(self::$tableAdressDistrict, $id), Dune_MysqliSystem::RESULT_ROWASSOC);
                    if ($this->_dataDistrict)
                    {
                        $id = $this->_dataDistrict['settlement_id'];
                    }
                    else 
                        break;
	            }
	            else 
	            {
	                $id = $id_settlement;
	            }
	            
            case 'settlement':
                $q = 'SELECT * 
                      FROM ?t
                      WHERE id = ?i
                      ';
                $this->_dataSettlement = $this->DB->query($q, array(self::$tableAdressSettlement, $id), Dune_MysqliSystem::RESULT_ROWASSOC);
                if ($this->_dataSettlement)
                {
                    $id = $this->_dataSettlement['area_id'];
                }
                else 
                    break;
            
            case 'area':
                $q = 'SELECT * 
                      FROM ?t
                      WHERE id = ?i
                      ';
                $this->_dataArea = $this->DB->query($q, array(self::$tableAdressArea, $id), Dune_MysqliSystem::RESULT_ROWASSOC);
                if ($this->_dataArea)
                {
                    $id = $this->_dataArea['region_id'];
                }
                else 
                    break;
        
            
            
            case 'region':
                $q = 'SELECT * 
                      FROM ?t
                      WHERE id = ?i
                      ';
                $this->_dataRegion = $this->DB->query($q, array(self::$tableAdressRegion, $id), Dune_MysqliSystem::RESULT_ROWASSOC);
                if ($this->_dataRegion !== false)
                {
                    $id = $this->_dataArea['region_id'];
                }
                else 
                    break;
	    }

	}	
	
}