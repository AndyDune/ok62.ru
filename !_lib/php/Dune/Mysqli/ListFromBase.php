<?
/**
 * ����� ��� ������ � ����� �������� � ����
 * 
 * ������ ���������� � ����� ������ �������� � ������� ������ ������ Dune_MysqliSystem::getInstance()
 * 
 * 
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: ListFromBase.php                            |
 * | � ����������: Dune/Mysqli/ListFromBase.php        |
 * | �����: ������ ����� (Dune) <dune@pochta.ru>       |
 * | ������: 1.03                                      |
 * | ����: www.rznlf.ru                                |
 * ----------------------------------------------------
 * 
 * ������ 1.02 -> 1.03
 * ----------------------
 * 1) ��������� ����� save() - ��� �������� �������� ��������� ���� = 0 ����������� ����� ����
 * 2) ��������� ����� save() - ������� ������� �������� ���������� ($array, $id)
 * 3) ��������� ����� addRecordKnownId() - ��� �������� ���������� $id = 0 ������ ������ � ������ � ����� ������������� id
 * 4) ��������� ����� addRecord() - ������������� id ����������� ������ � ���������� $ID
 * 
 * ������� ������:
 * -----------------
 * ������ 1.01 -> 1.02
 * ��������� ��������� ������ ������ ������ addRecordKnownId()
 * ��� ����������� ��� ������������ ����� �� ��������� ������������ false
 * ��� ������ ������. ������ setExceptionOn() - ��������� ����������
 * 
 */
class Dune_Mysqli_ListFromBase implements Iterator
{
	private $tableName; // ��� ������� �� ������� �������
	private $tableExist = false; // ���� ������������� �������
	private $tableFields = 0; // ����� ����� � �������
	private $totalNumberRows = false; // ����� ����� � �������
	private $numberRowsWithCondition = false; // ����� ����� � ������� c ���������
	private $orderString = ''; // ������ ��� ������� �������
	private $whereString = ''; // ������ ��� ������� �������
	private $ID = 0; // ����� �������� �������
	private $keyField = 'id'; // ��� ��������� ����
	private $oneRow = false; // ������ � ������ ����� ������
	private $list = false; // ����� � ����������� �� �������
	private $listCurrentKey = 0;
	
	private $numberRowsInList = 0; // ������� �������
	private $fieldList = array();// ����� �� ������� ����� ��� ������� 
	private $queryLimitNumber = 10;
	private $queryLimitShift = 0;
	
	private $fieldListString = '*';
	private $fieldListArray = array();
	
	static protected $exceptionOn = false;
	
	const ERROR_CODE_ON_DEFK = 1062;
	
