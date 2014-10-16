<div id="talk-form">
<h2>Оставить сообщение</h2>
<p>Собщение будет сохранено сразу после проверки адреса электронной почты</p>
<?php if ($this->message) { ?>
<p id="system-message"><?php echo $this->message;?></p>
<?php } ?>
<form action="<?php echo $this->action;?>" method="post">
<input type="hidden" name="object_id" value="<?php echo $this->object_id?>" />
<input type="hidden" name="back_anchor" value="#talk-form" />
<input type="hidden" name="interlocutor" value="<?php echo $this->interlocutor?>" />
<input type="hidden" name="what_comment" value="<?php echo $this->what_comment?>" />
<textarea name="text" id="textarea-text"><?php echo $this->text; ?></textarea>

<dl class="talk-auth-form-field">
<dt>Имя:</dt>
<dd class="dd-first">
<input type="text" name="login" value="<?php echo $this->login?>" />
</dd>
</dl>

<dl class="talk-auth-form-field">
<dt>Почта:</dt>
<dd class="dd-first">
<input type="text" name="mail" value="<?php echo $this->mail?>" />
</dd>
</dl>

<dl class="talk-auth-form-field">
<dt>Введите секретный код: </dt>
<dd class="dd-first"><input name="captcha" type="text" value="" maxlength="10" /></dd>
<dd class="dd-second"><img  src="<?php echo $this->captcha; ?>" /></dd>
</dl>

<p><input id="buttom-submit" type="submit" name="go" value="Сохранить" /></p>
</form>
<div class="ugol-left-top"></div>
<div class="ugol-left-bottom"></div>
<div class="ugol-right-top"></div>
<div class="ugol-right-bottom"></div>

</div>