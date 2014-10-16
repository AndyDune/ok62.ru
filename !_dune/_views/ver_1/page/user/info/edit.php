<form method="post" enctype="multipart/form-data">
<input type="hidden" name="_do_" value="save" />
<input type="hidden" name="id" value="<?php echo $this->user->id;?>" />
<div id="info-part">

<h3>Основная</h3>
<table>

<tr>
<th class="prompting"></th>
<th>
</th>
<th>Отображать<br /> на сайте</th>
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
<input name="contact_name" type="text" value="<?php echo $this->user->contact_name?>" />
</td>
<td class="td-shot">-</td>
</tr>

<?php if (false) { ?> 
<tr>
<td class="prompting">Полное имя (ФИО)</td>
<td>
<input name="contact_surname" type="text" value="<?php echo $this->user->contact_surname?>" />
</td>
<td class="td-shot">
<input type="checkbox" name="contact_surname_allow" value="1"
<?php if ($this->user_info_allow->contact_surname_allow) { ?> checked="checked"<?php } 
?> /> 
</td>
</tr>

<?php } ?>

<tr>
<td class="prompting">e-mail</td>
<td>
<?php echo $this->user->mail?>
</td>
<td class="td-shot">
<input type="checkbox" name="mail_allow" value="1"
<?php if ($this->user_info_allow->mail_allow) { ?> checked="checked"<?php } 
?> /> 

</td>
</tr>

<tr>
<td class="prompting">Телефон</td>
<td>
<input name="phone" type="text" value="<?php echo $this->user->phone?>" />
</td>
<td class="td-shot">
<input type="checkbox" name="phone_allow" value="1"
<?php if ($this->user_info_allow->phone_allow) { ?> checked="checked"<?php } 
?> /> 
</td>
</tr>

<tr>
<td class="prompting">Номер ICQ</td>
<td>
<input name="icq" type="text" value="<?php echo $this->user->icq?>" />
</td>
<td class="td-shot">
<input type="checkbox" name="icq_allow" value="1"
<?php if ($this->user_info_allow->icq_allow) { ?> checked="checked"<?php } 
?> /> 

</td>
</tr>

</table>
<h3>О себе</h3>
<textarea name="about_me" class="mach-info-text"><?php echo $this->user->getUserArrayCell('about_me');?></textarea>

<h3>Настройки</h3>

<table>
<tr>
<td class="prompting-1">Отсылать e-mail при получении сообщения на сайте </td>
<td class="td-shot"> 
<input type="checkbox" name="mail_on_message" value="1"
<?php if ($this->user_settings->mail_on_message) { ?> checked="checked"<?php } 
?> /> 
</td>
</tr>
</table>

<h3>Фотография</h3>

<?php if (count($this->array_photo)) { ?>
<dl>
<dt></dt>
<dd><div class="pictures-float-list"><BR><a href="<?php echo $this->array_photo[1]; ?>" class="thickbox" ><img src="<?php echo $this->array_photo[2]; ?>" /></a></div></dd>
<dt><p>Вы можете <a href="<?php echo $this->array_photo[1]; ?>" class="thickbox" >просмотреть загруженное изображение</A> или <a href="<?php echo $this->url; ?>?delete=yes&name=<?php echo $this->array_photo[0]; ?>">удалить</a> эту фотографию и загрузить другую.</p></dt>
</dl>
<?php } else { ?>
<input type="file" name="photo[]" />

<?php } ?>



<p><input type="submit" name="save" value="Сохранить" /></p>
</form>

<?php if (false) { ?>

<h3>Фотография</h3>

<?php if (count($this->array_photo)) { ?>
<dl>
<dt></dt>
<dd><div class="pictures-float-list"><BR><a href="<?php echo $this->array_photo[1]; ?>" class="thickbox" ><img src="<?php echo $this->array_photo[2]; ?>" /></a></div></dd>
<dt><p>Вы можете <a href="<?php echo $this->array_photo[1]; ?>" class="thickbox" >просмотреть загруженное изображение</A> или <a href="<?php echo $this->url; ?>?delete=yes&name=<?php echo $this->array_photo[0]; ?>">удалить</a> эту фотографию и загрузить другую.</p></dt>
</dl>
<?php } else { ?>
<form method="post" enctype="multipart/form-data">
<input type="file" name="photo[]" />
<input name="_do_" type="hidden" value="save_image" />
<input name="id" type="hidden" value="" />
<p class="submit-tipa-big-">
<input name="go" type="submit" value="Сохранить" />
</p>
</form>

<?php } } ?>


</div>
