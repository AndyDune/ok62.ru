<?php
/**
 * 
 * Список конкурирующих.
 * 
 */
class Special_Vtor_Nearby_Group
{
    protected $_DB = null;
    
    protected $_status = null;
    protected $_id;
    protected $_userId = 0;
    protected $_data = null;
    
    protected $_name = '';
    protected $_text = '';
    
    protected $_orderString = '';
                        
    public static $tableGroups    = 'unity_catalogue_object_builder_look_groups';
    public static $tableCorr      = 'unity_catalogue_object_builder_look_corr';
    public static $tableObjects   = 'unity_catalogue_object';
    
    
	public function __construct($id = null)
	{
	    $this->_id = $id;
	    $this->_DB = Dune_MysqliSystem::getInstance();
	}

/////////////////////////////////////////////////////////////////////////////////    
    
    public function getData()
    {
        if (is_null($this->_data))
        {
            $q = 'SELECT * FROM ?t WHERE id = ?i';
            $this->_data = new Dune_Array_Container($this->_DB->query($q, array(self::$tableGroups, $this->_id), Dune_MysqliSystem::RESULT_ROWASSOC));
        }
        return $this->_data;
    }

    public function check()
    {
        if (is_null($this->_data))
        {
            $this->getData();
        }
        if (count($this->_data))
            return true;
        else 
            return false;
    }
    
    public function setName($value)
    {
        $this->_data['name'] = $value;
    }

    public function setOrder($value)
    {
        $this->_data['order'] = $value;
    }
    
    
    public function setText($value)
    {
        $this->_data['text'] = $value;
    }

    public function getText()
    {
        $this->getData();
        return $this->_data['text'];
    }

    public function getName()
    {
        $this->getData();
        return $this->_data['name'];
    }

    public function getOrder()
    {
        $this->getData();
        return $this->_data['order'];
    }
    
    public function getId()
    {
        return $this->_id;
    }
    
    public function delete()
    {
       $q = 'DELETE
             FROM ?t
             WHERE `id` = ?i';
       return $this->_DB->query($q, array(self::$tableGroups, $this->_id), Dune_MysqliSystem::RESULT_AR);
        
    }
    
    public function save()
    {
        if ($this->_id > 0)
        {
            $this->_replace();
        }
        else 
        {
            $this->_id = $this->_insert();
        }
        return $this->_id;
    }

    protected function _replace()
    {   
       $q = 'REPLACE
             INTO ?t
             SET `name` = ?,
                 `text` = ?,
                 `order` = ?i,
                  `id` = ?i';
       //$array = new Dune_Array_Container($this->_data);
       $array = $this->_data;
       return $this->_DB->query($q, array(self::$tableGroups, $array['name'], $array['text'],$array['order'], $this->_id), Dune_MysqliSystem::RESULT_AR);
    }
    protected function _insert()
    {   
       $q = 'INSERT
             INTO ?t
             SET name = ?,
                 text = ?,
                 `order` = ?i
                 ';
       //$array = new Dune_Array_Container($this->_data);
       $array = $this->_data;
       return $this->_DB->query($q, array(self::$tableGroups, $array['name'], $array['text'], $array['order'],), Dune_MysqliSystem::RESULT_ID);
    }

    
}