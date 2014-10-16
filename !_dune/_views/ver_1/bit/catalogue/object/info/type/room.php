<?php
$heating      = array(2 => 'автономное', 'центральное', 'индивидуальное');
$water_cold   = array(2 => 'автономный', 'центральный');
$sewer        = array(2 => 'местная', 'центральный');
$corner_room  = array(1 => 'угловая', 'не угловая');
?>
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
if ($this->object->street_adding) { ?>улица <?php } echo $this->object->name_street;    
if ($this->object->house_number) {
?>, дом <?php echo $this->object->house_number;
if ($this->object->building_number) {
    $word = $this->object->building_number;
    $word = str_replace(array('a', 'b', 'c', 'd', 'e'), array('а', 'б', 'в', 'г', 'д'), $word);

    ?>, корпус <?php echo $word; }
 if ($this->object->type == 1 and $this->object->room) {?>
, кв. <?php echo $this->object->room; } 

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
	
    <?php if ($this->object->settlement_id != 1) { 
    
	   if ($this->object->region_id < 2)
	   {
	       echo $this->object->name_area?>, <?php
	   }

	
	   if ($this->object->settlement_id and $this->object->type_settlement < 100)  { ?>
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
  	if ($this->object->house_number_comment)
   	{
   	?> <?php echo $this->object->house_number_comment;
   	}
	if ($this->object->building_number) { 
	?>, корпус <?php echo $this->object->building_number; }
	
	if ($this->object->room)
	 {
	    if ($this->object->type == 1) {
	 ?>, квартира <?php
        } else {
            ?>, номер <?php
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


<p id="print-buttom"><a target="_blank" href="?print=print" class="buttom">Печать</a></p>
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


<tr>
<td class="object-prompting">Этаж/этажей в доме</td>
<td>
<?php echo $this->object->floor;
if ($this->object->floors_total) { ?>/<?php echo $this->object->floors_total; } else {?>/-<?php } ?>
</td>
</tr>


<?php if ($this->object->space_total) {?>
<tr>
<td class="object-prompting">Площадь:<br /> общая/жилая/кухня</td>
<td>
<?php echo $this->object->space_total ?>/<?php
 if ($this->object->space_living)
     echo $this->object->space_living;
 else
     echo '-';
?>/<?php
if ($this->object->space_kitchen)
    echo $this->object->space_kitchen;
else 
    echo '-';
?> кв.м.
</td>
</tr>
<?php } ?>

<?php if ($this->object->space_calculation) {?>
<tr>
<td class="object-prompting">Расчетная площадь</td>
<td>
<?php echo $this->object->space_calculation ?> кв.м.
</td>
</tr>
<?php } ?>

<?php if ($this->object->height_ceiling) {?>
<tr>
<td class="object-prompting">Высота потолков</td>
<td>
<?php echo $this->object->height_ceiling ?> м.
</td>
</tr>
<?php } ?>


<?php if ($this->object->rooms_count) { ?>
<tr>
<td class="object-prompting">Комнат</td>
<td>
<?php
echo $this->object->rooms_count;
?>
</td>
</tr>
<?php } ?>


<?php if ($this->object->type_heating > 1 ) { ?>
<tr>
<td class="object-prompting">Вид отопления:</td>
<td>
<?php
if (isset($heating[$this->object->type_heating]))
    echo $heating[$this->object->type_heating];
else 
{
    ?>не известно<?php
}
?>
</td>
</tr>
<?php } ?>


</table>

<?php if ($this->object->levels > 1)
{ ?>
<p class="object-one-param">
<span>2-х уровневая квартира</span>
</p>
<?php } ?>



<?php if ($this->object->windows_type > 0 and key_exists($this->object->windows_type, Special_Vtor_Settings::$windowsType))
{ ?>
<p class="object-one-param">
Окна <span><?php echo Special_Vtor_Settings::$windowsType[$this->object->windows_type] ?></span>
</p>
<?php } ?>

<h3>Детали</h3>

<?php if ($this->object->corner_room > 0 and key_exists($this->object->corner_room, $corner_room))
{ ?>
<p class="object-one-param">
<span><?php echo ucfirst($corner_room[$this->object->corner_room]) ?></span>
</p>
<?php } ?>


<table class="object-parameters-list">


<?php if ($this->object->planning) { ?>
<tr>
<td class="object-prompting">Планировка:</td>
<td>
<?php
$check = ' - ';
foreach ($this->planning as $value)
{
    if ($value['id'] == $this->object->planning)
    {
        $check = $value['name'];
        break;
    }
}
echo $check;
?>
</td>
</tr>
<?php } ?>

<?php if ($this->object->condition) { ?>

<tr>
<td class="object-prompting">Состояние:</td>
<td>
<?php
$check = ' - ';
foreach ($this->condition as $value)
{
    if ($value['id'] == $this->object->condition)
    {
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
{ ?>
<p class="object-one-param">
<span>есть городской телефон</span>
</p>
<?php } ?>


<?php 
if ($this->object->balcony or $this->object->space_balcony) { ?>
<p class="object-one-param">есть <span>балкон</span><?php if ($this->object->space_balcony) { 
?>, площадь <span><?php echo $this->object->space_balcony; ?></span> кв. м.
<?php } ?></p>
<?php } ?>

<?php 
if ($this->object->loggia or $this->object->space_loggia) { ?>
<p class="object-one-param">есть <span>лоджия</span><?php if ($this->object->space_loggia) { 
?>, площадь <span><?php echo $this->object->space_loggia; ?></span> кв. м.
<?php } ?></p>
<?php } ?>


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
<dl class="dl-description-long" id="saler_comment">
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
?><p class="p-object-shot-price">Цена за 1м<sup>2</sup>: <span class="focus-red"><?php echo number_format($this->object->price_one, '0', '.',' ')?> руб.</span>
</p><?php
}
?>

<?php if ($this->object->price) { ?>
<p class="p-object-shot-price">Цена: 
<span class="focus-red"><?php echo number_format($this->object->price, '0', '.',' ')?> руб.</span>
</p>
<?php }
if ($this->object->price_rent_day)
{
?><p class="p-object-shot-price">Цена аренды: <span class="focus-red"><?php echo number_format($this->object->price_rent_day, '0', '.',' ')?> руб./сутки</span>
</p><?php
}
else if ($this->object->price_rent)
{
?><p class="p-object-shot-price">Цена за 1 месяц аренды: <span class="focus-red"><?php echo number_format($this->object->price_rent, '0', '.',' ')?> руб.</span>
</p><?php
} else if (!$this->object->price and !$this->object->price_one)
{
?><p class="p-object-shot-price">Цена: <span class="focus-red">Договорная</span></p><?php
}
?>


<p class="p-object-shot-price-valuta"></p>

</div>

