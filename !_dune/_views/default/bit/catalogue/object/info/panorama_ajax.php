<?php
foreach ($this->array as $panorama_id => $panorama_array)
{
?>
<?php
if ($this->file_name and (in_array($this->file_name . '.swf', $panorama_array['swf'])))
{
    $fname = $this->file_name . '.swf';
}
else 
{
    $fname = current($panorama_array['swf']);
}
?>
<OBJECT CLASSID="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
WIDTH="650" HEIGHT="650"
CODEBASE="http://active.macromedia.com/flash2/cabs/swflash.cab#version=2,0,0,0">
<PARAM NAME="MOVIE" VALUE="/images/panorama/<?php echo $panorama_id . '/swf/' . $fname;?>">


<PARAM NAME="BASE" VALUE="/images/panorama/<?php echo $panorama_id ?>/swf/">

<EMBED SRC="/images/panorama/<?php echo $panorama_id . '/swf/' . $fname;?>" WIDTH="650" HEIGHT="650" 
PLUGINSPAGE="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash2"
BASE="/images/panorama/<?php echo $panorama_id ?>/swf/">

</EMBED>
</OBJECT>

<?php } ?>
