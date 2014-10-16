<p id="object-page-group" class="object-page"><strong>�������� � ������</strong></p>
<div id="div-objects-list" style="padding: 7px; width: 99%">
<?php echo $this->list_statistic; ?>
<table>
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
<?php if (($value['type'] == 1) and $value['rooms_count']) {
	switch ($value['rooms_count']) {
		case '1':
			?>1-���������<?php
			break;
		case '2':
			?>2-���������<?php
			break;
		case '3':
			?>3-���������<?php
			break;
		case '4':
			?>4-���������<?php
			break;
		case '5':
			?>5-���������<?php
			break;
		case '6':
			?>6-���������<?php
			break;
		case '7':
			?>7-���������<?php
			break;
	}
	switch ($value['levels']) {
		case '2':
			?> �������������<?php
			break;
	}
	?> ��������<?php
	if($value['planning'] == 2) {
		?> ���������� ����������<?php
	}
} else {
	echo ucfirst($value['name_type']);
}?>
</a>
</p>


<p class="objects-list-adress">

<!-- ������ � ������ -->
    <?php if ($value['region_id'] != 1) { ?>
	<?php echo $value['name_region']?>,
	<?php } ?>
	
    <?php if ($value['settlement_id'] != 1) { ?>
	<?php echo $value['name_area']?>,
	
	<?php if ($value['settlement_id'] and $value['type_settlement'] < 100)  { ?>
	<?php echo $value['name_settlement']?>,
	<?php } else { ?>
	<?php echo $value['settlement_name']?>,
	<?php }  ?>
	
	
	<?php } else {
	    echo $value['name_district'];?>,<?
                 }
	
	
	
	if ($value['street_id']) { 
	 ?> ����� <?php echo $value['name_street'];   
    } else
	{ if ($value['street_adding']) { ?> ����� <?php } else { ?> <?php }
	       echo $value['street_name'];
	} 
	if ($value['house_number'])
	{
	?>, ��� <?php echo $value['house_number'];
	}

	if ($value['building_number']) { 
	?>, ������ <?php echo $value['building_number']; }
	
	if ($value['room'])
	 {
	    if ($value['type'] == 1) {
	 ?>, �������� <?php
        } else {
            ?>, ����� <?php
        }
	   echo $value['room'];
	    } ?>
<!--/ ������ � ������ -->	    
	    
	    
</p>

<?php if ($value['new_building_flag']) { ?>
<p class="objects-list-add-info-focus">�����������<?php
if ($value['new_building_text']) { ?>
, <?php echo $value['new_building_text'];  } ?></p>
<?php } ?>

<?php
if ($value['user_contact_name'])
    $name = $value['user_contact_name'];
else 
    $name = $value['name_user'];
?><p class="objects-list-add-info-focus">��������: <a href="/user/info/<?php echo $value['saler_id'] ?>/"><?php echo $name ?></a></p>

<?php if ($value['floor']) { ?>
<p class="objects-list-add-info-focus">����: <?php echo $value['floor'] ?></p>
<?php } ?>


</td>

<td class="td-objects-list-price">
<?php if ($value['price_rent']) { ?>
<span class="no-wrap"><?php echo number_format($value['price_rent'], 0, ',', ' ')?></span> ���.<span class="no-wrap"><em>(1 ����� ������)</em></span>
<?php } else if ($value['price']) { ?>
<span class="no-wrap"><?php echo number_format($value['price'], 0, ',', ' ')?></span> ���.
<?php } else if ($value['price_one']){ ?>
<p class="object-shot-price">���� 1�<sup>2</sup>: <span class="price-number"><?php echo number_format($value['price_one'], 0, ',', ' ')?></span> <span class="price-red">���.</span></p>

<?php } else if (!$value['price']) { ?>
<span class="no-wrap price-new">����������</span>
<?php } else if ($value['price_old']) { ?>
<span class="no-wrap price-new"><?php echo number_format($value['price'], 0, ',', ' ')?></span>
<span class="no-wrap price-old"><?php echo number_format($value['price_old'], 0, ',', ' ')?></span> ���.
<?php } else { ?>
<span class="no-wrap"><?php echo number_format($value['price'], 0, ',', ' ')?></span> ���.
<?php }?>

</td>
</tr>

<?php }?>
<tr><td colspan="3" class="td-objects-list-buffer"></td></tr>
</table>


</div>