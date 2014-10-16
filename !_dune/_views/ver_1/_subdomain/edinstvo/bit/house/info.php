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
?><table id="table-house-one" width="100%" cellpadding="5" cellspacing="0">
<tr>
<td width="260px" rowspan="2">

<?php if ($this->fasad)
{
    ?><a href="/house/<?php echo $data['id']; ?>/"><img src="<?php echo $this->fasad->getPreviewFileUrl(250); ?>" alt="����� ����." /></a><?php
}
?>
</td>
<td colspan="2">
<?php
if ($data['district_id_plus'] > 1)
{
    ?><p class="p-house-list-district">�����: <?php echo $data['name_district_plus'] ?></p><?php
}

// ���������
if ($data['count_floors'])
{
    ?><p>���������: <?php echo $data['count_floors']; ?></p><?php
}
?><td></tr><tr><td><?php

?><div><?php
// ��������� �������
if ($data['count_room_total'])
{
    ?><p class="strong">����� ������� - <?php echo $data['count_room_total']; ?></p><?php
}

if ($data['count_room'])
{
    ?><p class="strong">��������� - <a href="/house/<?php echo $data['id'] ?>/grid/room/"><?php echo $data['count_room']; ?></a></p><?php
}

if ($data['count_room_1'])
{
    ?><p class="strong">1-����. - <a href="/house/<?php echo $data['id'] ?>/grid/room/"><?php echo $data['count_room_1']; ?></a></p><?php
}
if ($data['count_room_2'])
{
    ?><p class="strong">2-����. - <a href="/house/<?php echo $data['id'] ?>/grid/room/"><?php echo $data['count_room_2']; ?></a></p><?php
}
if ($data['count_room_3'])
{
    ?><p class="strong">3-����. - <a href="/house/<?php echo $data['id'] ?>/grid/room/"><?php echo $data['count_room_3']; ?></a></p><?php
}

if ($data['count_room_4'])
{
    ?><p class="strong">������ - <a href="/house/<?php echo $data['id'] ?>/grid/room/"><?php echo $data['count_room_4']; ?></a></p><?php
}


?></div>
</td>
<td><div>
<?php
// ��������� �������
if ($data['count_nolife_total'])
{
    ?><p class="strong">����� ������� ���������: <?php echo $data['count_nolife_total']; ?></p><?php
}

// ��������� �������
if ($data['count_nolife'])
{
    $url_catalogue->setType(4);
    ?><p class="strong">���������: <a href="/house/<?php echo $data['id'] ?>/grid/nolife/"><?php echo $data['count_nolife']; ?></a></p><?php
}
?></div><div><?php
// ��������� �������
if ($data['count_pantry_total'])
{
    ?><p class="strong">����� �������� ���������: <?php echo $data['count_pantry_total']; ?></p><?php
}

// ��������� ��������
if ($data['count_pantry'])
{
    ?><p class="strong">���������: <a href="/house/<?php echo $data['id'] ?>/grid/pantry/"><?php echo $data['count_pantry']; ?></a></p><?php
}

?></div>
</td>
</tr>
</table>






<h4>�������� ���������</h4>
<ul class="just-list">
<?php
// ��������� �������
if ($data['price_min_metre_room'])
{
    ?><li>��������� ������� �� <?php echo number_format($data['price_min_metre_room'], 0,',', ' ');
    if ($data['price_max_metre_room']) { ?> �� <?php echo number_format($data['price_max_metre_room'], 0,',', ' '); } ?> ���/�<sup>2</sup></li><?php
}

// ��������� �������
if ($data['price_max_metre_room'])
{
    ?><li>��������� ������� �� <?php echo number_format($data['price_max_metre_room'], 0,',', ' ');
    ?> ���/�<sup>2</sup></li><?php
}

// ������� �������
if ($data['space_total_min_room'])
{
    ?><li>������� ������� �� <?php echo number_format($data['space_total_min_room'], 2,',', ' ');
    if ($data['space_total_max_room']) { ?> �� <?php echo number_format($data['space_total_max_room'], 2,',', ' '); } ?> �<sup>2</sup></li><?php
}

// ��������� �������
if ($data['price_min_metre_nolife'])
{
    ?><li>��������� ������� ��������� �� <?php echo number_format($data['price_min_metre_nolife'], 0,',', ' ');
    if ($data['price_max_metre_nolife'] and $data['price_max_metre_nolife'] != $data['price_min_metre_nolife']) { ?> �� <?php echo number_format($data['price_max_metre_nolife'], 0,',', ' '); } ?> ���/�<sup>2</sup></li><?php
}
// ������� ������� ���������
if ($data['space_total_min_nolife'])
{
    ?><li>������� ������� ��������� �� <?php echo number_format($data['space_total_min_nolife'], 2,',', ' ');
    if ($data['space_total_max_nolife']) { ?> �� <?php echo number_format($data['space_total_max_nolife'], 2,',', ' '); } ?> �<sup>2</sup></li><?php
}



// ��������� ��������
if ($data['price_min_metre_pantry'])
{
    ?><li>��������� �������� ��������� �� <?php echo number_format($data['price_min_metre_pantry'], 0,',', ' ');
    if ($data['price_max_metre_pantry']) { ?> �� <?php echo number_format($data['price_max_metre_pantry'], 0,',', ' '); } ?> ���/�<sup>2</sup></li><?php
}
// ������� �������� ���������
if ($data['space_total_min_pantry'])
{
    ?><li>������� ������� ��������� �� <?php echo number_format($data['space_total_min_pantry'], 2,',', ' ');
    if ($data['space_total_max_pantry']) { ?> �� <?php echo number_format($data['space_total_max_pantry'], 2,',', ' '); } ?> �<sup>2</sup></li><?php
}





?></ul>

<br />
<?php













if ($data['text'])
{
    ?><div class="house-description"><?php echo $data['text']; ?></div><?php
}
?>


<?php
//echo $data;
?>
</div>
