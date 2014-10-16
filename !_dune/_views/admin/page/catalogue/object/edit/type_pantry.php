<h1>�������������� ������� �������� ���������.</h1>
<p>������:
 <a href="/admin/catalogue/object/edit/<?php echo $this->data['id'] - 1 ?>/">����������</a>
 <a href="/admin/catalogue/object/edit/<?php echo $this->data['id'] + 1 ?>/">���������</a>
 </p>
 <?php if ($this->copy_original_url) { ?>
 <p><strong style="color:red;">!!! ����� �� �������: <a target="_blank" href="<?php echo $this->copy_original_url;?>">��������</a></strong></p>
 <?php } ?>

<div id="edit-object-container">
<table id="main-edit-table">
<tr><td>

<div id="add-object">
<form method="post">

<input name="go" type="submit" value="���������" />
<div id="add-object-adress-part">
<table class="list-table-js">

<tr>
<td class="add-object-prompting">����������</td>
<td>
<?php 
$form = new Dune_Form_InputCheckBox('activity');
if ($this->data['activity'])
$form->setChecked();
echo $form;
?>
</td>
</tr>

<tr>
<td class="add-object-prompting">��������</td>
<td>
<input name="saler_id" type="text" value="<?php echo $this->data['saler_id']?>" />
</td>
</tr>

<tr>
<td class="add-object-prompting">���� ��� ��������</td>
<td>
<input name="saler_special" type="text" value="<?php echo $this->data['saler_special']?>" />
</td>
</tr>



<tr>
<td class="add-object-prompting">��������. ���������� ����������</td>
<td>
<textarea style="width:100%;" rows="3" name="info_contact"><?php echo$this->data['info_contact'] ?></textarea>
</td>
</tr>


<tr>
<td class="add-object-prompting">����������</td>
<td>
<?php 
$form = new Dune_Form_InputCheckBox('mark');
$form->setValue(1);
if ($this->data['mark'])
$form->setChecked();
echo $form;
?>

</td>
</tr>

<tr>
<td class="add-object-prompting">��� ������������� ��������:</td>
<td>
<input class="input-shot" name="panorama" type="text" value="<?php echo $this->data['panorama']?>" /> 
</td>
</tr>

</table>
</div>

<div id="add-object-adress-part">
<table class="list-table-js">

<tr>
<td class="add-object-prompting">��������, ��������</td>
<td>
 <input type="text" name="name_complex" value="<?php echo $this->data['name_complex']; ?>" style="width:85%;"/> 
</td>
</tr>


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
<td class="add-object-prompting">���������� �����</td>
<td>
<?php
$form = new Dune_Form_Select('district_id_plus');
$form->setOption(0, '---');
foreach (Special_Vtor_Districts::$list as $key => $value)
{
    if ($key == $this->data['district_id_plus'])
        $check = true;
    else 
        $check = false;
    $form->setOption($key, $value, $check);
}
echo $form;
?>

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
<input name="floors_total" type="text" value="<?php echo $this->data['floors_total']?>" />
</td>
</tr>

<tr>
<td class="add-object-prompting">������</td>
<td>
<input name="building_number" type="text" value="<?php echo $this->data['building_number']?>" />
</td>
</tr>

<tr>
<td class="add-object-prompting">�������</td>
<td>
<input name="porch" type="text" value="<?php echo $this->data['porch']?>" />
</td>
</tr>

<tr>
<td class="add-object-prompting">������� (����� �� 100 ��������.)</td>
<td>
<?php 
$form = new Dune_Form_TextArea('porch_text');
$form->setValue($this->data['porch_text']);
$form->setRows(5);
$form->setCols(50);
$form->setClass('textarea');
echo $form->get();
?>

</td>
</tr>

<tr>
<td class="add-object-prompting">�����</td>
<td>
<input name="room" type="text" value="<?php echo $this->data['room']?>" />
</td>
</tr>

<tr>
<td class="add-object-prompting">����</td>
<td>
<?php
if ($this->data['floor'] == -1 or !$this->data['floor'])
{
    $floor = '';
}
else 
    $floor = $this->data['floor'];
?>
<input name="floor" type="text" value="<?php echo $floor?>" />
, ������ <input type="checkbox" name="floor" value="-1"<?php
if ($this->data['floor'] == -1)
{
    ?> checked="checked"<?php
}
?> />
</td>
</tr>

<tr>
<td class="add-object-prompting">����, ������� ���� �����</td>
<td>
<input name="floor_2" type="text" value="<?php echo $this->data['floor_2']?>" />
</td>
</tr>

<tr>
<td class="add-object-prompting">��� ����:</td>
<td>
<?php
foreach ($this->house_type as $value)
{
    $form = new Dune_Form_InputRadio('type_house');
    if ($value['id'] == $this->data['type_house'])
        $form->setChecked();
    $form->setValue($value['id']);
    echo $form;?> <?php echo $value['name']; ?> <br /><?php
}
?>
</td>
</tr>

</table>
</div>

<div id="add-object-info-part">

<table class="list-table-js">

