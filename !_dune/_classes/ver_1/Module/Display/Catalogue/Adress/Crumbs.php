<?php

class Module_Display_Catalogue_Adress_Crumbs extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        

$crumbs = Dune_Display_BreadCrumb::getInstance();
$crumbs->addCrumb('Главная', '/');
$crumbs->addCrumb('Каталог', '/catalogue/');
if ($this->special)
    $crumbs->addCrumb('Все спецпредложения', '/catalogue/spec/');

    $cat_url = new Special_Vtor_Catalogue_Url_Collector();
    $cat_url->setRegion(1);
//    $cat_url->setArea(1);
    
    if ($this->adress_object->getDistrictPlus())
    {
        $cat_url->setDistrict(0, true);
    }


if ($this->type)
    $cat_url->setType($this->type);

$good = false;
if ($this->adress_object->getSettlementId() != 1 and !$this->no_adress)
{
    $cat_url->setRegion($this->adress_object->getRegionId());
    $crumbs->addCrumb($this->adress_object->getRegionName(), $cat_url->get());
    $good = true;
}
    $cat_url->setArea($this->adress_object->getAreaId());
if ($this->adress_object->getAreaId() and $this->adress_object->getSettlementId() != 1 and !$this->no_adress and $this->adress_object->getRegionId() < 2) /// ТОлько для разани
{
    $cat_url->setArea($this->adress_object->getAreaId());
    $crumbs->addCrumb($this->adress_object->getAreaName(), $cat_url->get());
    $good = true;
}

if ($good and $this->adress_object->getSettlementType() == 100)
{
    $crumbs->addCrumb('Поселок');
    $good = true;
   
}
else if ($this->adress_object->getSettlementId() and !$this->no_adress)
{
    $cat_url->setSettlement($this->adress_object->getSettlementId());
    
    $crumbs->addCrumb($this->adress_object->getSettlementName(), $cat_url->get());
    
    $good = true;
}

if ($good and $this->adress_object->getDistrictPlus())
{
    if ($this->adress_object->getDistrictId() > 1)
    {
        $cat_url->setDistrict($this->adress_object->getDistrictId(), true);
        $crumbs->addCrumb($this->adress_object->getDistrictName(), $cat_url->get());
    }
    $good = true;
}
else if ($good and $this->adress_object->getDistrictId())
{
    $cat_url->setDistrict($this->adress_object->getDistrictId());
    $crumbs->addCrumb($this->adress_object->getDistrictName(), $cat_url->get());
    $good = true;
}
else
{
//    $good = false;
    $good = true;
}

if ($good and $this->adress_object->getStreetId())
{
    $cat_url->setStreet($this->adress_object->getStreetId());
    $crumbs->addCrumb('улица ' . $this->adress_object->getStreetName(), $cat_url->get());
    $good = true;
}
else 
{
//    $good = false;
    $good = true;
}

//echo $this->object_name; die();

if ($good and $this->object_name)
{
    $crumbs->addCrumb($this->object_name);
    $good = true;
}
else 
    $good = false;
    
echo $crumbs;




/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    