<?php
/**
 * Коллектор условий в WHERE для запросов в BD
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Where.php                                   |
 * | В библиотеке: Dune/Mysqli/Collector/Where.php     |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 0.92                                      |
 * | Сайт: www.dune.rznw.ru                            |
 * ----------------------------------------------------
 *
 *  Истоия версий:
 * 
 * 0.92 (2009 апрель 16)
 *  В методе get() контроль выдачи строки.
 *  Ошибка фильтрации данных в мтоде addSimpleData()
 * 
 * 0.91 (2009 апрель 10)
 *  Котроль ввода соединений для условий AND, OR. Альфа.
 * 
 * 0.90 (2009 апрель 09)
 *  Рализована база.
 * 
 */

class Dune_Mysqli_Collector_Where extends Dune_Mysqli_Abstract_Connect
{
    protected $_accumulator = '';
    protected $_bracketCount = 0;
    
    protected $_canAddAndOr  = false;
    protected $_needAddAndOr = false;
    protected $_openAddAndOr = false;
    protected $_exception    = false;
    protected $_haveLeft     = false;
    protected $_haveAndOr    = false;
    
    protected $_comares = array('=', '>', '<', '>=', '<=', '<>', '!=', '<=>');
    
    public function __construct()
    {
        
    }
    
    /**
     * Открыть скобку.
     *
     * @return Dune_Mysqli_Collector_Where
     */
    public function bracketBegin()
    {
        $this->_canAddAndOr = false;
        $this->_bracketCount++;
        $this->_needAddAndOr = false;
        
        if (!$this->_openAddAndOr and Dune_String_Functions::len($this->_accumulator) > 1)
        {
            throw new Dune_Exception_Base('Не указано условия соединения (OR, AND) группы в скобках с предыдущими условиями.');
        }
        $this->_accumulator .= ' (';
        
        return $this;
    }

    /**
     * Закрыть скобку.
     * 
     * Прерывание при закритии при отсутствии открытой.
     *
     * @return Dune_Mysqli_Collector_Where
     */
    public function bracketEnd()
    {
        if ($this->_bracketCount == 0)
            throw new Dune_Exception_Base('Попытка закрытия скобки. Открытой нет.');
        if ($this->_openAddAndOr)
            throw new Dune_Exception_Base('Соединитель условий оставлен (OR, AND) оставлен открытым.');
            
        $this->_bracketCount--;
        $this->_canAddAndOr = true;
        $this->_needAddAndOr = true;
        $this->_accumulator .= ')';
        return $this;
    }
    

    /**
     * Включение генерации прерывания на некритичных участках.
     *
     * @return Dune_Mysqli_Collector_Where
     */
    public function setExceptionThrow($value = true)
    {
        $this->_exception = $value;
        return $this;
    }

    /**
     * Добавить AND
     *
     * @return Dune_Mysqli_Collector_Where
     */
    public function addAnd($exception_on_empty = false)
    {
        $this->_addAndOr('AND', $exception_on_empty);
        return $this;
    }

    /**
     * Добавить OR
     *
     * @return Dune_Mysqli_Collector_Where
     */
    public function addOr($exception_on_empty = false)
    {
        $this->_addAndOr('OR', $exception_on_empty);
        return $this;
    }

    /**
     * Добавить условие.
     * Проверка на корректность и полмещение после ввода левого значения.
     *
     * @param string $value опрераторы сравненеия: >, <, >=, <=, <>, <=>
     * @return Dune_Mysqli_Collector_Where
     */
    public function addCompare($value = '=')
    {
        if (!in_array($value, $this->_comares))
        {
            throw new Dune_Exception_Base('Введено неверное условие для сравнения: ' . $value);
        }
        
        if (!$this->_haveLeft)
        {
            throw new Dune_Exception_Base('Нельзя вводить условие сревнения. Левая часть не введена.');
        }
        $this->_accumulator .= ' ' . $value;
        $this->_openAddAndOr = false;
        return $this;
    }
    
