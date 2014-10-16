<h1>Заявка на размещение гаража в каталоге</h1>

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

<?php case 5: ?>
<p id="system-message">Ошибка. Сделайте повторную попытку сохранения данных.</p>
<?php break; ?> 


<?php } 
echo $this->steps_panel;
?>

<div id="object-under-bookmark">

<div id="object-info">

<div id="object-sell">
<form method="post">

<table id="two-col-table">
<tr><td class="left" style="width:40%">
<h3>Расположение</h3>
<table class="list-table-js">


<tr>
<td class="object-prompting">Область</td>
<td>
Рязанская
</td>
</tr>

<tr>
<td class="object-prompting">Город</td>
<td>
Рязань
</td>
</tr>

<tr>
<td class="object-prompting">Улица</td>
<td>
<input name="street" type="text" value="<?php echo $this->data['street']?>" />
</td>
</tr>

<tr>
<td class="object-prompting">Дом</td>
<td>
<input name="house_number" type="text" value="<?php echo $this->data['house_number']?>" />
</td>
</tr>



<tr>
<td class="object-prompting">Корпус</td>
<td>
<?php
    $word = $this->data['building_number'];
    $word = str_replace(array('a', 'b', 'c', 'd', 'e'), array('а', 'б', 'в', 'г', 'д'), $word);
?>
<input name="building_number" type="text" value="<?php echo $word?>" />
</td>
</tr>



<tr>
<td class="object-prompting">Номер</td>
<td>
<input name="room" type="text" value="<?php echo $this->data['room']?>" />
</td>
</tr>



<!--
<tr>
<td class="object-prompting">Тип гаража:</td>
<td>
<?php
foreach ($this->house_type as $value)
{
    $form = new Dune_Form_InputRadio('house_type');
    if ($value['id'] == $this->data['house_type'])
        $form->setChecked();
    $form->setValue($value['id']);
    echo $form;?> <?php echo $value['name']; ?> <br /><?php
}
?>
</td>
</tr>
-->

</table>

</td><td>

<h3>Основные параметры</h3>


<table class="list-table-js">

<tr>
<td class="object-prompting">Площадь:</td>
<td>
<input name="space_total" type="text" value="<?php echo $this->data['space_total']?>"  class="input-1" /> 
 кв. м.
</td>
</tr>



</table>


<h3>Детали</h3>
<table>

<tr>
<td class="object-prompting">Состояние:</td>
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


</table>

</td></tr>
</table>


<dl class="dl-description">
<dt>Описание</dt>
<dd>
<?php 
//echo str_replace("\n", '<br />', $this->object->info_text);

?>
<textarea name="info_text" rows="5" style="width:100%"><?php echo $this->data['info_text']; ?></textarea>
</dd>
</dl>

<dl class="dl-description">
<dt>Комментарий</dt>
<dd>
<?php 
//echo str_replace("\n", '<br />', $this->object->info_text);

?>
<textarea name="comments_text" rows="5" style="width:100%"><?php echo $this->data['comments_text']; ?></textarea>
</dd>
</dl>



<table class="list-table-js" style="width:100%;">

<tr>
<td class="object-prompting">Возможность торга</td>
<td>
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


</td><td>
<p class="p-object-shot-price">Цена
<input name="price" type="text" value="<?php echo $this->data['price']?>" /> руб.
</p><p class="p-object-shot-price" style="padding-top: 5px;">
Цена за 1 кв.м.
<input name="price_one" type="text" value="<?php echo $this->data['price_one']?>" /> руб.
</p>
</td></tr>

</table>



<input name="type" type="hidden" value="<?php echo $this->type; ?>" />
<input name="_do_" type="hidden" value="<?php echo $this->do; ?>" />
<input name="id" type="hidden" value="<?php echo $this->id; ?>" />
<p class="submit-tipa-big">
<input name="go" type="submit" value="Сохранить" />
</p>
</form>
</div>
</div>
<div class="ugol-left-top"></div>
<div class="ugol-left-bottom"></div>
<div class="ugol-right-top"></div>
<div class="ugol-right-bottom"></div>

</div>
