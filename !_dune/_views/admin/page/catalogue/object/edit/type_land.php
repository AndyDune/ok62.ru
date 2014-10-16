<?php
$heating    = array(2 => 'автономное', 'центральное');
$water_cold = array(2 => 'автономный', 'центральный');
$sewer      = array(2 => 'местная', 'центральный');

?>
<h1>Редактирование объекта Земельный участок.</h1>
<div id="edit-object-container">
<table id="main-edit-table">
<tr><td>

<div id="add-object">
<form method="post">

<input name="go" type="submit" value="Сохранить" />

<div id="add-object-adress-part">
<table class="list-table-js">

<tr>
<td class="add-object-prompting">Активность</td>
<td>
<?php 
$form = new Dune_Form_InputCheckBox('activity');
if ($this->data['activity'])
$form->setChecked();
echo $form;
?>
</td>
</tr>

<tr>
<td class="add-object-prompting">Продавец</td>
<td>
<input name="saler_id" type="text" value="<?php echo $this->data['saler_id']?>" />
</td>
</tr>


<tr>
<td class="add-object-prompting">Спец код продавца</td>
<td>
<input name="saler_special" type="text" value="<?php echo $this->data['saler_special']?>" />
</td>
</tr>


<tr>
<td class="add-object-prompting">Дополнит. контактная информация</td>
<td>
<textarea style="width:100%;" rows="3" name="info_contact"><?php echo$this->data['info_contact'] ?></textarea>
</td>
</tr>


<tr>
<td class="add-object-prompting">Выделенное</td>
<td>
<?php 
$form = new Dune_Form_InputCheckBox('mark');
$form->setValue(1);
if ($this->data['mark'])
$form->setChecked();
echo $form;
?>

</td>
</tr>


<tr>
<td class="add-object-prompting">Код прикрепляемой панорамы:</td>
<td>
<input class="input-shot" name="panorama" type="text" value="<?php echo $this->data['panorama']?>" /> 
</td>
</tr>


<tr>
<td class="add-object-prompting">Имя объекта <br /> <em>(Пример: Супермегаэкстра недвижимость почти нахаляву)</em></td>
<td>
 <input type="text" name="name" value="<?php echo $this->data['name']; ?>" style="width:85%;"/> 
</td>
</tr>


</table>
</div>

<div id="add-object-adress-part">
<table class="list-table-js">

<tr>
<td class="add-object-prompting">Область</td>
<td>
<?php echo $this->adress['region']['name'] ?>
</td>
</tr>

<tr>
<td class="add-object-prompting">Район</td>
<td>
<?php echo $this->adress['area']['name'] ?>
</td>
</tr>

<tr>
<td class="add-object-prompting">Понятийный район</td>
<td>
<?php
$form = new Dune_Form_Select('district_id_plus');
$form->setOption(0, '---');
foreach (Special_Vtor_Districts::$list as $key => $value)
{
    if ($key == $this->data['district_id_plus'])
        $check = true;
    else 
        $check = false;
    $form->setOption($key, $value, $check);
}
echo $form;
?>

</td>
</tr>



<tr>
<td class="add-object-prompting">Город (поселок, село, деревня)</td>
<td>
<?php if ($this->data['settlement_id'] and $this->adress['settlement']['type'] < 100) { ?>
<?php echo $this->adress['settlement']['name'] ?>
<?php } else { ?>
<input style="width: 300px;" name="settlement_name" type="text" value="<?php echo $this->data['settlement_name']?>" />
<?php } ?>
</td>
</tr>

<?php if ($this->adress['district']['id']) { ?>
<tr>
<td class="add-object-prompting">Городской округ</td>
<td>
<?php echo $this->adress['district']['name'] ?>
</td>
</tr>
<?php } ?>

<tr>
<td class="add-object-prompting">Улица</td>
<td>
<?php if ($this->data['street_id']) { ?>
<?php echo $this->adress['street']['name'] ?>
<?php } else { ?>
<input style="width: 300px;" name="street_name" type="text" value="<?php echo $this->data['street_name']?>" />
<?php } ?>

</td>
</tr>

</table>
</div>

<div id="add-object-info-part">
<table class="list-table-js">

<tr>
<td class="add-object-prompting">Площадь: общая</td>
<td>
<input class="input-shot" name="space_land" type="text" value="<?php echo $this->data['space_land']?>" /> соток
</td>
</tr>

<tr>
<td class="add-object-prompting">Состояние:</td>
<td>
<?php
$form = new Dune_Form_Select('condition');
$form->setOption(0, 'Не известно');
foreach ($this->condition as $value)
{
    if ($value['id'] == $this->data['condition'])
        $check = true;
    else 
        $check = false;
    $form->setOption($value['id'], $value['name'], $check);
}
echo $form;
?>
</td>
</tr>



<tr>
<td class="add-object-prompting">Описание</td>
<td>
<?php 
$form = new Dune_Form_TextArea('info_text');
$form->setValue($this->data['info_text']);
$form->setRows(5);
$form->setClass('textarea');
echo $form->get();
?>
</td>
</tr>

<tr>
<td class="add-object-prompting">Коментарий</td>
<td>
<?php 
$form = new Dune_Form_TextArea('info_comment');
$form->setValue($this->data['info_comment']);
$form->setRows(5);
$form->setClass('textarea');
echo $form->get();
?>
</td>
</tr>


