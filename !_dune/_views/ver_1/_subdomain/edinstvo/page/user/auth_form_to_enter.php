<h1 id="h1-for-auth-forms">���� �� ����</h1>
<p id="system-message"><?php echo $this->message;?></p>
<div id="user-enter-form-page">
<p><span><a href="/user/registration/">�����������</a></span> <span><a href="/user/recall/">�������� ������</a></span></p>
<form action="/user/enter/" method="post">
<input name="_do_" type="hidden" value="enter" />
<dl id="user-logo-dl">
<dt>���(��� e-mail)</dt>
<dd><input name="login" type="text" value="<?php echo $this->login; ?>" size="50" maxlength="50" /></dd>
</dl>
<dl id="user-password-dl">
<dt>������</dt>
<dd><input name="password" type="password" value="" size="30" maxlength="30" /></dd>
</dl>
<p id="user-enter-page-submit"><input name="go" type="submit" value="������!" /></p>
</form>
</div>