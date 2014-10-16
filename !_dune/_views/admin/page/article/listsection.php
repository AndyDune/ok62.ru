<h1>Разделы статей.</h1>
<?php
//$test = new Dune_Test_Array($this->array);
//$test->printPre();

if ($this->data->count() > 0)
{ // Если записей много. Начало.
?><table class="list-table">
<tr>
<th>ID</th>
<th>Название</th>
<th>Действие</th>
</tr>
<?php
foreach ($this->data as $value)
{ 
	?><tr>
	<td class="list-td-id"><?php echo $value['id']?></td>
	<td class="list-td-text-shot"><a href="?com=edit&id=<?php echo $value['id']?>"><?php echo $value['name']?></a></td>
	
	<td class="list-td-text-mid"><a href="?com=delete&id=<?php echo $value['id']?>">Удалить</a></td>
	</tr>
	<?php
} ?> </table>
<?php
} // Если записей много. Конец.
else 
{
	echo '<p id="say-important">Список пуст</p>';
}
?>
<p>
<form method="post">
<input type="hidden" name="com" value="add" />
<input type="submit" name="new" value="Новый раздел" />
</form>
</p>