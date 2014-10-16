<h1>Редактирование объекта. План этажа.</h1>
<div id="edit-object-container">

<!--           Графика                   -->
<div id="edit-object-pics">
<h2>Фотографии</h2>


<div id="fragment-2">
<?php
$o_form = new Dune_Form_Form();
$o_form->setMethod(Dune_Form_Form::METHOD_POST);
$o_form->setEnctype(Dune_Form_Form::ENCTYPE_MULTI);
echo $o_form->getBegin();
$o_hidden_do = new Dune_Form_InputHidden('_do_');
$o_hidden_do->setValue('save_floor');
echo $o_hidden_do;
$o_submit = new Dune_Form_InputSubmit('Сохранить');
$o_submit->setValue('Сохранить');

?>
<div id="float-list">
<input name="id" type="hidden" value="<?php echo $this->data['id'] ?>" />
<?php
$count = 0;
foreach ($this->photos as $key => $file)
{
	$count++;
?>
<dl class="float-dl"><dt>
<?php echo $key?>. <a href="<?php echo $file->getSourseFileUrl()  ?>" target="_blank">
<img src="<?php echo $file->getPreviewFileUrl(400);  ?>" />
</a>
</dt>
<dd>
<input type="file" name="pic[<?php echo $key?>]">
</dd></dl>
<?php
}
?>
</div>
<?php 
if ($count < 1) {
?>
<p>Добавить картинку: <input type="file" name="new"></p>
<?php }?>
<p>Удалить: <a href="<?php echo $this->command_path_edit?>?_do_=delete_floor&id=<?php echo $this->data['id'];?>">Да</a></p>
<?php echo $o_submit->get();?>
</form>
</div>




</div>
