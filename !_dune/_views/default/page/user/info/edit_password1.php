<p id="system-message"><?php echo $this->message;?></p>
<div id="user-enter-form-page">
<form action="/user/changepassword/" method="post">
<input name="_do_" type="hidden" value="save" />
<input name="id" type="hidden" value="<?php echo $this->user_id; ?>" />
<dl id="user-logo-dl">
<dt>������ ������</dt>
<dd><input name="password_old" type="text" value="<?php echo $this->user_password; ?>" size="30" maxlength="30" /></dd>
</dl>
<dl id="user-password-dl">
<dt>����� ������</dt>
<dd><input name="password_new_1" type="password" value="<?php echo $this->user_password_new; ?>" size="30" maxlength="30" /></dd>
</dl>
<dl id="user-password-dl">
<dt>����� ������. ��� ��������.</dt>
<dd><input name="password_new_2" type="password" value="<?php echo $this->code; ?>" size="30" maxlength="30" /></dd>
</dl>

<p id="user-enter-page-submit"><input name="go" type="submit" value="������!" /></p>
</form>
</div>