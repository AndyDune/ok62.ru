<?php
if (!$this->data->getFlashFileName($this->number))
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


<OBJECT CLASSID="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
WIDTH="650" HEIGHT="650"
CODEBASE="http://active.macromedia.com/flash2/cabs/swflash.cab#version=2,0,0,0">
<PARAM NAME="MOVIE" VALUE="<?php echo $this->data->getFlashFileUrl($this->number);?>">


<PARAM NAME="BASE" VALUE="<?php echo $this->data->getFlashFolderUrl();?>">

<EMBED SRC="<?php echo $this->data->getFlashFileUrl($this->number);?>" WIDTH="650" HEIGHT="650" 
PLUGINSPAGE="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash2"
BASE="<?php echo $this->data->getFlashFolderUrl();?>">

</EMBED>

</OBJECT>

</div>

</td></tr>
<tr><td id="td-panorama-preview">
<?php
for ($x = 1; $x <= $this->data->count(); $x++)
{ 
    $url = $this->data->getPreviewFileUrl($x);
    if (!$url)
        $url = $this->view_folder . '/img/objects/collection/panorama_default.jpg';
    ?>
    <a class="panorama-link-to-one" title="" href="<?php echo $this->base_url;?>?number=<?php echo $x;?>"><img height="100" width="100" src="<?php echo $url; ?>" <?php
    if ($x == $this->number) echo 'class="active" ';
    ?>/></a>
<?php
}
?>
</td></tr>
</table>
