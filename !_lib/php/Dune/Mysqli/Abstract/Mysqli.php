<?php
/**
 * Рвсширяет mysqli дополнительной функциональностью.
 * Конструктор  защищенный.
 * 
 * Особые возможности метода query. В обычном режиме работает как в родителе - возвращает объект-результат.
 * При передаче дополнительных параметров методу дополнительные плюшки.
 * Позаимствован и расширен функционал из класса goDB (http://pyha.ru/go/godb/)
 * 
 * Строка запроса, при наличии 2-го параметра метода query превращается в шаблон.
 * Сводная таблица плейсхолдеров:
 * ---------------------------------------
 *  ? Строковое данное. Экранируются спецсимволы, заключается в кавычки. 
 *  ?p Строковое данное. Часть строки запроса, уже обработанная. Не экранируется.
 *  ?s Данное для сериализации. Экранируются спецсимволы, заключается в кавычки. 
 *  ?i Целочисленное данное. Принудительно приводится к целому числу. 
 *  ?n, ?ni Данные с возможным NULL. В случае равенства переменной php-значению null, в запрос вставляется NULL. В других случаях ведут себя, как обычные «?», «?i».  
 *  ?a, ?ai Список данных. На входе имеется массив — преобразуется в список строковых или целочисленных данных. 
 *  ?t Имя таблицы. Вставляется имя таблицы с использованием префикса. Заключается в апострофы. 
 *  ?c Имя столбца. Вставляется имя столбца, заключенное в апострофы. На входе может быть массив Array(таблица, столбец). 
 *  ?ia, ?in Модификаторы сложных плейсхолдеров можно писать в любом порядке (?ia === ?ai). 
 *  ?;, ?ia; Во избежания неоднозначности, плейсхолдеры можно завершать точкой с запятой. 
 *  ?? Для непосредственной вставки символа «вопросительный знак» его следует удвоить. 
 *
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Mysqli.php                                  |
 * | В библиотеке: Dune/Mysqli/Abstract/Mysqli.php     |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.06                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * 
 * История версий:
 * -----------------
 * 
 * 1.06 (2009 январь 22)
 * Добавлен магический метод __toString() - печать последней строки запроса.
 * 
 * 1.05 (2009 январь 20)
 * Сохраняет и позволяет получить строку последнего запроса. Метод getQuery().
 * Новый плейсхолдер: обработанная часть запроса. ?p
 * 
 * 1.04 (2008 декабрь 04)
 * Ошибка с новым плейсхолдером s устранена.
 * 
 * 1.03 (2008 декабрь 03)
 * Новый плейсхолдер ?s, что символизирует данные, подвергаемые сериализации, и вставлямые как строки.
 * 
 * Версия 1.01 -> 1.02
 * Новый метод  makeSubstitution() подстановка и возврат плейсхолдеров без запроса.
 * 
 * Версия 1.00 -> 1.01
 * ошибка в вызове исключения - лишний параметр.
 *
 */
abstract class Dune_Mysqli_Abstract_Mysqli extends mysqli
{

   /**
     * Префикс таблиц по умолчанию
     *
     * @var string
     */
    protected $tablePrefix = '';

    /**
     * Разрешение отладки
     *
     * @var bool
     */
    protected $queryDebug = false;

    /**
     * Список баз данных
     *
     * @var array
     */
    protected static $dbList = Array();
    
    /**
     * Количество запросов через класс
     *
     * @var int
     */
    protected $qQuery = 0;

    /**
     * Содержит строку запроса. Используется для тестированя.
     *
     * @var string
     * @access private
     */
    protected $_query = '';
    
    
    /* Вспомагательная фигня */
    protected $_mqPH;
    protected $_mqPrefix;      
  
    /**
     * Идентифокатор последней вставленной записи. $this->insert_id
     */
    const RESULT_ID ='id';
    
    /**
     * Затронутые строки. $this->affected_rows
     */
    const RESULT_AR ='ar';
    
    /**
     * Число строк в результате.
     */
    const RESULT_NUM ='num';
    
