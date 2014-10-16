<?php

class Module_Sub_View_GenerateArrayFotGrid extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        

    $porchs = $this->porchs;
    $objects = $this->objects;

    $result_array = array();
    
    print_array($objects);
    
    print_array($porchs);
    
    
    foreach ($porchs as $porch)
    {
//        print_array($porch);
        if (
            !$porch['number_object_min']
            or !$porch['number_object_max']
            or !$porch['count_on_level']
            )
        {
                throw new Dune_Exception_Base('� ������ ��� ������ �������� ��� ����������� ������: level_end ��� level_end.');
        }
        $current_room = $porch['number_object_min'];
        
        $have_cokol = $porch['have_cokol'];
        
        $array_porchs = array();
        if ($porch['level_begin'] > $porch['level_end'])
        {
            throw new Dune_Exception_Base('������������ �����: ���� level_end ����� ���� ������ level_begin.');
        }
        $empty_was = $empty = $porch['level_1_position_empty']; // ���������� � ������ ����� ��������� ������� �� ������
        for ($current_level = $porch['level_begin']; $current_level <= $porch['level_end']; $current_level++) // ���������� �����
        {
            $array = array();
            $current_room_max = $current_room + $porch['count_on_level'] - 1;
            $count_on_level = $porch['count_on_level'];
            $go_next_on_level = true;
            $array_rooms_on_level = array();
            while ($go_next_on_level) // ���� �� �����
            {
                if ($empty > 0) // ���������� � 1-� ����� ��������� �������
                {
                    $array_rooms_on_level[] = false;
                    $empty--;
                    $count_on_level--;
                    continue;
                }
                if (key_exists($current_room, $objects))
                {
                    $array_rooms_on_level[] = $objects[$current_room];
                    unset($objects[$current_room]);
                }
                else 
                    $array_rooms_on_level[] = $current_room;
                $current_room++;
                if ($current_room > $current_room_max or ($count_on_level < 2))
                    $go_next_on_level = false;
                $empty_was = 0;
                $count_on_level--;
            }
            krsort($array_rooms_on_level);
            $array = array();
            foreach ($array_rooms_on_level as $value)
            {
                $array[] = $value;
            }
            $array_porchs[$current_level] = $array;
        }
        krsort($array_porchs);
        $result_array[$porch['number']] = $array_porchs;
        
    }
    krsort($result_array);
/*    $array = array();
    foreach ($result_array as $value)
    {
        $array[] = $value;
    }
    $result_array = $array;
*/    
    
//    print_array($result_array);
    
    $this->setResult('data', $result_array);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    
