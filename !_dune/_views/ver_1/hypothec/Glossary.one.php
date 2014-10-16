<?php echo $this->crumbs; ?>
<hr />
<div id="glossary-one">
<h1><?php echo $this->name;?></h1>
<div id="glossary-one-text">
<?php echo str_replace("\n", '<br />', $this->text);?>
</div>
</div>