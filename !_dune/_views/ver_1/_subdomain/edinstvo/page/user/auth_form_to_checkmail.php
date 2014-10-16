<h1 id="h1-for-auth-forms">проверка адреса электронной почты</h1>
<?php switch ($this->message_code) { 
      case 17: ?>
<p id="system-message-good">По указанному при регистрации адресу эл. почты отправлено письмо с секретным кодом.
Необходимо ввести его в соответствующее поле для завершения регистрации.</p>
<?php break;
      default: ?>
       <p id="system-message"><?php echo $this->message;?></p>
 
<?php }  ?>

<div id="user-enter-form-page">
<p><span><a href="/user/registration/">регистрация</a></span> <span><a href="/user/recall/">получить пароль</a></span></p>
<form action="/user/checkmail/" method="post">
<input name="_do_" type="hidden" value="enter" />
<dl id="user-logo-dl">
<dt>E-mail</dt>
<dd><input name="mail" type="text" value="<?php echo $this->mail; ?>" size="50" maxlength="50" /></dd>
</dl>
<dl id="user-password-dl">
<dt>Пароль</dt>
<dd><input name="code" type="text" value="<?php echo $this->code; ?>" size="35" maxlength="35" /></dd>
</dl>
<p id="user-enter-page-submit"><input name="go" type="submit" value="Вперед!" /></p>
</form>
</div>