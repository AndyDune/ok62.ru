<div id="talk-form">
<h2>Оставить сообщение</h2>
<form action="<?php echo $this->action;?>" method="post">
<input type="hidden" name="object_id" value="<?php echo $this->object_id?>" />
<input type="hidden" name="interlocutor" value="<?php echo $this->interlocutor?>" />
<input type="hidden" name="what_comment" value="<?php echo $this->what_comment?>" />
<textarea name="text" id="textarea-text"><?php echo $this->text; ?></textarea>
<p><input id="buttom-submit" type="submit" name="go" value="Сохранить" /></p>
</form>
<div class="ugol-left-top"></div>
<div class="ugol-left-bottom"></div>
<div class="ugol-right-top"></div>
<div class="ugol-right-bottom"></div>

</div>