
<div id="object-info">
<table>


<tr>
<td class="object-prompting">Город</td>
<td>
<?php echo $this->object->name_settlement;
if ($this->object->district_id) { ?>, <?php echo $this->object->name_district; } ?>

</td>
</tr>

<tr>
<td class="object-prompting">Улица</td>
<td>
<?php echo $this->object->name_street ?>
</td>
</tr>

<tr>
<td class="object-prompting">Дом</td>
<td>
<?php echo $this->object->house_number;
if ($this->object->building_number) {
    $word = $this->object->building_number;
    $word = str_replace(array('a', 'b', 'c', 'd', 'e'), array('а', 'б', 'в', 'г', 'д'), $word);


    ?>, корпус <?php echo $word; } ?>
</td>
</tr>


<?php if ($this->object->porch)
{ ?>
<tr>
<td class="object-prompting">Подъезд</td>
<td>
<?php echo $this->object->porch ?>
</td>
</tr>
<?php } ?> 


<tr>
<td class="object-prompting">Этаж/этажей</td>
<td>
<?php echo $this->object->floor;
if ($this->object->floors_total) { ?>/<?php echo $this->object->floors_total; } else {?>/-<?php } ?>
</td>
</tr>

<tr>
<td class="object-prompting">Номер квартиры</td>
<td>
<?php echo $this->object->room ?>
</td>
</tr>
</table>


<table class="list-table-js">
<tr>
<td class="object-prompting">Площадь:<br /> общая/жилая/кухня</td>
<td>
<?php echo $this->object->space_total ?>/<?php echo $this->object->space_living ?>/<?php echo $this->object->space_kitchen ?> кв.м.
</td>
</tr>

<tr>
<td class="object-prompting">Комнат</td>
<td>
<?php
if (!$this->object->rooms_count) echo ' - ';
else if ($this->object->rooms_count < 4) echo $this->object->rooms_count;
else 
{
?>более 3-х<?php }?>
</td>
</tr>


<?php if ($this->object->levels > 1)
{ ?>
<tr>
<td class="object-prompting">Этажей</td>
<td>
<?php echo $this->object->levels; ?>
</td>
</tr>
<?php } ?>

<tr>
<td class="object-prompting">Планировка:</td>
<td>
<?php
$check = ' - ';
foreach ($this->planning as $value)
{
    if ($value['id'] == $this->object->planning)
    {
        $check = $value['name'];
        break;
    }
}
echo $check;
?>
</td>
</tr>

<tr>
<td class="object-prompting">Состояние:</td>
<td>
<?php
$check = ' - ';
foreach ($this->condition as $value)
{
    if ($value['id'] == $this->object->condition)
    {
        $check = $value['name'];
        break;
    }
}
echo $check;
?>
</td>
</tr>


<tr>
<td class="object-prompting">Балкон</td>
<td>
<?php 
if (!$this->object->balcony) echo ' Есть';
else echo 'Нет';
?>
</td>
</tr>

<tr>
<td class="object-prompting">Лоджия</td>
<td>
<?php 
if (!$this->object->loggia) echo ' Есть';
else echo 'Нет';
?>
</td>
</tr>
<table>

<dl id="dl-description">
<dt>Описание</dt>
<dd>
<?php 
echo str_replace("\n", '<br />', $this->object->info_text);
?>
</dd>
</dl>


<table>

<?php if ($this->object->price_one)
{
?><tr>
<td class="object-prompting">Цена за 1 кв.м.</td>
<td>
<span class="focus-red"><?php echo number_format($this->object->price_one, '0', '.',' ')?> руб.</span>
</td>
</tr>
<?php
}
?>


<tr>
<td class="object-prompting">Цена</td>
<td>
<span class="focus-red"><?php echo number_format($this->object->price, '0', '.',' ')?> руб.</span>
</td>
</tr>

</table>




</div>

