<?php
$data = $this->data;
$url_catalogue = new Special_Vtor_Catalogue_Url_Collector();
$url_catalogue->setRegion($data['region_id']);
$url_catalogue->setArea($data['area_id']);
$url_catalogue->setSettlement($data['settlement_id']);

$url_catalogue->setStreet($data['street_id']);
$url_catalogue->setHouse($data['house_number']);
$url_catalogue->setBuilding($data['building_number']);

$url_catalogue->setGroup($data['complex_id']);
    
if (Special_Vtor_Settings::$districtPlus)
    $url_catalogue->setDistrict($data['district_id_plus'], true);
else 
    $url_catalogue->setDistrict($data['district_id']);

?>
<div id="crumbs-info"><?php echo $this->crumbs; ?></div>
<div id="house-info">
<?php
if ($data['name'])
{
    ?><h1><?php echo $data['name']; ?></h1><?php
}

?>
<p class="house-name">
<?php if ($data['settlement_id'] == 1)
{
    ?>������<?php
} else 
{
    echo $data['name_region']; 
    if ($data['area_id'])
    {
        ?>, <?php echo $data['name_area'];
    }
    if ($data['settlement_id'])
    {
        ?>, <?php echo $data['name_settlement'];
    }
    
}
if ($data['district_plus_id'])
{
    ?>, <?php echo $data['name_district_plus'];
}
if ($data['street_id'])
{
?>, <?php if ($data['street_adding']) { ?>����� <?php } echo $data['name_street'];
}

if (!$data['build_status'] and $data['adress_build'])
{
    ?><br /> (<?php echo $data['adress_build'] ?>) <?php
}
?></p><?php


if ($data['text_short'])
{
    ?><div><?php echo $data['text_short']; ?></div><?php
}






?><div id="complex-info-grafic"><?php
if ($this->photo)
{
    ?><dl class="pic-text"><dd><a href="<?php echo $this->url ?>photo/" title="�������� ����������"><img src="<?php echo $this->photo->getPreviewFileUrl(150); ?>" /></a> </dd>
    <dt><a href="<?php echo $this->url ?>photo/">������������</a></dt>
    </dl> <?php
}
?>

<?php
if ($this->situa)
{
    ?><dl class="pic-text"><dd><a class="thickbox" href="<?php echo $this->situa->getSourseFileUrl(); ?>" title="�������� �����"><img src="<?php echo $this->situa->getPreviewFileUrl(150); ?>" /></a> </dd>
    <dt><a class="thickbox" href="<?php echo $this->situa->getSourseFileUrl(); ?>">����������� ����</a></dt>
    </dl> <?php
}
?>


<?php
if ($this->fasad)
{
    ?><dl class="pic-text"><dd><a class="thickbox" href="<?php echo $this->fasad->getSourseFileUrl(); ?>" title="�����"><img src="<?php echo $this->fasad->getPreviewFileUrl(150); ?>" /></a> </dd>
    <dt><a class="thickbox" href="<?php echo $this->fasad->getSourseFileUrl(); ?>">�����</a></dt>
    </dl> <?php
}
?>



<?php
$goo = false;
if ($data['gm_x'])
{
    $gm = array('x' => $data['gm_x'], 'y' => $data['gm_y']);
    $goo = true;
}
else if ($data['complex_gm_x'])
{
    $gm = array('x' => $data['group_gm_x'], 'y' => $data['group_gm_y']);
    $goo = true;
}
if ($goo and false)
{
    ?><dl class="pic-text"><dt><a href="http://ok62.ru/map/public/<?php echo $gm['x']; ?>_<?php echo $gm['y']; ?>/">�������� �� �����</a></dt></dl> <?php
}
?>

<?php
if (($data['panorama_id'] or $data['complex_panorama_id']) and false)
{
    ?><dl class="pic-text"><dt><a href="<?php echo $this->url; ?>panorama/">���������� �����</a></dt></dl> <?php
}
?>

<?php
if ($data['gen_plan'] and false)
{
    ?><dl class="pic-text"><dt><a href="<?php echo $this->url; ?>gen/">����������� ����</a></dt></dl> <?php
}
?>


<?php
if ($this->pd and false)
{
    ?><dl class="pic-text"><dt><a href="<?php echo $this->url; ?>pd/">��������� ����������</a></dt></dl> <?php
}
?>

</div>




<?php


?><ul class="jast-list"><?php

// ����� �������
if ($data['count_room_total'])
{
    ?><li>���������� ������� - <?php echo $data['count_room_total']; ?></li><?php
}

// ��������� �������
if ($data['count_room'])
{
    ?><li>��������� ������� - <?php echo $data['count_room']; ?></li><?php
}
// ��������� �������
if ($data['price_min_metre_room'])
{
    ?><li>��������� ������� �� <?php echo number_format($data['price_min_metre_room'], 0,',', ' ');
    if ($data['price_max_metre_room']) { ?> �� <?php echo number_format($data['price_max_metre_room'], 0,',', ' '); } ?> ���/�<sup>2</sup></li><?php
}

// ������� �������
if ($data['space_total_min_room'])
{
    ?><li>������� ������� �� <?php echo number_format($data['space_total_min_room'], 2,',', ' ');
    if ($data['space_total_max_room']) { ?> �� <?php echo number_format($data['space_total_max_room'], 2,',', ' '); } ?> �<sup>2</sup></li><?php
}


// ����� �������
if ($data['count_nolife_total'])
{
    ?><li>����������� ������� ��������� - <?php echo $data['count_nolife_total']; ?></li><?php
}

// ��������� �������
if ($data['count_nolife'])
{
    ?><li>��������� ������� ��������� - <?php echo $data['count_nolife']; ?></li><?php
}
// ��������� �������
if ($data['price_min_metre_nolife'])
{
    ?><li>��������� ������� ��������� �� <?php echo number_format($data['price_min_metre_nolife'], 0,',', ' ');
    if ($data['price_max_metre_nolife'] and $data['price_max_metre_nolife'] != $data['price_min_metre_nolife']) { ?> �� <?php echo number_format($data['price_max_metre_nolife'], 0,',', ' '); } ?> ���/�<sup>2</sup></li><?php
}


// ����� ��������
if ($data['count_pantry_total'])
{
    ?><li>����������� �������� ��������� - <?php echo $data['count_pantry_total']; ?></li><?php
}

// ��������� ��������
if ($data['count_pantry'])
{
    ?><li>��������� �������� ��������� - <?php echo $data['count_pantry']; ?></li><?php
}



?></table><br /><h2>������� ���������</h2><?php

	$list_houses = new Special_Vtor_Sub_List_House();
	$list_houses->setComplex($data['id']);
	
	$result = $list_houses->getDatas();
	if (count($result))
	{
	    foreach ($result as $value)
	    {
            $house = new Display_House_OneInListComplex();
            $house->data = $value;
            echo $house->render();
	    }
	}
	


if ($data['text'])
{
    ?><div class="house-description"><?php echo $data['text']; ?></div><?php
}
?>


<?php
//echo $data;
?>
</div>
