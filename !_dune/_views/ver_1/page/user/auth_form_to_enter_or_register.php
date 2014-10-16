<h1 id="h1-for-auth-forms">авторизуйтесь для продолжения</h1>
<?php switch ($this->message_code) { 
case 1: ?>
<p id="system-message">Продолжение возможно после регистрации на сайте или входа.</p>
<?php break; ?> 

<?php case 1000: ?>
<p id="system-message"></p>
<?php break; ?> 

<?php } ?>

<div id="user-enter-form-page">



<div id="user-auth-2">

<div id="user-auth-2-1"><div class="user-auth-2-conteainer">

<form action="/user/enter/" method="post">
<input name="_do_" type="hidden" value="enter" />
<dl id="user-logo-dl">
<dt>Имя(или e-mail)</dt>
<dd><input name="login" type="text" value="<?php echo $this->login; ?>" size="50" maxlength="50" /></dd>
</dl>
<dl id="user-password-dl">
<dt>Пароль</dt>
<dd><input name="password" type="password" value="" size="30" maxlength="30" /></dd>
</dl>
<p id="user-enter-page-submit"><input name="go" type="submit" value="Вперед!" /></p>
</form>

</div></div>
<div id="user-auth-2-2"><div class="user-auth-2-conteainer">


<form action="/user/registration/" method="post">
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

</div></div>


</div>


</div>