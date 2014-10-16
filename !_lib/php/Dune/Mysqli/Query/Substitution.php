<?php
/**
 * Рвсширяет mysqli дополнительной функциональностью.
 * Конструктор  защищенный.
 * 
 * Особые возможности метода query. В обычном режиме работает как в родителе - возвращает объект-результат.
 * При передаче дополнительных параметров методу дополнительные плюшки.
 * Позаимствован и расширен функционал из класса goDB (http://pyha.ru/go/godb/)
 * 
 * Строка запроса, при наличии 2-го параметра метода query првевращается в шаблон.
 * Сводная таблица плейсхолдеров:
 * ---------------------------------------
 *  ? Строковое данное. Экранируются спецсимволы, заключается в кавычки. 
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
 * | Версия: 1.00                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * 
 * История версий:
 * -----------------
 * Версия 1.00 -> 1.01
 *
 */
class Dune_Mysqli_Query_Substitution
{


    /**
     * Разрешение отладки
     *
     * @var bool
     */
    protected $queryDebug = false;
    
    protected $_string = '';
    protected $_data = array();


    /* Вспомагательная фигня */
    protected $_mqPH;
    protected $_mqPrefix = '';      
  
    

    /**
     * Выполнение запроса к базе
     */
    public function make($data = null)
    {   
        if ($data != null)
            $this->_data = $data;
    	$query = $this->makeQuery($this->string, $this->_data);
    	return $query;
    }    
  
    /**
     * Формирование запроса
     *
     * @param string $pattern строка-шаблон с плейсхолдерами
     * @param array  $data    массив входных данных
     * @param string $prefix  [optional] префикс таблиц
     */
    public function makeQuery($pattern, $data)
    {
        $this->_mqPH = $data;
        $q = @preg_replace_callback('/\?([int?ca]?[ina]?);?/', Array($this, '_makeQuery'), $pattern);
        if (sizeOf($this->_mqPH) > 0) 
        {
            throw new Dune_Exception_Mysqli('It is too much data.');
        }
        return $q;
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
                return is_null($el) ? 'NULL' : ('"'.$this->_DB->real_escape_string($el).'"');
            case ('ni'):
            case ('in'): 
                return is_null($el) ? 'NULL' : intVal($el);
            case ('a'):
                foreach ($el as &$e) 
                {
                    $e = '"'.$this->_DB->real_escape_string($e).'"';
                }
                return implode(',', $el);
            case ('ai'):
            case ('ia'):
                foreach ($el as &$e) {
                    $e = intVal($e);
                }
                return implode(',', $el);
        }
        return '"'.$this->_DB->real_escape_string($el).'"';
    }
  


  protected function __construct($string)
  {
      $this->_DB = Dune_MysqliSystem::getInstance();
      $this->_string = $string;
  }
}