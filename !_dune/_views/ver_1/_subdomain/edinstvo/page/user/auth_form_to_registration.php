<h1 id="h1-for-auth-forms">регистрация</h1>
<p id="system-message"><?php echo $this->message;?></p>
<div id="user-enter-form-page">
<p><span><a href="/user/enter/">вход</a></span> <span><a href="/user/recall/">получить пароль</a></span></p>
<form action="<?php echo $this->action; ?>" method="post">
<input name="_do_" type="hidden" value="register" />
<dl id="user-logo-dl">
<dt>Имя</dt>
<dd><input name="login" type="text" value="<?php echo $this->login; ?>" maxlength="50" /></dd>
</dl>
<dl id="user-password-dl">
<dt>Адрес электронной почты</dt>
<dd><input name="mail" type="text" value="<?php echo $this->mail; ?>" maxlength="50" /></dd>
</dl>

<dl id="user-captcha-dl">
<dt>Введите секретный код: <img  src="<?php echo $this->captcha; ?>" /></dt>
<dd><input name="captcha" type="text" value="" maxlength="10" /></dd>
</dl>

<p id="user-enter-page-submit"><input name="go" type="submit" value="Вперед!" /></p>
</form>
</div>