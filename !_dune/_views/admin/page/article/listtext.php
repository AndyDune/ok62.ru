<h1>Статьи.</h1>
<?php
//$test = new Dune_Test_Array($this->array);
//$test->printPre();
?><p><?php
echo $this->crumbs;
?></p><?php
if ($this->data->count() > 0)
{ // Если записей много. Начало.
?>
<p>
<form method="post">
<input type="hidden" name="com" value="add" />
<input type="submit" name="new" value="Новая статья" />
</form>
</p>

<table class="list-table">
<tr>
<th>ID</th>
<th>Название</th>
<th>Код</th>
<th>Дети</th>
<th>Родитель</th>
<th>Момент внедрения</th>
<th>Актив</th>
<th>Действие</th>
</tr>
<?php
foreach ($this->data as $value)
{ 
	?><tr> 
	<td class="list-td-id"><?php echo $value['id']?></td>
	<td class="list-td-text-shot"><a href="?com=edit&id=<?php echo $value['id']?>"><?php echo $value['name']?></a></td>
	<td class="list-td-id"><?php echo $value['name_code']?></td>
    <td class="list-td-text-shot"><a href="<?php echo $this->url; ?>parent_<?php echo $value['id']?>/">Список</a></td>
	<td class="list-td-text-shot"><span style="white-space:pre;"><?php echo $value['parent']?></span></td>
	<td class="list-td-text-shot"><span style="white-space:pre;"><?php echo $value['time_insert']?></span></td>
	
	<td class="list-td-text-shot">
	<?php if ($value['activity']) { ?>
	ДА
	<?php } else { ?>
	НЕТ
	<?php } ?>
	</td>
	
	<td class="list-td-text-mid"><a href="?com=delete&id=<?php echo $value['id']?>">Удалить</a></td>
	</tr>
	<?php
} ?> </table>
<?php
echo $this->navigator;

} // Если записей много. Конец.
else 
{
	echo '<p id="say-important">Список пуст</p>';
}
?>
<p>
<form method="post">
<input type="hidden" name="com" value="add" />
<input type="submit" name="new" value="Новая статья" />
</form>
</p>