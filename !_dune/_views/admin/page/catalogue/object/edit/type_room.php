<?php
$heating = array(2 => 'автономное', 'центральное', 'индивидуальное');
$water_cold = array(2 => 'автономный', 'центральный');
$sewer      = array(2 => 'местная', 'центральный');

$corner_room      = array(1 => 'угловая', 'не угловая');
?>

<h1>Редактирование объекта Квартира.</h1>
<p>Быстро:
 <a href="/admin/catalogue/object/edit/<?php echo $this->data['id'] - 1 ?>/">предыдущий</a>
 <a href="/admin/catalogue/object/edit/<?php echo $this->data['id'] + 1 ?>/">следующий</a>
 </p>
 <?php echo $this->top_menu; ?>
 <?php if ($this->copy_original_url) { ?>
 <p><strong style="color:red;">!!! Копия от объекта: <a target="_blank" href="<?php echo $this->copy_original_url;?>">оригинал</a></strong></p>
 <?php } ?>
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
<td class="add-object-prompting">Группировка по стояку:</td>
<td>
<input class="input-shot" name="group_list" type="text" value="<?php echo $this->data['group_list']?>" /> 
</td>
</tr>

<tr>
<td class="add-object-prompting">Приоритет в списке по умолчанию:</td>
<td>
<input class="input-shot" name="priority" type="text" value="<?php echo $this->data['priority']?>" /> 
</td>
</tr>

</table>
</div>

<div id="add-object-adress-part">
<table class="list-table-js">


<tr>
<td class="add-object-prompting">Комплекс, название</td>
<td>
 <input type="text" name="name_complex" value="<?php echo $this->data['name_complex']; ?>" style="width:85%;"/> 
</td>
</tr>


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

<tr>
<td class="add-object-prompting">Дом</td>
<td>
<input name="house_number" type="text" value="<?php echo $this->data['house_number']?>" />
</td>
</tr>

<tr>
<td class="add-object-prompting">Корпус</td>
<td>
<?php
    $word = $this->data['building_number'];
    $word = str_replace(array('a', 'b', 'c', 'd', 'e'), array('а', 'б', 'в', 'г', 'д'), $word);
?>
<input name="building_number" type="text" value="<?php echo $word?>" />
</td>
</tr>

<tr>
<td class="add-object-prompting">Номер квартиры</td>
<td>
<input name="room" type="text" value="<?php echo $this->data['room']?>" />
</td>
</tr>

<tr>
<td class="add-object-prompting">Тип дома:</td>
<td>
<?php
foreach ($this->house_type as $value)
{
    $form = new Dune_Form_InputRadio('type_house');
    if ($value['id'] == $this->data['type_house'])
        $form->setChecked();
    $form->setValue($value['id']);
    echo $form;?> <?php echo $value['name']; ?> <br /><?php
}
?>
</td>
</tr>


<tr>
<td class="add-object-prompting">Подъезд</td>
<td>
<input name="porch" type="text" value="<?php echo $this->data['porch']?>" />
</td>
</tr>

<tr>
<td class="add-object-prompting">Подъезд (текст до 100 символов.)</td>
<td>
<?php 
$form = new Dune_Form_TextArea('porch_text');
$form->setValue($this->data['porch_text']);
$form->setRows(5);
$form->setCols(50);
$form->setClass('textarea');
echo $form->get();
?>

</td>
</tr>

<tr>
<td class="add-object-prompting">Этаж/этажей всего</td>
<td>
<input class="input-shot" name="floor" type="text" value="<?php echo $this->data['floor']?>" />
 / 
<input class="input-shot" name="floors_total" type="text" value="<?php echo $this->data['floors_total']?>" />
</td>
</tr>

<tr>
<td class="add-object-prompting">Уровней в квартире</td>
<td>
<input name="levels" type="text" value="<?php echo $this->data['levels']?>" />
</td>
</tr>


</table>
</div>

<div id="add-object-info-part">
<table class="list-table-js">


<tr>
<td class="add-object-prompting">Число комнат</td>
<td>
<input name="rooms_count" type="text" value="<?php echo $this->data['rooms_count']?>" /> 
</td>
</tr>


<tr>
<td class="add-object-prompting">Площадь: общая/жилая/кухня</td>
<td>
<input class="input-shot" name="space_total" type="text" value="<?php echo $this->data['space_total']?>" /> 
 / 
 <input class="input-shot" name="space_living" type="text" value="<?php echo $this->data['space_living']?>" /> 
 / 