	private $db; // ������ ��������� �� ������ ������� ������ Dune_MysqliSystem
	

/**
 * �����������.
 * ����������� ��� ������� � ������� ����� ��������
 *
 * @param string $t_name ��� �������
 */
public function __construct($t_name = '')
{
	$this->tableName = $t_name;
	$this->db = Dune_MysqliSystem::getInstance();
}

/**
 * ������� ��������� �������.
 * 
 * ������������� �������� �� ���������.
 * ������� ���������� ������ ��������.
 *
 */
public function clear()
{
	$this->whereString = '';
	$this->orderString = '';
	$this->queryLimitShift = 0;
	$this->queryLimitNumber = 10;
	$this->list = false;
	$this->oneRow = false;
	$this->totalNumberRows = false;
	$this->numberRowsWithCondition = false;
}

/**
 * ��������� ����� ��������� ����������
 * �� ��������� - ��������
 *
 * @param boolean $val
 */
static public function setExceptionOn($val = true)
{
    self::$exceptionOn = $val;
}


/**
 * �������� ������������� �������, � ������� �������� ������
 *
 * @return boolean
 */
public function existTable()
{
    $q = 'SELECT 1 FROM `'.$this->tableName.'` WHERE 0';
    
	if ($this->db->query($q))
	{
		$this->tableExist = true;
	}
	else
	{
		$this->tableExist = false;
		//throw new Dune_Exception_Mysql('������, ��������� ������: '.$q);
	}	
	return $this->tableExist;
} // ����� �������

/**
 * ���������� ����� ����� ����� � �������
 *
 * @return integer
 */
public function getTotalNumberRows()
{
    if ($this->totalNumberRows === false)
    {
	   $q = 'SELECT COUNT(*) as "num" FROM `'.$this->tableName.'`';
       $stmt = $this->db->prepare($q);
       $stmt->execute();
       $stmt->store_result();
       // ��������� ��������� ������� � ��������� ������
       $stmt->bind_result($this->totalNumberRows);
       if (!$stmt->errno) 
       {
           $stmt->fetch();
           $stmt->close();
       }
       else 
           throw new Dune_Exception_Mysqli('������, ��������� ������: '.$q);
    }
	   return $this->totalNumberRows;
}
/**
 * ������������� ��������� ��� LIMIT $shift, $num � �������.
 *
 * @param integer $shift �����
 * @param integer $num �����������
 */
public function setQueryLimit($shift = 0, $num = 10)
{
	$this->queryLimitNumber = $num;
	$this->queryLimitShift = $shift;
}

/**
 * ��������� ����� ��������� ���� � �������.
 * 
 * �� ���������: id
 *
 * @param string $str
 */
public function setKeyFieldName($str = 'id')
{
	$this->keyField = $str;
}

/**
 * ��������� �������� ��������� ���� � �������.
 * 
 * �� ��������� $id = 0
 * ��������� ������������ ��� ������ � ����� ������� � �������
 *
 * @param mixed $str
 */
public function setID($id = 0)
{
	$this->ID = $id;
}

public function setConditionEqualityWithNumber($field_name,$value,$mode = 'AND')
{
	if ($this->whereString != '')
		$this->whereString.= ' '.$mode;
	else 
		$this->whereString.= ' WHERE';
	$this->whereString.= ' `'.$field_name.'`='.$value;
}
public function setConditionEqualityWithString($field_name,$value,$mode = 'AND')
{
	if ($this->whereString != '')
		$this->whereString.= ' '.$mode;
	else 
		$this->whereString.= ' WHERE';
	$this->whereString.= ' `'.$field_name.'`="'.mysql_escape_string($value).'"';
}

public function getNumberRowsWithCondition()
{
   	if ($this->numberRowsWithCondition === false)
	{
	   $q = 'SELECT COUNT(*) as "num" FROM `'.$this->tableName.'`'.$this->whereString;
       $stmt = $this->db->prepare($q);
       $stmt->execute();
       $stmt->store_result();
       // ��������� ��������� ������� � ��������� ������
       $stmt->bind_result($this->numberRowsWithCondition);
       if (!$stmt->errno) 
       {
           $stmt->fetch();
           $stmt->close();
       }
       else 
	       throw new Dune_Exception_Mysql('������, ��������� ������: '.$q);	   
	}
	return $this->numberRowsWithCondition;
} // ����� �������

public function setOrder($field, $order = 'ASC')
{
	if (($order == 'DESC') OR ($order == 'ASC') OR ($order == ''))
	{
		if ($this->orderString == '')
			$this->orderString = ' ORDER BY';
		else 
			$this->orderString.= ',';
		$this->orderString.= ' `'.$field.'` '.$order;
		return true;
	}
	return false;
}

public function setFieldList($array = 0)
{
	if ($array == 0)
	{
		unset($this->fieldListArray);
		$this->fieldListString = '*';
	}
	else 
	{
		$this->fieldListString = '';
		$this->fieldListArray = $array;
		foreach ($array as $arr)
		{
			if ($this->fieldListString == '')
				$this->fieldListString='`'.$arr.'`';
			else 
				$this->fieldListString.=', `'.$arr.'`';
		}
	}
}

public function getNumberRows()
{
	return $this->numberRowsInList;
} // ����� �������


public function getList()
{
    if ($this->list === false)
    {
       	$q = 'SELECT '.$this->fieldListString.' FROM `'.$this->tableName.'`'.$this->whereString.$this->orderString.'		
					LIMIT '.$this->queryLimitShift.','.$this->queryLimitNumber;
       $result = @$this->db->query($q);
       if (!$this->db->errno) 
       {
           $this->numberRowsInList = $result->num_rows;
           if ($this->numberRowsInList != 0)
	       {
		      while ($row = $result->fetch_assoc())
		      {
			     $this->list[] = $row;
 		     }
	       }
	       else 
		      $this->list = false;
       }
       else 
	       throw new Dune_Exception_Mysqli('������, ��������� ������: '.$q);	   
    }
	return $this->list;
} // ����� �������


public function getOneRow()
{
    if ($this->oneRow === false)
    {
       $q = 'SELECT * FROM `'.$this->tableName.'` WHERE `'.$this->keyField.'`='.$this->ID.' LIMIT 1';
       $result = @$this->db->query($q);
       if (!$this->db->errno) 
       {
            if ($result->num_rows)
            {
                $this->oneRow = $result->fetch_assoc();
            }
            else 
		        $this->oneRow = false;
        }
        else 
	        throw new Dune_Exception_Mysqli('������, ��������� ������: '.$q);	   
    }
	return $this->oneRow;
} // ����� �������


/**
 * ���������� ���������� � �������.
 * !!! ����. ������� ������������.
 * 
 * ��� � ������������ id ������ ������������.
 * ���������� ������ �������� � ������� � ������� array( <��� �������> => <������ ��� ����������> )
 *
 * @param integer $id
 * @param array $array
 * @return boolean
 */

public function save($array, $id = 0)
{
	if (!isset($array))
		return false;
	$x = 0;
	$set_str = '';
	foreach ($array as $r_rey => $contents)
	{
		if ($x == 0)
			$set_str.= ' SET `'.$r_rey.'`="'.mysql_escape_string($contents).'"';
		else
			$set_str.= ', `'.$r_rey.'`="'.mysql_escape_string($contents).'"';
		$x++;
	}
	if ($id == 0)
	{
	    $q = 'INSERT INTO `'.$this->tableName.'`'.$set_str.', `'.$this->keyField.'`=NULL';
	}
    else 
    {
	    $q = 'UPDATE `'.$this->tableName.'`'.$set_str.' WHERE `'.$this->keyField.'`='.$id.' LIMIT 1';
    }
	
    @$this->db->query($q);
    if ($this->db->errno) 
        throw new Dune_Exception_Mysqli('������, ��������� ������: '.$q);	   
	return true;
} // ����� �������

/**
 * ���������� ���������� � ������� � ���������� ������� ������� � ��������� �������� ����� � ��� ���������..
 * !!! ����. ������� ������������.
 * 
 * ���������� ������ �������� � ������� � ������� array( <��� �������> => <������ ��� ����������> )
 *
 * @param string $key_field ��� ��������� ����
 * @param mixed $key_field_val �������� ��������� ����
 * @param array $array
 * @return boolean
 */
public function groupSave($key_field, $key_field_val, $array)
{
	if (!isset($array))
		return false;
	$x = 0;
	$set_str = '';
	foreach ($array as $r_rey => $contents)
	{
		if ($x == 0)
			$set_str.= ' SET `'.$r_rey.'`="'.mysql_real_escape_string($contents).'"';
		else
			$set_str.= ', `'.$r_rey.'`="'.mysql_real_escape_string($contents).'"';
		$x++;
	}
	$q = 'UPDATE `'.$this->tableName.'`'.$set_str.' WHERE `'.$key_field.'`="'.$key_field_val.'"';
	
	
    @$this->db->query($q);
    if ($this->db->errno) 
        throw new Dune_Exception_Mysqli('������, ��������� ������: '.$q);	   
	return true;
} // ����� �������


public function addRecord()
{
	$q = 'INSERT INTO `'.$this->tableName.'` SET `'.$this->keyField.'`=NULL';
    @$this->db->query($q);
    if ($this->db->errno) 
        throw new Dune_Exception_Mysqli('������, ��������� ������: '.$q);	   
    $this->ID = $this->db->insert_id;
	return $this->db->insert_id;
}
public function addRecordKnownId($id = 0)
{
    if ($id != 0)
    {
	   $q = 'INSERT INTO `'.$this->tableName.'` SET `'.$this->keyField.'`='.$id;
    }
    else 
    {
        $q = 'INSERT INTO `'.$this->tableName.'` SET `'.$this->keyField.'`='.$this->ID;
    }
    @$this->db->query($q);
    if ($this->db->errno)
    {
        if (($this->db->errno == self::ERROR_CODE_ON_DEFK) AND (!self::$exceptionOn))
            return false;
        else 
            throw new Dune_Exception_Mysqli('������, ��������� ������: '.$q);	   
    }
    $this->ID = $this->db->insert_id;
	return $this->db->insert_id;
}


public function deleteRecord($id = 0)
{
	$q = 'DELETE FROM `'.$this->tableName.'` WHERE `'.$this->keyField.'`='.$id.' LIMIT 1';
    @$this->db->query($q);
    if ($this->db->errno) 
        throw new Dune_Exception_Mysqli('������, ��������� ������: '.$q);	   
	return true;
}
public function deleteCorrRecords($name, $id = 0)
{
	$q = 'DELETE FROM `'.$this->tableName.'` WHERE `'.$name.'`='.$id;
    @$this->db->query($q);
    if ($this->db->errno) 
        throw new Dune_Exception_Mysqli('������, ��������� ������: '.$q);	   
	return true;
}

////////////////////////////////////////////////////////////////
///////////////////////////////     ������ ���������� Iterator
  public function rewind()
  {
    $this->listCurrentKey = 0;
  }

  public function current()
  {
    return $this->list[$this->listCurrentKey];
  }

  public function key()
  {
      return $this->listCurrentKey;
  }

  public function next()
  {
    return $this->listCurrentKey += 1;
  }

  public function valid()
  {
    return isset($this->list[$this->listCurrentKey]);
  }    
/////////////////////////////
////////////////////////////////////////////////////////////////


} // ����� �������� ������