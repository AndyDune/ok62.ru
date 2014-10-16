<?php
/**
 * Коллектор условий FROM для запросов в BD.
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: From.php                                    |
 * | В библиотеке: Dune/Mysqli/Collector/From.php      |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 0.91                                      |
 * | Сайт: www.dune.rznw.ru                            |
 * ----------------------------------------------------
 *
 *  Истоия версий:
 * 
 * 0.91 (2009 май 12)
 * Метод addJoinConditionOn() внедрение условия для JOIN. Проверено.
 * 
 * 0.90 (2009 апрель 27)
 *  Работает только простое указание таблиц и их алиасов.
 * 
 */

class Dune_Mysqli_Collector_From
{
    protected $_accumulator = '';
    protected $_addedJoin = false;

    /**
     * Добавление таблицы в поле FORM
     *
     * @param string $field таблица
     * @param string $alias псевдомин таблицы
     * @return Dune_Mysqli_Collector_From
     */
    public function addTable($table, $alias = '')
    {
        if ($this->_accumulator)
            $this->_accumulator .= ', ';
        if ($alias)
            $this->_accumulator .= '`' . $table . '` AS `' . $alias . '`';
        else 
            $this->_accumulator .= '`' . $table . '`';
        return $this;
    }
    
    /**
     * Добавление таблицы LEFT JOIN в поле FORM
     *
     * @param string $field таблица
     * @param string $alias псевдомин таблицы
     * @return Dune_Mysqli_Collector_From
     */
    public function addJoinLeft($table, $alias = '')
    {
        if (!$this->_accumulator)
            throw new Dune_Exception_Base('Применяем LEFT JOIN к пустой таблице.');
        if ($alias)
        {
            $this->_addedJoin = $alias;
            $this->_accumulator .= ' LEFT JOIN `' . $table . '` AS `' . $alias . '`';
        }
        else 
        {
            $this->_addedJoin = $table;
            $this->_accumulator .= ' LEFT JOIN `' . $table . '`';
        }
//        $this->_addedJoin = true;
        return $this;
    }
    
    /**
     * Добавление условия для LEFT JOIN в поле FORM
     *
     * @param string $field таблица
     * @param string $alias псевдомин таблицы
     * @return Dune_Mysqli_Collector_From
     */
    public function addJoinConditionOnFullCondition($string)
    {
        if (!$this->_addedJoin)
            throw new Dune_Exception_Base('Применяем условие для LEFT JOIN ни к месту.');
            
        $this->_accumulator .= ' ON ' . $string ;
            
        $this->_addedJoin = false;
        return $this;
    }

    /**
     * Добавление условия для JOIN в поле FROM
     *
     * @param string $field1 поле присоединяемой таблица
     * @param string $field2 поле опорной таблицы
     * @param string $table2 опорная таблица - алиас
     * @return Dune_Mysqli_Collector_From
     */
    public function addJoinConditionOn($field1, $field2, $table2)
    {
        if (!$this->_addedJoin)
            throw new Dune_Exception_Base('Применяем условие для LEFT JOIN ни к месту.');
            
        $this->_accumulator .= ' ON `' . $this->_addedJoin . '`.`' . $field1 . '` = `' . $table2 . '`.`' . $field2 . '`';
            
        $this->_addedJoin = false;
        return $this;
    }
    
    
    /**
     * Добавление произвольной строки в поле FROM
     *
     * @param string $string произвольная строка
     * @return Dune_Mysqli_Collector_From
     */
    public function addString($string)
    {
        if ($this->_accumulator)
            $this->_accumulator .= ', ';
        $this->_accumulator .= $string;
        return $this;
    }
    

    /**
     * Сброс.
     *
     * @return Dune_Mysqli_Collector_From
     */
    public function clear()
    {
        $this->_accumulator = '';
        $this->_addedJoin = false;
        return $this;
    }

    /**
     * Выбор собранной строки.
     *
     * @return string
     */
    public function get($get_from = false)
    {
        if ($this->_accumulator)
        {
            if ($get_from)
                return ' FROM ' . $this->_accumulator;
            else 
                return $this->_accumulator;
        }
        return '';
    }
    
}