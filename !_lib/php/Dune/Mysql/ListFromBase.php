<?
/**
 * Класс для работы с одной таблицей в базе
 * 
 * !!! База должна быть открыта
 * !!! Должно быть в таблице ключевое поле с автоинкрементом
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: ListFromBase.php                            |
 * | В библиотеке: Dune/Mysql/ListFromBase.php         |
 * | Автор: Андрей Рыжов (Dune) <dune@pochta.ru>       |
 * | Версия: 2.02                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 * 
 * 
 * Версия 2.02 -> 2.03
 * ----------------------
 * 1) Доработан метод save() - при передаче значение ключевого поля = 0 вставляется новое поле
 * 2) Доработан метод save() - изменён порядок передачи параметрок ($array, $id)
 * 3) Доработан метод addRecordKnownId() - при передаче переменной $id = 0 создаём запись в строки с ранее установленным id
 * 4) Доработан метод addRecord() - устанавливает id вставленной записи в переменную $ID
 * 
 * Версия 2.01 -> 2.02
 * ----------------------
 * 1) Исправлена ошибка сохранения результатов выборки общего числа строк в таблице
 * 2) Добавлена обработка ошибок работы метода addRecordKnownId()
 *    При добавлениее при существующем ключе по умолчанию возвращается false
 *    При вызове статич. меьода setExceptionOn() - генерация исключения
 * 
 * Версия 2.00 -> 2.01
 * ----------------------
 * Исправлена ошибка при работе метода getTotalNumberRows()
 * 
 * Версия 1 -> 2
 * ---------------------
 * Добавлен доступ к результату запроса как Iterator
 * Функции get... сохраняют выбранный результат, про повторном вызове возвращают сохранённый
 * Сброс результатов работы методом clear()
 * При ошибках работы с БД - генерация исключений Dune_Exception_Mysql
 * 
 */
class Dune_Mysql_ListFromBase implements Iterator
{
	private $tableName; // Имя таблицы из которой выводим
	private $tableExist = false; // Флаг существования таблицы
	private $tableFields = 0; // Всего полей в таблице
	private $totalNumberRows = false; // Число рядов в таблице
	private $numberRowsWithCondition = false; // Число рядов в таблице c условиями
	private $orderString = ''; // Строка для задания порядка
	private $whereString = ''; // Строка для задания условия
	private $ID = 0; // Номер текущего объекта
	private $keyField = 'id'; // Имя ключевого поля
	private $oneRow = false; // Массив с полями одной записи
	private $list = false; // Мссив с информацией об объекте
	private $listCurrentKey = 0;
	
	private $numberRowsInList = 0; // Сколько выбрали
	private $fieldList = array();// Мссив со списком полей для выборки 
	private $queryLimitNumber = 10;
	private $queryLimitShift = 0;
	
	private $fieldListString = '*';
	private $fieldListArray = array();
	
	
    static protected $exceptionOn = false;
	
	const ERROR_CODE_ON_DEFK = 1062;


/**
 * Конструктор.
 * Иницилизует имя таблицы с которой будет работать
 *
 * @param string $table_name имя таблицы
 */
public function __construct($table_name = '')
{
	$this->tableName = $table_name;
}


static public function setExceptionOn($val = true)
{
    self::$exceptionOn = $val;
}

/**
 * Очищает параметры объекта.
 * 
 * Устанавливает значения по умолчанию.
 * Убирает результаты работы запросов.
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
 * Проверка существования таблицы, с которой работает объект
 *
 * @return boolean
 */
public function existTable()
{
    $q = 'SELECT 1 FROM `'.$this->tableName.'` WHERE 0';
	$res = mysql_query($q);
	if ($res)
	{
		$this->tableExist = true;
	}
	else
	{
		$this->tableExist = false;
		//throw new Dune_Exception_Mysql('Запрос, вызвавший ошибку: '.$q);
	}	
	return $this->tableExist;
} // Конец функции

/**
 * Возвращает общее число строк в таблице
 *
 * @return integer
 */
public function getTotalNumberRows()
{
    if ($this->totalNumberRows === false)
    {
	   $q = 'SELECT COUNT(*) as "num" FROM `'.$this->tableName.'`';
	   $res = mysql_query($q);
	   if (!$res)
	       throw new Dune_Exception_Mysql('Запрос, вызвавший ошибку: '.$q);
	   $row = mysql_result($res,0);
	   $this->totalNumberRows = $row;
    }
	   return $this->totalNumberRows;
}

/**
 * Устанавоивает параметры для LIMIT $shift, $num в запросе.
 *
 * @param integer $shift сдвиг
 * @param integer $num колличество
 */
public function setQueryLimit($shift = 0, $num = 10)
{
	$this->queryLimitNumber = $num;
	$this->queryLimitShift = $shift;
}

/**
 * Установка имени ключевого поля в таблице.
 * 
 * По умолчанию: id
 *
 * @param string $str
 */
public function setKeyFieldName($str = 'id')
{
	$this->keyField = $str;
}

/**
 * Установка значение ключевого поля в таблице.
 * 
 * По умолчанию $id = 0
 * Установка используется для работы с одной строкой в таблице
 *
 * @param mixed $str
 */
public function setId($id = 0)
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
	   $res = mysql_query($q);
	   if (!$res)
	       throw new Dune_Exception_Mysql('Запрос, вызвавший ошибку: '.$q);
	   $row = mysql_fetch_assoc($res);
	   $this->numberRowsWithCondition = $row['num'];
	}

	return $this->numberRowsWithCondition;
} // Конец функции

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
} // Конец функции


