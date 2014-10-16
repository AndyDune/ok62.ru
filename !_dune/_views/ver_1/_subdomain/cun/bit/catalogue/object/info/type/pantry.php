<p id="object-page-info" class="object-page"><strong>Информация</strong></p>
<div id="object-info">
<h2 class="h2-object-info">Информация об объекте</h2>
<table id="two-col-table">
<tr><td class="left">
<h3>Расположение</h3>
<p class="p-adress">
<!-- Адресс на странице -->
<?php
if ($this->object->settlement_id == 1) {
if ($this->object->street_adding) { ?>улица <?php } else {?> <?php } echo $this->object->name_street;    
if ($this->object->house_number) {
?>, дом <?php echo $this->object->house_number;
if ($this->object->building_number) {
    $word = $this->object->building_number;
    $word = str_replace(array('a', 'b', 'c', 'd', 'e'), array('а', 'б', 'в', 'г', 'д'), $word);

    ?>, корпус <?php echo $word; }
 if ($this->object->room) {?>
, номер Н<?php echo $this->object->room; } 

}
?>
<p class="p-adress"><?php

  if ($this->object->district_id_plus > 1)
  {
      echo $this->object->name_district_plus, ' <em>(', $this->object->name_district, ')</em>';
  }
  else 
	  echo $this->object->name_district;


?></p>
<p class="p-adress-no-main">г. <?php echo $this->object->name_settlement ?></p>
<?php

} else {
?>

	<?php echo $this->object->name_region?>,<br />
	
    <?php if ($this->object->settlement_id != 1) { ?>
	<?php echo $this->object->name_area?>,
	
	<?php if ($this->object->settlement_id and $this->object->type_settlement < 100)  { ?>
	<?php echo $this->object->name_settlement?>,
	<?php } else { ?>
	<?php echo $this->object->settlement_name?>,
	<?php }  ?>
	
	
	<?php } else {
	    echo $this->object->name_district;?>,<?
                 }
	
	if ($this->object->street_id) { 
	  if ($this->object->street_adding) { ?> улица <?php } else {?> <?php }
	  echo $this->object->name_street;   
    } else
	{
	       echo $this->object->street_name;
	} 
	if ($this->object->house_number)
	{
	?>, дом <?php echo $this->object->house_number;
	}
	if ($this->object->building_number) { 
	?>, корпус <?php echo $this->object->building_number; }
	
	if ($this->object->room)
	 {
	    if ($this->object->type == 1) {
	 ?>, квартира <?php
        } else {
            ?>, номер Н<?php
        }
	   echo $this->object->room;
	    } ?>
<?php } ?>
<!--/ Адресс на странице -->

</p>
    
<p class="preview_big">
<?php if ($this->preview_big) { ?>
<a class="thickbox" href="<?php echo $this->preview_sourse?>" />
<img width="300" height="300" src="<?php echo $this->preview_big?>" />
</a>
<?php } else { ?>
<img width="300" height="300" src="<?php echo $this->view_folder?>/img/house-300.png" />
<?php }?>

</p>
</td><td>



<h3>Основные параметры</h3>
<table class="object-parameters-list">

<?php if ($this->object->type_house > 1)
{ ?>
<tr>
<td class="object-prompting">Тип дома:</td>
<td>
<?php
$text = '';
foreach ($this->house_type as $value)
{
    if ($value['id'] == $this->object->type_house)
        $text = $value['name'];
}
if ($text) 
{ ?><span class="form-field-value"><?php
    echo $text; 
  ?></span><?php
}
else
{
  ?><span class="form-field-none">не указано</span><?php
}
?>
</td>
</tr>
<?php } ?>


<?php if ($this->object->porch_text)
{ ?>
<tr>
<td class="object-prompting">Подъезд</td>
<td>
<?php echo $this->object->porch_text ?>
</td>
</tr>
<?php } else if ($this->object->porch_text) {?> 
<tr>
<td class="object-prompting">Подъезд</td>
<td>
<?php echo $this->object->porch ?>
</td>
</tr>
<?php } ?>


<?php
$no_cok = false;
if ($this->object->floor_2 > 0 and ($this->object->floor > 0 or $this->object->floor < 0))
{ 
    $no_cok = true;
    ?>
<tr>
<td class="object-prompting">Располагается между этажами: </td>
<td>
<?php
if ($this->object->floor < 0)
{
    ?>цокольным и <?php
} else 
{
    ?> <?php echo $this->object->floor ?> и <?php
}
?>
<?php echo $this->object->floor_2; ?>
</td>
</tr>

<?php if ($this->object->floors_total) { ?>
<tr>
<td class="object-prompting">Этажей в доме</td>
<td>
<?php echo $this->object->floors_total; ?>
</td>
</tr>
<?php } ?>


<?php } else if ($this->object->floor > 0)
{ ?>
<tr>
<td class="object-prompting">Этаж/этажей в доме</td>
<td>
<?php echo $this->object->floor;
if ($this->object->floors_total) { ?>/<?php echo $this->object->floors_total; } else {?>/-<?php } ?>
</td>
</tr>
<?php } ?>



