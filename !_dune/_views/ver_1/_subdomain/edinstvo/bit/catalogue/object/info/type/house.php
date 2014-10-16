<p id="object-page-info" class="object-page"><strong>Информация</strong></p>
<?php
$heating = array(2 => 'автономное', 'центральное');
$water_cold = array(2 => 'автономный', 'центральный');
$sewer      = array(2 => 'местная', 'центральный');
?>

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
, квартира<?php echo $this->object->room; } 

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

<?php if ($this->object->type_add > 1)
{ ?>
<tr>
<td class="object-prompting">Тип :</td>
<td>
<?php
$text = '';
foreach ($this->type_add as $value)
{
    if ($value['id'] == $this->object->type_add)
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



<?php if ($this->object->type_wall > 1)
{ ?>
<tr>
<td class="object-prompting">Тип стен:</td>
<td>
<?php
$text = '';
foreach ($this->walls as $value)
{
    if ($value['id'] == $this->object->type_wall)
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





<?php
if ($this->object->floors_total) { ?>
<tr>
<td class="object-prompting">Этажей в доме:</td>
<td>
<?php
 echo $this->object->floors_total;  ?>
</td>
</tr>
<?php } ?>

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
?> м<sup>2</sup>
</td>
</tr>
<?php } ?>

<?php if ($this->object->space_calculation) {?>
<tr>
<td class="object-prompting">Расчетная площадь:</td>
<td>
<?php echo $this->object->space_calculation ?> м<sup>2</sup>
</td>
</tr>
<?php } ?>

<?php if ($this->object->height_ceiling) {?>
<tr>
<td class="object-prompting">Высота потолков:</td>
<td>
<?php echo $this->object->height_ceiling ?> м.
</td>
</tr>
<?php } ?>


<?php if ($this->object->rooms_count) { ?>
<tr>
<td class="object-prompting">Комнат:</td>
<td>
<?php
echo $this->object->rooms_count;
?>
</td>
</tr>
<?php } ?>


<?php if ($this->object->type_water_cold > 1 ) { ?>
<tr>
<td class="object-prompting">Вид водопровода:</td>
<td>
<?php
if (isset($water_cold[$this->object->type_water_cold]))
    echo $water_cold[$this->object->type_water_cold];
else 
{
    ?>не известно<?php
}
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


<?php if ($this->object->type_sewer > 1 ) { ?>
<tr>
<td class="object-prompting">Вид канализации:</td>
<td>
<?php
if (isset($sewer[$this->object->type_sewer]))
    echo $sewer[$this->object->type_sewer];
else 
{
    ?>не известно<?php
}
?>
</td>
</tr>
<?php } ?>




</table>

<?php if ($this->object->windows_type > 0 and key_exists($this->object->windows_type, Special_Vtor_Settings::$windowsType))
{ ?>
<p class="object-one-param">
Окна <span><?php echo Special_Vtor_Settings::$windowsType[$this->object->windows_type] ?></span>
</p>
<?php } ?>


<h3>Детали</h3>

<table class="object-parameters-list">

<?php
//$this->object->count_in_group = 901;
$name = ' соток';
if ($this->object->space_land >= 100)
    $number = $this->object->space_land % 100;
else 
    $number = $this->object->space_land;

$zero = $number % 10;
if (!$zero)
{
    $name = ' соток';
}
else if ($number > 10 and $number < 20)
{
    $name = ' соток';
}
else if ($zero == 1)
{
    $name = ' сотка';
}
else if ($zero < 5)
{
    $name = ' сотки';
}

if ($this->object->have_land) { ?>
<p class="object-one-param">есть <span>земельный участок</span><?php if ($this->object->space_land) { 
?>, площадь <span><?php echo $this->object->space_land; ?></span> <?php echo $name; ?>
<?php } ?></p>
<?php } ?>


<?php 
if ($this->object->garage) { ?>
<p class="object-one-param">есть <span>гараж</span><?php if ($this->object->garage > 1)
{ 
?>, на <span><?php echo $this->object->garage; ?></span> автомобиля
<?php } ?>

</p>
<?php } ?>


<?php if ($this->object->have_bath)
{ ?>
<p class="object-one-param">
есть <span>баня</span>
</p>
<?php } ?>


<?php if ($this->object->planning and false) { ?>
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

</table>

<?php if ($this->object->have_phone)
{ ?>
<p class="object-one-param">
есть <span>городской телефон</span>
</p>
<?php } ?>


<?php 
if ($this->object->balcony or $this->object->space_balcony) { ?>
<p class="object-one-param">есть <span>балкон</span><?php if ($this->object->space_balcony) { 
?>, площадь <span><?php echo $this->object->space_balcony; ?></span> м<sup>2</sup>
<?php } ?></p>
<?php } ?>

<?php 
if ($this->object->loggia or $this->object->space_loggia) { ?>
<p class="object-one-param">есть <span>лоджия</span><?php if ($this->object->space_loggia) { 
?>, площадь <span><?php echo $this->object->space_loggia; ?></span> м<Sup>2</Sup>
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

