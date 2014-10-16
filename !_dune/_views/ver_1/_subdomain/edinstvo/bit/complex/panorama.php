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

<h1>Панорамный обзор. <?php echo $data['name']; ?></h1><?php


?><p class="house-name">
<?php if ($data['settlement_id'] == 1)
{
    ?>Рязань<?php
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
?>, <?php if ($data['street_adding']) { ?>улица <?php } echo $data['name_street'];
}

if (!$data['build_status'] and $data['adress_build'])
{
    ?><br /> (<?php echo $data['adress_build'] ?>) <?php
}
?></p>
<!--
<p class="house-name">Панорамный обзор</p>
-->


<?php
if (!$this->panorama->getFlashFileName($this->number))
{
    $this->number = 1;
}
?>
<p>Для просмотра панорамных обзоров необходим <a href="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash">Adobe Flash Player</a></p>
<table style="width: 100%;">
<?php
?>
<tr><td style="width: 100%; text-align:center; padding: 5px;">

<div id="panorama-flash">
<?php
$text = $this->panorama->getText($this->number);
if ($text) { ?>
<h4><?php echo $text; ?></h4>
<?php } ?>
<OBJECT CLASSID="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
WIDTH="650" HEIGHT="650"
CODEBASE="http://active.macromedia.com/flash2/cabs/swflash.cab#version=2,0,0,0">
<PARAM NAME="MOVIE" VALUE="<?php echo $this->panorama->getFlashFileUrl($this->number);?>">


<PARAM NAME="BASE" VALUE="<?php echo $this->panorama->getFlashFolderUrl();?>">

<EMBED SRC="<?php echo $this->panorama->getFlashFileUrl($this->number);?>" WIDTH="650" HEIGHT="650" 
PLUGINSPAGE="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash2"
BASE="<?php echo $this->panorama->getFlashFolderUrl();?>">

</EMBED>

</OBJECT>

</div>

</td></tr>
<tr><td id="td-panorama-preview">
<?php
for ($x = 1; $x <= $this->panorama->count(); $x++)
{ 
    $url = $this->panorama->getPreviewFileUrl($x);
    if (!$url)
        $url = $this->view_folder . '/img/objects/collection/panorama_default.jpg';
    ?>
    <a class="panorama-link-to-one" title="" href="<?php echo $this->url_sourse;?>?number=<?php echo $x;?>"><img height="100" width="100" src="<?php echo $url; ?>" <?php
    if ($x == $this->number) echo 'class="active" ';
    ?>/></a>
<?php
}
?>
</td></tr>
</table>


</div>