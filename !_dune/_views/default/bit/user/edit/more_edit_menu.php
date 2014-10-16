<div id="user-activity-part"> 
<h1>Для редактирования</h1>
        <table>
        
<?php if ($this->current != 'changepassword') { ?>        
        <tr><td>
        <a href="/user/changepassword/">Смена пароля</a>
        </td></tr>
<?php } else {?>
        <tr><td>
        <span>Смена пароля</span>
        </td></tr>
<?php } ?>


<?php if ($this->current != 'edit') { ?>
        <tr><td>
        <a href="/user/edit/">Информация о пользователе</a>
        </td></tr>
<?php } else {?>
        <tr><td>
        <span>Информация о пользователе</span>
        </td></tr>

<?php } ?>


<?php if ($this->current != 'basket' and $this->have_basket) { ?>
        <tr><td>
        <a href="/user/basket/">Корзина</a>
        </td></tr>
<?php } else {?>
        <tr><td>
        <span>Корзина</span>
        </td></tr>

<?php } ?>

<?php if ($this->current != 'salelist') { ?>
        <tr><td>
        <a href="/user/salelist/">Продажа недвижимости</a>
        </td></tr>
<?php } else {?>
        <tr><td>
        <span>Продажа недвижимости</span>
        </td></tr>
<?php } ?>


        </table>
</div>