<div id="more_edit_menu">        
<div>
<table>
        
<?php if ($this->code != 'changepassword'
          and 
          $this->code != 'edit'
          and 
          $this->code != 'info'
            ) { ?>        
        <tr><td>
        <a href="/user/info/">Персональная информация</a>
        </td></tr>
<?php } else {?>
        <tr><td>
        <a href="/user/info/" class="current">Персональная информация</a>
        </td></tr>
<?php } ?>


<?php if (false) 
{ ?>
<?php if ($this->current != 'basket' and $this->have_basket) { ?>
        <tr><td>
        <a href="/user/basket/">Корзина</a>
        </td></tr>
<?php } else {?>
        <tr><td>
        <span>Корзина</span>
        </td></tr>
<?php } ?>
<?php } ?>

<?php if ($this->code != 'sell') { ?>
        <tr><td>
        
        <a href="/user/sell/<?php
        
if ($this->code == 'tosell')
{
    ?>request/<?php
}

        
        ?>">Мои объекты</a>
        </td></tr>
<?php } else {?>
        <tr><td>
        <a href="/user/sell/" class="current">Мои объекты</a>
        </td></tr>

<?php } ?>


	
<?php if ($this->code != 'tosell') { ?>
        <tr><td>
        <a href="/public/sell/">Разместить объявление</a>
        </td></tr>
<?php } else {?>
        <tr><td>
        <a href="/public/sell/" class="current">Разместить объявление</a>
        </td></tr>
<?php } ?>



<?php if ($this->code != 'request_info') { ?>
        <tr><td>
        <a href="/user/request/">Мои заявки</a>
        </td></tr>
<?php } else {?>
        <tr><td>
        <a href="/user/request/" class="current">Мои заявки</a>
        </td></tr>
<?php } ?>

<?php if ($this->code != 'request') { ?>
        <tr><td>
        <a href="/public/request/">Разместить заявку</a>
        </td></tr>
<?php } else {?>
        <tr><td>
        <a href="/public/request/" class="current">Разместить заявку</a>
        </td></tr>
<?php } ?>


<?php if ($this->code != 'contact') { ?>
        <tr><td>
        <a href="/user/list/">Пользователи</a>
        </td></tr>
<?php } else {?>
        <tr><td>
        <a href="/user/list/" class="current">Пользователи</a>
        </td></tr>
<?php } ?>


<?php
if ($this->code != 'message') { ?>
        <tr><td>
        <a href="/user/message/">Все сообщения</a>
        </td></tr>
<?php } else {?>
        <tr><td>
        <a href="/user/message/" class="current">Все сообщения</a>
        </td></tr>
<?php } ?>

<?php
if ($this->user_status > 499) { 
if ($this->code != 'nearby') { ?>
        <tr><td>
        <a href="/user/nearby/">Конкуренты</a>
        </td></tr>
<?php } else {?>
        <tr><td>
        <a href="/user/nearby/" class="current">Конкуренты</a>
        </td></tr>
<?php } } ?>



<?php if (false) { ?>
	
<?php if ($this->code != 'salelist') { ?>
        <tr><td>
        <a href="/user/salelist/">Продажа недвижимости</a>
        </td></tr>
<?php } else {?>
        <tr><td>
        <span>Продажа недвижимости</span>
        </td></tr>
<?php } ?>

<?php } ?>
        </table>
</div>
<div class="ugol-left-top"></div>
<div class="ugol-left-bottom"></div>
<div class="ugol-right-top"></div>
<div class="ugol-right-bottom"></div>
</div>