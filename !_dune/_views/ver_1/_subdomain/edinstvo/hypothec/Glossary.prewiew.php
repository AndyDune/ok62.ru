<?php echo $this->crumbs; ?>
<hr />
<div id="glossary-list">
<h1>Глоссарий по ипотеке.</h1>
<p id="glossary-words-list">
<?php foreach ($this->words as $key => $value)
{
  ?> <a href="#word<?php echo $key?>"><?php echo $value?></a> <?php  
}
?>
</p>

<?php
foreach ($this->list as $key =>$value)
{
?>
<dl class="glossary-item-word" id="word<?php echo $key;?>">
<dt><?php echo $this->words[$key];?></dt>
<dd><ul class="glossary-list-one-word"><?php
foreach ($value as $value_inner)
{
    ?><li><a href="/modules.php?name=Hypothec&op=GlossaryOne&id=<?php echo $value_inner['id']; ?>"><?php echo $value_inner['name']; ?></a></li><?php
}
?></ul></dd>
</dl>

<?php 
}
?>
</div>