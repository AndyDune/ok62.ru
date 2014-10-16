<div id="talk-mode-change">
<ul>
<?php if ($this->talk_mode == 'private') { ?>
<li><a href="<?php echo $this->url_object->get();?>?talk_mode=public" title="Сообщения, доступные для просмотра всем рользователям сайта.">Публичное общение</a></li>
<li><span>Приватное общение</span></li>

<?php } else {?>
<li><span>Публичное общение</span></li>
<li><a href="<?php echo $this->url_object->get();?>?talk_mode=private" title="">Приватное общение</a></li>
<?php }?>
</ul>
</div>