<tr>
<td class="add-object-prompting">�������: �����/�����/�����</td>
<td>
<input class="input-shot" name="space_total" type="text" value="<?php echo $this->data['space_total']?>" /> 
 / 
 <input class="input-shot" name="space_living" type="text" value="<?php echo $this->data['space_living']?>" /> 
 / 
<input class="input-shot" name="space_kitchen" type="text" value="<?php echo $this->data['space_kitchen']?>" /> 
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
<td class="add-object-prompting">���������:</td>
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




<tr>
<td class="add-object-prompting">������� ������</td>
<td>
<?php 
$form = new Dune_Form_TextArea('info_show_condition');
$form->setValue($this->data['info_show_condition']);
$form->setRows(4);
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
<td class="add-object-prompting">������</td>
<td>
<?php 
$var_1 = $var_2 = '';
if (!$this->data['deal'])
{
    $var_1 = ' checked="checked"';
}
else if ($this->data['deal'] == 1)
{
    $var_2 = ' checked="checked"';
}
else if ($this->data['deal'] == 2)
{
    $var_1 = ' checked="checked"';
    $var_2 = ' checked="checked"';
}

?>
<input name="deal_1" type="checkbox"  value="1"<?php echo $var_1?> /> �������<br />
<input name="deal_2" type="checkbox"  value="1"<?php echo $var_2?> /> ������
</td>
</tr>


<tr>
<td class="add-object-prompting">���� ����������</td>
<td>
<?php
if ($this->data['price_contractual'])
{
    $var = ' checked="checked"';
}
else 
 $var = '';
?>
<input name="price_contractual" type="checkbox"  value="1"<?php echo $var?> />
</td>
</tr>



<tr>
<td class="add-object-prompting">����</td>
<td>
<?php
$value = '';
if ($this->data['price'])  
{
    $value = number_format($this->data['price'], '0', '.',' ');
}
?>

<input name="price" type="text" value="<?php echo $value?>" /> 
<?php
$value = '';
if ($this->data['price_old'])  
{
    $value = number_format($this->data['price_old'], '0', '.',' ');
}
?>

 ������ ����: <input name="price_old" type="text" value="<?php echo $value?>" /> 
</td>
</tr>

<tr>
<td class="add-object-prompting">���� �� 1 ��.�.</td>
<td>
<?php
$value = '';
if ($this->data['price_one'])  
{
    $value = number_format($this->data['price_one'], '0', '.',' ');
} ?>

<input name="price_one" type="text" value="<?php echo $value?>" /> 
</td>
</tr>

<tr>
<td class="add-object-prompting">���� �� ������</td>
<td>
<?php
$value = '';
if ($this->data['price_rent'])  
{
    $value = number_format($this->data['price_rent'], '0', '.',' ');
} ?>
<input name="price_rent" type="text" value="<?php echo $value?>" /> </td>
</tr>



</table>
</div>

<input name="region_id" type="hidden" value="<?php echo $this->data_region['id'] ?>" />
<input name="link_list" type="hidden" value="<?php echo $this->link_list ?>" />
<input name="_do_" type="hidden" value="save" />
<input name="adress_code" type="hidden" value="<?php echo $this->adress_code ?>" />
<input name="adress_id" type="hidden" value="<?php echo $this->adress_id ?>" />
<input name="id" type="hidden" value="<?php echo $this->data['id'] ?>" />
<input name="go" type="submit" value="���������" />

</form>
</div>


</td><td id="edit-object-pics-td">
<!--           �������                   -->
<div id="edit-object-pics">
<h2>����������</h2>


<div id="fragment-2">
<?php
$o_form = new Dune_Form_Form();
$o_form->setMethod(Dune_Form_Form::METHOD_POST);
$o_form->setEnctype(Dune_Form_Form::ENCTYPE_MULTI);
echo $o_form->getBegin();
$o_hidden_do = new Dune_Form_InputHidden('_do_');
$o_hidden_do->setValue('save_pics');
echo $o_hidden_do;
$o_submit = new Dune_Form_InputSubmit('���������');
$o_submit->setValue('���������');

?>
<div id="float-list">
<input name="id" type="hidden" value="<?php echo $this->data['id'] ?>" />
<?php
$count = 0;
foreach ($this->photos as $key => $file)
{
	$count++;
?>
<dl class="float-dl"><dt>
<?php echo $key?>. <a href="<?php echo $file->getSourseFileUrl()  ?>" target="_blank">
<img src="<?php echo $file->getPreviewFileUrl();  ?>" />
</a>
</dt>
<dd>
<input type="file" name="pic[<?php echo $key?>]">
</dd></dl>
<?php
}
?>
</div>
<?php 
if ($count < 5)
{
	$key = $count;
	echo '<h2>���������� ������ ��������</h2><ul>';
	for ($key = $count; $key < 5; $key++)
	{
		?><li>
		<input type="file" name="pic[<?php echo $key?>]">
		</li>
		<?php
		
	}
		echo '</ul>';
}
?>
<p>�������� ��������: <input type="file" name="new"></p>
<p>������� ��������� � ������: <a href="<?php echo $this->command_path_edit?>?_do_=delete_last&id=<?php echo $this->data['id'];?>">��</a></p>
<?php echo $o_submit->get();?>
</form>
</div>




</div>
</td></tr>
</table>
</div>