    /**
     * Массив из результатов запроса. Скалярный.
     */
    const RESULT_ROW ='row';

    /**
     * Массив из одной, первой, строки результата. Скалярный.
     */
    const RESULT_ROWROW ='rowrow';
    
    /**
     * Массив из результатов запроса. Ассоциативный..
     */
    const RESULT_ASSOC ='assoc';

    /**
     * Массив из одной, первой, строки результата. Ассоциативный..
     */
    const RESULT_ROWASSOC ='rowassoc';
    
    /**
     * Массив из знчение по одному столбцу - первому.
     */
    const RESULT_COL ='col';
    
    /**
     * Одно единственно езначение. Первая строка запрроа, первое поле в запросе.
     */
    const RESULT_EL ='el';
    
    /**
     * Объект-итератор по ассоциативному массиву. Аналог assoc, только вместо настоящего массива используется объект-итератор.
     */
    const RESULT_IASSOC ='iassoc';

    /**
     * Объект-итератор для row.
     */
    const RESULT_IROW ='irow';

    /**
     * Объект-итератор для col.
     */
    const RESULT_ICOL ='icol';
    

    /**
     * Выполнение запроса к базе
     *
     * 
     * @param  string $pattern sql-запрос или строка-шаблон с плейсхолдерами
     * @param  array  $data    [optional] массив входных данных
     * @param  string $fetch   [optional] формат результата. Используйте константы класса.
     * @param  string $prefix  [optional] префикс имен таблиц
     * @return mixed  результат запроса в заданном формате     
     */
    public function query($pattern, $data = null, $fetch = null, $prefix = null)
    {        
		$this->qQuery++;
    	$query = $data ? $this->makeQuery($pattern, $data, $prefix) : $pattern;
        if ($this->queryDebug) {
        	if ($this->queryDebug === true) {
            	print '<pre>'.htmlSpecialChars($query).'</pre>';
        	} else {
        		call_user_func($this->queryDebug, $query);
        	}
        }
        $this->_query = $query;
        $result = parent::query($query, MYSQLI_STORE_RESULT);
        if ($this->errno) {
            throw new Dune_Exception_Mysqli('Error in query: ' . $query . '<br /> ' . $this->error, $this->errno);
        }
        $return = $this->fetch($result, $fetch);
        if ((!is_object($return)) && (is_object($result))) 
        {
            $result->free();
        }
        return $return;
    }    
  
    
    /**
     * Выполнение подстановки в строке для включения ее в строку запроса.
     * Полезно при хитром составлении строки.
     * 
     * @param string $string
     * @param array $data
     * @return string
     */
    public function makeSubstitution($string, $data = null)
    {   
    	$query = $this->makeQuery($string, $data);
    	return $query;
    }    
    
    
    /**
     * Формирование запроса
     *
     * @param string $pattern строка-шаблон с плейсхолдерами
     * @param array  $data    массив входных данных
     * @param string $prefix  [optional] префикс таблиц
     */
    public function makeQuery($pattern, $data, $prefix = '')
    {
        $prefix = ($prefix === null) ? $this->tablePrefix : $prefix;    
        $this->_mqPH = $data;
        $this->_mqPrefix = $prefix;
        $q = @preg_replace_callback('/\?([psint?ca]?[ina]?);?/', Array($this, '_makeQuery'), $pattern);
        if (sizeOf($this->_mqPH) > 0) 
        {
            throw new Dune_Exception_Mysqli('It is too much data.');
        }
        return $q;
    }    
  
  
    /**
     * Разбор результата в нужном формате
     *
     * @param  mysqli_result $result результат
     * @param  string        $fetch  формат
     * @return mixed
     */
    public function fetch($result, $fetch)
    {
        $fetch = strToLower($fetch);
        if ((!$fetch) || ($fetch == 'no')) {
            return $result;
        }
        if ($fetch == 'id') {
            return $this->insert_id;
        }
        if ($fetch == 'ar') {
            return $this->affected_rows;
        }
        $numRows = $result->num_rows;
        if ($fetch == 'num') {
            return $numRows;
        }
        if ($fetch == 'row') {
            $A = Array();
            for ($i = 0; $i < $numRows; $i++) {
                $A[] = $result->fetch_row();
            }
            return $A;
        }
        if ($fetch == 'assoc') {
            $A = Array();
            for ($i = 0; $i < $numRows; $i++) {
                $A[] = $result->fetch_assoc();
            }
            return $A;
        }
        if ($fetch == 'col') {
            $A = Array();
            for ($i = 0; $i < $numRows; $i++) {
                $r = $result->fetch_row();
                $A[] = $r[0];
            }
            return $A;
        }

        if ($fetch == 'irow') {
            return new Dune_Mysqli_Iterator_ResultRow($result);
        }
        if ($fetch == 'iassoc') {
            return new Dune_Mysqli_Iterator_ResultAssoc($result);
        }
        if ($fetch == 'icol') {
            return new Dune_Mysqli_Iterator_ResultCol($result);
        }

        if ($numRows == 0) 
        {
            return false;
        }
        if ($fetch == 'rowrow')
        {
            return $result->fetch_row();
        }
        if ($fetch == 'rowassoc') 
        {
            return $result->fetch_assoc();
        }
        if ($fetch == 'el') 
        {
            $r = $result->fetch_row();
            return $r[0];
        }
        return true;
    }

