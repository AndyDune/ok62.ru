<?php

class Module_Display_Catalogue_Object_List_Filter_Type_Common extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        

$this->setResult('no_mediator', false);
$list = $this->list;
$session = $this->session;


/* 
        $session->seller_sk = null;
        $session->seller_an = null;
        $session->seller_f = null;
        $session->seller_array = null;
*/

$result = array();
if ($session->seller_sk)
{
    foreach (Special_Vtor_Data::$sellerSpecial as $value)
    {
        if ($value['type'] == 30 or  $value['type'] == 1000)
            $result[$value['id']] = $value['id'];
    }
}
if ($session->seller_an)
{
    foreach (Special_Vtor_Data::$sellerSpecial as $value)
    {
        if ($value['type'] == 20 or $value['type'] == 1000)
            $result[$value['id']] = $value['id'];
    }
} 
if (is_array($session->seller_array) and count($session->seller_array))
{
    $array = $session->seller_array;
    foreach ($array as $value)
    {
        $result[$value] = $value;
    }
}
if (count($result))
{
    $list->setSeller($result);
}
if ($session->seller_f)
{
    $list->setFSeller();
}

if ($session->seller_e)
{
    $list->setEdinstvo();
}


/*
if ($session->seller and $session->seller > 0)
    $list->setSeller($session->seller);
    
else if ($session->seller and $session->seller == -1)
{
    $array = array();
    foreach (Special_Vtor_Data::$sellerSpecial as $value)
    {
        $array[] = $value['id'];
    }
    $list->setSellerException($array);
}
*/

//    $this->adress_object->setStreet(0);
//    $this->adress_object->setHouse(0);
//    $this->adress_object->setGroup(0);
//    $this->adress_object->setBuilding(0);
//    $this->adress_object->setDistrict(0);

$list->setAdress($this->adress_object);
$list->setActivity(1);


$list->setDeal($session->getInt('deal', null));


if ($this->no_ryazan)   
    $list->setNoRyazan();

if ($session->price_from)
    $list->setPriceFrom($session->price_from);
if ($session->price_to)
    $list->setPriceTo($session->price_to);

if ($session->have_plan)
    $list->setPlan(1);
    
if ($session->have_panorama)
    $list->setPanorama(1);

if ($session->online)
    $list->setUserOnline(true);
    
if ($session->show_bad)
    $list->setShowWitoutHouseNumber(true);

if ($session->seller_over_the_counter)
{
    $list->setFSeller();
    $list->setSeller(Special_Vtor_Settings::$idOk62);
    $this->setResult('no_mediator', true);
}

$this->setResult('list', $list);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    