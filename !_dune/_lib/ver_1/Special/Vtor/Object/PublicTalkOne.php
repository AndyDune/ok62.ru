<?php
/**
 * 
 * Список данных об объекте.
 * 
 */
class Special_Vtor_Object_PublicTalkOne
{
    protected $_DB = null;
    
    protected $_activity = null;
    protected $_id;
    protected $_data = false;
    protected $_text = '';
    protected $_object_id = '';
    protected $_user_id = '';
    
                        
    public static $table          = 'unity_catalogue_object_public_talk';
    public static $tableUser      = 'dune_auth_user_active';
    
    
	public function __construct($id = null)
	{
	    $this->_id = $id;
	    $this->_DB = Dune_MysqliSystem::getInstance();
	}
	
	public function setUserId($id)
	{
	    $this->_user_id = $id;
	}
	
	public function setObjectId($id)
	{
	    $this->_object_id = $id;
	}
	
	public function setText($text)
	{
	    $this->_text = htmlspecialchars($text);
	    $this->_text = str_replace("\n", '<br />', $this->_text);
	}
	public function add()
	{
	    $q = 'INSERT INTO ?t SET object_id = ?i, user_id = ?i, text = ?';
	    return $this->_DB->query($q, array(self::$table, $this->_object_id, $this->_user_id, $this->_text), Dune_MysqliSystem::RESULT_ID);
	}
    

/////////////////////////////////////////////////////////////////////////////////    
    
    
}