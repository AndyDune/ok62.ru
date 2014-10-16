<?php

class Module_Display_Catalogue_Object_List_Filter_Type_GE_Land extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        


$list = new Special_Vtor_Object_List_Type_Land();


$session = Dune_Session::getInstance($this->session_zone);
//echo $session;
                                    

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
                                    
                                             


if ($session->condition)
    $list->setConditionArray($session->condition);
                                
    
    $list->setDeal($session->getInt('deal', null));

if ($session->photo)
    $list->setPhoto();


if ($session->value_from_land)
    $list->setValueFrom($session->value_from_land);
if ($session->value_to_land)
    $list->setValueTo($session->value_to_land);
    
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
    
    