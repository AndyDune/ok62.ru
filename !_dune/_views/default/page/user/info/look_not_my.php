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
</tr>

<tr>
<td class="prompting">Псевдоним в системе</td>
<td>
<?php echo $this->user->name;?>
</td>
</tr>

<tr>
<td class="prompting">Контактное имя</td>
<td>
<?php echo $this->user->contact_name;?>
</td>
</tr>


<?php
if ($this->user_info_allow->contact_surname_allow)
{
?>
<tr>
<td class="prompting">Ф.И.О.</td>
<td>
<?php echo $this->user->contact_surname;?>
</td>
</tr>
<?php
}
?>

<?php
if ($this->user_info_allow->mail_allow)
{
?>
<tr>
<td class="prompting">e-mail</td>
<td>
<?php echo $this->user->mail;?>
</td>
</tr>
<?php
}
?>


<?php
if ($this->user_info_allow->phone_allow)
{
?>
<tr>
<td class="prompting">Телефон</td>
<td>
<?php echo $this->user->phone;?>
</td>
</tr>
<?php
}
?>

<?php
if ($this->user_info_allow->icq_allow)
{
?>
<tr>
<td class="prompting">Номер ICQ</td>
<td>
<?php echo $this->user->icq;?>
</td>
</tr>
<?php
}
?>

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


<tr>
<td class="prompting">Дата последнего посещения</td>
<td>
<?php echo $this->user->time;?>
</td>
<td>
</td>
</tr>


</table>

<ul>
<li><a href="/user/">Действие</a></li>
</ul>

</div>
</td><!-- Об. конец ячейки с инфой о пользователе -->
<td>
<div id="user-activity-part">
<h1>Активность</h1>
<table>

<tr>
<td class="prompting">Объектов выставлено на продажу</td>
<td>
0
</td>

</tr>
<tr>
<td class="prompting">Объектов отложено</td>
<td>
0
</td>
</tr>


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