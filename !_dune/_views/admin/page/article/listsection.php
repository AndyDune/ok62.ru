<h1>������� ������.</h1>
<?php
//$test = new Dune_Test_Array($this->array);
//$test->printPre();

if ($this->data->count() > 0)
{ // ���� ������� �����. ������.
?><table class="list-table">
<tr>
<th>ID</th>
<th>��������</th>
<th>��������</th>
</tr>
<?php
foreach ($this->data as $value)
{ 
	?><tr>
	<td class="list-td-id"><?php echo $value['id']?></td>
	<td class="list-td-text-shot"><a href="?com=edit&id=<?php echo $value['id']?>"><?php echo $value['name']?></a></td>
	
	<td class="list-td-text-mid"><a href="?com=delete&id=<?php echo $value['id']?>">�������</a></td>
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
<p>
<form method="post">
<input type="hidden" name="com" value="add" />
<input type="submit" name="new" value="����� ������" />
</form>
</p>