<table id="two-col-table">
<tr><td class="left">

<div id="user">
<h3>Информация о продавце</h3>
<table id="table-object-saler-info">

<tr>
<td class="td-saler-info-name">
Контактное имя:
</td><td class="td-saler-info-data">
<a href="/user/info/<?php echo $this->user_info->id; ?>/" title="Персональная страница">
<?php
if ($this->user_info->contact_name)
    echo $this->user_info->contact_name;
else 
    echo $this->user_info->name; 
  ?>
 </a>
</td>
<td class="td-saler-info-data-add">
</td>
</tr>


<?php
// Показ адреса электроной почты
if ($this->user_info_allow->mail_allow) {?>
<tr>
<td class="td-saler-info-name">
Эл.почта:
</td><td class="td-saler-info-data">
 <?php echo $this->user_info->mail; ?>
</td>
<td class="td-saler-info-data-add">
</td>
</tr>
<?php } ?>



<?php
// Показ адреса электроной почты
if ($this->user_info_allow->phone_allow) {?>
<tr>
<td class="td-saler-info-name">
Телефон:
</td><td class="td-saler-info-data">
 <?php echo $this->user_info->phone; ?>
</td>
<td class="td-saler-info-data-add">
</td>
</tr>
<?php } ?>

<?php
// Показ аськи
if ($this->user_info_allow->icq_allow and $this->user_info->icq) {?>
<tr style="height: 30px;">
<td class="td-saler-info-name">
ICQ&nbsp; :
</td><td class="td-saler-info-data">
<img style="display:inline; line-height:12px; vertical-align:bottom; position:relative; bottom: 1px;" alt="статус" src="http://wwp.icq.com/scripts/online.dll?icq=<?php echo str_ireplace(array(' ', '-', '(', ')'), '',$this->user_info->icq); ?>&img=5&rnd=<?php echo rand(1000, 9999) ?>" />
<a href="#" onclick='clientWindow = window.open("http://www.icq.com/icq2go/flicq.html","ICQ2Go","left=20,top=20,width=176,height=441,toolbar=0,resizable=0");return false;'>
 <?php echo $this->user_info->icq; ?>
 </a>
</td>
<td class="td-saler-info-data-add">
</td>
</tr>
<?php } ?>


<?php
// Показ адреса электроной почты
if ($this->user_info->site) {?>
<tr>
<td class="td-saler-info-name">
Сайт:
</td><td class="td-saler-info-data">
 <?php echo $this->user_info->site; ?>
</td>
<td class="td-saler-info-data-add">
</td>
</tr>
<?php } ?>



</table>


</div>





<p class="preview_big">
<?php if ($this->preview_big) { ?>
<a class="thickbox" href="<?php echo $this->preview_sourse?>" />
<img width="400" height="400" src="<?php echo $this->preview_big?>" />
</a>
<?php } else { ?>
<img width="400" height="400" src="<?php echo $this->view_folder?>/img/house-300.png" />
<?php }?>
</p>
</td><td>


<h3><?php echo $this->object->name_type; ?></h3>
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
?>, <?php echo $this->object->name_district ?>, г. <?php echo $this->object->name_settlement ?>
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
    



<table class="object-parameters-list">


<tr>
<td>
<h3>Основные параметры</h3>
</td>
<td></td>
</tr>


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

<?php if ($this->object->floor > 0)
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


<?php if ($this->object->floor < 0)
{ ?>
<p class="object-one-param">
<span>цокольный этаж</span>
</p>
<?php } ?>





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

<p class="object-one-param">
<?php if ($this->object->have_phone)
{ ?>
<span>есть городской телефон</span>
<?php } ?>


<?php 
if ($this->object->balcony) { ?>
<br />есть <strong>балкон</strong><?php if ($this->object->space_balcony) { 
?>, площадь <span><?php echo $this->object->space_balcony; ?></span> кв. м.
<?php } ?>
<?php } ?>

<?php 
if ($this->object->loggia) { ?>
<br />есть <strong>лоджия</strong><?php if ($this->object->space_loggia) { 
?>, площадь <span><?php echo $this->object->space_loggia; ?></span> кв. м.
<?php } ?>
<?php } ?>


</p>
<?php if ($this->object->info_text) {?>
<dl class="dl-description">
<dt>Описание</dt>
<dd>
<?php 
echo str_replace("\n", '<br />', $this->object->info_text);
?>
</dd>
</dl>
<?php } ?>


<?php if ($this->object->info_comment) {?>
<dl class="dl-description" id="saler_comment">
<dt>Комментарий</dt>
<dd><em>
<?php 
echo str_replace("\n", '<br />', $this->object->info_comment);
?></em>
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

<?php if ($this->object->price_rent_day)
{
?><p class="p-object-shot-price">Цена аренды: <span class="focus-red"><?php echo number_format($this->object->price_rent_day, '0', '.',' ')?> руб./сутки</span>
</p><?php
}
else if ($this->object->price_rent)
{
?><p class="p-object-shot-price">Цена за 1 месяц аренды: <span class="focus-red"><?php echo number_format($this->object->price_rent, '0', '.',' ')?> руб.</span>
</p><?php
}
?>

</td></tr>
</table>




