<div id="user-info-page">
<!-- Мега бегин -->
<table>

<tr>
<th class="object-prompting"></th>
<th>
Значение
</th>
</th>
<th>Показать</th>
</tr>



<tr>
<td class="object-prompting">Логин</td>
<td>
<?php echo $this->user->name;?>
</td>
<td>-</td>
</tr>

<tr>
<td class="object-prompting">Контактное имя</td>
<td>
<?php echo $this->user->contact_name;?>
</td>
<td>-</td>
</tr>


<tr>
<td class="object-prompting">Фамилия</td>
<td>
<?php echo $this->user->contact_surname;?>
</td>
<td>

<input type="checkbox" name="contact_surname_allow" checked="checked" /> 
</td>
</tr>



</table>

<!-- Мега конец-->
</div>