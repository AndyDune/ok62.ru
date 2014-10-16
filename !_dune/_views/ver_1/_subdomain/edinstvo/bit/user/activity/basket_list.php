<div id="catalogue-list">
<?php 
if ($this->data->count())
{
?>
<table>
<tr>
<th>Тип</th>
<th>Адрес</th>
<th>Цена</th>
<th></th>
</tr>
<?php
$cat_url = new Special_Vtor_Catalogue_Url_Collector();
foreach ($this->data as $one)
{  
$cat_url->setRegion($one['region_id']);
$cat_url->setArea($one['area_id']);
$cat_url->setSettlement($one['settlement_id']);
$cat_url->setStreet($one['street_id']);
$cat_url->setHouse($one['house_number']);
$cat_url->setDistrict($one['district_id']);
$cat_url->setType($one['type']);
$cat_url->setObject($one['id']);
     ?>
<tr>
<td><?php echo $one['name_type']?></td>
<td>
<a href="<?php echo $cat_url;?>">
<?php echo $one['name_settlement']?>, <?php echo $one['name_district']?>, улица <?php echo $one['name_street'];
if ($one['house_number'])
{
    ?>, дом <?php echo $one['house_number'];
}

if ($one['building_number'])
{
    ?>, корпус <?php echo $one['building_number'];
}

if ($one['room'] and $one['type'] == 1)
{
    ?>, квартира <?php echo $one['room'];
}
else if ($one['room'])
{
    ?>, Номер Н<?php echo $one['room'];
}

?>
</a>
</td>
<td><?php echo number_format($one['price'],0,'.',' ')?> руб.</td>
<td><a id="a-save-buttom" href="/user/do/savefrombasket/<?php echo $one['id']?>/">Удалить</a></td>
</tr>
   <?php    
}
?>

</table>
<?
if ($this->count > $this->navigator_per_page)
{

$navigator = new Dune_Navigate_Page($this->url, $this->count, $this->navigator_page, $this->navigator_per_page);
echo $navigator->getNavigator();
}
}
else 
{
    
}
?>
</div>