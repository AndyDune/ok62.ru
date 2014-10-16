<?php
/**
 * 
 * ������ ������ �� �������.
 * 
 */
class Special_Vtor_PrivateTalk_ListInterlocuter
{
    protected $_DB = null;
    
    protected $_activity = null;
    protected $_id;
    protected $_data = false;
    
    protected $_orderString = '';
                        
    public static $table          = 'unity_private_talk_topic_text';
    public static $tableUser      = 'dune_auth_user_active';
    
    protected $_interlocutorId = 0;
        
    protected $_topicCode = 0;
    protected $_topicId;
    
	public function __construct($id)
	{
	    $this->_id = $id;
	    $this->_DB = Dune_MysqliSystem::getInstance();
	}

	public function setInterlocutorId($id)
	{
	    $this->_interlocutorId = $id;
	}
	
    public function setActivity($value = null)
    {
        $this->_activity = (int)$value;
    }	
    
	public function setTopicId($id)
	{
	    $this->_topicId = $id;
	}

	public function setTopicCode($id)
	{
	    $this->_topicCode = $id;
	}
	
/////////////////////////////////////////////////////////////////////////////////    
    
    /**
     * ����� ������� � ����������� ���������
     *
     * @return integer
     */
    public function count()
    {
        $q = 'SELECT count(*) FROM `' . self::$table . '` as talk' . $this->_collectWhere();
        return $this->_DB->query($q, null, Dune_MysqliSystem::RESULT_EL);
    }
    

    
    /**
     * ������ ������� �� ������� � ����� ���������� �����������.
     * ����������� ������ � �� �������� ������ (����, �������).
     * ���������� ������ �������� �� ����������� ��� false.
     *
     * @param integer $shift �����
     * @param integer $limit ����������� ������� ��� �������
     * @return Dune_Mysqli_Iterator_ResultAssoc
     */
    public function getList()
    {
        $where = $this->_collectWhere();
        
        
        $q = 'SELECT user.*,
                     talk.time as talk_time,
                     MIN(talk.read) as talk_read
                     

             FROM '
           . $this->_setFromString()
           
           . $where
           . ' GROUP BY `user`.`id` '
           . $this->_orderString           
           ;

        return $this->_DB->query($q, null, Dune_MysqliSystem::RESULT_IASSOC);
    }
    
    
    protected function _addWhereSpecial()
    {
        return '';
    }

    protected function _setFromString()
    {
        $str = 
           ' `' .  self::$table . '` as talk,' 
           . ' `' . self::$tableUser . '` as user' 
           ;
        return $str;
    }
    
/////////////////////////////////////////////////////////////////////////////////    
///////     ����� ��������� ������� �������


    /**
     * ���������� ������� �������. ����� �������� ������.
     *
     * @param string $order ����������� ADC ��� DESC
     */
    public function setOrder($field, $order = 'ADC')
    {
        if (!$this->_orderString)
            $this->_orderString = ' ORDER BY ';
        else 
            $this->_orderString = ', ';
        $this->_orderString .= $field . ' ' . $order;
    }

    
    /**
     * ���������� ������� �������. ����� ��������� ������.
     *
     * @param string $order ����������� ADC ��� DESC
     */
    public function setOrderTime($order = 'ADC')
    {
        if (!$this->_orderString)
            $this->_orderString = ' ORDER BY';
        $this->_orderString .= ' talk.time ' . $order;
     }
    
    
    /**
     * �������� �������.
     */
    public function resetOrder()
    {
        $this->_orderString = '';
    }
    
////////////////////////////////////////////////////////////////////////
////////////        ���������� ������
    protected function _collectWhere()
    {
        $where = '';
        $where = $this->_addWhereSpecial();
        
        if ($where)
            $where .= ' AND ';
            
        $where .= 'talk.interlocutor_id = ' . $this->_id;
        $where .= ' AND talk.user_id = user.id';
        $where .= ' AND talk.topic_id = ' . $this->_topicId;
        $where .= ' AND talk.topic_code = ' . $this->_topicCode;
        if ($where)
            $where = ' WHERE ' . $where;
        return $where;
    }    
}