    /**
     * Добавить значение для одного условия.
     *
     * @param mixed $value
     * @param string $format
     * @return Dune_Mysqli_Collector_Where
     */
    public function addSimpleData($value, $format = 's')
    {
        switch ($format)
        {
            case 'i':
                $this->_accumulator .= ' ' . (int)$value;
            break;
            case 'f':
                $this->_accumulator .= ' ' . (float)$value;
            break;
            default:
                $this->_initDB();
                $this->_accumulator .= ' "' . $this->_DB->real_escape_string($value) . '"';
                
        }
        if ($this->_haveLeft)
        {
            $this->_haveLeft = false;
            $this->_canAddAndOr = true;
            $this->_needAddAndOr = true;
        }
        else 
        {
            $this->_needAddAndOr = false;
            $this->_haveLeft = true;
            $this->_canAddAndOr = false;
        }
        $this->_openAddAndOr = false;
        return $this;
    }
    
    /**
     * Enter description here...
     *
     * @param unknown_type $field
     * @param unknown_type $table
     * @return Dune_Mysqli_Collector_Where
     */
    public function addSimpleField($field, $table = '')
    {
        if ($table)
            $this->_accumulator .= ' `' . $table .'`.';
        else 
            $this->_accumulator .= ' ';
        $this->_accumulator .= '`' . $field .'`';
        
        if ($this->_haveLeft)
        {
            $this->_haveLeft = false;
            $this->_canAddAndOr = true;
            $this->_needAddAndOr = true;
        }
        else 
        {
            $this->_haveLeft = true;
            $this->_canAddAndOr = false;
            $this->_needAddAndOr = false;
        }
        $this->_openAddAndOr = false;
        return $this;

    }
    
    /**
     * Добавление одного условия целиком.
     *
     * @param string $value
     * @return Dune_Mysqli_Collector_Where
     */
    public function addOneWholly($value)
    {
        $this->_accumulator .= ' ' . $value;
        $this->_canAddAndOr = true;
        $this->_needAddAndOr = true;
        $this->_openAddAndOr = false;
        return $this;
    }

    
    /**
     * Возврат всей строки.
     *
     * @param boolean $where требование присрединить слово WHERE в начало.
     * @return string
     */
    public function get($where = true)
    {
        
        if ($this->_bracketCount)
            throw new Dune_Exception_Base('Есть незакрытая скобка.');
        if ($this->_haveLeft)
            throw new Dune_Exception_Base('Есть неоконченное выражение.');
           
        if ($where and $this->_accumulator)
            return ' WHERE ' . $this->_accumulator;
        return $this->_accumulator;
    }

    /**
     * Добавляем AND или OR.
     * Прерывание, если введено левое значение (без правого).
     * 
     * Некритичное замецание - прерывание при запрете вставки.
     *
     * @param string $value
     * @access private
     */
    protected function _addAndOr($value = 'AND', $exception_when_empty = false)
    {
        if (Dune_String_Functions::len($this->_accumulator) < 2)
        {
            if ($exception_when_empty)
                throw new Dune_Exception_Base('Добавление условия соединения не нужно - нет ранее указанных условий.');
            return $this;
        }
        if ($this->_openAddAndOr)
        {
            throw new Dune_Exception_Base('Повторное добавление оператора соединения условий.');
        }
        if (!$this->_needAddAndOr)
        {
            throw new Dune_Exception_Base('Запрещено вставлять строку: ' . $value . '. Ей здесь не место.');
        }
        
        if ($this->_haveLeft)
        {
            throw new Dune_Exception_Base('Нельзя вводить условие соединения. Было начато создание одного простого условия. Левая часть введена.');
        }
        if (!$this->_canAddAndOr)
        {
            if ($this->_exception)
                throw new Dune_Exception_Base('Добавление AND или OR не разрешено.');
        }
        else 
            $this->_accumulator .= ' ' . $value;
        $this->_openAddAndOr = true;
    }
    
}