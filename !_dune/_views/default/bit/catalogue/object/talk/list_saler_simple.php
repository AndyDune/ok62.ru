<div id="talk-list">
<a href="<?php echo $this->url; ?>">Покупатели</a>
<?php if ($this->count) { ?>
<h2>Общение</h2>
<?php foreach ($this->list as $key => $value)
{
?>
<dl>
<dt>
<ul class="user-info-shot">
<li><a href="/user/info/<?php echo $value['user_id'] ?>/"><?php echo $value['name_user'] ?></a></li>
<li><?php echo substr($value['time'], 0, 16) ?></li>
</ul>
</dt>
<dd><?php echo $value['text'] ?></dd>
</dl>
<?php }?>
<?php } else {?>
<h2 class="h2-message">Нет сообщений</h2>
<?php }?>
</div>