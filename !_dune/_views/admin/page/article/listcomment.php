<h1>�����������.</h1>
<?php
//$test = new Dune_Test_Array($this->array);
//$test->printPre();
?><p><?php
echo $this->crumbs;
?></p><?php
if ($this->data->count() > 0)
{ // ���� ������� �����. ������.

    if ($this->for_article)
    {
        ?><p><a href="<?php echo $this->url ?>">�������� ���</a></p><?php
    }
    
?><table class="list-table">
<tr>
<th>ID</th>
<th>�����</th>
<th>�����</th>
<th>������ ���������</th>
<th>���������</th>
<th>����������</th>
</tr>
<?php
foreach ($this->data as $value)
{ 
	?><tr> 
	<td class="list-td-id"><?php echo $value['id']?></td>
	<td class="list-td-text-shot" style="vertical-align:top;"><pre><?php echo $value['text']?></pre>
	
	<br />
	<p>
	<strong>��� ������:&nbsp;<a style="display:inline;" href="<?php echo $this->url ?>article_<?php echo $value['text_id']?>/"><?php echo $value['text_name']?></a></strong>
	</p>
	</td>
	<td class="list-td-text-shot">
	
	<?php if ($value['user_id'] > 0) { ?>
	<strong>������������������ ������������</strong>
	<br />
	<a href="/user/info/<?php echo $value['ruser_id']?>"><?php echo $value['ruser_name']?> (<?php echo $value['ruser_contact_name']?>)</a>
	<?php } else { ?>
	<strong>�������������������� ������������</strong>
	<br />
	���: <?php echo $value['user_name'] ?>
	<br />
	����: <?php echo $value['user_mail'] ?> 
	<br />
	����: <?php echo $value['user_site'] ?> 
	
	<?php } ?>
	</td>
	
	
	<td class="list-td-text-shot"><span style="white-space:pre;"><?php echo $value['time']?></span></td>
	
	<td class="list-td-text-mid">
	<?php if ($value['activity'] == 0) { ?>
	<a href="?com=activate&id=<?php echo $value['id']?>" style="color:red;">��������</a>
	<?php } else { ?>
	<a href="?com=deactivate&id=<?php echo $value['id']?>" style="color:green;">���������</a>
	<?php } ?>
	</td>	
	<td class="list-td-text-mid"><a href="?com=delete&id=<?php echo $value['id']?>">�������</a></td>
	</tr>
	<?php
} ?> </table>
<?php
echo $this->navigator;

} // ���� ������� �����. �����.
else 
{
	echo '<p id="say-important">��� ������������</p>';
}
?>
<!--
<p>
<form method="post">
<input type="hidden" name="com" value="add" />
<input type="submit" name="new" value="����� ������" />
</form>
</p>
-->