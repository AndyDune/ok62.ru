<?php switch ($this->message_code) { 
case 51: ?>
<p id="system-message">Объект уделен. Возможно прошло более недели с момента начала ввода.</p>
<?php break; ?> 

<?php case 52: ?>
<p id="system-message">Редактировать нельзя.</p>
<?php break; ?> 

<?php case 55: ?>
<p id="system-message">Потеря сеанса.
<?php if ($this->last_edit) { ?>
<br /><br /><span><a href="/public/sell/<?php echo $this->last_edit['type_code']?>/">Редактировали последним</a></span>
</p>
<?php
}
break; ?> 

<?php case 54: ?>
<p id="system-message">Часто создается объект на редактирование.</p>
<?php break; ?> 

<?php case 56: ?>
<p id="system-message">Объект удален.</p>
<?php break; ?> 


<?php } ?>

<?php if ($this->last_edit) { ?>
<div id="div-sell-no-auth-have-edit">
<p>Вы начали вносить в очередь на добавление в каталог 
<?php
switch ($this->last_edit['type_code'])
{
    case 'room':
        ?> квартиру<?php
    break;
    case 'garage':
        ?> гараж<?php
    break;
    case 'nolife':
        ?> нежилое помещение<?php
    break;
}
?>
</p>
<dl>
<dt>Вы можете:</dt>
<dd>
<ul>
<li><a href="/public/sell/<?php echo $this->last_edit['type_code']?>/">Продолжить редактирование</a></li>
<li><a href="/public/sell/do/delete/">Удалить внесенную информацию и начать сначала</a></li>
</ul>
</dd>
</dl>
</div>
<?php
} else {
?>

<dl id="dl-want-to-sell">
<dt>Создать заявку на размещение в каталоге:</dt>
<dd>
<ul>
<li>
<form method="post">
<input type="hidden" name="new" value="room" />
<input type="submit" name="go" value="Квартиры" />
</form>
</li>

<li>
<form method="post">
<input type="hidden" name="new" value="nolife" />
<input type="submit" name="go" value="Коммерческой недвижимости" />
</form>
</li>

<li>
<form method="post">
<input type="hidden" name="new" value="garage" />
<input type="submit" name="go" value="Гаража" />
</form>
</li>

</ul>
</dd>
</dl>

<?php } ?>