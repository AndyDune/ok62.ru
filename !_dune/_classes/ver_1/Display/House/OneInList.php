<?php

class Display_House_OneInList extends Dune_Include_Abstract_Display
{

    /**
     * Используемые стили
     *
     * @var array
     */
    protected $______styles = array(
                                   'complex_house',
                                   'thickbox'
                                   );

    /**
     * Используемые скрипты
     *
     * @var array
     */
    protected $______scripts = array(
                                   'thickbox'
                                   );
                                   
    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
$id = $this->id;
$data = $this->data;
if (!$data)
{
    $house = new Special_Vtor_Sub_Data_House($id);
    if (!($data = $house->getInfo(1)))
        return '';
}

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


if ($data['have_fasad'])
{
    $img = new Special_Vtor_Sub_Image_Fasad($data['id']);
    $this->fasad = $img->getOneImage();
}
?><table class="table-house-in-list" cellpadding="5" cellspacing="0">
<tr>
<td width="260px">
<?php if ($data['name'])
{
    ?><p class="p-house-list-name"><strong style="color:red;"><a href="/house/<?php echo $data['id']; ?>/"><?php echo $data['name'] ?></a></strong></p><?php
}
?>

<?php if ($this->fasad)
{
    ?><a href="/house/<?php echo $data['id']; ?>/"><img src="<?php echo $this->fasad->getPreviewFileUrl(250); ?>" alt="Фасад дома." /></a><?php
}
?>
</td>
<td><p class="p-house-list-adress"><a href="/house/<?php echo $data['id']; ?>/">
Улица <?php

echo $data['name_street'];
if ($data['house_number'])
{
    ?>, дом <?php echo $data['house_number'];
}
if ($data['building_number'])
{
    ?>, корпус <?php echo $data['building_number'];
}

if (!$data['build_status'] and $data['adress_build'])
{
    ?><br /> (<?php echo $data['adress_build'] ?>) <?php
}
?></a></p>
<?php
if ($data['district_id_plus'] > 1)
{
    ?><p class="p-house-list-district">Район: <?php echo $data['name_district_plus'] ?></p><?php
}
?><div class="div-house-list-count"><?php
// Свободных квартир
if ($data['count_room'])
{
    if ($data['grid_id'])
        $url = '/house/' . $data['id'] . '/grid/room/';
    else
    { 
        $url_catalogue->setType(1);
        $url = $url_catalogue->get();
    }
    ?><p>Свободных квартир: <a href="<?php echo $url; ?>"><?php echo $data['count_room']; ?></a></p><?php
}
// Свободных нежилых
if ($data['count_nolife'])
{
    ?><p>Свободных нежилых помещений: <a href="/house/<?php echo $data['id']; ?>/grid/nolife/"><?php echo $data['count_nolife']; ?></a></p><?php
}
// Свободных кладовых
if ($data['count_pantry'])
{
    $url_catalogue->setType(5);
    ?><p>Свободных кладовых помещений: <a href="/house/<?php echo $data['id']; ?>/grid/pantry/"><?php echo $data['count_pantry']; ?></a></p><?php
}


?></div>
</td>
<td width="180px">




<!--

<div class="div-house-list-info-add"><?php

if ($data['have_photo'])
{
    ?><p><a href="/house/<?php echo $data['id']; ?>/photo/">Фоторепортаж</a></p> <?php
}
?>

<?php
if ($data['have_situa'])
{
    $img = new Special_Vtor_Sub_Image_Situa($data['id']);
    $one = $img->getOneImage();
    
    ?><p><a class="thickbox" href="<?php echo $one->getSourseFileUrl(); ?>">Ситуационый план</a></p><?php
}
else if ($data['complex_have_situa'])
{
    $img = new Special_Vtor_Sub_Complex_Image_Situa($data['complex_id']);
    if (count($img))
    {
        $one = $img->getOneImage();
        ?><p><a class="thickbox" href="<?php echo $one->getSourseFileUrl(); ?>">Ситуационый план</a></p><?php
    }
}
?>

<?php
if ($data['panorama_id'])
{
    ?><p><a href="/house/<?php echo $data['id']; ?>/panorama/">Панорамный обзор</a></p> <?php
}
else if ($data['complex_panorama_id'])
{
    ?><p><a href="/house/<?php echo $data['id']; ?>/panorama/">Панорамный обзор</a></p> <?php
}

?>

<?php
if ($data['pd'])
{
    ?><p><a href="/house/<?php echo $data['id']; ?>/pd/">Проектная декларация</a></p> <?php
}
?>



<?php
$goo = false;
if ($data['gm_x'])
{
    $gm = array('x' => $data['gm_x'], 'y' => $data['gm_y']);
    $goo = true;
}
else if ($data['group_gm_x'])
{
    $gm = array('x' => $data['group_gm_x'], 'y' => $data['group_gm_y']);
    $goo = true;
}
if ($goo)
{
    ?><p><a href="/map/public/<?php echo $gm['x']; ?>_<?php echo $gm['y']; ?>/">Смотреть на карте</a></p> <?php
}
?>

</div>


-->
</td>
</tr>
</table>
<div>
<p class="info-photo-house">
<?php
$goo = false;
if ($data['gm_x'])
{
    $gm = array('x' => $data['gm_x'], 'y' => $data['gm_y']);
    $goo = true;
}
else if ($data['group_gm_x'])
{
    $gm = array('x' => $data['group_gm_x'], 'y' => $data['group_gm_y']);
    $goo = true;
}
if ($goo)
{
    ?><a href="/map/public/<?php echo $gm['x']; ?>_<?php echo $gm['y']; ?>/"><img width="21" height="21" src="/data/img/subdomain/edinstvo/img/info/map.gif" alt="Смотреть на карте" /></a> <?php
}
if ($data['panorama_id'] or $data['complex_panorama_id'])
{
    ?><a href="/house/<?php echo $data['id']; ?>/panorama/"><img width="21" height="21" src="/data/img/subdomain/edinstvo/img/info/pan.gif" alt="Панорамный обзор" /></a> <?php
}

if ($data['have_photo'] or $data['complex_have_photo'])
{
    ?><a href="/house/<?php echo $data['id']; ?>/photo/"><img width="21" height="21" src="/data/img/subdomain/edinstvo/img/info/photo.gif" alt="Фоторепортаж" /></a> <?php
}
?>

</p><?php
if ($data['text_short'])
{
    ?><p><?php echo $data['text_short']; ?></p><?php
}
?>

</div>


<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    