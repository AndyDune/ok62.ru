<a href="/public/sell/" id="">Выставить на продажу</a>

<div id="catalogue-list">

<?php 
if ($this->count)
{
?>
<h3>В очереди на добавление</h3>
<table>
<tr>
<th>Тип</th>
<th>Дата</th>
<th>Адрес</th>
<th>Цена</th>
<th>Статус</th>
<th></th>
</tr>
<?php

foreach ($this->data_sell_query as $one)
{  
     ?>
<tr>
<td><?php echo $one['name_type']?></td>
<td style="text-align:center;"><?php echo substr($one['time'], 0, 10)?><br /> <?php echo substr($one['time'], 10, 6)?></td>
<td>
<?php if ($one['status'] > 1) { ?>

<?php } else {?>
<a href="/public/sell/<?php echo $one['name_type_code']?>/?edit=<?php echo $one['id']?>" title="Редактировать">
<?php } ?>
Рязань, улица <?php echo $one['street'];
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
    ?>, Номер <?php echo $one['room'];
}

?>
<?php if ($one['status'] < 2) { ?>
</a>
<?php } ?>
</td>
<td><?php echo number_format($one['price'],0,'.',' ')?> руб.</td>
<td style="text-align:center;">
<?php if ($one['result_id']) { ?>
<a href="/catalogue/type/<?php echo $one['type']; ?>/object/<?php echo $one['result_id']; ?>/">принят</a>
<?php } else  if ($one['status'] == 0) { ?>
редактируется
<?php } else  if ($one['status'] == 1) { ?>
отправлен на рассмотрение
<?php } else  if ($one['status'] == 2) { ?>
обрабатывается
<?php } else  if ($one['status'] == 4) { ?>
отклонен
<?php } ?>

</td>

<td>
<?php if ($one['status'] != 2) { ?>
<a id="a-save-buttom" href="/user/do/deletefromquery/<?php echo $one['id']?>/" title="Удаление из очереди заявок на размещение">Удалить из очереди</a>
<?php } ?>
</td>
</tr>
   <?php    
}
    
?></table><?php
}
?>



<?php 
/////       Если есть продаваемые
if ($this->count_sell)
{
?>
<h3>Продаются</h3>
<table>
<tr>
<th>Тип</th>
<th>Код</th>
<th>Адрес</th>
<th>Цена</th>
</tr>
<?php
$cat_url = new Special_Vtor_Catalogue_Url_Collector();
foreach ($this->data_sell as $one)
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
<td><?php echo $one['id']?></td>
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
    ?>, Номер <?php echo $one['room'];
}

?>
</a>
</td>
<td><?php echo number_format($one['price'],0,'.',' ')?> руб.</td>
<td>
<?php
// <a id="a-save-buttom" href="/user/do/deletefromquery/<?php echo $one['id']/">Удалить</a>
?>
</td>
</tr>
   <?php    
} ?>
</table>
<?php } ?>





<?php 
/////       Не активные
if ($this->count_sell_na)
{
?>
<h3>Зарезервировано.</h3>
<table>
<tr>
<th>Тип</th>
<th>Код</th>
<th>Адрес</th>
<th>Цена</th>
</tr>
<?php
$cat_url = new Special_Vtor_Catalogue_Url_Collector();
foreach ($this->data_sell_na as $one)
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
<td><?php echo $one['id']?></td>
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
    ?>, Номер <?php echo $one['room'];
}

?>
</a>
</td>
<td><?php echo number_format($one['price'],0,'.',' ')?> руб.</td>
<td>
<?php
// <a id="a-save-buttom" href="/user/do/deletefromquery/<?php echo $one['id']/">Удалить</a>
?>
</td>
</tr>
   <?php    
}
?> </table>
<?php } ?>

<?php 
/////       Снятое с продажи
if ($this->count_sell_h)
{
?>
<h3>Снятое с продажи.</h3>
<table>
<tr>
<th>Тип</th>
<th>Код</th>
<th>Адрес</th>
<th>Цена</th>
</tr>
<?php
$cat_url = new Special_Vtor_Catalogue_Url_Collector();
foreach ($this->data_sell_h as $one)
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
<td><?php echo $one['id']?></td>
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
    ?>, Номер <?php echo $one['room'];
}

?>
</a>
</td>
<td><?php echo number_format($one['price'],0,'.',' ')?> руб.</td>
<td>
<?php
// <a id="a-save-buttom" href="/user/do/deletefromquery/<?php echo $one['id']/">Удалить</a>
?>
</td>
</tr>
   <?php    
} ?>
</table>
<?php } ?>





</div>