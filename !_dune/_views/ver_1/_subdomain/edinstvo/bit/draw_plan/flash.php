<h1>��������� ����������</h1>
<?php
// echo $this->steps_panel;
$this->setResult('title', '��������� ����������. ');
?>


<div id="object-under-bookmark">
<div id="object-info">
<div id="object-sell">
<?php if ($this->look) {
    $url = '#';
    ?>
<p><a  class="buttom" href="/public/plan/info/<?php echo $this->look; ?>/">���������� ��������</a></p>
<?php } else 
{
    $url = '/public/plan/draw/';
}
?>
<?php if (isset($this->data['public']) and $this->data['public']) { ?>
<p>����������� �������� ��� ���������� ���������. <a href="/public/plan/info/<?php echo $this->look; ?>/frompublic/">������</a></p>
<?php } ?>


<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="900" height="800" id="planningFlash">
				<param name="movie" value="/data/flash/plan/flash.swf" />
				<param name="flashvars" value="phpSid=<?php echo $this->session_id; ?>&amp;saveXml=/public/plan/draw/do_savexml/id_<?php echo $this->draw_id; ?>/&amp;savePng=/public/plan/draw/do_savepng/id_<?php echo $this->draw_id; ?>/&amp;loadXml=/public/plan/draw/do_loadxml/id_<?php echo $this->draw_id; ?>/&amp;url=<?php echo $url; ?>" />
				<!--[if !IE]>-->
				<object type="application/x-shockwave-flash" data="/data/flash/plan/flash.swf" width="900" height="800">
				<param name="flashvars" value="phpSid=<?php echo $this->session_id; ?>&amp;saveXml=/public/plan/draw/do_savexml/id_<?php echo $this->draw_id; ?>/&amp;savePng=/public/plan/draw/do_savepng/id_<?php echo $this->draw_id; ?>/&amp;loadXml=/public/plan/draw/do_loadxml/id_<?php echo $this->draw_id; ?>/&amp;url=<?php echo $url; ?>" />
				<!--<![endif]-->
					<a href="http://www.adobe.com/go/getflashplayer">
						<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
					</a>
				<!--[if !IE]>-->
				</object>
				<!--<![endif]-->
			</object>

</div>



</div>

<div class="ugol-left-top"></div>
<div class="ugol-left-bottom"></div>
<div class="ugol-right-top"></div>
<div class="ugol-right-bottom"></div>

</div>
