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
<h1>����� <?php

echo $data['name_street'];
if ($data['house_number'])
{
    ?>, ��� <?php echo $data['house_number'];
}
if ($data['building_number'])
{
    ?>, ������ <?php echo $data['building_number'];
}

if (!$data['build_status'] and $data['adress_build'])
{
    ?><br /> (<?php echo $data['adress_build'] ?>) <?php
}
?></h1><?php
if ($data['new_building_flag'])
{
    ?><p class="house-status">�����������, <?php echo  $data['new_building_text']; ?></p><?php
}
else 
{
    ?><p class="house-status">������� ���</p><?php
}
if ($data['name'])
{
    ?><p class="house-name"><?php echo $data['name']; ?></p><?php
}



if ($data['have_fasad'])
{
    $img = new Special_Vtor_Sub_Image_Fasad($data['id']);
    $this->fasad = $img->getOneImage();
}
?><table class="table-house-in-list" width="100%" cellpadding="5" cellspacing="0">
<tr>
<td width="260px">

<?php if ($this->fasad)
{
    ?><a href="/house/<?php echo $data['id']; ?>/"><img src="<?php echo $this->fasad->getPreviewFileUrl(250); ?>" alt="����� ����." /></a><?php
}
?>
</td>
<td>
<?php
if ($data['district_id_plus'] > 1)
{
    ?><p class="p-house-list-district">�����: <?php echo $data['name_district_plus'] ?></p><?php
}
?><div class="div-house-list-count"><?php
// ��������� �������
if ($data['count_room'])
{
    if ($data['grid_id'])
        $url = '/house/' . $data['id'] . '/grid/room/';
    else
    { 
        $url_catalogue->setType(1);
        $url = $url_catalogue->get();
    }
    ?><p>��������� �������: <a href="<?php echo $url; ?>"><?php echo $data['count_room']; ?></a></p><?php
}
// ��������� �������
if ($data['count_nolife'])
{
    $url_catalogue->setType(4);
    ?><p>��������� ������� ���������: <a href="<?php echo $url_catalogue->get(); ?>"><?php echo $data['count_nolife']; ?></a></p><?php
}
// ��������� ��������
if ($data['count_pantry'])
{
    $url_catalogue->setType(5);
    ?><p>��������� �������� ���������: <a href="<?php echo $url_catalogue->get(); ?>"><?php echo $data['count_pantry']; ?></a></p><?php
}


?></div>
</td>
<td width="180px">

</td>
</tr>
</table>





















<table id="house-info-details"><?php
if ($data['name_district_plus'])
{
    ?><tr><td>�����</td><td><?php echo $data['name_district_plus']; ?></td></tr><?php
}
// ���������
if ($data['count_floors'])
{
    ?><tr><td>���������</td><td><?php echo $data['count_floors']; ?></td></tr><?php
}

// ����� �������
if ($data['count_room_total'])
{
    ?><tr><td>���������� �������</td><td><?php echo $data['count_room_total']; ?></td></tr><?php
}

// ��������� �������
if ($data['count_room'])
{
    $url_catalogue->setType(1);
    ?><tr><td>��������� �������</td><td><a href="<?php
    if ($data['grid_room'])
        echo $this->url . 'grid/room/';
    else 
        echo $url_catalogue->get(); 
     
     ?>"><?php echo $data['count_room']; ?></a></td></tr><?php
}
// ��������� �������
if ($data['price_min_metre_room'])
{
    ?><tr><td>��������� �������</td><td>�� <?php echo number_format($data['price_min_metre_room'], 0,',', ' ');
    if ($data['price_max_metre_room']) { ?> �� <?php echo number_format($data['price_max_metre_room'], 0,',', ' '); } ?> ���/�<sup>2</sup></td></tr><?php
}

// ������� �������
if ($data['space_total_min_room'])
{
    ?><tr><td>������� �������</td><td>�� <?php echo number_format($data['space_total_min_room'], 2,',', ' ');
    if ($data['space_total_max_room']) { ?> �� <?php echo number_format($data['space_total_max_room'], 2,',', ' '); } ?> �<sup>2</sup></td></tr><?php
}



// ����� �������
if ($data['count_nolife_total'])
{
    ?><tr><td>����������� ������� ���������</td><td><?php echo $data['count_nolife_total']; ?></td></tr><?php
}

// ��������� �������
if ($data['count_nolife'])
{
    $url_catalogue->setType(4);
    ?><tr><td>��������� ������� ���������</td><td><a href="<?php echo $url_catalogue->get(); ?>"><?php echo $data['count_nolife']; ?></a></td></tr><?php
}
// ��������� �������
if ($data['price_min_metre_nolife'])
{
    ?><tr><td>��������� ������� ���������</td><td>�� <?php echo number_format($data['price_min_metre_nolife'], 0,',', ' ');
    if ($data['price_max_metre_nolife'] and $data['price_max_metre_nolife'] != $data['price_min_metre_nolife']) { ?> �� <?php echo number_format($data['price_max_metre_nolife'], 0,',', ' '); } ?> ���/�<sup>2</sup></td></tr><?php
}
// ������� ������� ���������
if ($data['space_total_min_nolife'])
{
    ?><tr><td>������� ������� ���������</td><td>�� <?php echo number_format($data['space_total_min_nolife'], 2,',', ' ');
    if ($data['space_total_max_nolife']) { ?> �� <?php echo number_format($data['space_total_max_nolife'], 2,',', ' '); } ?> �<sup>2</sup></td></tr><?php
}





// ����� ��������
if ($data['count_pantry_total'])
{
    ?><tr><td>����������� �������� ���������</td><td><?php echo $data['count_pantry_total']; ?></td></tr><?php
}

// ��������� ��������
if ($data['count_pantry'])
{
    $url_catalogue->setType(5);
    ?><tr><td>��������� �������� ���������</td><td><a href="<?php echo $url_catalogue->get(); ?>"><?php echo $data['count_pantry']; ?></a></td></tr><?php
}

// ��������� ��������
if ($data['price_min_metre_pantry'])
{
    ?><tr><td>��������� �������� ���������</td><td>�� <?php echo number_format($data['price_min_metre_pantry'], 0,',', ' ');
    if ($data['price_max_metre_pantry']) { ?> �� <?php echo number_format($data['price_max_metre_pantry'], 0,',', ' '); } ?> ���/�<sup>2</sup></td></tr><?php
}
// ������� �������� ���������
if ($data['space_total_min_pantry'])
{
    ?><tr><td>������� ������� ���������</td><td>�� <?php echo number_format($data['space_total_min_pantry'], 2,',', ' ');
    if ($data['space_total_max_pantry']) { ?> �� <?php echo number_format($data['space_total_max_pantry'], 2,',', ' '); } ?> �<sup>2</sup></td></tr><?php
}





?></table><?php


if ($data['text'])
{
    ?><div class="house-description"><?php echo $data['text']; ?></div><?php
}
?>


<?php
//echo $data;
?>
</div>
