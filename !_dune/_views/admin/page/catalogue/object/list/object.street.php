<h1>������ ��������.</h1>
<?php
//$test = new Dune_Test_Array($this->array);
//$test->printPre();

if ($this->data->count() > 0)
{ // ���� ������� �����. ������.
?><table class="list-table">
<tr>
<th>ID</th>
<th>������</th>
<th>�����</th>
<th>���</th>
<th>��������</th>
</tr>
<?php
foreach ($this->data as $value)
{ 
	?><tr>
	<td class="list-td-id"><?php echo $value['id']?></td>
	<td class="list-td-text-mid"><a href="<?php
	   echo $this->link_edit;
	?>/<?php echo $value['id']?>/" title="�������������"><?php echo $value['name_type']?></a></td>
	
	<td class="list-td-text-shot">
	<?php echo $value['name_region']?>,
	<?php echo $value['name_area']?>,
	<?php if ($value['settlement_id'] and $value['type_settlement'] < 100)  { ?>
	<?php echo $value['name_settlement']?>,
	<?php } else { ?>
	<?php echo $value['settlement_name']?>,
	<?php } ?>
	<?php if ($value['street_id']) { ?>
	 ����� <?php echo $value['name_street'];?>
	<?php } else
	{
	       echo $value['street_name'];
	} ?>
	 
	, ��� <?php echo $value['house_number'];

	if ($value['building_number']) { 
	?>, ������ <?php echo $value['building_number']; }?>
	
	<?php if ($value['room'])
	 {
	    if ($value['type'] == 1) {
	 ?>, �������� <?php
        } else {
            ?>, ����� <?php
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
	?>/<?php echo $value['id']?>/">�������������.</a></td>
	</tr>
	<?php
} ?> </table>
<?php
} // ���� ������� �����. �����.
else 
{
	echo '<p id="say-important">������ ����</p>';
}
?>

<dl>
<dt>�� �������� ������ ��������:<dt>
<ul>
<?php foreach ($this->types as $value) { ?>
<li><a href="<?php echo $this->link_add;?>-type-<?php echo $value['code']?>/"><?php echo $value['name']?></a></li>
<?php } ?>
</ul>

