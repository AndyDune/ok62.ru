<?php
/**
 * 
 * ������ ��������.
 * 
 */
class Special_Vtor_Article_Comment_List extends Dune_Mysqli_Abstract_Connect
{ 
                        
    public static $table        = 'unity_article_comments';
    public static $tableArticle = 'unity_article_text';
    public static $tableUser    = 'dune_auth_user_active';
    
    protected $_article = null;
    protected $_section = null;
    protected $_parent = null;
    protected $_activity = 0;
    
    /**
     * ������ - ���������� ORDER BY
     *
     * @var Dune_Mysqli_Collector_Order
     */
    protected $_order = null;
    
	public function __construct($type = null)
	{
	    if (!is_null($type))
	       $this->_type = $type;
	    $this->_initDB();
	    $this->_order = new Dune_Mysqli_Collector_Order();
	}
	
	/**
	 * �������� ���� �������.
	 * 0 - ��� ������.
	 * 1 - ��� ��������.
	 *
	 * @param unknown_type $type
	 */
	public function setType($type)
	{
	    $this->_type = $type;
	    return $this;
	}

	
	/**
	 * �������� ��������.
	 *
	 * @param integer $value
	 */
	public function setArticle($value)
	{
	    $this->_article = $value;
	    return $this;
	}

	/**
	 * �������� ����������.
	 *
	 * @param integer $value
	 */
	public function setActivity($value = 1)
	{
	    $this->_activity = $value;
	    return $this;
	}
	
	
	/**
	 * �������� �������.
	 *
	 * @param unknown_type $type
	 */
	public function setSection($type)
	{
	    $this->_type = $type;
	    return $this;
	}
	
	/**
	 * �������
	 *
	 * @param string $field �������� ����
	 * @param ������� $order ASC ��� DESC
	 */
	public function setOrderInComment($field, $order = 'ASC')
	{
	    if ($order == 'ASC')
	       $this->_order->addASC($field, 'comment');
	    else 
	       $this->_order->addDESC($field, 'comment');
	    return $this;
	}

	/**
	 * �������
	 *
	 * @param string $field �������� ����
	 * @param ������� $order ASC ��� DESC
	 */
	public function setOrderInArticle($field, $order = 'ASC')
	{
	    if ($order == 'ASC')
	       $this->_order->addASC($field, 'text');
	    else 
	       $this->_order->addDESC($field, 'text');
	    return $this;
	    
	}
	
	
	public function getList($shift = 0, $limit = 100)
	{
	    $q = 'SELECT distinct(`comment`.`id`) as `comment_id`,
	                 `comment`.*,
	                 `text`.`id` as `text_id`,
	                 `text`.`name` as `text_name`,
	                 `user`.`id` as `ruser_id`,
	                 `user`.`name` as `ruser_name`,
	                 `user`.`time` as `ruser_time`,
	                 `user`.`contact_name` as `ruser_contact_name`
	          FROM `' . self::$table . '` as `comment`
	          LEFT JOIN `' . self::$tableUser . '` as `user` ON `user`.`id` = `comment`.`user_id`,
	          `' . self::$tableArticle . '` as `text`
	          ';
	    
//	    if (!is_null($this->_type))
//	       $q .= ' WHERE type = ' . (int)$this->_type;
	       
	    $where = new Dune_Mysqli_Collector_Where();
	    if (!is_null($this->_type))
	    {
	        $where->addSimpleField('type', 'text')->addCompare()->addSimpleData($this->_type, 'i');
	    }
	    
	    if (!is_null($this->_article))
	    {
	        $where->addAnd();
	        $where->addSimpleField('article_id', 'comment')->addCompare()->addSimpleData($this->_article, 'i');
	    }
	    if ($this->_activity)
	    {
	        $where->addAnd();
	        $where->addSimpleField('activity', 'comment')->addCompare()->addSimpleData(1, 'i');
	    }

	    
        $where->addAnd();
        $where->addSimpleField('article_id', 'comment')->addCompare()->addSimpleField('id', 'text');
	    
	    
	    $q .= $where->get();
	    $q .= $this->_order->get();
	    $q .= ' LIMIT ' . $shift . ', ' . $limit;
	    $result = $this->_DB->query($q, null, Dune_MysqliSystem::RESULT_IASSOC);
	    return $result;
	}

