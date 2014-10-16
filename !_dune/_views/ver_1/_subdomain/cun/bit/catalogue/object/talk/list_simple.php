<div id="talk-list"><div style="position:relative; width:100%;">&nbsp;
<?php if ($this->count) { ?>
<h2></h2>
<?php foreach ($this->list as $key => $value)
{
?>
<dl id="mes_<?php echo $value['id']?>">
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
<div class="ugol-left-top"></div>
<div class="ugol-left-bottom"></div>
<div class="ugol-right-top"></div>
<div class="ugol-right-bottom"></div>

</div></div>