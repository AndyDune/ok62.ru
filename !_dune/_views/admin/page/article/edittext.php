<h1>�������������� ������.</h1>
<?php
//$test = new Dune_Test_Array($this->array);
//$test->printPre();

?>
<p><a href="<?php echo $this->url_parent ?>texts/">������ ������</a></p>

<?php
if ($this->parent->id)
{
    ?><p><a href="<?php echo $this->url_parent ?>texts/parent_<?php echo $this->parent->id; ?>/">������ ������ ��������</a></p><?php
    ?><p>������������ ������: <a href="?id=<?php echo $this->parent->id; ?>"><?php echo $this->parent->name; ?></a></p><?php
}
?>
<form method="post">
<p>
<input type="submit" name="go" value="���������" />
</p>
<input type="checkbox" name="quote" value="1" /> ������� � �������
<table class="list-table">
<tr>
	<td class="list-td-id">���</td>
	<td class="list-td-text-shot"><input type="text" name="name" style="width:99%;" value="<?php echo $this->data->name; ?>" /></td>
</tr><tr>
	<td class="list-td-id">��������</td>
	<td class="list-td-text-shot"><input type="text" name="parent" style="width:99%;" value="<?php echo $this->data->parent; ?>" /></td>
</tr><tr>

	<td class="list-td-id">������� �����</td>
	<td class="list-td-text-shot"><input type="text" name="name_code" style="width:99%;" value="<?php echo $this->data->name_code; ?>" />
	<em>������������ � �������� ����. ������ ���������� ������� � ������� ������������ ����.</em>
	</td>
</tr><tr>
	<td class="list-td-id">������</td>
	<td class="list-td-text-shot"><input type="text" name="name_crumb" style="width:99%;" value="<?php echo $this->data->name_crumb; ?>" />
	<em>�������� ������ � ������� �������</em>
	</td>
</tr><tr>

	<td class="list-td-id" style="vertical-align:top;">��������</td>
	<td class="list-td-text-shot"><textarea name="annotation" rows="3" style="width:99%;"><?php echo $this->data->annotation; ?></textarea></td>
</tr><tr>
	<td class="list-td-id">title</td>
	<td class="list-td-text-shot"><input type="text" name="title" style="width:99%;" value="<?php echo $this->data->title; ?>" /></td>
	
</tr><tr>	
	<td class="list-td-id" style="vertical-align:top;">description</td>
	<td class="list-td-text-shot"><textarea name="description" rows="2" style="width:99%;"><?php echo $this->data->description; ?></textarea></td>	
</tr><tr>	
	<td class="list-td-id" style="vertical-align:top;">keywords</td>
	<td class="list-td-text-shot"><input type="text" name="keywords" style="width:99%;" value="<?php echo $this->data->keywords; ?>" /></td>
</tr><tr>	
	<td class="list-td-id" style="vertical-align:top;">�����</td>
	<td class="list-td-text-shot"><textarea name="text" rows="20" style="width:99%;"><?php echo $this->data->text; ?></textarea></td>

	
</tr><tr>	
	<td class="list-td-id" style="vertical-align:top;">���������</td>
	<td class="list-td-text-shot">
	<?php
	if ($this->data->can_comment)
	    $checked = ' checked="checked"';
	else 
	    $checked = '';
	?>
	<input type="checkbox" name="can_comment" value="1"<?php echo $checked; ?> /> ��������� �����������
	<br />
	<?php
	if ($this->data->activity)
	    $checked = ' checked="checked"';
	else 
	    $checked = '';
	?>
	<input type="checkbox" name="activity" value="1"<?php echo $checked; ?> /> ����������
	
	</td>
	
	
</tr><tr>	
	<td class="list-td-id" style="vertical-align:top;">������</td>
	<td class="list-td-text-shot"><input type="text" name="script" style="width:99%;" value="<?php echo $this->data->script; ?>" /></td>
	
</tr><tr>	
	<td class="list-td-id" style="vertical-align:top;">� ��������</td>
	<td class="list-td-text-shot">
	
	</td>
	
</tr>

</table>
<input type="hidden" name="com" value="save" />
<input type="hidden" name="id" value="<?php echo $this->data->id; ?>" />
<p>
<input type="submit" name="go" value="���������" />
</p>
</form>
