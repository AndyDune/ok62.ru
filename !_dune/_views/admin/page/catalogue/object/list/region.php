<h1>Объектов в области</h1>
<?php
//$test = new Dune_Test_Array($this->array);
//$test->printPre();

if ($this->data->count() > 0)
{ // Если записей много. Начало.
?><table class="list-table">
<tr>
<th>ID</th>
<th>Название</th>
<th>Общее число объектов</th>
<th>Число активных объектов</th>
<th>Действие</th>
</tr>
<?php
foreach ($this->data as $value)
{ 
	?><tr>
	<td class="list-td-id"><?php echo $value['id']?></td>
	<td class="list-td-text-shot"><a href="<?php echo $this->link_next_list;?>/<?php echo $value['id']?>/" title="Список районов области"><?php echo $value['name']?></a></td>
	<td class="list-td-id"><?php echo $value['count_total']?></td>
	<td class="list-td-id"><?php echo $value['count_active']?></td>
	<td class="list-td-text-mid"><a href="#">Редактирование</a></td>
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
