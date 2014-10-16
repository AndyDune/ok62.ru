<div id="object-under-bookmark">
<div id="object-info">
<div id="interlocutor-list">
<?php if ($this->count) { ?>
<h2>Приватное общение с пользователями.</h2>
<?php foreach ($this->list as $key => $value)
{
?>
<ul class="user-info-shot">
<li><a href="<?php echo $this->url; ?>?user=<?php echo $value['id'] ?>"><?php echo $value['name'] ?><?php 
if (!$value['talk_read'])
{
    ?>(Непрочитанное сообщение)<?php
}
?></a></li>
</ul>
<?php }?>
<?php } else {?>
<h2 class="h2-message">Нет сообщений</h2>
<?php }?>
</div>


</div>
<div class="ugol-left-top"></div>
<div class="ugol-left-bottom"></div>
<div class="ugol-right-top"></div>
<div class="ugol-right-bottom"></div>


</div>