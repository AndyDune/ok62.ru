<?php
/**
 * Коллектор условий в ORDER для запросов в BD
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Order.php                                   |
 * | В библиотеке: Dune/Mysqli/Collector/Order.php     |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.90                                      |
 * | Сайт: www.dune.rznw.ru                            |
 * ----------------------------------------------------
 *
 *  Истоия версий:
 * 
 * 1.00 (2009 апрель 20)
 *  Рализована база.
 * 
 */

class Dune_Mysqli_Collector_Order
{
    protected $_accumulator = '';

    /**
     * Добавление порядка сортировки ASC
     *
     * @param string $field поле
     * @param string $table таблица или псевдоним
     * @return Dune_Mysqli_Collector_Order
     */
    public function addASC($field, $table = false)
    {
        if ($this->_accumulator)
            $this->_accumulator .= ', ';
        if ($table)
            $this->_accumulator .= '`' . $table . '`.`' . $field . '` ASC';
        else 
            $this->_accumulator .= '`' . $field . '` ASC';
        return $this;
    }

    /**
     * Добавление порядка сортировки DESC
     *
     * @param string $field поле
     * @param string $table таблица или псевдоним
     * @return Dune_Mysqli_Collector_Order
     */
    public function addDESC($field, $table = false)
    {
        if ($this->_accumulator)
            $this->_accumulator .= ', ';
        if ($table)
            $this->_accumulator .= '`' . $table . '`.`' . $field . '` DESC';
        else 
            $this->_accumulator .= '`' . $field . '` DESC';
        return $this;
    }

    /**
     * Сброс.
     *
     * @return Dune_Mysqli_Collector_Order
     */
    public function clear()
    {
        $this->_accumulator = '';
        return $this;
    }

    /**
     * Выбор собранной строки.
     *
     * @return string
     */
    public function get()
    {
        if ($this->_accumulator)
        {
            return ' ORDER BY ' . $this->_accumulator;
        }
        return '';
    }
    
}