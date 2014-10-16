<div id="user-info-page">
<!-- Мега бегин -->

<table>
<tr>
<td><!-- Об. начало ячейки с инфой о пользователе -->
<div id="info-part">
<h1>Информация о пользователе «<?php echo $this->user->name;?>»</h1>

<h2>Основная</h2>
<table>

<tr>
<th class="prompting"></th>
<th>
</th>
<th>Показать</th>
</tr>

<tr>
<td class="prompting">Псевдоним в системе</td>
<td>
<?php echo $this->user->name;?>
</td>
<td class="td-shot">-</td>
</tr>

<tr>
<td class="prompting">Контактное имя</td>
<td>
<?php echo $this->user->contact_name;?>
</td>
<td class="td-shot">-</td>
</tr>


<tr>
<td class="prompting">Фамилия</td>
<td>
<?php echo $this->user->contact_surname;?>
</td>
<td class="td-shot">
<?php if ($this->user_info_allow->contact_surname_allow) { ?>ДА<?php } else { ?>НЕТ<?php }
?>
</td>
</tr>

<tr>
<td class="prompting">e-mail</td>
<td>
<?php echo $this->user->mail;?>
</td>
<td class="td-shot">
<?php if ($this->user_info_allow->mail_allow) { ?>ДА<?php } else { ?>НЕТ<?php }
?>
</td>
</tr>


<tr>
<td class="prompting">Телефон</td>
<td>
<?php echo $this->user->phone;?>
</td>
<td class="td-shot">
<?php if ($this->user_info_allow->phone_allow) { ?>ДА<?php } else { ?>НЕТ<?php }
?>
</td>
</tr>


<tr>
<td class="prompting">Номер ICQ</td>
<td>
<?php echo $this->user->icq;?>
</td>
<td class="td-shot">
<?php if ($this->user_info_allow->icq_allow) { ?>ДА<?php } else { ?>НЕТ<?php }
?>
</td>
</tr>

</table>

<h2>Дополнительно</h2>
<table>

<tr>
<th class="prompting"></th>
<th>

</th>
<th></th>
</tr>

<tr>
<td class="prompting">Дата регистрации</td>
<td>
<?php echo $this->user->time;?>
</td>
<td>
</td>
</tr>


</table>

<ul>
<li><a href="/user/edit/">Редактировать</a></li>
<li><a href="/user/changepassword/">Сменить пароль</a></li>
<li><a href="/user/enter/exittotal/">Смена кода доступа</a></li>
</ul>

</div>
</td><!-- Об. конец ячейки с инфой о пользователе -->
<td>
<div id="user-activity-part">
<h1>Активность</h1>
<table>

<?php if ($this->objects_in_busket) {?>
<tr>
<td class="prompting"><a href="/user/basket/">Объектов в корзине</a></td>
<td>
<a href="/user/basket/"><?php echo $this->objects_in_busket; ?></a>
</td>
<?php } ?>

<?php if ($this->objects_in_sale) {?>
<tr>
<td class="prompting"><a href="/user/salelist/">Объектов продается</a></td>
<td>
<a href="/user/salelist/"><?php echo $this->objects_in_sale; ?></a>
</td>
<?php } ?>


</tr>
<tr>
<td class="prompting">Собеседников</td>
<td>
0
</td>
</tr>


</table>


</div>
<td>
</tr></table>
<!-- Мега конец-->
</div>