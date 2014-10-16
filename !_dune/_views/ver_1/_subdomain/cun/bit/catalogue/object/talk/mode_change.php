<div id="talk-mode-change">
<ul>
<?php if ($this->talk_mode == 'private') { ?>
<li><a href="<?php echo $this->url_object->get();?>?talk_mode=public#talk-mode-change" title="Сообщения, доступные для просмотра всем рользователям сайта."><span><em>Коментарии</em></span></a></li>
<li class="current"><p><span><em>Приватное общение с продавцом</em></span></p></li>

<?php } else {?>
<li class="current"><p><span><em>Комментарии</em></span></p></li>
<li><a href="<?php echo $this->url_object->get();?>?talk_mode=private#talk-mode-change" title=""><span><em>Приватное общение с продавцом</em></span></a></li>
<?php }?>
</ul>
</div>