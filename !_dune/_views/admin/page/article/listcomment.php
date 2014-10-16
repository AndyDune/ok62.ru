<h1>Комментарии.</h1>
<?php
//$test = new Dune_Test_Array($this->array);
//$test->printPre();
?><p><?php
echo $this->crumbs;
?></p><?php
if ($this->data->count() > 0)
{ // Если записей много. Начало.

    if ($this->for_article)
    {
        ?><p><a href="<?php echo $this->url ?>">Показать все</a></p><?php
    }
    
?><table class="list-table">
<tr>
<th>ID</th>
<th>Текст</th>
<th>Автор</th>
<th>Момент внедрения</th>
<th>Активация</th>
<th>Ликвидация</th>
</tr>
<?php
foreach ($this->data as $value)
{ 
	?><tr> 
	<td class="list-td-id"><?php echo $value['id']?></td>
	<td class="list-td-text-shot" style="vertical-align:top;"><pre><?php echo $value['text']?></pre>
	
	<br />
	<p>
	<strong>Для статьи:&nbsp;<a style="display:inline;" href="<?php echo $this->url ?>article_<?php echo $value['text_id']?>/"><?php echo $value['text_name']?></a></strong>
	</p>
	</td>
	<td class="list-td-text-shot">
	
	<?php if ($value['user_id'] > 0) { ?>
	<strong>Зарегистрированный пользователь</strong>
	<br />
	<a href="/user/info/<?php echo $value['ruser_id']?>"><?php echo $value['ruser_name']?> (<?php echo $value['ruser_contact_name']?>)</a>
	<?php } else { ?>
	<strong>Незарегистрированный пользователь</strong>
	<br />
	Имя: <?php echo $value['user_name'] ?>
	<br />
	Мыло: <?php echo $value['user_mail'] ?> 
	<br />
	Сайт: <?php echo $value['user_site'] ?> 
	
	<?php } ?>
	</td>
	
	
	<td class="list-td-text-shot"><span style="white-space:pre;"><?php echo $value['time']?></span></td>
	
	<td class="list-td-text-mid">
	<?php if ($value['activity'] == 0) { ?>
	<a href="?com=activate&id=<?php echo $value['id']?>" style="color:red;">Включить</a>
	<?php } else { ?>
	<a href="?com=deactivate&id=<?php echo $value['id']?>" style="color:green;">Выключить</a>
	<?php } ?>
	</td>	
	<td class="list-td-text-mid"><a href="?com=delete&id=<?php echo $value['id']?>">Удалить</a></td>
	</tr>
	<?php
} ?> </table>
<?php
echo $this->navigator;

} // Если записей много. Конец.
else 
{
	echo '<p id="say-important">Нет комментариев</p>';
}
?>
<!--
<p>
<form method="post">
<input type="hidden" name="com" value="add" />
<input type="submit" name="new" value="Новый раздел" />
</form>
</p>
-->