    /**
     * Установка префикса таблиц
     *
     * @param string $prefix
     */
    public function setPrefix($prefix)
    {
        $this->tablePrefix = $prefix;
        return true;
    }

    /**
     * Установить значение отладки
     *
     * @param bool $debug
     */
    public function setDebug($debug = true)
    {
        $this->queryDebug = $debug;
        return true;
    }
    
	/**
	 * Получить количество запросов через данный класс
	 *
	 * @return int
	 */
    public function getQQuery()
    {
    	return $this->qQuery;
    }

	/**
	 * Получить текст последнего запроса.
	 *
	 * @return int
	 */
    public function getQuery()
    {
    	return $this->_query;
    }
    
    public function __toString()
    {
        return $this->getQuery();
    }
    
/////////////////////////////////////////////////////////////////////

//////////////////////////////      Приватные методы    
    /**
     * Вспомагательная функция для формирования запроса
     *
     * @param  array  $ph
     * @return string
     */
    protected function _makeQuery($ph)
    {
        if ($ph[1] == '?') 
        {
            return '?';
        }
        if (sizeOf($this->_mqPH) == 0) 
        {
            throw new Dune_Exception_Mysqli('It is not enough data');
        }
        $el = array_shift($this->_mqPH);
        switch ($ph[1]) {
            
            case ('s'):
                 $el = serialize($el);
                 return '"'.$this->real_escape_string($el).'"';
            case ('p'):
                 return $el;
                 
            case ('i'):
                 return intVal($el);
            case ('t'): 
                return '`'.$this->_mqPrefix.$el.'`';
            case ('c'):
                if (is_array($el)) 
                {
                    return '`'.$this->_mqPrefix.$el[0].'`.`'.$el[1].'`';
                }
                return '`'.$el.'`';
            case ('n'): 
                return is_null($el) ? 'NULL' : ('"'.$this->real_escape_string($el).'"');
            case ('ni'):
            case ('in'): 
                return is_null($el) ? 'NULL' : intVal($el);
            case ('a'):
                foreach ($el as &$e) 
                {
                    $e = '"'.$this->real_escape_string($e).'"';
                }
                return implode(',', $el);
            case ('ai'):
            case ('ia'):
                foreach ($el as &$e) {
                    $e = intVal($e);
                }
                return implode(',', $el);
        }
        return '"'.$this->real_escape_string($el).'"';
    }


  protected function __construct($host,$username,$passwd=null,$dbname=null,$port=null, $socket=null)
  {
      parent::__construct($host,$username,$passwd,$dbname,$port, $socket);
  }
////////// Конец описания приватных методов
///////////////////////////////////////////////////////////////  
}