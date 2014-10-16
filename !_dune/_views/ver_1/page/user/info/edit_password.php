<!-- Мега бегин -->
<form method="post">
<input type="hidden" name="_do_" value="save" />
<input type="hidden" name="id" value="<?php echo $this->user->id;?>" />
<div id="info-part">

<p id="system-message"><?php echo $this->message;?></p>
<table>

<tr>
<th class="prompting"></th>
<th>
</th>


<tr>
<td class="prompting">Старый пароль</td>
<td>
<input name="password_old" type="text" value="<?php echo $this->user_password; ?>" size="30" maxlength="30" />
</td>
</tr>

<tr>
<td class="prompting">Новый пароль</td>
<td>
<input name="password_new_1" type="password" value="<?php echo $this->user_password_new; ?>" size="30" maxlength="30" />
</td>
</tr>

<tr>
<td class="prompting">Новый пароль. Еще раз.</td>
<td>
<input name="password_new_2" type="password" value="<?php echo $this->user_password_new_2; ?>" size="30" maxlength="30" />
</td>
</tr>



</table>
<input type="submit" name="save" value="Сохранить" />
</form>

</div>
