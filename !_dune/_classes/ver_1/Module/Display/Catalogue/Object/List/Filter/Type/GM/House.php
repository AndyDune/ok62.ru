<?php

class Module_Display_Catalogue_Object_List_Filter_Type_GM_House extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        


$list = new Special_Vtor_Object_List_Type_House();


$session = Dune_Session::getInstance($this->session_zone);
//echo $session;
if ($session->levels)
    $list->setLevels();
else 
    $list->setRoomsCountArray(array(
                                    1 => $session->rooms_count_1,
                                    2 => $session->rooms_count_2,
                                    3 => $session->rooms_count_3,
                                    4 => $session->rooms_count_4,
                                    ));
                                    
    $list->setFloors(array(
                                    0 => $session->floor_count_0,
                                    1 => $session->floor_count_1,
                                    2 => $session->floor_count_2,
                                    ));

                                    

// Установка фильтра для всех типов
    $set_list = new Module_Display_Catalogue_Object_List_Filter_Type_Common();
    $set_list->list = $list;
    $set_list->session = $session;
    $set_list->adress_object = $this->adress_object;
    $set_list->type = $this->type;
    $set_list->no_ryazan = $this->no_ryazan;
    $set_list->make();
    $no_mediator = $set_list->getResult('no_mediator');    
    $list = $set_list->getResult('list');
/// клнец установки для всех типов
                                    
                                             
                                    
                                                
if ($session->house_type)
    $list->setHouseType($session->house_type);

if ($session->type_add and is_array($session->type_add))
{
    $array = $session->type_add;
    foreach ($array as $value)
        $list->setTypeAdd($value);
}   

if ($session->type_wall and is_array($session->type_wall))
{
    $array = $session->type_wall;
    foreach ($array as $value)
        $list->setWall($value);
}   
if ($session->have_bath)
    $list->setBath();
if ($session->have_land)
    $list->setLand();
if ($session->garage)
    $list->setGarage();


if ($session->condition)
    $list->setConditionArray($session->condition);
                                
    
    $list->setDeal($session->getInt('deal', null));

if ($session->phone)
    $list->setPhone();
if ($session->photo)
    $list->setPhoto();

if ($session->floor_no_first)
    $list->setFloorFrom();
if ($session->floor_from)
    $list->setFloorFrom($session->floor_from);



$x      = 0;
$result = null;
if ($session->new_building_flag_0 === 1)
{
    $x++;
    $result = 0;
}
if ($session->new_building_flag_1 === 1)
{
    $x++;
    $result = 1;
}   
if ($x == 1)
{
    $list->setNewBuilding($result);
}   
    
if ($session->floor_no_last)
    $list->setFloorTo();

if ($session->have_bath)
    $list->setBath();
    
    
if ($session->floor_to)
    $list->setFloorTo($session->floor_to);

if ($session->value_from)
    $list->setValueFrom($session->value_from);
if ($session->value_to)
    $list->setValueTo($session->value_to);
    
if ($session->price_from)
    $list->setPriceFrom($session->price_from);
if ($session->price_to)
    $list->setPriceTo($session->price_to);

    
$list->filter = $session->getZone(true);

if ($this->type)
    $list->setType($this->type);
    
    
    
    
    
    


$objects_list_run = $list->getListCumulateGroupInHouse(0, 1000);
      
$module = new Module_Display_Catalogue_Object_prepareForGM();    
$module->objects_list = $objects_list_run;
$module->make();
$data = $module->getResult('data');


$this->setResult('data', $data);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    