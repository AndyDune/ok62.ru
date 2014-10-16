<?php
/**
 * ��������� ������� � ORDER ��� �������� � BD
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Order.php                                   |
 * | � ����������: Dune/Mysqli/Collector/Order.php     |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 1.90                                      |
 * | ����: www.dune.rznw.ru                            |
 * ----------------------------------------------------
 *
 *  ������ ������:
 * 
 * 1.00 (2009 ������ 20)
 *  ���������� ����.
 * 
 */

class Dune_Mysqli_Collector_Order
{
    protected $_accumulator = '';

    /**
     * ���������� ������� ���������� ASC
     *
     * @param string $field ����
     * @param string $table ������� ��� ���������
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
     * ���������� ������� ���������� DESC
     *
     * @param string $field ����
     * @param string $table ������� ��� ���������
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
     * �����.
     *
     * @return Dune_Mysqli_Collector_Order
     */
    public function clear()
    {
        $this->_accumulator = '';
        return $this;
    }

    /**
     * ����� ��������� ������.
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