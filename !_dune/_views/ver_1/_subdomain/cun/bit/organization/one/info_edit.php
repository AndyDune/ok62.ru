<div id="ocatalogue">

<h2>Редактирование информации</h2>
<p>&nbsp;</p>
<form method="post">
<input type="hidden" name="_do_" value="save_info" />
<table style="width:100%;">

<tr>
<td style="width:50px;">Название:</td>
<td><input style="width:100%;" type="text" name="name" value="<?php echo $this->data['name'] ?>" /></td>
</tr>

<tr>
<td style="width:50px;">Раздел:</td>
<td><?php echo $this->sections_select; ?></td>
</tr>


<tr>
<td>Аннотация (короткое описание в списке):</td>
<td>
<textarea  style="width:100%;" name="annotation" rows="5"><?php echo $this->data['annotation'] ?></textarea>
</td>
</tr>


<tr>
<td>Описание:</td>
<td>
<textarea  style="width:100%;" name="description" rows="20"><?php echo $this->data['description'] ?></textarea>
</td>
</tr>

<tr>
<td>Адрес:</td>
<td>
<textarea  style="width:100%;" name="adress" rows="5"><?php echo $this->data['adress'] ?></textarea>
</td>
</tr>

<tr>
<td><span style="white-space:nowrap;">Телефон(ы):</span></td>
<td>
<textarea  style="width:100%;" name="phone" rows="4"><?php echo $this->data['phone'] ?></textarea>
</td>
</tr>

<tr>
<td style="width:50px;">Сайт:</td>
<td><input style="width:200px;" type="text" name="site" value="<?php echo $this->data['site'] ?>" /></td>
</tr>

<?php if (Dune_Variables::$userStatus > 499) { ?>
<tr>
<td><span style="white-space:nowrap;">Дисконт:</span></td>
<td>
<textarea  style="width:100%;" name="diskont" rows="4"><?php echo $this->data['diskont'] ?></textarea>
</td>
</tr>
<?php } ?>

</table>
<p><input type="submit" name="Сохранить" value="Сохранить" /></p>
</form>

<h2>Смена логотипа</h2>
<p>&nbsp;</p>
<div id="ocatalogue-one-img">
<form enctype="multipart/form-data" method="post">
<input type="hidden" name="_do_" value="save_logo" />
<table>
<tr><td>
<?php
        if ($this->data['pic'])
        {
            $link_pic = '/ddata/ocatalogue/logo/' . $this->data['pic'];
        }
        else 
            $link_pic = $this->view_folder .'/img/ocatalogue_text_pic.gif';

?>
<img width="150" height="150" src="<?php echo $link_pic; ?>" alt="<?php echo $this->data['name']; ?>" />
</td><td>
Новый логотип:<input type="file" name="file[]" />
<p><input type="submit" name="Сохранить" value="Сохранить" /></p>
<td></tr></table>

</form>
</div>

</div>