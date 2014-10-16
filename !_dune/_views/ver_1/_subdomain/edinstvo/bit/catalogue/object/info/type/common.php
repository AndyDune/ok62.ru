
<div id="object-info">
<table>

<tr>
<td class="object-prompting">Область</td>
<td>
<?php echo $this->object->name_region ?>
</td>
</tr>

<tr>
<td class="object-prompting">Район</td>
<td>
<?php echo $this->object->name_area ?>
</td>
</tr>

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
if ($this->object->building_number) { ?>, корпус <?php echo $this->object->building_number; } ?>
</td>
</tr>

<tr>
<td class="object-prompting">Этаж/этажей</td>
<td>
<?php echo $this->object->floor;
if ($this->object->levels) { ?>/<?php echo $this->object->levels; } ?>
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

<dl>
<dt>Описание</dt>
<dd>
<?php 
echo str_replace("\n", '<br />', $this->object->info_text);
?>
</dd>
</dl>


<table>
<tr>
<td class="object-prompting">Цена</td>
<td>
<span class="focus-red"><?php echo number_format($this->object->price, '0', '.',' ')?></span> руб.
</td>
</tr>


</table>

</div>

