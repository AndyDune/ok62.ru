<h1>���������� ������� ��������� �������.</h1>
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


</table>
</div>

<div id="add-object-info-part">

<table class="list-table-js">

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