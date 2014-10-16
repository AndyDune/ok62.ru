<div id="user-enter-form-ajax">
<div id="user-enter-form-common">
<?php if ($this->admin and false) {?>
<p id="p-admin-panel"><a href="/<?php echo $this->admin;?>/">Панель администратора</a></p>
<?php }?>

<p id="p-main-line">
<span if="talk-container">
<?php if ($this->talk) {?>
<a href="/user/message/" id="user-talk" title="Новое сообщение"><img src="<?php echo $this->view_folder;?>/user/nmes.gif" alt="" /></a>
<?php } ?>
</span>

<a id="user-name" href="/user/info/"><?php echo $this->name;?></a>
<a href="/user/enter/exit/">Выход</a>
</p>
</div>
</div>
