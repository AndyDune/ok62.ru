<?php echo $this->crumbs; ?>
<hr />
<h1>Статьи о ипотеке.</h1>
<ul class="articles-list-parents">
<?php
foreach ($this->list as $value_top)
{
?>
<li><a href="/modules.php?name=Hypothec&op=ArticleRead&id=<?php echo  $value_top['info']['id']?>"><?php echo  $value_top['info']['name']?></a>
<?php
if (count($value_top['children']))
{
?><ul class="articles-list-children"><?php
foreach ($value_top['children'] as $value)
{ ?>
<li><a href="/modules.php?name=Hypothec&op=ArticleRead&id=<?php echo  $value['id']?>"><?php echo  $value['name']?></a>
<?php } ?></ul>
<?php } ?>

</li>

<?php 
}
?></ul>