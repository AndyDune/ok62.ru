<h1>�������� � �������</h1>
<?php
//$test = new Dune_Test_Array($this->array);
//$test->printPre();

if ($this->data->count() > 0)
{ // ���� ������� �����. ������.
?><table class="list-table">
<tr>
<th>ID</th>
<th>��������</th>
<th>����� ����� ��������</th>
<th>����� �������� ��������</th>
<th>��������</th>
</tr>
<?php
foreach ($this->data as $value)
{ 
	?><tr>
	<td class="list-td-id"><?php echo $value['id']?></td>
	<td class="list-td-text-shot"><a href="<?php echo $this->link_next_list;?>/<?php echo $value['id']?>/" title="������ ������� �������"><?php echo $value['name']?></a></td>
	<td class="list-td-id"><?php echo $value['count_total']?></td>
	<td class="list-td-id"><?php echo $value['count_active']?></td>
	<td class="list-td-text-mid"><a href="#">��������������</a></td>
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
