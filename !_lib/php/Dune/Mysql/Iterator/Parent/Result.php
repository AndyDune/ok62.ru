<?php
/**
 * Результат выполнения запроса (итератор).
 * Абстрактный.
 * 
 * Используется с устаревшими методиками. С библиотекой mysql.
 * 
 * -------------------------------------------------------
 * | Библиотека: Dune                                     |
 * | Файл: Result.php                                     |
 * | В библиотеке: Dune/Mysql/Iterator/Parent/Result.php |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>           |
 * | Версия: 1.00                                         |
 * | Сайт: www.rznlf.ru                                   |
 * -------------------------------------------------------
 *
 */
abstract class Dune_Mysql_Iterator_Parent_Result implements Iterator, ArrayAccess
{

    protected $result = false;
    protected $numRows = 0;
    protected $count = 0;
    
    protected $error = '';
    
	
    abstract protected function getEl();
    
   
    public function __construct($result, $exeption = true)
    {
        if ($result === false)
        {
            if ($exeption)
                throw new Dune_Exception_Mysql('Ошибка в выполнении запроса');
            else 
                $this->error = 'Ошибка в выполнении запроса';
        }
        else 
        {
            $this->result  = $result;
            $this->numRows = mysql_num_rows($result);
        }
    }

    public function __destruct()
    {
        if ($this->result)
        {
            unset($this->result);
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
        mysql_data_seek($this->result, $this->count);
        return $this->getEl();
    }

    /**
     * возвращает ключ текущего элемента
     *
     * @return mixed
     */
    public function key()
    {
        return $this->count;
    }
	
    /**
     * переходит к следующему элементу
     *
     * @return mixed
     */
    public function next()
    {
        $this->count++;
        //return $this->current(); // Ошибка вывода последнего
    }
	
    /**
     * проверяет, существует ли текущий элемент после выполнения мотода rewind или next
     *
     * @return unknown
     */
    public function valid()
    {
        if ($this->count >= $this->numRows) {
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
        mysql_data_seek($this->result, $num);
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



}