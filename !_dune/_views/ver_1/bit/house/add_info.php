<div id="house-info-add"><?php
$data = $this->data;
if ($this->photo)
{
    ?><dl class="pic-text"><dt><a href="<?php echo $this->url ?>photo/">������������</a></dt><dd><a href="<?php echo $this->url ?>photo/" title="�������� ����������"><img src="<?php echo $this->photo->getPreviewFileUrl(250); ?>" /></a> </dd></dl> <?php
}
?>

<?php
if ($this->situa)
{
    ?><dl class="pic-text"><dt><a class="thickbox" href="<?php echo $this->situa->getSourseFileUrl(); ?>">����������� ����</a></dt><dd><a class="thickbox" href="<?php echo $this->situa->getSourseFileUrl(); ?>" title="�������� �����"><img src="<?php echo $this->situa->getPreviewFileUrl(250); ?>" /></a> </dd></dl> <?php
}
?>


<?php
if ($this->fasad)
{
    ?><dl class="pic-text"><dt><a class="thickbox" href="<?php echo $this->fasad->getSourseFileUrl(); ?>">����� ������</a></dt><dd><a class="thickbox" href="<?php echo $this->fasad->getSourseFileUrl(); ?>" title="����� ������"><img src="<?php echo $this->fasad->getPreviewFileUrl(250); ?>" /></a> </dd></dl> <?php
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
    ?><dl class="pic-text"><dt><a href="http://ok62.ru/map/public/<?php echo $gm['x']; ?>_<?php echo $gm['y']; ?>/">�������� �� �����</a></dt></dl> <?php
}
?>

<?php
if ($data['panorama_id'] or $data['complex_panorama_id'])
{
    ?><dl class="pic-text"><dt><a href="<?php echo $this->url; ?>panorama/">���������� �����</a></dt></dl> <?php
}
?>

<?php
if ($this->pd)
{
    ?><dl class="pic-text"><dt><a href="<?php echo $this->url; ?>pd/">��������� ����������</a></dt></dl> <?php
}
?>


</div>
