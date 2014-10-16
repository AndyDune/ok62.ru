<h1>Основные настройки системы</h1>
<ul class="class-add-links">
<li></li>
</ul>
<hr />
<?php
$o_form = new Dune_Form_Form();
$o_form->setAction($this->do_path);
$o_form->setMethod(Dune_Form_Form::METHOD_POST);

$o_submit = new Dune_Form_InputSubmit('Сохранить');
$o_submit->setValue('Сохранить');


$allow_reg = new Dune_Form_InputCheckBox('allow_reg');
$allow_reg->setValue(1);
if ($this->allow_reg)
	$allow_reg->setChecked();

$o_hidden = new Dune_Form_InputHidden('_do_');
$o_hidden->setValue('save_main');

echo $o_form->getBegin();
echo $o_hidden->get();
?>
<table>
<tr><td>Возможность регистрации новых пользователей: </td><td><?php echo $allow_reg->get();?></td></tr>
</table><p id="id-submit">
<?php echo $o_submit->get();?></p>
</form>
