<div id="div-objects-list">
<div id="div-objects-elected"> <p id="p-elected-on-catalogue">спецпредложение</p>
<div class="l-2">
<div class="l-3">
<div class="l-4">
<div class="inside">

<table>
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

<tr>
<td class="td-objects-list-image">
<a href="<?php echo $value['link']?>" title="<?=$imgTitle;?>">
<?php if ($value['preview']) {?>
<img src="<?php echo $value['preview'];?>" height="100" alt="<?=$imgTitle;?>" />
<?php } else {?>

<img src="<?php echo $this->view_folder?>/img/house-100.png" height="100"/>
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


<p class="objects-list-adress"> <?php

  if ($value['district_id_plus'] > 1)
  {
      echo $value['name_district_plus'], ' <em>(', $value['name_district'], ')</em>';
  }
  else 
      echo $value['name_district']

?>, <?php if ($value['street_adding']) { ?>улица <?php } echo $value['name_street']?>, дом <?php echo $value['house_number']?>
</p>

<?php
if ($value['user_contact_name'])
    $name = $value['user_contact_name'];
else 
    $name = $value['name_user'];
?><p class="objects-list-add-info-focus">Продавец: <a href="/user/info/<?php echo $value['saler_id'] ?>/"><?php echo $name ?></a></p>


<?php if ($value['info_comment']) { ?>
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
<?php if ($value['price_old']) { ?>
<span class="no-wrap price-new"><?php echo number_format($value['price'], 0, ',', ' ')?></span>
<span class="no-wrap price-old"><?php echo number_format($value['price_old'], 0, ',', ' ')?></span> руб.
<?php } else { ?>
<span class="no-wrap"><?php echo number_format($value['price'], 0, ',', ' ')?></span> руб.
<?php }?>

</td>
</tr>

<?php }?>
</table>
</div>
</div>
</div>
</div>

</div></div>