<tr>
<td class="add-object-prompting">Условия показа</td>
<td>
<?php 
$form = new Dune_Form_TextArea('info_show_condition');
$form->setValue($this->data['info_show_condition']);
$form->setRows(4);
$form->setClass('textarea');
echo $form->get();
?>
</td>
</tr>



</table>
</div>




<div id="add-object-info-part">
<table class="list-table-js">

<!--
<tr>
<td class="add-object-prompting">Сооружения (двор, баня, сарай и др.) <br /> <em>(Текст уточнения или маркер наличия 1 символ)</em></td>
<td>
<input type="text" name="add_building" value="<?php echo $this->data['add_building']; ?>" class="input-1" style="width:85%;" /></td>
</tr>
-->




</table>
</div>




<div id="add-object-final-part">
<table>


<tr>
<td class="add-object-prompting">Сделка</td>
<td>
<?php 
$var_1 = $var_2 = '';
if (!$this->data['deal'])
{
    $var_1 = ' checked="checked"';
}
else if ($this->data['deal'] == 1)
{
    $var_2 = ' checked="checked"';
}
else if ($this->data['deal'] == 2)
{
    $var_1 = ' checked="checked"';
    $var_2 = ' checked="checked"';
}

?>
<input name="deal_1" type="checkbox"  value="1"<?php echo $var_1?> /> продажа<br />
<input name="deal_2" type="checkbox"  value="1"<?php echo $var_2?> /> аренда
</td>
</tr>


<tr>
<td class="add-object-prompting">Торг</td>
<td>

<?php 
$form = new Dune_Form_InputRadio('haggling');
$form->setValue(100);
if ($this->data['haggling'] == 100)
$form->setChecked();
echo $form;
?> не отображать на сайте
<br />


<?php 
$form = new Dune_Form_InputRadio('haggling');
$form->setValue(0);
if ($this->data['haggling'] == 0)
$form->setChecked();
echo $form;
?> торгуюсь для "порядка"
<br />

<?php 
$form = new Dune_Form_InputRadio('haggling');
$form->setValue(1);
if ($this->data['haggling'] == 1)
$form->setChecked();
echo $form;
?> не торгуюсь
<br />
<?php 
$form = new Dune_Form_InputRadio('haggling');
$form->setValue(2);
if ($this->data['haggling'] == 2)
$form->setChecked();
echo $form;
?> очень хочу продать
</td>
</tr>


<tr>
<td class="add-object-prompting">Цена договорная</td>
<td>
<?php
if ($this->data['price_contractual'])
{
    $var = ' checked="checked"';
}
else 
 $var = '';
?>
<input name="price_contractual" type="checkbox"  value="1"<?php echo $var?> />
</td>
</tr>


<tr>
<td class="add-object-prompting">Цена</td>
<td>
<?php
$value = '';
if ($this->data['price'])  
{
    $value = number_format($this->data['price'], '0', '.',' ');
}
?>

<input name="price" type="text" value="<?php echo $value?>" /> 
<?php
$value = '';
if ($this->data['price_old'])  
{
    $value = number_format($this->data['price_old'], '0', '.',' ');
}
?>

 старая цена: <input name="price_old" type="text" value="<?php echo $value?>" /> 
</td>
</tr>

<!--
<tr>
<td class="add-object-prompting">Цена за 1 сотку</td>
<td>
<?php
$value = '';
if ($this->data['price_one'])  
{
    $value = number_format($this->data['price_one'], '0', '.',' ');
} ?>

<input name="price_one" type="text" value="<?php echo $value?>" /> 
</td>
</tr>
-->

<tr>
<td class="add-object-prompting">Цена за аренду</td>
<td>
<?php
$value = '';
if ($this->data['price_rent'])  
{
    $value = number_format($this->data['price_rent'], '0', '.',' ');
} ?>
<input name="price_rent" type="text" value="<?php echo $value?>" /> </td>
</tr>


</table>
</div>

<input name="region_id" type="hidden" value="<?php echo $this->data_region['id'] ?>" />
<input name="link_list" type="hidden" value="<?php echo $this->link_list ?>" />
<input name="_do_" type="hidden" value="save" />
<input name="adress_code" type="hidden" value="<?php echo $this->adress_code ?>" />
<input name="adress_id" type="hidden" value="<?php echo $this->adress_id ?>" />
<input name="id" type="hidden" value="<?php echo $this->data['id'] ?>" />
<input name="go" type="submit" value="Сохранить" />

</form>
</div>


</td><td id="edit-object-pics-td">
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
$o_hidden_do->setValue('save_pics');
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
<img src="<?php echo $file->getPreviewFileUrl();  ?>" />
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
if ($count < 5)
{
	$key = $count;
	echo '<h2>Добавление пакета картинок</h2><ul>';
	for ($key = $count; $key < 5; $key++)
	{
		?><li>
		<input type="file" name="pic[<?php echo $key?>]">
		</li>
		<?php
		
	}
		echo '</ul>';
}
?>
<p>Добавить картинку: <input type="file" name="new"></p>
<p>Удалить последнюю в списке: <a href="<?php echo $this->command_path_edit?>?_do_=delete_last&id=<?php echo $this->data['id'];?>">Да</a></p>
<?php echo $o_submit->get();?>
</form>
</div>




</div>
</td></tr>
</table>
</div>