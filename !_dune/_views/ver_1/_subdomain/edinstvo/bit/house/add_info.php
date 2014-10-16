<div id="house-info-add"><?php
$data = $this->data;
if ($this->photo)
{
    ?><dl class="pic-text"><dt><a href="<?php echo $this->url ?>photo/">Фоторепортаж</a></dt><dd><a href="<?php echo $this->url ?>photo/" title="Оригинал фотографии"><img src="<?php echo $this->photo->getPreviewFileUrl(250); ?>" /></a> </dd></dl> <?php
}
?>

<?php
if ($this->situa)
{
    ?><dl class="pic-text"><dt><a class="thickbox" href="<?php echo $this->situa->getSourseFileUrl(); ?>">Ситуационый план</a></dt><dd><a class="thickbox" href="<?php echo $this->situa->getSourseFileUrl(); ?>" title="Оригинал плана"><img src="<?php echo $this->situa->getPreviewFileUrl(250); ?>" /></a> </dd></dl> <?php
}
?>


<?php
if ($this->fasad)
{
    ?><dl class="pic-text"><dt><a class="thickbox" href="<?php echo $this->fasad->getSourseFileUrl(); ?>">Фасад здания</a></dt><dd><a class="thickbox" href="<?php echo $this->fasad->getSourseFileUrl(); ?>" title="Фасад здания"><img src="<?php echo $this->fasad->getPreviewFileUrl(250); ?>" /></a> </dd></dl> <?php
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
if ($goo)
{
    ?><dl class="pic-text"><dt><a href="http://ok62.ru/map/public/<?php echo $gm['x']; ?>_<?php echo $gm['y']; ?>/">Смотреть на карте</a></dt></dl> <?php
}
?>

<?php
if ($data['panorama_id'] or $data['complex_panorama_id'])
{
    ?><dl class="pic-text"><dt><a href="<?php echo $this->url; ?>panorama/">Панорамный обзор</a></dt></dl> <?php
}
?>

<?php
if ($this->pd)
{
    ?><dl class="pic-text"><dt><a href="<?php echo $this->url; ?>pd/">Проектная декларация</a></dt></dl> <?php
}
?>


</div>
