<?php switch ($this->message_code) { 
case 51: ?>
<p id="system-message">Заявка удалена.</p>
<?php break; ?> 

<?php case 52: ?>
<p id="system-message">Редактировать нельзя.</p>
<?php break; ?> 

<?php case 53: ?>
<p id="system-message">Редактировать чужое нельзя.</p>
<?php break; ?> 

<?php case 4: ?>
<p id="system-message">Превышен лимит количества заявок.</p>
<?php break; ?> 


<?php case 55: ?>
<p id="system-message">Потеря сеанса.
<?php if ($this->last_edit) { ?>
<br /><br /><span><a href="/public/request/<?php echo $this->last_edit['type_code']?>/?edit=<?php echo $this->last_edit['id']?>">Редактировали последним</a></span>
</p>
<?php }
break; ?> 

<?php case 54: ?>
<p id="system-message">Часто создается заявка.</p>
<?php break; ?> 

<?php } ?>

<div id="form">
<form method="post" action="<?php echo $this->action; ?>">
<input type="hidden" name="edit" value="<?php echo $this->edit; ?>" />
<input type="hidden" name="save" value="save" />
<dl><dt>Заголовок:</dt><dd><input style="width:500px;" name="name" type="text" value="<?php echo $this->data['name']; ?>" /></dd></dl>
<dl><dt>Что бы вы хотели?</dt><dd><ul style="list-style-type:none;">
<li><input type="checkbox" name="sale" value="1"<?php
if ($this->data['sale'])
{
    ?> checked="checked"<?php    
}
?> /> Купить</li>
<li><input type="checkbox" name="rent" value="1"<?php
if ($this->data['rent'])
{
    ?> checked="checked"<?php    
}
?> /> Арендовать</li>
</ul>
</dd></dl>
<dl><dt>За какую стоимость Вы расчитываете приобрести:</dt><dd><input name="price" type="text" value="<?php echo $this->data['price']; ?>" /></dd></dl>
<dl><dt>Описание:</dt><dd>
<textarea name="text"><?php echo $this->data['text']; ?></textarea>
</dd></dl>
<p><input type="submit" name="go" value="Сохранить" /></p>
</form>
