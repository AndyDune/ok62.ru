<?php
/**
 * 
 * Данные о добавляемом объекте.
 * 
 */
class Special_Vtor_Object_Query_Data extends Special_Vtor_Object_Query_Abstract_Data
{
    
	public function __construct($id = 0)
	{
	    $this->DB = Dune_MysqliSystem::getInstance();
	    $this->_id = $id;
	    if ($id)
	    {
	        $this->_haveSaved = $this->_getFromDb();
	    }
	}

}