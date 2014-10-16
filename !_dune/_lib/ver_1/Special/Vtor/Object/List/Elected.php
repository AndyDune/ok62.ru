<?php
/**
 * 
 * Список данных об объекте.
 * 
 */
class Special_Vtor_Object_List_Elected extends Special_Vtor_Object_List
{
    protected $_elected_rows = '';
    protected function _addWhereSpecial()
    {
        
        if ($this->_elected_rows)
        {
            $str = ' `el`.`object_id` = `objects`.`id`'; // AND `el`.`selection_id` = ' . $this->_id;
            $str .= ' AND `objects`.`id` IN (' . $this->_elected_rows . ') ';
        }
        else 
        {
            if ($this->_id == 1)
            {
                $str = ' `el`.`object_id` = `objects`.`id` AND `el`.`selection_id` IN (1, 3)';
            }
            else 
                $str = ' `el`.`object_id` = `objects`.`id` AND `el`.`selection_id` = ' . $this->_id;
        }
        return $str;
    }
    
    protected function _setFromStringSpecial()
    {
        return ' `unity_catalogue_object_elected` as el';
    }
    
    
    /**
     * Добавление порядка выборки. Поле порядка.
     *
     * @param string $order направление ADC или DESC
     */
    public function setOrderOrder($order = '')
    {
        if (!$this->_orderString)
            $this->_orderString = ' ORDER BY';
        $this->_orderString .= ' el.order ' . $order;
    }
    
    public function getRandomRows($count = 4, $special = true)
    {
        $coun_s = $count;
        $q = 'SELECT unity_catalogue_object_elected.object_id as id FROM unity_catalogue_object_elected, unity_catalogue_object
              WHERE unity_catalogue_object.`activity` = 1
                    AND
                    unity_catalogue_object.`id` = unity_catalogue_object_elected.`object_id`
                     AND
                     unity_catalogue_object_elected.`selection_id` = ?i';
        $array =  $this->DB->query($q, array($this->_id), Dune_MysqliSystem::RESULT_COL);
        $count_array = count($array);
        $str = '';
        if (!$count_array)
            return array();
        if ($count >= $count_array)
        {
            $str = implode(',', $array);
        }
        else 
        {
            $one = '';
            if ($this->_id == 1 and $special)
            {
                $array_spec =  $this->DB->query($q, array(3), Dune_MysqliSystem::RESULT_COL);            
                if (count($array_spec))
                {
                    shuffle($array_spec);
                    $one = $array_spec[0] . ',';
                    $count--;
                    //die();
                }
            }
            shuffle($array);
            $array_shuffle = array_slice($array, 0, $count);
            $str = $one . implode(',', $array_shuffle);
           // die();
        }
        $this->_elected_rows = $str;
        $this->setOrder('selection_id' , 'DESC', 'el');
        return $this->getListCumulate(0, $coun_s);
        
/*        echo '<pre>';
        print_r($array_shuffle);
        echo '</pre>';
        
        die();
*/        
        
    }
}