<?php
$crumbs = Dune_Display_BreadCrumb::getInstance();
$crumbs->addCrumb('Главная', '/');
$crumbs->addCrumb('Каталог', '/catalogue/');

    $cat_url = new Special_Vtor_Catalogue_Url_Collector();
    $cat_url->setRegion(1);
    $cat_url->setArea(1);
    

if ($this->type)
    $cat_url->setType($this->type);

$good = false;
if ($this->adress_object->getSettlementId())
{
    $cat_url->setSettlement($this->adress_object->getSettlementId());
    $crumbs->addCrumb($this->adress_object->getSettlementName(), $cat_url->get());
    $good = true;
}
if ($good and $this->adress_object->getDistrictId())
{
    $cat_url->setDistrict($this->adress_object->getDistrictId());
    $crumbs->addCrumb($this->adress_object->getDistrictName(), $cat_url->get());
    $good = true;
}
else 
    $good = false;

if ($good and $this->adress_object->getStreetId())
{
    $cat_url->setStreet($this->adress_object->getStreetId());
    $crumbs->addCrumb('улица ' . $this->adress_object->getStreetName(), $cat_url->get());
    $good = true;
}
else 
    $good = false;

if ($good and $this->object_name)
{
    $crumbs->addCrumb($this->object_name);
    $good = true;
}
else 
    $good = false;
    
echo $crumbs;
?>