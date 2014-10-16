<?php
/**
 * јнализирует входную строку (число) и создаЄт единицы вркмени (год, мес€ц...)
 * 
 * ----------------------------------------------------
 * | Ѕиблиотека: Dune                                  |
 * | ‘айл: Date.php                                    |
 * | ¬ библиотеке: Dune/Data/Parsing/Date.php          |
 * | јвтор: јндрей –ыжов (Dune) <dune@rznw.ru>         |
 * | ¬ерси€: 0.91                                      |
 * | —айт: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * »стори€ версий:
 *
 * ¬ерси€ 0.91 (2009 июнь 29)
 * ¬ыбор имени месаца в 3-х падежах: €нварь, €нвар€, €нваре
 * 
 * 
 * 
 */
class Dune_Data_Parsing_Date
{

	/**
	 * ƒанные дл€ обработки
	 *
	 * @var mixed
	 * @access private
	 */
	protected $_source;
	
	/**
	 * @var string
	 * @access private
	 */
	protected $_type;
	
	const TYPE_DATE 	 = 'DATE';
	const TYPE_TIME		 = 'TIME';
	const TYPE_DATATIME  = 'DATATIME';
	const TYPE_TIMESTAMP = 'TIMESTAMP';

	/**
	 * @var string
	 * @access private
	 */
	protected $_year = '';

	/**
	 * @var string
	 * @access private
	 */
	protected $_month = '';

	/**
	 * @var string
	 * @access private
	 */
	protected $_day = '';
	
	/**
	 * @var string
	 * @access private
	 */
	protected $_hour = '';

	
	/**
	 * @var string
	 * @access private
	 */
	protected $_minute = '';

	/**
	 * @var string
	 * @access private
	 */
	protected $_second = '';
	

	/**
	 * @var integer
	 * @access private
	 */
	protected $_unix = 0;

	/**
	 * @var boolean
	 * @access private
	 */
	protected $_parsed = false;
	
	
	/**
	 * @var string
	 * @access private
	 */
	protected $_monthName = array(
	                               0 => array(1 => 'мес€ц', 'мес€ца', 'мес€це'),
	                               1 => array(1 => '€нварь', '€нвар€', '€нваре'),
	                               2 => array(1 => 'февраль', 'феврал€', 'феврале'),
	                               3 => array(1 => 'март', 'марта', 'марте'),
	                               4 => array(1 => 'апрель', 'апрель€', 'апреле'),
	                               5 => array(1 => 'май', 'ма€', 'мае'),
	                               
	                               6 => array(1 => 'июнь', 'июн€', 'июне'),
	                               7 => array(1 => 'июль', 'июл€', 'июле'),
	                               8 => array(1 => 'август', 'августа', 'августе'),
	                               9 => array(1 => 'сент€брь', 'сент€бр€', 'сент€бре'),
	                               10 => array(1 => 'окт€брь', 'окт€бр€', 'окт€бре'),
	                               11 => array(1 => 'но€брь', 'но€бр€', 'но€бре'),
	                               12 => array(1 => 'декабрь', 'декабр€', 'декабре'),
	                              );
	
	
	
	public function __construct($source, $type = 'DATATIME')
	{
		$this->_source = $source;
		$this->_type = $type;
	}
	
	public function getYear($part = false)
	{
	    if (!$this->_parsed)
	    {
	        $this->parse();
	    }
	    if ($part)
	       return substr($this->_year, 2, 2);
        return $this->_year;	    
	}

	public function getMonth()
	{
	    if (!$this->_parsed)
	    {
	        $this->parse();
	    }
        return $this->_month;	    
	}
	
	
	public function getMonthName($key = 1)
	{
	    if (!$this->_parsed)
	    {
	        $this->parse();
	    }
        return $this->_monthName[(int)$this->_month][$key];
	}
	
	
	public function getDay()
	{
	    if (!$this->_parsed)
	    {
	        $this->parse();
	    }
        return $this->_day;	    
	}

	public function getHour()
	{
	    if (!$this->_parsed)
	    {
	        $this->parse();
	    }
        return $this->_hour;
	}

	public function getMinute()
	{
	    if (!$this->_parsed)
	    {
	        $this->parse();
	    }
        return $this->_minute;
	}
	
	public function getSecond()
	{
	    if (!$this->_parsed)
	    {
	        $this->parse();
	    }
        return $this->_second;
	}
	
/////////////////////////////////////////////////////////////////////
/////////       «ащтщЄнные методы
////////////////////////////////////////////////////////////////////	
	/**
	 * @access private
	 */
	protected function parse()
	{
        switch ($this->_type)   
	    {
	       case self::TYPE_DATATIME:
	           $this->parseDate();
	           $this->parseTime();
	       break;
	       case self::TYPE_DATE :
	           $this->parseDate();
	       break;
	       case self::TYPE_TIME:
	           $this->parseTime();
	    }
//	       $this->_unix = mktime($this->_hour, $this->_minute, $this->_second, $this->_month, $this->_day, $this->_year);
	}

	/**
	 * @access private
	 */
	protected function parseTimeStamp()
	{
	    $array = getdate($this->_source);
	    $this->_year = $array['year'];
	    $this->_month = $array['mon'];
 	    $this->_day = $array['mday'];
	    $this->_hour = $array['hour'];
	    $this->_minute = $array['minute'];
	    $this->_second = $array['second'];
	    $this->_unix = $array[0];
	}

	/**
	 * @access private
	 */
	protected function parseDate()
	{
	    $pos1 = strpos($this->_source, '-');
	    
	    if ($pos1 === false)
	       throw new Dune_Exception_Base('ќшибка выборки временных параметров из свтроки');
	    $pos1 = $pos1 + 1;
	    $pos2 = strpos($this->_source, '-', $pos1) + 1;

	       
	    $this->_year = substr($this->_source, 0, 4);
	    $this->_month = substr($this->_source, $pos1, 2);
 	    $this->_day = substr($this->_source, $pos2, 2);
	}


	/**
	 * @access private
	 */
	protected function parseTime()
	{
	    $pos1 = strpos($this->_source, ':');
	    if ($pos1 === false)
	       throw new Dune_Exception_Base('ќшибка выборки временных параметров из строки');
	    $pos1 = $pos1 + 1;
	    $pos2 = strpos($this->_source, ':', $pos1) + 1;
	    
	    $this->_hour = substr($this->_source, $pos1 - 3, 2);
	    $this->_minute = substr($this->_source, $pos1, 2);
 	    $this->_second = substr($this->_source, $pos2, 2);
	}
	
}