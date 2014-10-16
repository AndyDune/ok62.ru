<div id="div-main-page-elected-list">
<div id="div-objects-list">
<table>
<tr>
<th></th>
<th>последние добавления</th>
<th>цена</th>
</tr>
<?php foreach ($this->objects_list as $value) {
	$imgTitle = 'Продажа';
	$imgTitle .= ' ';
	switch ($value['type']) {
		case 1:
			$imgTitle .= $value['rooms_count'] . '-комнатной квартиры';
			if($value['planning'] == 2) {
				$imgTitle .= ' ';
				$imgTitle .= 'улучшенной планировки';
			}
			break;
	}
	switch ($value['name_settlement']) {
		case 'Рязань':
			$imgTitle .= ' ';
			$imgTitle .= 'в Рязани';
			break;
	}
	?>
<tr><td colspan="3" class="td-objects-list-buffer"></td></tr>

<tr>
<td class="td-objects-list-image">
<a href="<?php echo $value['link']?>" title="<?=$imgTitle;?>">
<?php if ($value['preview']) {?>
<img src="<?php echo $value['preview'];?>" height="100" alt="<?=$imgTitle;?>" />
<?php } else {?>

<img src="<?php echo $this->view_folder?>/img/house-3.png" height="100" width="100" alt="<?=$imgTitle;?>"/>
<?php } ?>
</a>
</td>
<td class="td-objects-list-info">

<p class="objects-list-name">
<a href="<?php echo $value['link']?>">
<?php
switch ($value['type']) {
	case 1:
       if ($value['rooms_count'])
	       echo $value['rooms_count'] . '-комнатная квартира';
   	   else 
   		  echo 'Квартира';

		if($value['planning'] == 2) {
			echo ' улучшенной планировки';
		}
		break;
	default:
		echo $value['name_type'];
		if (($value['type'] == 1 or $value['type'] == 2) and $value['rooms_count'] ) {?>, комнат: <?php echo $value['rooms_count']; }
		break;
}
?>
</a>
</p>

<p class="objects-list-adress">

<?php if ($value['settlement_id'] == 1) { 
    
  echo $value['name_district']?>
, <?php if ($value['street_adding']) { ?>улица <?php } echo $value['name_street'];
if ($value['house_number'])
{
  ?>, дом <?php echo $value['house_number'];
}
} else 
    { 
    echo $value['name_region'];
    if ($value['region_id'] == 1) {
        ?>, <?php echo $value['name_area'];
    } 
    if ($value['type_settlement'] < 100) {
        ?>, <?php echo $value['name_settlement'];
    } else {
        ?>, <?php echo $value['settlement_name'];
    }
    } ?>


</p>

<?php
if ($value['user_contact_name'])
    $name = $value['user_contact_name'];
else 
    $name = $value['name_user'];
?><p class="objects-list-add-info-focus">Продавец: <strong><a title="Персональная страница продавца" href="/user/info/<?php echo $value['saler_id'] ?>/"><?php echo $name ?></a></strong></p>


<style type="text/css">
#object-shot-grafic-param a
{
text-decoration:none;
}
</style>

<p id="object-shot-grafic-param"><!-- Табло с пикчами -->
<?php 

$this->object = new Dune_Array_Container($value);    


$link = $value['link'];
    ?>
<a href="<?php echo $link; ?>" title="Информация об объекте">
<img src="<?php echo $this->view_folder ?>/img/param/small/k1.png" height="25" width="25" alt="Информация" />
</a>
<?php

if ($this->object->price and $this->object->price > 1000) { ?>
<a href="/modules.php?name=Hypothec&op=Calculation&object=<?php echo $this->object->id ?>" title="Ипотечный калькулятор">
<img src="<?php echo $this->view_folder ?>/img/param/small/v1.png" height="25" width="25" />
</a>
<?php if ($this->object->have_hypothec_privilege) { ?>
<a href="/modules.php?name=Hypothec&op=Calculation&object=<?php echo $this->object->id ?>" title="Ипотечный калькулятор. Возможна льготная ипотека.">
<img src="<?php echo $this->view_folder ?>/img/param/small/v2.png" height="25" width="25" />
</a>
<?php } ?>
<?php } ?>

<?php if ($this->object->have_plan) {
$link = $value['link']  .'mode/plan/';
    ?>
<a href="<?php echo $link; ?>" title="Планировка">
<img src="<?php echo $this->view_folder ?>/img/param/small/k2.png" height="25" width="25" />
</a>
<?php } ?>

<?php if ($this->object->pics) { 
$link = $value['link']  .'mode/photo/';  
    ?>
<a href="<?php echo $link; ?>" title="Фотографии">
<img src="<?php echo $this->view_folder ?>/img/param/small/k5.png" height="25" width="25" />
</a>
<?php } else if ($this->object->have_photo_house) {
$link = $value['link']  .'mode/house/';  
    ?>
<a href="<?php echo $link; ?>" title="Фотографии дома">
<img src="<?php echo $this->view_folder ?>/img/param/small/k5.png" height="25" width="25" />
</a>
<?php } ?>


<?php if ($this->object->have_panorama or $this->object->panorama) { 
$link = $value['link']  .'mode/panorama/';  
    ?>
<a href="<?php echo $link; ?>" title="Панорамные обзоры">
<img src="<?php echo $this->view_folder ?>/img/param/small/k6.png" height="25" width="25" />
</a>
<?php } ?>



<?php if ($this->object->have_situa) { 
$link = $value['link']  .'mode/situa/';  
    ?>
<a href="<?php echo $link; ?>" title="Ситуационный план">
<img src="<?php echo $this->view_folder ?>/img/param/small/k8.png" height="25" width="25" />
</a>
<?php } ?>

<?php if ($this->object->gm_x or $this->object->group > 1 or $this->object->house_gm_x) { 
$link = $value['link']  .'mode/gm/';  
    ?>
<a href="<?php echo $link; ?>" title="На карте">
<img src="<?php echo $this->view_folder ?>/img/param/small/k7.png" height="25" width="25" />
</a>
<?php } ?>

</p>




<?php if ($value['info_comment'] and false) { ?>
<p class="objects-list-special"> <?php
$text = new Dune_String_CutShort($value['info_comment']);
if ($text->cut(200))
{
    echo $text->getResultString(); ?> <a href="<?php echo $value['link']?>#saler_comment">...</a><?php
}
else 
    echo $value['info_comment']?> 
</p>
<?php }?>


</td>


<td class="td-objects-list-price">

<?php if ($value['price_rent_day']) { ?>
<span class="no-wrap"><?php echo number_format($value['price_rent_day'], 0, ',', ' ')?></span> руб./сутки<span class="no-wrap"></span>

<?php } else if ($value['price_rent']) { ?>
<span class="no-wrap"><?php echo number_format($value['price_rent'], 0, ',', ' ')?></span> <span>руб./месяц</span>
<?php } else if ($value['price_rent_metre']) { ?>
<span class="no-wrap"><?php echo number_format($value['price_rent_metre'], 0, ',', ' ')?></span> <span class="no-wrap">руб./месяц за 1м<sup>2</sup></span>
<?php } else if (!$value['price'] and !$value['price_one']) { ?>
<span class="no-wrap price-new">Договорная</span>
<?php } else if ($value['price_old']) { ?>
<span class="no-wrap price-new"><?php echo number_format($value['price'], 0, ',', ' ')?></span>
<span class="no-wrap price-old"><?php echo number_format($value['price_old'], 0, ',', ' ')?></span> руб.
<?php } else if ($value['price']) { ?>
<span class="no-wrap"><?php echo number_format($value['price'], 0, ',', ' ')?></span><span>руб.</span>
<?php } else if ($value['price_one']) { ?>
<span class="no-wrap"><?php echo number_format($value['price_one'], 0, ',', ' ')?></span><span>руб./м<sup>2</sup></span>
<?php } else { ?>
<span class="no-wrap"><?php echo number_format($value['price'], 0, ',', ' ')?></span> руб.
<?php }?>
</td>
</tr>

<?php }?>
<tr><td colspan="3" class="td-objects-list-buffer"></td></tr>
</table>
</div>
</div>