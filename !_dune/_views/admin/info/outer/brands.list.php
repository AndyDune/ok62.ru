<h1>������ ��������������</h1>
<?php
//$test = new Dune_Test_Array($this->array);
//$test->printPre();

if ($this->array_count > 0)
{ // ���� ������� �����. ������.
?><table class="list-table">
<tr>
<th>ID</th>
<th>��������</th>
<th>���</th>
<th>���</th>
</tr>
<?php
foreach ($this->array as $value)
{ 
	?><tr>
	<td class="list-td-id"><?php echo $value['id']?></td>
	<td class="list-td-text-shot"><a href="<?php echo $value['link_list_models']; ?>" title="������ ������� �������������"><?php echo $value['name']?></a></td>
	<td class="list-td-text-mid"><?php echo $value['code']?></td>
	<td class="list-td-text-mid"><?php echo $value['rus']?></td>
	
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


