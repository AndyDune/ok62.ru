<?php

class Module_Display_Catalogue_Object_prepareForGM extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        


$objects_list_run = $this->objects_list;

$groups = array();
$complex = array();
$data = array();
$objects = array();
$objects_list_list = array();


foreach ($objects_list_run as $key => $value)
{
    if ($value['group'] > 1)
    {
       $groups[$value['group']][] = $value;
       continue;
    }
    $objects[] = $value;
}

if (count($groups))
{
    foreach ($groups as $key => $value)
    {
        $count = 0;
        $price_min = -1;
        $price_max = 0;
        
        $space_min = -1;
        $space_max = 0;
        
        $group_data = $value[0];
        if (count($value) == 1)
        {
            $objects[] = $group_data;
            continue;
        }
        $group_data['house_number'] = '';
        $group_data['building_number'] = '';
        
        $house_building_number_array = array();
        
        foreach ($value as $object)
        {
            $count += $object['count_in_group'];
            if ((int)$object['price_min'] or $price_min < 0 )
            {
                $price_min = $object['price_min'];
            }
            if ((int)$object['price_max'] > $price_max)
            {
                $price_max = $object['price_max'];
            }

            if ((int)$object['space_min'] or $space_min < 0 )
            {
                $space_min = $object['space_min'];
            }
            if ((int)$object['space_max'] > $space_max)
            {
                $space_max = $object['space_max'];
            }
            if ($object['house_number'])
                $house_building_number_array[$object['house_number'] . $object['building_number']] = array($object['house_number'], $object['building_number']);
        }
        $group_data['house_building_number_array'] = $house_building_number_array;
        $group_data['price_max'] = $price_max;
        $group_data['price_min'] = $price_min;

        $group_data['space_max'] = round($space_max);
        $group_data['space_min'] = round($space_min);
        
        $group_data['count_in_group'] = $count;
        $objects[] = $group_data;
    }
}



foreach ($objects as $key => $value)
{
    $run = array();
    $run['header'] = '';
    $gm_param = false;
    $header_name = false;
    if ($value['group_gm_x'])
    {
        $run['x'] = $value['group_gm_x'];
        $run['y'] = $value['group_gm_y'];
        $run['header'] = $value['group_name'];
        $gm_param = 'group';
    }
    else if ($value['house_gm_x'])
    {
        $run['x'] = $value['house_gm_x'];
        $run['y'] = $value['house_gm_y'];
        $run['header'] = $value['house_name'];
        $gm_param = 'house';
    }
    else if ($value['gm_x'])
    {
        $run['x'] = $value['gm_x'];
        $run['y'] = $value['gm_y'];
    }
    else
    {
        $run['x'] = $value['settlement_gm_x'];
        $run['y'] = $value['settlement_gm_y'];
    }
    
    if ($gm_param)
    { 
        if ($value[$gm_param . '_gm_image'])
        {
            $run['image'] = $value[$gm_param . '_gm_image'];
            if ($value[$gm_param . '_gm_shadow'])
            {
                $run['shadow'] = $value[$gm_param . '_gm_shadow'];
            }
            
            if ($value[$gm_param . '_gm_iconSize_x'] and $value[$gm_param . '_gm_iconSize_y'])
            {
                $run['iconSize'] = array($value[$gm_param . '_gm_iconSize_x'], $value[$gm_param . '_gm_iconSize_y']);
            }
            if ($value[$gm_param . '_gm_shadowSize_x'] and $value[$gm_param . '_gm_shadowSize_y'])
            {
                $run['shadowSize'] = array($value[$gm_param . '_gm_shadowSize_x'], $value[$gm_param . '_gm_shadowSize_y']);
            }
            if ($value[$gm_param . '_gm_iconAnchor_x'] and $value[$gm_param . '_gm_iconAnchor_y'])
            {
                $run['iconAnchor'] = array($value[$gm_param . '_gm_iconAnchor_x'], $value[$gm_param . '_gm_iconAnchor_y']);
            }
            
            $gm_param = false;
        }
    }
    
    $run['title'] = 'Объектов под маркером: ' . $value['count_in_group'];
    
        $cat_url = new Special_Vtor_Catalogue_Url_Collector();
        $cat_url->setRegion($value['region_id']);
        $cat_url->setArea($value['area_id']);
        $cat_url->setSettlement($value['settlement_id']);
        $cat_url->setStreet($value['street_id']);
        $cat_url->setHouse($value['house_number']);
        $cat_url->setBuilding($value['building_number']);
        $cat_url->setGroup($value['group']);
        if (Special_Vtor_Settings::$districtPlus)
            $cat_url->setDistrict($value['district_id_plus'], true);
        else 
            $cat_url->setDistrict($value['district_id']);
        $cat_url->setType($value['type']);
    
    if ($value['count_in_group'] == 1)
    {
        $cat_url->setObject($value['id']);
        
        $module = new Module_Display_Catalogue_Object_InfoOneGM();
        $module->object = $value;
        $module->header = $run['header'];
        $module->link = $cat_url->get();
        $module->make();
        
        $run['comment'] = str_replace(array("\r", "\n"), '', $module->getOutput());
    }
    else 
    {
        $module = new Module_Display_Catalogue_Object_InfoHouseGM();
        $module->object = $value;
        $module->header = $run['header'];
        $module->link = $cat_url->get();
        $module->make();
        
        $run['comment'] = str_replace(array("\r", "\n", "'"), array('', '', '"'), $module->getOutput());
        
    }
    
    $data[] = $run;
}


$this->setResult('data', $data);




/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    