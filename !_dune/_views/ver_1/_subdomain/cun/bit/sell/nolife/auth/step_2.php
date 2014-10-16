<h1>Заявка на размещение коммерческой недвижимости в каталоге</h1>

<?php
//echo $this->steps_panel;
?>

<?php switch ($this->message_code) { 
case 1: ?>
<p id="system-message">Не заполнены обязательные поля.</p>
<?php break; ?> 

<?php case 2: ?>
<p id="system-message">Запрещено слишком часто отправлять пакеты.</p>
<?php break; ?> 

<?php case 3: ?>
<p id="system-message">Потеря сеанса.</p>
<?php break; ?> 

<?php case 4: ?>
<p id="system-message">Вы достигли лимита колличества объектов отправленных на обработку модератору. Ждите, мы с Вами свяжемся.</p>
<?php break; ?> 

<?php } 

echo $this->steps_panel;
?>

<div id="object-under-bookmark">
<div id="object-sell">


<?php if (count($this->array_photo)) { ?>
<dl>
<dt>Загруженные фотографии объекта</dt>
<dd><div class="pictures-float-list">
<?php foreach ($this->array_photo as $key => $value) {?>
<div>
<a href="<?php echo $value[1]; ?>" class="thickbox" ><img src="<?php echo $value[2]; ?>" /></a>
<p><a href="<?php echo $this->url; ?>?delete=yes&name=<?php echo $value[0]; ?>">Удалить</a></p>
</div>
<?php } ?>
</div></dd>
</dl>
<?php } ?>




<form method="post" enctype="multipart/form-data">

<?php if ($this->count_images_to_load) { ?>
<div class="form-part">
<dl>
<dt>Загрузить фотографии объекта</dt>
<dd><ul>
<?php for ($x=0; $x < $this->count_images_to_load; $x++) { ?>
<li><input type="file" name="photo[]" /></li>
<?php } ?>
</ul></dd>
</dl>
</div>
<?php } ?>


<input name="_do_" type="hidden" value="save" />
<input name="id" type="hidden" value="<?php echo $this->id; ?>" />
<p class="submit-tipa-big">
<input name="go" type="submit" value="Сохранить" />
</p>
</form>
</div>

<div class="ugol-left-top"></div>
<div class="ugol-left-bottom"></div>
<div class="ugol-right-top"></div>
<div class="ugol-right-bottom"></div>

</div>