<input class="input-shot" name="space_kitchen" type="text" value="<?php echo $this->data['space_kitchen']?>" /> 
</td>
</tr>

<tr>
<td class="add-object-prompting">Расчетная площадь:</td>
<td>
<input class="input-shot" name="space_calculation" type="text" value="<?php echo $this->data['space_calculation']?>" /> 
</td>
</tr>

<tr>
<td class="add-object-prompting">Высота потолков:</td>
<td>
<input class="input-shot" name="height_ceiling" type="text" value="<?php echo $this->data['height_ceiling']?>" /> 
</td>
</tr>



<tr>
<td class="add-object-prompting">Планировка:</td>
<td>
<?php
$form = new Dune_Form_Select('planning');
$form->setOption(0, 'Не известно');
foreach ($this->planning as $value)
{
    if ($value['id'] == $this->data['planning'])
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
<td class="add-object-prompting">Наличие телефона</td>
<td>
<?php 
$form = new Dune_Form_InputCheckBox('have_phone');
$form->setValue(1);
if ($this->data['have_phone'])
$form->setChecked();
echo $form;
?>

</td>
</tr>


<tr>
<td class="add-object-prompting">Наличие балкона</td>
<td>
<?php 
$form = new Dune_Form_InputCheckBox('balcony');
$form->setValue(1);
if ($this->data['balcony'])
$form->setChecked();
echo $form;
?>
 / <input type="text" name="space_balcony" value="<?php echo $this->data['space_balcony']; ?>" class="input-1" /> кв. м.
</td>
</tr>

<tr>
<td class="add-object-prompting">Наличие лоджии</td>
<td>
<?php 
$form = new Dune_Form_InputCheckBox('loggia');
$form->setValue(1);
if ($this->data['loggia'])
$form->setChecked();
echo $form;
?>
 / <input type="text" name="space_loggia" value="<?php echo $this->data['space_loggia']; ?>" class="input-1" /> кв. м.
</td>
</tr>


<tr>
<td class="add-object-prompting">Окна:</td>
<td>
<?php

$form = new Dune_Form_Select('windows_type');
$form->setOption(0, 'Не известно');
foreach (Special_Vtor_Settings::$windowsType as $key => $value)
{
    if ($key == $this->data['windows_type'])
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
<td class="add-object-prompting">Вид отопления</td>
<td>
<?php
$form = new Dune_Form_Select('type_heating');
$form->setOption(0, '---');
foreach ($heating as $key => $value)
{
    if ($key == $this->data['type_heating'])
        $check = true;
    else 
        $check = false;
    $form->setOption($key, $value, $check);
}
echo $form;
?>

</tr>

<tr>
<td class="add-object-prompting">Угловатость</td>
<td>
<?php
$form = new Dune_Form_Select('corner_room');
$form->setOption(0, '---');
foreach ($corner_room as $key => $value)
{
    if ($key == $this->data['corner_room'])
        $check = true;
    else 
        $check = false;
    $form->setOption($key, $value, $check);
}
echo $form;
?>

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

<div id="add-object-final-part">
<table>


<tr>
<td class="add-object-prompting">Новостройка</td>
<td>
<?php 
$form = new Dune_Form_InputCheckBox('new_building_flag');
$form->setValue(1);
if ($this->data['new_building_flag'])
$form->setChecked();
echo $form;
?>
 / <input type="text" name="new_building_text" value="<?php echo $this->data['new_building_text']; ?>" style="width:85%;"/> 
</td>
</tr>


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

<tr>
<td class="add-object-prompting">Цена за 1 кв.м.</td>
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

<tr>
<td class="add-object-prompting">Цена за аренду в <strong>месяц</strong></td>
<td>
<?php
$value = '';
if ($this->data['price_rent'])  
{
    $value = number_format($this->data['price_rent'], '0', '.',' ');
} ?>
<input name="price_rent" type="text" value="<?php echo $value?>" /> </td>
</tr>

<tr>
<td class="add-object-prompting">Цена за аренду в <strong>день</strong></td>
<td>
<?php
$value = '';
if ($this->data['price_rent_day'])  
{
    $value = number_format($this->data['price_rent_day'], '0', '.',' ');
} ?>
<input name="price_rent_day" type="text" value="<?php echo $value?>" /> </td>
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