<?php if ($this->object->type_add and $this->object->type_add >  1)
{
?><tr>
<td class="object-prompting">Тип</td>
<td>
<?php echo $this->object->name_type_add ?>
</td>
</tr>
<?php } ?>



<tr>
<td class="object-prompting">Площадь:</td>
<td>
<?php echo $this->object->space_total ?> кв.м.
</td>
</tr>


<?php if ($this->object->height_ceiling) {?>
<tr>
<td class="object-prompting">Высота потолков</td>
<td>
<?php echo $this->object->height_ceiling ?> м.
</td>
</tr>
<?php } ?>



</table>


<?php if ($this->object->floor < 0 and !$no_cok)
{ ?>
<p class="object-one-param">
<span>цокольный этаж</span>
</p>
<?php } ?>





<?php ob_start();
$have = false;
?>

<h3>Детали</h3>

<table class="object-parameters-list">


<?php if ($this->condition) { ?>
<tr>
<td class="object-prompting">Состояние:</td>
<td>
<?php
$check = ' - ';
foreach ($this->condition as $value)
{
    if ($value['id'] == $this->object->condition)
    {
        $have = true;
        $check = $value['name'];
        break;
    }
}
echo $check;
?>
</td>
</tr>

<?php } ?>
</table>

<?php if ($this->object->have_phone)
{
    $have = true;
    ?>
<p class="object-one-param">
<span>есть городской телефон</span>
</p>
<?php } ?>


<?php if ($this->object->balcony) {
    $have = true;
    ?>
<p class="object-one-param">есть <span>балкон</span><?php if ($this->object->space_balcony) { 
?>, площадь <span><?php echo $this->object->space_balcony; ?></span> кв. м.
<?php } ?></p>
<?php } ?>

<?php 
if ($this->object->loggia) { 
    $have = true;
    ?>
<p class="object-one-param">есть <span>лоджия</span><?php if ($this->object->space_loggia) { 
?>, площадь <span><?php echo $this->object->space_loggia; ?></span> кв. м.
<?php } ?></p>
<?php } ?>

<?php 
$text = ob_get_clean();
if ($have)
    echo $text;
 ?>

</td></tr>
</table>



<?php if ($this->object->info_text) {?>
<dl class="dl-description-long">
<dt>Описание</dt>
<dd>
<?php 
echo str_replace("\n", '<br />', $this->object->info_text);
?>
</dd>
</dl>
<?php } ?>

<?php if ($this->object->info_comment) {?>
<dl class="dl-description-long">
<dt>Комментарий</dt>
<dd><em>
<?php 
echo str_replace("\n", '<br />', $this->object->info_comment);
?></em>
</dd>
</dl>
<?php } ?>


<?php if ($this->object->info_show_condition) {?>
<dl class="dl-description-long" id="info_show_condition">
<dt>Условия показа</dt>
<dd>
<?php 
echo str_replace("\n", '<br />', $this->object->info_show_condition);
?>
</dd>
</dl>
<?php } ?>


<?php if ($this->object->info_contact) {?>
<dl class="dl-description-long" id="info_contact">
<dt>Дополнительная контактная информация</dt>
<dd>
<?php 
echo str_replace("\n", '<br />', $this->object->info_contact);
?>
</dd>
</dl>
<?php } ?>



<?php if ($this->object->price_one)
{
?><p class="p-object-shot-price">Цена за 1 кв.м.: <span class="focus-red"><?php echo number_format($this->object->price_one, '0', '.',' ')?> руб.</span>
</p><?php
}
?>

<?php if ($this->object->price or !$this->object->price_rent) { ?>
<p class="p-object-shot-price">Цена: 
<?php if (!$this->object->price) { ?>
<span class="focus-red">Договорная</span>
<?php } else  { ?>
<span class="focus-red"><?php echo number_format($this->object->price, '0', '.',' ')?> руб.</span>
<?php }?>
</p>
<?php } ?>

<?php if ($this->object->price_rent)
{
?><p class="p-object-shot-price">Цена за 1 месяц аренды: <span class="focus-red"><?php echo number_format($this->object->price_rent, '0', '.',' ')?> руб.</span>
</p><?php
}
?>


<p class="p-object-shot-price-valuta"></p>

</div>

