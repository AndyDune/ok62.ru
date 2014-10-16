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

<!--
<dl>
<dt>Вы хотите продать:</dt>
<dd>
<ul>
<li><a href="/public/sell/room/">Квартиру</a></li>
<li><a href="/public/sell/garage/">Гараж</a></li>
<li><a href="/public/sell/nolife/">Нежилое помещение</a></li>
</ul>
</dd>
</dl>
-->

<dl id="dl-want-to-sell">
<dt>Создать заявку на покупку:</dt>
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
<input type="submit" name="go" value="Нежилого помещения" />
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
