<h1 id="h1-for-auth-forms">�����������</h1>
<p id="system-message"><?php echo $this->message;?></p>
<div id="user-enter-form-page">
<p><span><a href="/user/enter/">����</a></span> <span><a href="/user/recall/">�������� ������</a></span></p>
<form action="<?php echo $this->action; ?>" method="post">
<input name="_do_" type="hidden" value="register" />
<dl id="user-logo-dl">
<dt>���</dt>
<dd><input name="login" type="text" value="<?php echo $this->login; ?>" maxlength="50" /></dd>
</dl>
<dl id="user-password-dl">
<dt>����� ����������� �����</dt>
<dd><input name="mail" type="text" value="<?php echo $this->mail; ?>" maxlength="50" /></dd>
</dl>

<dl id="user-captcha-dl">
<dt>������� ��������� ���: <img  src="<?php echo $this->captcha; ?>" /></dt>
<dd><input name="captcha" type="text" value="" maxlength="10" /></dd>
</dl>

<p id="user-enter-page-submit"><input name="go" type="submit" value="������!" /></p>
</form>
</div>