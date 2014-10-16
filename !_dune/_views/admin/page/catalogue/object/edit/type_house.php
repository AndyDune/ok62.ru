<?php
$heating    = array(2 => '����������', '�����������');
$water_cold = array(2 => '����������', '�����������');
$sewer      = array(2 => '�������', '�����������');

?>
<h1>�������������� ������� ���/�������.</h1>
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


<tr>
<td class="add-object-prompting">��� ������� <br /> <em>(������: ��������������� ������������ ����� ��������)</em></td>
<td>
 <input type="text" name="name" value="<?php echo $this->data['name']; ?>" style="width:85%;"/> 
</td>
</tr>


</table>
</div>

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
<td class="add-object-prompting">����� ����</td>
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
<td class="add-object-prompting">��� ����:</td>
<td>

<?php
$form = new Dune_Form_Select('type_add');
$form->setOption(1, '�� ��������');
foreach ($this->house_type as $value)
{
    if ($value['id'] == $this->data['type_add'])
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
<td class="add-object-prompting">�������� ���� :</td>
<td>

<?php
$form = new Dune_Form_Select('type_wall');
$form->setOption(1, '�� ��������');
foreach ($this->walls as $value)
{
    if ($value['id'] == $this->data['type_wall'])
        $check = true;
    else 
        $check = false;
    $form->setOption($value['id'], $value['name'], $check);
}
echo $form;
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
<td class="add-object-prompting">��������� �������:</td>
<td>
<input class="input-shot" name="space_calculation" type="text" value="<?php echo $this->data['space_calculation']?>" /> 
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
<input name="rooms_count" type="text" value="<?php echo $this->data['rooms_count']?>" /> 

 
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
<td class="add-object-prompting">������� ��������</td>
<td>
<?php 
$form = new Dune_Form_InputCheckBox('have_phone');
$form->setValue(1);
if ($this->data['have_phone'])
$form->setChecked();
echo $form;
?>

</td>
</tr>


<tr>
<td class="add-object-prompting">������� �������</td>
<td>
<?php 
$form = new Dune_Form_InputCheckBox('balcony');
$form->setValue(1);
if ($this->data['balcony'])
$form->setChecked();
echo $form;
?>
 / <input type="text" name="space_balcony" value="<?php echo $this->data['space_balcony']; ?>" class="input-1" /> ��. �.
</td>
</tr>

<tr>
<td class="add-object-prompting">������� ������</td>
<td>
<?php 
$form = new Dune_Form_InputCheckBox('loggia');
$form->setValue(1);
if ($this->data['loggia'])
$form->setChecked();
echo $form;
?>
 / <input type="text" name="space_loggia" value="<?php echo $this->data['space_loggia']; ?>" class="input-1" /> ��. �.
</td>
</tr>

<tr>
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
<td class="add-object-prompting">����������</td>
<td>
<?php 
$form = new Dune_Form_TextArea('info_comment');
$form->setValue($this->data['info_comment']);
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




<div id="add-object-info-part">
<table class="list-table-js">




<tr>
<td class="add-object-prompting">��������� �������</td>
<td>
<?php 
$form = new Dune_Form_InputCheckBox('have_land');
$form->setValue(1);
if ($this->data['have_land'])
$form->setChecked();
echo $form;
?> / 
<input type="text" name="space_land" value="<?php echo $this->data['space_land']; ?>" class="input-1" /> �����
</td>
</tr>


<tr>
<td class="add-object-prompting">����� (������� ����� ����������)</td>
<td>
<?php if ((int)$this->data['garage'] > 0)
{
    $text = $this->data['garage'];
}
else 
    $text = '';
 ?>
 <input type="text" name="garage" value="<?php echo $text; ?>"  class="input-shot" /> ��.
</td>
</tr>


<tr>
<td class="add-object-prompting">����</td>
<td>
<?php 
$form = new Dune_Form_InputCheckBox('have_bath');
if ($this->data['have_bath'])
$form->setChecked();
echo $form;
?>
</tr>

<!--
<tr>
<td class="add-object-prompting">���������� (����, ����, ����� � ��.) <br /> <em>(����� ��������� ��� ������ ������� 1 ������)</em></td>
<td>
<input type="text" name="add_building" value="<?php echo $this->data['add_building']; ?>" class="input-1" style="width:85%;" /></td>
</tr>
-->

<tr>
<td class="add-object-prompting">��� ����������� <br /><em> (�������� ����)</em>:</td>
<td>
<?php
$form = new Dune_Form_Select('type_water_cold');
$form->setOption(0, '---');
foreach ($water_cold as $key => $value)
{
    if ($key == $this->data['type_water_cold'])
        $check = true;
    else 
        $check = false;
    $form->setOption($key, $value, $check);
}
echo $form;
?>
</tr>

<tr>
<td class="add-object-prompting">��� ���������</td>
<td>
<?php
$form = new Dune_Form_Select('type_heating');
$form->setOption(0, '---');
foreach ($heating as $key => $value)
{
    if ($key == $this->data['type_heating'])
        $check = true;
    else 
        $check = false;
    $form->setOption($key, $value, $check);
}
echo $form;
?>

</tr>


<tr>
<td class="add-object-prompting">��� �����������:</td>
<td>
<?php
$form = new Dune_Form_Select('type_sewer');
$form->setOption(0, '---');
foreach ($sewer as $key => $value)
{
    if ($key == $this->data['type_sewer'])
        $check = true;
    else 
        $check = false;
    $form->setOption($key, $value, $check);
}
echo $form;
?>
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
 / <input type="text" name="new_building_text" value="<?php echo $this->data['new_building_text']; ?>" style="width:85%;" /> 
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
<td class="add-object-prompting">����</td>
<td>

<?php 
$form = new Dune_Form_InputRadio('haggling');
$form->setValue(100);
if ($this->data['haggling'] == 100)
$form->setChecked();
echo $form;
?> �� ���������� �� �����
<br />


<?php 
$form = new Dune_Form_InputRadio('haggling');
$form->setValue(0);
if ($this->data['haggling'] == 0)
$form->setChecked();
echo $form;
?> �������� ��� "�������"
<br />

<?php 
$form = new Dune_Form_InputRadio('haggling');
$form->setValue(1);
if ($this->data['haggling'] == 1)
$form->setChecked();
echo $form;
?> �� ��������
<br />
<?php 
$form = new Dune_Form_InputRadio('haggling');
$form->setValue(2);
if ($this->data['haggling'] == 2)
$form->setChecked();
echo $form;
?> ����� ���� �������
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