public function getList()
{
    if ($this->list === false)
    {
       	$q = 'SELECT '.$this->fieldListString.' FROM `'.$this->tableName.'`'.$this->whereString.$this->orderString.'		
					LIMIT '.$this->queryLimitShift.','.$this->queryLimitNumber;
    	$res = mysql_query($q);
	   if (!$res)
         throw new Dune_Exception_Mysql('Запрос, вызвавший ошибку: '.$q);
	   $this->numberRowsInList = mysql_num_rows($res);
	   if ($this->numberRowsInList != 0)
	   {
		  while ($row = mysql_fetch_assoc($res))
		  {
			 $this->list[] = $row;
 		 }
	   }
	   else 
		  $this->list = false;
    }
	return $this->list;
} // Конец функции


public function getOneRow()
{
    if ($this->oneRow === false)
    {
    	$q = 'SELECT * FROM `'.$this->tableName.'` WHERE `'.$this->keyField.'`='.$this->ID.' LIMIT 1';
	    $res = mysql_query($q);
	    if (!$res)
          throw new Dune_Exception_Mysql('Запрос, вызвавший ошибку: '.$q);
		
	   if (mysql_num_rows($res) != 0)
	   {
		  $this->oneRow = mysql_fetch_assoc($res);
	   }
	   else 
		  $this->oneRow = false;
    }
	return $this->oneRow;
} // Конец функции



/**
 * Сохранение информации в таблице.
 * !!! Спец. символы экранируются.
 * 
 * Ряд с передаваемым id должен существовать.
 * Изменяемые данный хранятся в массиве в формате array( <имя столбца> => <данные для сохранения> )
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
			$set_str.= ' SET `'.$r_rey.'`="'.mysql_real_escape_string($contents).'"';
		else
			$set_str.= ', `'.$r_rey.'`="'.mysql_real_escape_string($contents).'"';
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
	$res = mysql_query($q);	
    if (!$res)
       throw new Dune_Exception_Mysql('Запрос, вызвавший ошибку: '.$q);
	return $res;
} // Конец функции

/**
 * Сохранение информации в таблице в нескольких строках таблицы с указанным ключевым полем и его занчением..
 * !!! Спец. символы экранируются.
 * 
 * Изменяемые данный хранятся в массиве в формате array( <имя столбца> => <данные для сохранения> )
 *
 * @param string $key_field имя ключевого поля
 * @param mixed $key_field_val значение ключевого поля
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
	$res = mysql_query($q);	
    if (!$res)
       throw new Dune_Exception_Mysql('Запрос, вызвавший ошибку: '.$q);
	return $res;
} // Конец функции


public function addRecord()
{
	$q = 'INSERT INTO `'.$this->tableName.'` SET `'.$this->keyField.'`=NULL';
	$res = mysql_query($q);
	if (!$res)
        throw new Dune_Exception_Mysql('Запрос, вызвавший ошибку: '.$q);
	$this->ID = mysql_insert_id();
	return $this->ID;
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
	   
	$res = @mysql_query($q);
	if (!$res)
	{
        if ((mysql_errno($res) == self::ERROR_CODE_ON_DEFK) AND (!self::$exceptionOn))
            return false;
        else 
            throw new Dune_Exception_Mysql('Запрос, вызвавший ошибку: '.$q);	   
	}
	$this->ID = mysql_insert_id();
	return $this->ID;
}


public function deleteRecord($id = 0)
{
	$q = 'DELETE FROM `'.$this->tableName.'` WHERE `'.$this->keyField.'`='.$id.' LIMIT 1';
	$res = mysql_query($q);
	if (!$res)
        throw new Dune_Exception_Mysql('Запрос, вызвавший ошибку: '.$q);
	return $res;
}
public function deleteCorrRecords($name, $id = 0)
{
	$q = 'DELETE FROM `'.$this->tableName.'` WHERE `'.$name.'`='.$id;
	$res = mysql_query($q);
	if (!$res)
        throw new Dune_Exception_Mysql('Запрос, вызвавший ошибку: '.$q);
	return $res;
}

////////////////////////////////////////////////////////////////
///////////////////////////////     Методы интерфейса Iterator
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


} // Конец описания класса
?>