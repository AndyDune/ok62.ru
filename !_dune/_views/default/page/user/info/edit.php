<div id="user-info-page">
<!-- ���� ����� -->
<form method="post">
<input type="hidden" name="_do_" value="save" />
<input type="hidden" name="id" value="<?php echo $this->user->id;?>" />
<table>
<tr>
<td><!-- ��. ������ ������ � ����� � ������������ -->
<div id="info-part">
<h1>�������������� ���������� ������������ <a href="/user/info/">�<?php echo $this->user->name;?>�</a></h1>

<h2>��������</h2>
<table>

<tr>
<th class="prompting"></th>
<th>
</th>
<th>��������</th>
</tr>

<tr>
<td class="prompting">��������� � �������</td>
<td>
<?php echo $this->user->name;?>
</td>
<td class="td-shot">-</td>
</tr>

<tr>
<td class="prompting">���������� ���</td>
<td>
<input name="contact_name" type="text" value="<?php echo $this->user->contact_name?>" />
</td>
<td class="td-shot">-</td>
</tr>


<tr>
<td class="prompting">������ ��� (���)</td>
<td>
<input name="contact_surname" type="text" value="<?php echo $this->user->contact_surname?>" />
</td>
<td class="td-shot">
<input type="checkbox" name="contact_surname_allow" value="1"
<?php if ($this->user_info_allow->contact_surname_allow) { ?> checked="checked"<?php } 
?> /> 
</td>
</tr>

<tr>
<td class="prompting">e-mail</td>
<td>
<?php echo $this->user->mail?>
</td>
<td class="td-shot">
<input type="checkbox" name="mail_allow" value="1"
<?php if ($this->user_info_allow->mail_allow) { ?> checked="checked"<?php } 
?> /> 

</td>
</tr>

<tr>
<td class="prompting">�������</td>
<td>
<input name="phone" type="text" value="<?php echo $this->user->phone?>" />
</td>
<td class="td-shot">
<input type="checkbox" name="phone_allow" value="1"
<?php if ($this->user_info_allow->phone_allow) { ?> checked="checked"<?php } 
?> /> 
</td>
</tr>

<tr>
<td class="prompting">����� ICQ</td>
<td>
<input name="icq" type="text" value="<?php echo $this->user->icq?>" />
</td>
<td class="td-shot">
<input type="checkbox" name="icq_allow" value="1"
<?php if ($this->user_info_allow->icq_allow) { ?> checked="checked"<?php } 
?> /> 


</td>
</tr>

</table>
<input type="submit" name="save" value="���������" />
</form>

</div>
</td><!-- ��. ����� ������ � ����� � ������������ -->


<td>

<!-- ��� ��� �������������  -->
<?php echo $this->more_edit_menu;?>

<!-- /��� ��� �������������  -->


<td>
</tr></table>
<!-- ���� �����-->
</div>