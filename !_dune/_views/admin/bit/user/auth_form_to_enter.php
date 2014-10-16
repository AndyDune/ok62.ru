<div id="user-enter-form-common">
<p><span><a href="/user/registration/">регистрация</a></span> <span><a href="/user/recall/">получить пароль</a></span></p>
<form action="/user/enter/" method="post">
<input name="_do_" type="hidden" value="enter" />
<dl id="user-logo-dl">
<dt>Имя(или e-mail)</dt>
<dd><input name="login" type="text" value="<?php echo $this->login; ?>" size="20" maxlength="20" /></dd>
</dl>
<dl id="user-password-dl">
<dt>Пароль</dt>
<dd><input name="password" type="password" value="" size="10" maxlength="10" /></dd>
</dl>
<input name="go" type="submit" value="Вперед" />
</form>
</div>