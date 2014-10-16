<div id="panorama-flash">


<OBJECT CLASSID="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
WIDTH="650" HEIGHT="650"
CODEBASE="http://active.macromedia.com/flash2/cabs/swflash.cab#version=2,0,0,0">
<PARAM NAME="MOVIE" VALUE="/data/flash/example1/flash/<?php echo $this->number;?>.swf">


<PARAM NAME="BASE" VALUE="/data/flash/example1/flash/">

<EMBED SRC="/data/flash/example1/flash/<?php echo $this->number;?>.swf" WIDTH="650" HEIGHT="650" 
PLUGINSPAGE="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash2"
BASE="/data/flash/example1/flash/">

</EMBED>

</OBJECT>

</div>

</td></tr>
<tr><td id="td-panorama-preview">
<?php
for ($x = 1; $x <= 3; $x++)
{ 
    $url = '/data/flash/example1/img/' . $x . '.jpg';
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
