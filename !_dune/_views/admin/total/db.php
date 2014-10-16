<h1>Комманды в базу данных</h1>
<ul class="class-add-links">
<li></li>
</ul>
<?php 
if (is_int($this->count))
{
    ?><hr /><p>Затронуто строк: <strong><?php echo $this->count; ?></strong><?php 
if (is_int($this->count_success))
{
    ?> Успешно: <strong><?php echo $this->count_success; ?></strong></p><?php
}
?></p><?php
}
?>
<hr />
<table>


<tr>
<form method="post">
<input type="hidden" name="_do_" value="reset_have_situa_zero" />

<td>
Сброс флага отсутствия ситауционного плана:
</td>
<td>
<input type="submit" name="go" value="Пуск!">
</td>
<td>
&nbsp;
</td>

</form>
</tr>


<tr>
<form method="post">
<input type="hidden" name="_do_" value="object_remont" />

<td>
Ремонт данных объекта :
<input type="text" name="id" value="" size="5" />
</td>
<td>
<input type="submit" name="go" value="Пуск!">
</td>
<td>
&nbsp;
</td>

</form>
</tr>



<tr>
<form method="post">
<input type="hidden" name="_do_" value="reset_district_plus" />
<td>
Сброс неустановленных районов:
</td>
<td>
<input type="submit" name="go" value="Пуск!">
</td>
<td>
&nbsp;
</td>

</form>
</tr>


<tr>
<form method="post">
<input type="hidden" name="_do_" value="set_district_plus" />

<td>
Определение района для объекта по координатам:
</td>
<td>
<input type="submit" name="go" value="Пуск!">
</td>

<td>
 Проверить записей: 
<input type="text" name="limit" value="50" size="3" />
Начиная с: 
<input type="text" name="shift" value="0" size="3" />

</td>
</form>
</tr>




<tr>
<form method="post">
<input type="hidden" name="_do_" value="sub_house_to_edit" />

<td>
Установить флаг расчета статистики у дома:
</td>
<td>
<input type="submit" name="go" value="Пуск!">
</td>
<td>
&nbsp;
</td>

</form>
</tr>






</table>

