<div id="div-objects-list">
<!--
<p><a href="/user/nearby/" class="buttom">Все наблюдаемые</a></p>
-->
<form method="post" enctype="multipart/form-data">
<dl>

<dt>Название</dt>
<dd><input type="text" name="name" value="<?php echo $this->group['name'] ?>" style="width:500px;" /></dd>
</dl>

<dt>Порядок</dt>
<dd><input type="text" name="order" value="<?php echo $this->group['order'] ?>" style="width:100px;" /></dd>
</dl>


<dt>Описание</dt>
<dd>
<textarea name="text" style="width:500px; height: 50px;">
<?php echo $this->group['text'] ?>
</textarea>
</dd>
</dl>

<dl>
<dt>Улицы (коды через пробел):</dt>
<dd>
<textarea name="streets" style="width:500px; height: 50px;">
</textarea>
</dd>
</dl>

<h3>Фотография</h3>

<?php if (count($this->array_photo)) {
    Dune_Static_JavaScriptsList::add('thickbox');
    Dune_Static_StylesList::add('thickbox');
    
    ?>
<dl>
<dt></dt>
<dd><div class="pictures-float-list"><BR><a href="<?php echo $this->array_photo[1]; ?>" class="thickbox" ><img src="<?php echo $this->array_photo[2]; ?>" /></a></div></dd>
<dt><p>Вы можете <a href="<?php echo $this->array_photo[1]; ?>" class="thickbox" >просмотреть загруженное изображение</A> или <a href="<?php echo $this->url; ?>?delete_photo=delete_photo&name=<?php echo $this->array_photo[0]; ?>">удалить</a> эту фотографию и загрузить другую.</p></dt>
</dl>
<?php } else { ?>
<input type="file" name="photo[]" />
<input name="_do_" type="hidden" value="save_image" />
<input name="id" type="hidden" value="" />

<?php } ?>


<p>
<input type="hidden" name="do" value="save" />
<input type="hidden" name="edit" value="<?php echo $this->group_current ?>" />
<input type="submit" name="save" value="Сохранить" />
</p>
</form>

<?php if ($this->street_array and count($this->street_array) > 0) { ?>
<dl>
<dt>Добавленные улицы:</dt>
<dd>
<ul>
<?php foreach ($this->street_array as $value) {?>
<li>
<a href="/user/nearby/list/<?php echo $this->group_current ?>_<?php echo $value['id'] ?>/">
<?php echo $value['name']; ?>
</a>
(<a href="/user/nearby/edit/<?php echo $this->group_current ?>/?do=delete_street&id=<?php echo $value['id'] ?>">удалить</a>)
</li>
<?php } ?>
</ul>
</dd>
</dl>
<?php } ?>

</div>