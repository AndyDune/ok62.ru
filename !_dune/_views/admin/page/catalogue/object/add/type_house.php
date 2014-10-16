<h1>���������� ������� ���.</h1>
<div id="add-object">
<form method="post">
<p><strong>������ ����� �� "��������". �� ���������� ������ �� ���� ��������.</strong> </p>
<input name="go" type="submit" value="��������" />
<div id="add-object-adress-part">
<table class="list-table-js">

<tr>
<td class="add-object-prompting">�������</td>
<td>
<?php echo $this->adress['region']['name'] ?>
</td>
</tr>

<tr>
<td class="add-object-prompting">�����</td>
<td>
<?php echo $this->adress['area']['name'] ?>
</td>
</tr>

<tr>
<td class="add-object-prompting">����� (�������, ����, �������)</td>
<td>
<?php if ($this->data['settlement_id'] and $this->adress['settlement']['type'] < 100) { ?>
<?php echo $this->adress['settlement']['name'] ?>
<?php } else { ?>
<input style="width: 300px;" name="settlement_name" type="text" value="<?php echo $this->data['settlement_name']?>" />
<?php } ?>
</td>
</tr>

<?php if ($this->adress['district']['id']) { ?>
<tr>
<td class="add-object-prompting">��������� �����</td>
<td>
<?php echo $this->adress['district']['name'] ?>
</td>
</tr>
<?php } ?>

<tr>
<td class="add-object-prompting">�����</td>
<td>
<?php if ($this->data['street_id']) { ?>
<?php echo $this->adress['street']['name'] ?>
<?php } else { ?>
<input style="width: 300px;" name="street_name" type="text" value="<?php echo $this->data['street_name']?>" />
<?php } ?>

</td>
</tr>

<tr>
<td class="add-object-prompting">���</td>
<td>
<input name="house_number" type="text" value="<?php echo $this->data['house_number']?>" />
</td>
</tr>
<tr>
<td class="add-object-prompting">������ � ����</td>
<td>
<input name="levels" type="text" value="<?php echo $this->data['levels']?>" />
</td>
</tr>


</table>
</div>

<div id="add-object-info-part">

<table class="list-table-js">

<tr>
<td class="add-object-prompting">�������: �����/�����/�����</td>
<td>
<input name="space_total" type="text" value="<?php echo $this->data['space_total']?>" /> 
 / 
 <input name="space_living" type="text" value="<?php echo $this->data['space_living']?>" /> 
 / 
<input name="space_kitchen" type="text" value="<?php echo $this->data['space_kitchen']?>" /> 
</td>
</tr>


<tr>
<td class="add-object-prompting">������ ��������:</td>
<td>
<input class="input-shot" name="height_ceiling" type="text" value="<?php echo $this->data['height_ceiling']?>" /> 
</td>
</tr>


<tr>
<td class="add-object-prompting">�������</td>
<td>
<?php
 $room1 = new Dune_Form_InputRadio('rooms_count');
 $room1->setValue(1);
 if ($this->data['rooms_count'] == 1)
    $room1->setChecked();
 $room2 = new Dune_Form_InputRadio('rooms_count');
 $room2->setValue(2);
 if ($this->data['rooms_count'] == 2)
    $room2->setChecked();

 $room3 = new Dune_Form_InputRadio('rooms_count');
 $room3->setValue(3);
 if ($this->data['rooms_count'] == 3)
    $room3->setChecked();
 $room4 = new Dune_Form_InputRadio('rooms_count');
 $room4->setValue(4);
 if ($this->data['rooms_count'] == 4)
    $room4->setChecked();
?>
<ul>
 <li><?php echo $room1;?> 1 �������</li>
 <li><?php echo $room2;?> 2 �������</li>
 <li><?php echo $room3;?> 3 �������</li>
 <li><?php echo $room4;?> ����� 3-�</li>
 </ul>
 
</td>
</tr>


<tr>
<td class="add-object-prompting">���������</td>
<td>
<?php
$form = new Dune_Form_Select('condition');
$form->setOption(0, '�� ��������');
foreach ($this->condition as $value)
{
    if ($value['id'] == $this->data['condition'])
        $check = true;
    else 
        $check = false;
    $form->setOption($value['id'], $value['name'], $check);
}
echo $form;
?>
</td>
</tr>

<tr>
<td class="add-object-prompting">����������:</td>
<td>
<?php
$form = new Dune_Form_Select('planning');
$form->setOption(0, '�� ��������');
foreach ($this->planning as $value)
{
    if ($value['id'] == $this->data['planning'])
        $check = true;
    else 
        $check = false;
    $form->setOption($value['id'], $value['name'], $check);
}
echo $form;
?>
</td>
</tr>


<tr>
<td class="add-object-prompting">������� �������</td>
<td>
<?php 
$form = new Dune_Form_InputCheckBox('balcony');
if ($this->data['balcony'])
$form->setChecked();
echo $form;
?>

</td>
</tr>

<tr>
<td class="add-object-prompting">������� ������</td>
<td>
<?php 
$form = new Dune_Form_InputCheckBox('loggia');
if ($this->data['loggia'])
$form->setChecked();
echo $form;
?>
</td>
</tr>



<td class="add-object-prompting">��������</td>
<td>
<?php 
$form = new Dune_Form_TextArea('info_text');
$form->setValue($this->data['info_text']);
$form->setRows(5);
$form->setClass('textarea');
echo $form->get();
?>
</td>
</tr>

</table>
</div>

<div id="add-object-final-part">
<table>

<tr>
<td class="add-object-prompting">�����������</td>
<td>
<?php 
$form = new Dune_Form_InputCheckBox('new_building_flag');
$form->setValue(1);
if ($this->data['new_building_flag'])
$form->setChecked();
echo $form;
?>
 / <input type="text" name="new_building_text" value="<?php echo $this->data['new_building_text']; ?>" style="width:85%;"/> 
</td>
</tr>


<tr>
<td class="add-object-prompting">����</td>
<td>
<input name="price" type="text" value="<?php echo $this->data['price']?>" /> 
</td></tr>

<tr>
<td class="add-object-prompting">���� �� 1 ��.�.</td>
<td>
<input name="price_one" type="text" value="<?php echo number_format($this->data['price_one'], '0', '.',' ')?>" /> 
</td>
</tr>

<tr>
<td class="add-object-prompting">���� �� ������</td>
<td>
<input name="price_rent" type="text" value="<?php echo number_format($this->data['price_rent'], '0', '.',' ')?>" /> </td>
</tr>


</table>
</div>

<input name="region_id" type="hidden" value="<?php echo $this->data_region['id'] ?>" />
<input name="link_list" type="hidden" value="<?php echo $this->link_list ?>" />
<input name="_do_" type="hidden" value="save" />
<input name="adress_code" type="hidden" value="<?php echo $this->adress_code ?>" />
<input name="adress_id" type="hidden" value="<?php echo $this->adress_id ?>" />
<input name="go" type="submit" value="���������" />

</form>
</div>