	public function getCount()
	{
	    $q = 'SELECT count(distinct(`comment`.`id`)) 
	          FROM `' . self::$table . '` as `comment`,
	          `' . self::$tableArticle . '` as `text`
               ';
	    
	    $where = new Dune_Mysqli_Collector_Where();
	    if (!is_null($this->_type))
	    {
	        $where->addSimpleField('type', 'text')->addCompare()->addSimpleData($this->_type, 'i');
	    }
	    if (!is_null($this->_article))
	    {
	        $where->addAnd();
	        $where->addSimpleField('article_id', 'comment')->addCompare()->addSimpleData($this->_article, 'i');
	    }
	    if ($this->_activity)
	    {
	        $where->addAnd();
	        $where->addSimpleField('activity', 'comment')->addCompare()->addSimpleData(1, 'i');
	    }
	    
        $where->addAnd();
        $where->addSimpleField('article_id', 'comment')->addCompare()->addSimpleField('id', 'text');
	    
	    $q .= $where->get();
	       
	    $result = $this->_DB->query($q, null, Dune_MysqliSystem::RESULT_EL);
	    return $result;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function getListInSection($shift = 0, $limit = 100)
	{
	    $q = 'SELECT text.* FROM `' . self::$table . '` as `text`, `' . self::$tableCorr . '` as `text_corr`';
	    
	    $where = new Dune_Mysqli_Collector_Where();
	    $where->addSimpleField('article_id', 'text_corr')->addCompare()->addSimpleField('id', 'text');
	    if (!is_null($this->_type))
	    {
	        $where->addSimpleField('type')->addCompare()->addSimpleData($this->_type, 'i');
	    }
	    if (!is_null($this->_section))
	    {
	        throw new Dune_Exception_Base('�� ������ ������ ��� �������');
	    }
	    if (!is_null($this->_parent))
	    {
	        $where->addAnd();
	        $where->addSimpleField('parent')->addCompare()->addSimpleData($this->_parent, 'i');
	    }
	    
	    $where->addAnd();
	    $where->addSimpleField('section_id', 'text_corr')->addCompare()->addSimpleData($this->_section, 'i');
	    
	    $q .= $where->get();
	    $q .= ' LIMIT ' . $shift . ', ' . $limit;
	    $result = $this->_DB->query($q, null, Dune_MysqliSystem::RESULT_IASSOC);
	    return $result;
	}
	

	public function getCountInSection()
	{
	    $q = 'SELECT count(distinct(text.id)) FROM `' . self::$table . '` as `text`, `' . self::$tableCorr . '` as `text_corr`';
	    
	    $where = new Dune_Mysqli_Collector_Where();
	    $where->addSimpleField('article_id', 'text_corr')->addCompare()->addSimpleField('id', 'text');
	    if (!is_null($this->_type))
	    {
	        $where->addAnd();
	        $where->addSimpleField('type')->addCompare()->addSimpleData($this->_type, 'i');
	    }
	    if (!is_null($this->_parent))
	    {
	        $where->addAnd();
	        $where->addSimpleField('parent')->addCompare()->addSimpleData($this->_parent, 'i');
	    }
	    
	    if (!is_null($this->_section))
	    {
	        throw new Dune_Exception_Base('�� ������ ������ ��� �������');
	    }
	    $where->addAnd();
	    $where->addSimpleField('section_id', 'text_corr')->addCompare()->addSimpleData($this->_section, 'i');
	    
	    $q .= $where->get();
	       
	       
	    $result = $this->_DB->query($q, null, Dune_MysqliSystem::RESULT_EL);
	    return $result;
	}
	

}