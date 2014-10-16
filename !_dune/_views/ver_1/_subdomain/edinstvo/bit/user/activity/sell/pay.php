<div id="catalogue-list">
<table>
<tr>
<th>Тип</th>
<th>Код</th>
<th>Адрес</th>
<th>Цена</th>
<th>Активность</th>
</tr>

<?php 
/////       Если есть продаваемые
if ($this->count)
{
?>
<?php
$cat_url = new Special_Vtor_Catalogue_Url_Collector();
foreach ($this->data as $one)
{  
$cat_url->setRegion($one['region_id']);
$cat_url->setArea($one['area_id']);
$cat_url->setSettlement($one['settlement_id']);
$cat_url->setStreet($one['street_id']);
$cat_url->setHouse($one['house_number']);
if (Special_Vtor_Settings::$districtPlus)
{
    $cat_url->setDistrict($one['district_id_plus'], true);
}
else 
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
if ($one['activity'] == 1)
{
    ?>активен<?php
}
else
{
        ?>не активен<?php
}
// <a id="a-save-buttom" href="/user/do/deletefromquery/<?php echo $one['id']/">Удалить</a>
?>
</td>
</tr>
   <?php    
} ?>
</table>
<?php } else { ?>
</table>
<p class="p-center-say">У Вас нет объектов в каталоге</p>
<?php } ?>








</div>