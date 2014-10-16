<h1>Статистика системы</h1>
<ul class="class-add-links">
<li></li>
</ul>
<hr />
<form method="post">
<input type="hidden" name="_do_" value="get_count_total_in_interval" />
<table>
<tr>

<td>
Всего объектов:
</td>
<td>
От: <input size="10" type="text" name="time_begin" value="<?php echo $this->data['time_begin'] ?>" />
</td>
<td>
До: <input size="10" type="text" name="time_end" value="<?php echo $this->data['time_end'] ?>" />
</td>
<td>
Статус: <input size="3" type="text" name="status" value="<?php echo $this->data['status'] ?>" />
</td>
<td>
Пользователь: <input size="3" type="text" name="user" value="<?php echo $this->data['user'] ?>" />
</td>

<td>
Единство: <input type="checkbox" name="edinstvo" value="1"<?php if ($this->data['edinstvo']) { ?> checked="checked" <?php } ?> />
</td>
<td>
Физ. лицо: <input type="checkbox" name="fiz" value="1"<?php if ($this->data['fiz']) { ?> checked="checked" <?php } ?> />
</td>

<td>
<input type="submit" name="go" value="Пуск!">
</td>

</tr>
</table>
</form>

<?php if ($this->data['count_in_time']) { ?>
<p>
Число: <strong><?php echo $this->data['count_in_time'] ?></strong>
</p>
<?php } ?>

<?php if ($this->data['result_array']) {
    $arr = $this->data['result_array'];
    ?>
    <style type="text/css">
    table tr td
    {
    text-align:center;
    }
    </style>
<table>
<th>
<td>id продавца</td><td>Логин продавца</td><td>Имя продавца</td><td>Объектов</td>
</th>
<?php foreach ($arr as $value) { ?>
<tr>
<td><?php echo $value['id']; ?></td>
<td><?php echo $value['name']; ?></td>
<td><?php echo $value['contact_name']; ?></td>
<td><?php echo $value['count']; ?></td>
</tr>


<?php } ?>
</table>
<?php } ?>
