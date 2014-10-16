<?php
/**
 * 
 * 
 * 
 */
class Special_Vtor_Catalogue_Url_Parsing
{
    protected $_districtPlus = false;
    
    protected $_type = 0;
    protected $_mode = '';
    protected $_object = 0;
    protected $_adress = array(1 => 0, 0, 0, 0, 0, 0);
    protected $_house = array(1 => '', '', 0);
    
    protected $_page = 0;
    
	public function __construct($string = '')
	{
	    $adress_command_plus = 'adress' . Special_Vtor_Settings::$districtPlusPostFix;
	    if ($string)
	    {
	       $url = new Dune_String_Explode($string, '/');
	    }
	    else 
	       $url = Dune_Parsing_UrlSingleton::getInstance();
	    $find_type = false;
	    $find_adress = 0;
	    $find_object = false;
	    $find_page = false;
	    $find_mode = false;
	    foreach ($url as $key => $value)
	    {
	        
//	        echo $key, '=>', $value, '<br />';
	        
	        if ($key == 1 and !$string)
	           continue;// пропускаем 1-ю комманду
	        if ($value[0] == 't')
	        {
	            $find_adress = 0;
	            $find_type = true;
	            continue;
	        }
	        if ($find_type)
	        {
	            $find_type = false;
	            $this->_type = (int)$value;
	            if ($this->_type > 0)
	               continue;
	            
	        }
	        if ($find_mode)
	        {
	            $find_mode = false;
	            $this->_mode = $value;
	            if ($this->_mode)
	               continue;
	        }
	        
	        if ($find_page)
	        {
	            $find_page = false;
	            $this->_page = (int)$value;
	            if ($this->_page > 0)
	               continue;
	        }
	        
	        if ($find_object)
	        {
	            $find_object = false;
	            $this->_object = (int)$value;
	            if ($this->_object > 0)
                    continue;
	        }
	        
	        if ($value[0] == 'a')
	        {
	            if (strcmp($value, $adress_command_plus) === 0)
	            {
	                $this->_districtPlus = true;
	            }
	            $find_adress = 1;
	            $find_mode = false;
	            continue;
	        }
	        if ($value[0] == 'o')
	        {
	            $find_adress = 0;
	            $find_object = true;
	            $find_mode = false;
	            continue;
	        }
	        if ($value[0] == 'p')
	        {
	            $find_adress = 0;
	            $find_page = true;
	            $find_mode = false;
	            continue;
	        }
	        if ($value[0] == 'z')
	        {
	            $find_adress = 0;
	            $find_page = false;
	            $find_mode = false;
	            continue;
	        }

	        if ($value[0] == 'm')
	        {
	            $find_adress = 0;
	            $find_object = false;
	            $find_page = false;
	            $find_mode = true;
	            continue;
	        }
	        
	        if ($find_adress)
	        {
	            $this->_adress[$find_adress] = $value;
	            $find_adress++;
	        }
	           
	    }
	    if ($this->_adress[6])
	    {
	        $adress = new Dune_String_Explode($this->_adress[6], '-');
	        if ($adress->count() > 0)
	        {
	            $x = 1;
	            foreach ($adress as $value)
	            {
	               $this->_house[$x] = $value;
	               $x++;
	            }
                $this->_house[1] = str_replace(array('.', 'a', 'b', 'c', 'd', 'e', 'f', 'f', 'g', 'i'), array('/', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з'),  $this->_house[1]);
                $this->_house[2] = str_replace(array('.', 'a', 'b', 'c', 'd', 'e', 'f', 'f', 'g', 'i'), array('/', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з'),  $this->_house[2]);
                $this->_house[1] = htmlspecialchars($this->_house[1]);
                $this->_house[2] = htmlspecialchars($this->_house[2]);
                if (isset($this->_house[3]))
                    $this->_house[3] = (int)$this->_house[3];
                 else 
                    $this->_house[3] = 0;
	        }
	        else 
	        {
	            $this->_house[1] = htmlspecialchars($this->_adress[6]);
	            $this->_house[1] = str_replace(array('.', 'a', 'b', 'c', 'd', 'e', 'f', 'f', 'g', 'i'), array('/', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з'),  $this->_house[1]);
	        }
	        
	    }
	}
	
	/**
	 * Возвращает тип Объекта
	 *
	 * @return string
	 */
	public function getType()
	{
	    return $this->_type;
	}

	
	/**
	 * Возвращает комманду после mode
	 *
	 * @return string
	 */
	public function getMode()
	{
	    return $this->_mode;
	}
	
	/**
	 * Возвращает код области
	 *
	 * @return integer
	 */
	public function getRegion()
	{
	    return (int)$this->_adress[1];
	}
	
	/**
	 * Возвращает код района в области.
	 *
	 * @return integer
	 */
	public function getArea()
	{
	    return (int)$this->_adress[2];
	}

	
	
	/**
	 * Возвращает код города, посёлка, деревни
	 *
	 * @return integer
	 */
	public function getSettlement()
	{
	    return (int)$this->_adress[3];
	}
	
	/**
	 * Возвращает код района в городе.
	 *
	 * @return integer
	 */
	public function getDistrict()
	{
	    return (int)$this->_adress[4];
	}

	/**
	 * А есть ли дистрикт плюс.
	 *
	 * @return boolean
	 */
	public function isDistrictPlus()
	{
	    return $this->_districtPlus;
	}
	
	
	/**
	 * Возвращает код улицы.
	 *
	 * @return integer
	 */
	public function getStreet()
	{
	    return (int)$this->_adress[5];
	}

	/**
	 * Возвращает номер дома.
	 *
	 * @return integer
	 */
	public function getHouse()
	{
	    //return $this->_adress[6];
	    if (!$this->_house[1])
	       return '';
	    return $this->_house[1];
	}

	/**
	 * Возвращает номер корпуса дома.
	 *
	 * @return integer
	 */
	public function getBuilding()
	{
	    //return $this->_adress[6];
	    if (!$this->_house[2])
	       return '';
	    return $this->_house[2];
	}
	
	/**
	 * Возвращает номер группы.
	 *
	 * @return integer
	 */
	public function getGroup()
	{
	    return $this->_house[3];
	}
	
		
	/**
	 * Возвращает код объекта.
	 *
	 * @return integer
	 */
	public function getObject()
	{
	    return $this->_object;
	}
	
	/**
	 * Возвращает страницы
	 *
	 * @return integer
	 */
	public function getPage()
	{
	    return $this->_page;
	}
	
	

}