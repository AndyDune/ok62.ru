<h1>Список объектов.</h1>
<?php
//$test = new Dune_Test_Array($this->array);
//$test->printPre();

if ($this->data->count() > 0)
{ // Если записей много. Начало.
?><table class="list-table">
<tr>
<th>ID</th>
<th>Объект</th>
<th>Адрес</th>
<th>Акт</th>
<th>Действие</th>
</tr>
<?php
foreach ($this->data as $value)
{ 
	?><tr>
	<td class="list-td-id"><?php echo $value['id']?></td>
	<td class="list-td-text-mid"><a href="<?php
	   echo $this->link_edit;
	?>/<?php echo $value['id']?>/" title="Редактировать"><?php echo $value['name_type']?></a></td>
	
	<td class="list-td-text-shot">
	<?php echo $value['name_region']?>,
	<?php echo $value['name_area']?>,
	<?php if ($value['settlement_id'] and $value['type_settlement'] < 100)  { ?>
	<?php echo $value['name_settlement']?>,
	<?php } else { ?>
	<?php echo $value['settlement_name']?>,
	<?php } ?>
	<?php if ($value['street_id']) { ?>
	 улица <?php echo $value['name_street'];?>
	<?php } else
	{
	       echo $value['street_name'];
	} ?>
	 
	, дом <?php echo $value['house_number'];

	if ($value['building_number']) { 
	?>, корпус <?php echo $value['building_number']; }?>
	
	<?php if ($value['room'])
	 {
	    if ($value['type'] == 1) {
	 ?>, квартира <?php
        } else {
            ?>, номер <?php
        }
	   echo $value['room'];
	    } ?>
	
	</td>

	<?php if ($value['activity']) { ?>
	<td class="list-td-text-mid" style="background-color:green; width: 20px;">&nbsp;</td>
	<?php } else  { ?>
	<td class="list-td-text-mid" style="background-color:red; width: 20px;">&nbsp;</td>
	<?php } ?>
	
	
	<td class="list-td-text-mid"><a href="<?php
	   echo $this->link_edit;
	?>/<?php echo $value['id']?>/">Редактировать.</a></td>
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

<dl>
<dt>По текущему адресу добавить:<dt>
<ul>
<?php foreach ($this->types as $value) { ?>
<li><a href="<?php echo $this->link_add;?>-type-<?php echo $value['code']?>/"><?php echo $value['name']?></a></li>
<?php } ?>
</ul>

