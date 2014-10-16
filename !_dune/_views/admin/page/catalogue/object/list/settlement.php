<h1>Список посёлков района. Число объектов.</h1>
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

<?php
foreach ($this->data as $value)
{ 
	?><tr>
	<td class="list-td-id"><?php echo $value['id']?></td>
	<td class="list-td-text-shot"><a href="<?php
    if ($value['type'] == 1)
        echo $this->link_next_list_center . '/';
    else 
    {
//	   echo $this->link_next_list;
	   echo $this->link_list_object , '/settlement-';
    }
	?><?php echo $value['id']?>/" title="Список"><?php echo $value['name']?></a></td>
	<td class="list-td-id"><?php echo $value['count_total']?></td>
	<td class="list-td-id"><?php echo $value['count_active']?></td>
	
	<td class="list-td-text-mid"><a href="<?php echo $this->link_edit;?>/<?php echo $value['id']?>/">Редактирование</a></td>
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
