
<h3>Все наблюдаемые объекты</h3>
<?php if (Dune_Variables::$userStatus > 999) { ?>
<p><a href="/user/nearby/edit/" class="buttom">Добавить</a></p>
<?php } ?>

<!--
<ul id="ul-users-list-sort">
<li class="li-no-info"><span>Сортировка:</span></li>
<li<?php
if (!$this->order or $this->order == 'name')
{
    ?> class="current"<?php
}
?>><a href="/user/nearby/order_name/?page=0">По имени</a></li>
<li<?php
if ($this->order == 'time')
{
    ?> class="current"<?php
}
?>><a href="/user/nearby/order_time/?page=0">По количеству вражеских объектов</a></li>
</ul>
-->
<?php if (count($this->list)) {
    Dune_Static_JavaScriptsList::add('thickbox');
    Dune_Static_StylesList::add('thickbox');
    
    ?>
<table id="users-list">
<?php foreach ($this->list as $value) { ?>

<tr>
<td class="td-avatara">
<!--<a class="user-link" href="/user/nearby/list/<?php echo $value['id']; ?>/"> -->
<?php
if (isset($value['photo_preview']) and $value['photo_preview'])
{
    ?><a class="user-link thickbox" href="<?php echo $value['photo']; ?>"><img src="<?php
    echo $value['photo_preview'];
    ?>" width="100" height="100" /></a><?php
}
else 
{
    ?><img src="<?php
    echo $this->view_folder; ?>/img/house-3.png" width="100" height="100" /><?php
}
 ?>
 
<!-- </a> -->
</td>

<td class="td-text">
<p class="p-general-info"><a class="user-link" href="/user/nearby/list/<?php echo $value['id']; ?>/"><?php echo $value['name'];  ?></a></p>
<p class="p-general-info">Число конкурирующих: <?php echo $value['count'];  ?></p>

<?php if (Dune_Variables::$userStatus > 999) { ?>
<p class="p-general-info"><a href="/user/nearby/edit/<?php echo $value['id']; ?>/">Редактрировать</a></p>
<p style="text-align:right;"><a href="/user/nearby/edit/<?php echo $value['id']; ?>/?do=delete_group&id=<?php echo $value['id']; ?>">Удалить</a></p>
<?php } ?>

</td>
</tr>

<?php } ?>

</table>
<hr />
<?php echo $this->navigator; ?>

<?php } else{?>
нет
<?php } ?>

