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

<p id="system-message"><?php echo $this->message;?></p>
<table>

<tr>
<th class="prompting"></th>
<th>
</th>


<tr>
<td class="prompting">������ ������</td>
<td>
<input name="password_old" type="text" value="<?php echo $this->user_password; ?>" size="30" maxlength="30" />
</td>
</tr>

<tr>
<td class="prompting">����� ������</td>
<td>
<input name="password_new_1" type="password" value="<?php echo $this->user_password_new; ?>" size="30" maxlength="30" />
</td>
</tr>

<tr>
<td class="prompting">����� ������. ������.</td>
<td>
<input name="password_new_2" type="password" value="<?php echo $this->code; ?>" size="30" maxlength="30" />
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