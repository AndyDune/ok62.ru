
<div id="object-info">
<table>


<tr>
<td class="object-prompting">�����</td>
<td>
<?php echo $this->object->name_settlement;
if ($this->object->district_id) { ?>, <?php echo $this->object->name_district; } ?>

</td>
</tr>

<tr>
<td class="object-prompting">�����</td>
<td>
<?php echo $this->object->name_street ?>
</td>
</tr>

<tr>
<td class="object-prompting">���</td>
<td>
<?php echo $this->object->house_number;
if ($this->object->building_number) {
    $word = $this->object->building_number;
    $word = str_replace(array('a', 'b', 'c', 'd', 'e'), array('�', '�', '�', '�', '�'), $word);


    ?>, ������ <?php echo $word; } ?>
</td>
</tr>


<?php if ($this->object->porch)
{ ?>
<tr>
<td class="object-prompting">�������</td>
<td>
<?php echo $this->object->porch ?>
</td>
</tr>
<?php } ?> 


<tr>
<td class="object-prompting">����/������</td>
<td>
<?php echo $this->object->floor;
if ($this->object->floors_total) { ?>/<?php echo $this->object->floors_total; } else {?>/-<?php } ?>
</td>
</tr>

<tr>
<td class="object-prompting">����� ��������</td>
<td>
<?php echo $this->object->room ?>
</td>
</tr>
</table>


<table class="list-table-js">
<tr>
<td class="object-prompting">�������:<br /> �����/�����/�����</td>
<td>
<?php echo $this->object->space_total ?>/<?php echo $this->object->space_living ?>/<?php echo $this->object->space_kitchen ?> ��.�.
</td>
</tr>

<tr>
<td class="object-prompting">������</td>
<td>
<?php
if (!$this->object->rooms_count) echo ' - ';
else if ($this->object->rooms_count < 4) echo $this->object->rooms_count;
else 
{
?>����� 3-�<?php }?>
</td>
</tr>


<?php if ($this->object->levels > 1)
{ ?>
<tr>
<td class="object-prompting">������</td>
<td>
<?php echo $this->object->levels; ?>
</td>
</tr>
<?php } ?>

<tr>
<td class="object-prompting">����������:</td>
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
<td class="object-prompting">���������:</td>
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
<td class="object-prompting">������</td>
<td>
<?php 
if (!$this->object->balcony) echo ' ����';
else echo '���';
?>
</td>
</tr>

<tr>
<td class="object-prompting">������</td>
<td>
<?php 
if (!$this->object->loggia) echo ' ����';
else echo '���';
?>
</td>
</tr>
<table>

<dl id="dl-description">
<dt>��������</dt>
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
<td class="object-prompting">���� �� 1 ��.�.</td>
<td>
<span class="focus-red"><?php echo number_format($this->object->price_one, '0', '.',' ')?> ���.</span>
</td>
</tr>
<?php
}
?>


<tr>
<td class="object-prompting">����</td>
<td>
<span class="focus-red"><?php echo number_format($this->object->price, '0', '.',' ')?> ���.</span>
</td>
</tr>

</table>




</div>

