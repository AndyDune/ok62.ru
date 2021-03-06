<div id="div-objects-list">

<?php
$URL = Dune_Parsing_UrlSingleton::getInstance();
if ($this->gm)
{
?><p style="text-align:right;"><a class="buttom" href="<?php echo $URL->getCommandString(true); ?>?gm=no">������ �����</a></p><?php    
    echo $this->gm;
} else {
?><p style="text-align:right;"><a class="buttom" href="<?php echo $URL->getCommandString(true); ?>?gm=yes">�������� �����</a></p><?php
}?>
<br />

<?php
$cat_url = new Special_Vtor_Catalogue_Url_Collector();
$cat_url->setRegion($this->url_info->getRegion());
$cat_url->setArea($this->url_info->getArea());
$cat_url->setSettlement($this->url_info->getSettlement());
$cat_url->setStreet($this->url_info->getStreet());
$cat_url->setType($this->url_info->getType());

$cat_url->setDistrict($this->url_info->getDistrict(), $this->url_info->isDistrictPlus());


echo $this->list_statistic; ?>




<?php
if ($this->url_info->getGroup())
{
    foreach ($this->data as $value)
    {
        if (isset($value['group_name']))
        {
            ?><p>�������� �������: <?php echo $value['group_name']; ?>. <a href="<?php echo $cat_url->get(); ?>">�������� ���.</a></p><?php
        }
        else 
        {
            ?><p>�������� ����� ��������. <a href="<?php echo $cat_url->get(); ?>">�������� ���.</a></p><?php
        }
        break;
    }
    
}
else if ($this->url_info->getHouse())
{
    ?><p>�������� ��� ���� ����� <?php echo $this->url_info->getHouse();
    if ($this->url_info->getBuilding())
    {
        ?>, ������<?php  echo $this->url_info->getBuilding();
    }
    ?>. <a href="<?php echo $cat_url->get(); ?>">�������� ��� �� �����</a></p><?php
}

$cat_url->setBuilding($this->url_info->getBuilding());
$cat_url->setHouse($this->url_info->getHouse());

