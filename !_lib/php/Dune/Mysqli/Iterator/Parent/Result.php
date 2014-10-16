<?php
/**
 * Результат выполнения запроса (итератор).
 * Абстрактный.
 * 
 * -------------------------------------------------------
 * | Библиотека: Dune                                     |
 * | Файл: Result.php                                     |
 * | В библиотеке: Dune/Mysqli/Iterator/Parent/Result.php |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>            |
 * | Версия: 1.02                                         |
 * | Сайт: www.rznw.ru                                    |
 * -------------------------------------------------------
 *
 * Версии:
 * 
 * 1.02 (2009 март 13)  Реализована поддержка сериализации и десериализации результатов.
 * 
 * 1.01 (2008 ноябрь 13) Реализован интрефейс Countable
 * 
 */
abstract class Dune_Mysqli_Iterator_Parent_Result implements Iterator, ArrayAccess, Countable
{
	
	protected $result, $numRows, $count = 0;
	
	protected $_resultArray = array();
	protected $_afterUnserialize = false;
	
    abstract protected function getEl();
    
	/**
	 * Принимает объект result после вызова метода query, класса mysqli
	 *
	 * @param mysqli $result
	 */
    public function __construct($result)
    {
        $this->result  = $result;
        $this->numRows = $result->num_rows;
    }

    public function __destruct()
    {
        if (is_resource($this->result)) {
            $this->result->free();
        }
    }
    
////////////////////////////////////////////////////////////////
///////////////////////////////     Методы интерфейса Iterator
	/**
	 * станавливает итеретор на первый элемент
	 *
	 * @return boolean
	 */
    public function rewind()
    {
        $this->count = 0;
        return true;
    }
	
    /**
     * возвращает текущий элемент
     *
     * @return mixed
     */
    public function current()
    {
        if ($this->_afterUnserialize)
        {
            return $this->_resultArray[$this->count];
        }
        else 
        {
            $this->result->data_seek($this->count);
            return $this->getEl();
        }
    }

    /**
     * Возвращает ключ текущего элемента
     *
     * @return mixed
     */
    public function key()
    {
        return $this->count;
    }
	
    /**
     * Переходит к следующему элементу
     *
     * @return Dune_Mysqli_Iterator_Parent_Result
     */
    public function next()
    {
        $this->count++;
//        return $this->current();
        return $this;
    }
	
    /**
     * Проверяет, существует ли текущий элемент после выполнения мотода rewind или next
     *
     * @return boolean
     */
    public function valid()
    {
        if ($this->_afterUnserialize)
        {
            if (isset($this->_resultArray[$this->count]))
                return true;
            else 
                return false;
        }
        else if ($this->count >= $this->numRows)
        {
            return false;
        }
        return true;
    }

    /**
     * Возвращает число строк з запросе
     *
     * @return integer
     */
    public function count()
    {
        return $this->numRows;
    }

    /**
     * Возвращает значение из строки запроса, приведенной в массив.
     *
     * @param integer $num номер строки в результате запроса
     * @param mixed $index индекс в массиве из одного ряда в запросе
     * @return misxed
     */
    public function get($num, $index = false)
    {
        if ($num >= $this->numRows) {
            return false;
        }
        $this->result->data_seek($num);
        $r = $this->getEl();
        if ($index === false)
        {
            return $r;
        }
        if (!is_array($r)) 
        {
            return false;
        }
        if (!isSet($r[$index])) 
        {
            return false;
        }
        return $r[$index];
    }

////////////////////////////////////////////////////////////////
///////////////////////////////     Методы интерфейса ArrayAccess
    
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }
    public function offsetSet($offset, $value)
    {
        return false;
    }
    public function offsetExists($offset)
    {
        return (($offset >= 0) && ($offset < $numRows));
    }
    public function offsetUnset($offset)
    {
        return false;
    }

    public function __sleep()
    {
        if ($this->numRows)
        {
            $this->_resultArray = array();
            foreach ($this as $value)
            {
                $this->_resultArray[] = $value;
            }
        }
        return array('_resultArray', 'numRows', 'count');
    }
    public function __wakeup()
    {
        $this->_afterUnserialize = true;
    }
    
}