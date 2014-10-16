<h1>Добавление объекта. Кладовое помещение.</h1>
<div id="add-object">
<form method="post">
<p><strong>Стразу жмите на "добавить". Не заполняйте данные на этой странице.</strong> </p>
<input name="go" type="submit" value="Добавить" />
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
<td class="add-object-prompting">Этажей в доме</td>
<td>
<input name="levels" type="text" value="<?php echo $this->data['levels']?>" />
</td>
</tr>

<tr>
<td class="add-object-prompting">Корпус</td>
<td>
<input name="building_number" type="text" value="<?php echo $this->data['building_number']?>" />
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
<td class="add-object-prompting">Номер</td>
<td>
<input name="room" type="text" value="<?php echo $this->data['room']?>" />
</td>
</tr>

<tr>
<td class="add-object-prompting">Этаж</td>
<td>
<input name="floor" type="text" value="<?php echo $this->data['floor']?>" />
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


</table>
</div>

<div id="add-object-info-part">

<table class="list-table-js">

<tr>
<td class="add-object-prompting">Площадь:</td>
<td>
<input name="space_total" type="text" value="<?php echo $this->data['space_total']?>" /> 
</td>
</tr>


<tr>
<td class="add-object-prompting">Высота потолков:</td>
<td>
<input class="input-shot" name="height_ceiling" type="text" value="<?php echo $this->data['height_ceiling']?>" /> 
</td>
</tr>



<tr>
<td class="add-object-prompting">Состояние</td>
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
<td class="add-object-prompting">Цена</td>
<td>
<input name="price" type="text" value="<?php echo $this->data['price']?>" /> 
</td></tr>

<tr>
<td class="add-object-prompting">Цена за 1 кв.м.</td>
<td>
<input name="price_one" type="text" value="<?php echo number_format($this->data['price_one'], '0', '.',' ')?>" /> 
</td>
</tr>

<tr>
<td class="add-object-prompting">Цена за аренду</td>
<td>
<input name="price_rent" type="text" value="<?php echo number_format($this->data['price_rent'], '0', '.',' ')?>" /> </td>
</tr>


</table>
</div>

<input name="region_id" type="hidden" value="<?php echo $this->data_region['id'] ?>" />
<input name="link_list" type="hidden" value="<?php echo $this->link_list ?>" />
<input name="_do_" type="hidden" value="save" />
<input name="adress_code" type="hidden" value="<?php echo $this->adress_code ?>" />
<input name="adress_id" type="hidden" value="<?php echo $this->adress_id ?>" />
<input name="go" type="submit" value="Сохранить" />

</form>
</div>