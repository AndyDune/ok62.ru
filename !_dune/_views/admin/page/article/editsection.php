<h1>�������������� �������.</h1>
<?php
//$test = new Dune_Test_Array($this->array);
//$test->printPre();

?>
<p><a href="<?php echo $this->url_parent ?>sections/">������ ��������</a></p>
<form method="post">
<table class="list-table">
<tr>
	<td class="list-td-id">���</td>
	<td class="list-td-text-shot"><input type="text" name="name" size="50" value="<?php echo $this->data->name; ?>" /></td>
</tr>

</table>
<input type="hidden" name="com" value="save" />
<input type="hidden" name="id" value="<?php echo $this->data->id; ?>" />
<p>
<input type="submit" name="go" value="���������" />
</p>
</form>
