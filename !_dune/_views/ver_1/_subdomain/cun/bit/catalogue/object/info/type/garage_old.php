
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
if ($this->object->building_number) { ?>, ������ <?php echo $this->object->building_number; } ?>
</td>
</tr>

<?php if ($this->object->room)
{
?><tr>
<td class="object-prompting">�����</td>
<td>
<?php echo $this->object->room ?>
</td>
</tr>
<?php } ?>


<?php if ($this->object->type_add)
{
?><tr>
<td class="object-prompting">���</td>
<td>
<?php echo $this->object->name_type_add ?>
</td>
</tr>
<?php } ?>


</table>


<table class="list-table-js">
<tr>
<td class="object-prompting">�������</td>
<td>
<?php echo $this->object->space_total ?> ��.�.
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
<tr>
<td class="object-prompting">����</td>
<td>
<span class="focus-red"><?php echo number_format($this->object->price, '0', '.',' ')?> ���.</span>
</td>
</tr>


</table>

</div>

