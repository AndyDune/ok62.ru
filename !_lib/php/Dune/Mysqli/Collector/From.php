<?php
/**
 * ��������� ������� FROM ��� �������� � BD.
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: From.php                                    |
 * | � ����������: Dune/Mysqli/Collector/From.php      |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 0.91                                      |
 * | ����: www.dune.rznw.ru                            |
 * ----------------------------------------------------
 *
 *  ������ ������:
 * 
 * 0.91 (2009 ��� 12)
 * ����� addJoinConditionOn() ��������� ������� ��� JOIN. ���������.
 * 
 * 0.90 (2009 ������ 27)
 *  �������� ������ ������� �������� ������ � �� �������.
 * 
 */

class Dune_Mysqli_Collector_From
{
    protected $_accumulator = '';
    protected $_addedJoin = false;

    /**
     * ���������� ������� � ���� FORM
     *
     * @param string $field �������
     * @param string $alias ��������� �������
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
     * ���������� ������� LEFT JOIN � ���� FORM
     *
     * @param string $field �������
     * @param string $alias ��������� �������
     * @return Dune_Mysqli_Collector_From
     */
    public function addJoinLeft($table, $alias = '')
    {
        if (!$this->_accumulator)
            throw new Dune_Exception_Base('��������� LEFT JOIN � ������ �������.');
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
     * ���������� ������� ��� LEFT JOIN � ���� FORM
     *
     * @param string $field �������
     * @param string $alias ��������� �������
     * @return Dune_Mysqli_Collector_From
     */
    public function addJoinConditionOnFullCondition($string)
    {
        if (!$this->_addedJoin)
            throw new Dune_Exception_Base('��������� ������� ��� LEFT JOIN �� � �����.');
            
        $this->_accumulator .= ' ON ' . $string ;
            
        $this->_addedJoin = false;
        return $this;
    }

    /**
     * ���������� ������� ��� JOIN � ���� FROM
     *
     * @param string $field1 ���� �������������� �������
     * @param string $field2 ���� ������� �������
     * @param string $table2 ������� ������� - �����
     * @return Dune_Mysqli_Collector_From
     */
    public function addJoinConditionOn($field1, $field2, $table2)
    {
        if (!$this->_addedJoin)
            throw new Dune_Exception_Base('��������� ������� ��� LEFT JOIN �� � �����.');
            
        $this->_accumulator .= ' ON `' . $this->_addedJoin . '`.`' . $field1 . '` = `' . $table2 . '`.`' . $field2 . '`';
            
        $this->_addedJoin = false;
        return $this;
    }
    
    
    /**
     * ���������� ������������ ������ � ���� FROM
     *
     * @param string $string ������������ ������
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
     * �����.
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
     * ����� ��������� ������.
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