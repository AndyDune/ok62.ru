<?php echo $this->crumbs; ?>
<hr />
<h1>Глоссарий.</h1>

<?php
foreach ($this->list as $key =>$value)
{
?>
<dl class="glossary-item" id="<?php echo $key;?>">
<dt><?php echo $value['name'];?></dt>
<dd><?php echo $value['text'];?></dd>
</dl>

<?php 
}
?>