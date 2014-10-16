<div id="div-objects-list">
<!--
<p><a href="/user/nearby/" class="buttom">Все наблюдаемые</a></p>
-->
<dl>
<dt>Улицы:</dt>
<dd><ul style="padding:0; margin:0;">
<li>
<?php if ($this->street_current) { ?>
<a href="/user/nearby/list/<?php echo $this->group_current ?>_0_<?php echo $this->interval_current; ?>/">
Все
</a>
<?php } else { ?>
<strong>Все</strong>
<?php } ?>
</li>

<?php foreach ($this->street_array as $value) {?>
<li>
<?php if ($value['id'] != $this->street_current) { ?>
<a href="/user/nearby/list/<?php echo $this->group_current ?>_<?php echo $value['id'] ?>_<?php echo $this->interval_current ?>/">
<?php echo $value['name']; ?> (число объектов: <?php echo $value['count']; ?>)
</a>
<?php } else { ?>
<strong>
<?php echo $value['name']; ?> (число объектов: <?php echo $value['count']; ?>)
</strong>
<?php } ?>
</li>
<?php } ?>

</ul></dd>
</dl>

<dl>
<dt>Отбор по времени:</dt>
<dd>
<ul style="padding:0; margin:0;">
<li>
<?php if ($this->interval_current) { ?>
<a href="/user/nearby/list/<?php echo $this->group_current ?>_<?php echo $this->street_current ?>/">Показать все</a>
<?php } else  { ?>
<strong>Показать все</strong>
<?php } ?>

</li>
<li>Внесенные за последние:
 <?php if ($this->interval_current == 1) { ?>
 <strong>день</strong>,
<?php } else  { ?>
 <a href="/user/nearby/list/<?php echo $this->group_current ?>_<?php echo $this->street_current ?>_1/">день</a>,
<?php } ?>
 
 <?php if ($this->interval_current == 7) { ?>
 <strong>неделю</strong>,
<?php } else  { ?>
 <a href="/user/nearby/list/<?php echo $this->group_current ?>_<?php echo $this->street_current ?>_7/">неделю</a>,
<?php } ?>

<?php if ($this->interval_current == 30) { ?>
 <strong>месяц</strong>
<?php } else  { ?>
 <a href="/user/nearby/list/<?php echo $this->group_current ?>_<?php echo $this->street_current ?>_30/">месяц</a>
<?php } ?>


</li>
</ul>
</dd>
</dl>

<?php
if ($this->data) { ?>

<table>
<tr>
<th></th>
<th>описание</th>
<th>цена</th>
</tr>


<?php foreach ($this->data as $value) {?>
<tr><td colspan="3" class="td-objects-list-buffer"></td></tr>

<tr<?php
if ($value['mark'])
{
?> class="mark" <?php
}
?>>

<td class="td-objects-list-image">
<a href="<?php echo $value['link']?>">
<?php if ($value['preview']) {?>
<img src="<?php echo $value['preview'];?>" height="100" />
<?php } else {?>

<img src="<?php echo $this->view_folder?>/img/house-100.png" height="100" />
<?php } ?>
</a>
</td>
<td class="td-objects-list-info">

<p class="objects-list-name">
<a href="<?php echo $value['link']?>">
<?php if (($value['type'] == 1 or $value['type'] == 2) and $value['rooms_count']) {
	switch ($value['rooms_count']) {
		case '1':
			?>1-комнатная<?php
			break;
		case '2':
			?>2-комнатная<?php
			break;
		case '3':
			?>3-комнатная<?php
			break;
		case '4':
			?>4-комнатная<?php
			break;
		case '5':
			?>5-комнатная<?php
			break;
		case '6':
			?>6-комнатная<?php
			break;
		case '7':
			?>7-комнатная<?php
			break;
	}
	switch ($value['levels']) {
		case '2':
			?> двухуровневая<?php
			break;
	}
	?> квартира<?php
	if($value['planning'] == 2) {
		?> улучшенной планировки<?php
	}
} else {
	echo $value['name_type'];
}?>
</a>
</p>


<p class="objects-list-adress"> <?php echo $value['name_district']?> 
, <?php if ($value['street_adding']) { ?>улица <?php } echo $value['name_street'];
if ($value['house_number'])
{
?>, дом <?php echo $value['house_number']?><?php 
if ($value['building_number']) { ?>, корп. <?php echo $value['building_number']; }
}
?>
</p>

<?php if ($value['new_building_flag']) { ?>
<p class="objects-list-add-info-focus">новостройка<?php
if ($value['new_building_text']) { ?>
, <?php echo $value['new_building_text'];  } ?></p>
<?php } ?>


<?php
if ($value['user_contact_name'])
    $name = $value['user_contact_name'];
else 
    $name = $value['name_user'];
?><p class="objects-list-add-info-focus">Продавец: <a href="/user/info/<?php echo $value['saler_id'] ?>/"><?php echo $name ?></a></p>


<?php 
$month = new Dune_Date_MonthName(substr($value['time_insert'], 5, 2));
$mname = $month->getGenitive();
?>
<p class="objects-list-add-info-focus">Дата внесения: <?php echo trim(substr($value['time_insert'], 8, 2), ' 0') ?> <?php echo $mname; ?> <?php echo substr($value['time_insert'], 0, 4) ?></p>

</td>

<td class="td-objects-list-price">
<?php if ($value['price_rent']) { ?>
<span class="no-wrap"><?php echo number_format($value['price_rent'], 0, ',', ' ')?></span> руб.<span class="no-wrap"><em>(1 месяц аренды)</em></span>
<?php } else if (!$value['price']) { ?>
<span class="no-wrap price-new">Договорная</span>
<?php } else if ($value['price_old']) { ?>
<span class="no-wrap price-new"><?php echo number_format($value['price'], 0, ',', ' ')?></span>
<span class="no-wrap price-old"><?php echo number_format($value['price_old'], 0, ',', ' ')?></span> руб.
<?php } else { ?>
<span class="no-wrap"><?php echo number_format($value['price'], 0, ',', ' ')?></span> руб.
<?php }?>

</td>
</tr>

<?php } ?>
<tr><td colspan="3" class="td-objects-list-buffer"></td></tr>
</table>


<?php } else { ?>
<h1 style="text-align:center">Нет объектов с указанным адресом и/или типом</h1>
<?php }  ?>

<?
if ($this->count > $this->navigator_per_page)
{

$navigator = new Dune_Navigate_Page($this->url_info . '?page=', $this->count, $this->navigator_page, $this->navigator_per_page);
echo $navigator->getNavigator();
}
?>

</div>