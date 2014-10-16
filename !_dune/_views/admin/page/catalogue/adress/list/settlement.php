<h1>Список посёлков района</h1>
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
	<td class="list-td-text-shot"><a href="<?php
    if ($value['type'] == 1)
        echo $this->link_next_list_center;
    else 
	   echo $this->link_next_list;
	
	?>/<?php echo $value['id']?>/" title="Список городов района"><?php echo $value['name']?></a></td>
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
<ul>
<li><a href="<?php echo $this->link_add;?>">Добавить посёлок</a></li>
</ul>