if ($this->version)
{
    ?><p><a class="buttom" style="display:block; text-align:center;" href="/modules.php?name=Hypothec&op=Calculation&version=<?php echo $this->version ?>">������</a></p><?php
}
?>  
<table>
<tr>
<th></th>
<th></th>
<th>
<?php
if ($this->order_direction != 'DESC' and $this->order_field == 'price')
{
    $order_direction = '_desc';
    $orde_link_class = 'order_asc';
}
else if ($this->order_field == 'price')
{
    $order_direction = '';
    $orde_link_class = 'order_desc';
}
else 
{
    $order_direction = '';
    $orde_link_class = 'order_no';
}
?>
<a class="<?php echo $orde_link_class; ?>" href="<?php echo $this->url_self ?>?set=order_price<?php echo $order_direction ?>">
����
</a>
</th>
</tr>
<?php foreach ($this->data as $value) {
    $this->object = new Dune_Array_Container($value);
	$imgTitle = '�������';
	$imgTitle .= ' ';
	switch ($value['type']) {
		case 1:
			$imgTitle .= $value['rooms_count'] . '-��������� ��������';
			if($value['planning'] == 2) {
				$imgTitle .= ' ';
				$imgTitle .= '���������� ����������';
			}
			break;
	}
	switch ($value['name_settlement']) {
		case '������':
			$imgTitle .= ' ';
			$imgTitle .= '� ������';
			break;
	}
?>
<tr><td colspan="3" class="td-objects-list-buffer"></td></tr>

<tr<?php
if ($value['mark'])
{
?> class="mark" <?php
}
?>>
<td class="td-objects-list-image">
<a href="<?php echo $value['link']?>" title="<?=$imgTitle;?>">
<?php if ($value['preview']) {?>
<img src="<?php echo $value['preview'];?>"  height="100" width="100" alt="<?=$imgTitle;?>" />
<?php } else {?>

<img src="<?php echo $this->view_folder?>/img/house-100.png" height="100" width="100" alt="<?=$imgTitle;?>" />
<?php } ?>
</a>
</td>
<td class="td-objects-list-info">

<p class="objects-list-name">
<a href="<?php echo $value['link']?>">
<?php if (($value['type'] == 1 or $value['type'] == 2) and $value['rooms_count']) {
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
	echo $value['name_type'];
}?>
</a>
</p>

<?php if ($value['group_name']) { ?>
<p class="objects-list-add-info-focus"><strong>
<?php echo $value['group_name'];  ?></strong></p>
<?php } else if ($value['name_complex']) { ?>
<p class="objects-list-add-info-focus"><strong>
<?php echo $value['name_complex'];  ?></strong></p>
<?php } ?>

<p class="objects-list-adress">

<!-- ������ � ������ -->
    <?php if ($value['region_id'] != 1) { ?>
	<?php echo $value['name_region']?>,
	<?php } ?>
	
    <?php if ($value['settlement_id'] != 1) {
        
	if ($value['region_id'] < 2)
	{
	   echo $value['name_area']?>, <?php
	}
	 ?>
	
	<?php if ($value['settlement_id'] and $value['type_settlement'] < 100)  { ?>
	<?php echo $value['name_settlement']?>,
	<?php } else { ?>
	<?php echo $value['settlement_name']?>,
	<?php }  ?>
	
	
	<?php } else {
	    if (Special_Vtor_Settings::$districtPlus and $value['district_id_plus'] > 1)
	    {
	        echo $value['name_district_plus'];
	    }
	    else 
	    {
	       echo $value['name_district'];
	    }
	       ?>,<?
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
  	if ($this->object->house_number_comment)
   	{
   	?> <?php echo $this->object->house_number_comment;
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

<?php if (isset($value['array_group']) and count($value['array_group']) > 1) { ?>
<p class="objects-list-add-info-focus">
�������� � ������ �� ������: <?php
$x = 0;
foreach ($value['array_group'] as $value_group)
{
    if ($x)
    {
        ?>, <?php
    }
    ?><a href="<?php echo $value['link_adress']?>object/<?php echo $value_group['id']?>"><?php echo $value_group['floor']?></a><?php
    $x++;
}
?>
</p>
<?php } ?>

<?php
if ($value['user_contact_name'])
    $name = $value['user_contact_name'];
else 
    $name = $value['name_user'];
?><p class="objects-list-add-info-focus">��������: <a href="/user/info/<?php echo $value['saler_id'] ?>/"><?php echo $name ?></a></p>


<p id="object-shot-grafic-param"><!-- ����� � ������� -->
<?php 
$link = $value['link'];
    ?>
<a href="<?php echo $link; ?>" title="���������� �� �������">
<img src="<?php echo $this->view_folder ?>/img/param/small/k1.png" height="25" width="25" alt="����������" />
</a>
<?php

if ($this->object->price and $this->object->price > 1000) { ?>
<a href="/modules.php?name=Hypothec&op=Calculation&object=<?php echo $this->object->id ?>" title="��������� �����������">
<img src="<?php echo $this->view_folder ?>/img/param/small/v1.png" height="25" width="25" />
</a>
<?php if ($this->object->have_hypothec_privilege) { ?>
<a href="/modules.php?name=Hypothec&op=Calculation&object=<?php echo $this->object->id ?>" title="��������� �����������. �������� �������� �������.">
<img src="<?php echo $this->view_folder ?>/img/param/small/v2.png" height="25" width="25" />
</a>
<?php } ?>
<?php } ?>

<?php if ($this->object->have_plan) {
$link = $value['link']  .'mode/plan/';
    ?>
<a href="<?php echo $link; ?>" title="����������">
<img src="<?php echo $this->view_folder ?>/img/param/small/k2.png" height="25" width="25" />
</a>
<?php } ?>

<?php if ($this->object->pics) { 
$link = $value['link']  .'mode/photo/';  
    ?>
<a href="<?php echo $link; ?>" title="����������">
<img src="<?php echo $this->view_folder ?>/img/param/small/k5.png" height="25" width="25" />
</a>
<?php } else if ($this->object->have_photo_house) {
$link = $value['link']  .'mode/house/';  
    ?>
<a href="<?php echo $link; ?>" title="���������� ����">
<img src="<?php echo $this->view_folder ?>/img/param/small/k5.png" height="25" width="25" />
</a>
<?php } ?>


<?php if ($this->object->have_panorama or $this->object->panorama) { 
$link = $value['link']  .'mode/panorama/';  
    ?>
<a href="<?php echo $link; ?>" title="���������� ������">
<img src="<?php echo $this->view_folder ?>/img/param/small/k6.png" height="25" width="25" />
</a>
<?php } ?>



<?php if ($this->object->have_situa) { 
$link = $value['link']  .'mode/situa/';  
    ?>
<a href="<?php echo $link; ?>" title="������������ ����">
<img src="<?php echo $this->view_folder ?>/img/param/small/k8.png" height="25" width="25" />
</a>
<?php } ?>

<?php if ($this->object->gm_x or $this->object->group > 1 or $this->object->house_gm_x) { 
$link = $value['link']  .'mode/gm/';  
    ?>
<a href="<?php echo $link; ?>" title="�� �����">
<img src="<?php echo $this->view_folder ?>/img/param/small/k7.png" height="25" width="25" />
</a>
<?php } ?>


<?php if ($this->object->count_in_group and $this->object->count_in_group > 1) { 
$link = $value['link']  .'mode/group/';  
    ?>
<a href="<?php echo $link; ?>" title="������� � ������: <?php echo $this->object->count_in_group; ?>">
<img src="<?php echo $this->view_folder ?>/img/param/small/k10.png" height="25" width="25" />
</a>
<?php } ?>



</p>



</td>

<td class="td-objects-list-price">
<?php if ($value['price_rent_day']) { ?>
<span class="no-wrap"><?php echo number_format($value['price_rent_day'], 0, ',', ' ')?></span> ���./�����

<?php } else if ($value['price_rent']) { ?>
<span class="no-wrap"><?php echo number_format($value['price_rent'], 0, ',', ' ')?></span> <span class="no-wrap">���./�����</span>
<?php } else if ($value['price']) { ?>
<span class="no-wrap price-new"><?php echo number_format($value['price'], 0, ',', ' ')?></span> ���.</span>

<?php } else if ($value['price_one']) { ?>
<span class="no-wrap price-new"><?php echo number_format($value['price_one'], 0, ',', ' ')?></span> ���./1�<sup>2</sup></span>

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

<?
if ($this->count > $this->navigator_per_page)
{

$navigator = new Dune_Navigate_Page($cat_url->get() . 'page/', $this->count, $this->navigator_page, $this->navigator_per_page);
if ($this->version)
    $navigator->setAfterPageNumber('/?version=' . $this->version);
else 
    $navigator->setAfterPageNumber('/');
echo $navigator->getNavigator();
}
?>

</div>