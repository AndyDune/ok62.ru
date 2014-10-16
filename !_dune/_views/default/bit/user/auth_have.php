<div id="user-enter-form-common">
<p>Пользователь: <a href="/user/info/"><?php echo $this->name;?></a></p>
<?php if ($this->admin) {?>
<p><a href="/<?php echo $this->admin;?>/">Панель администратора</a>
<?php }?>

<p><a href="/user/enter/exit/">Выйти</a>
</div>