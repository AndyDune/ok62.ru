<h1>Заявка на размещение гаража в каталоге</h1>

<?php
Dune_Variables::$pageTitle = 'Подтверждение. ' . Dune_Variables::$pageTitle;
?>


<?php switch ($this->message_code) { 
case 1: ?>
<p id="system-message">Не заполнены обязательные поля. Указаны красным цветом.</p>
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

<?php
Dune_Session::getInstance();
if (Dune_Session::$auth) { // Пользователь зарегистрирован
?>

<p>Прежде чем Ваша заявка будет размещена в каталоге, ее проверит модератор.</p>
<p>На Ваш контактный е-майл (<B><?php  echo $_SESSION[Dune_Session::ZONE_AUTH]['user_mail'];?></B>), указанный при регистрации в каталоге, прийдет сообщение о размещении Вашей заявки.</p>
<p>После размещения Вы получаете возможность общаться с покупателями по данному гаражу.</p>

<?php } else { // Не зарегистрированный пользователь ?>

<p>Прежде чем Ваша заявка будет размещена в каталоге, ее проверит модератор.</p>
<p>Только <B>зарегистрированне пользователи</B> могут размещать свои объекты в каталоге!<BR>
По-этому, после нажатия кнопки "Отправить на рассмотрение модератору" внизу страницы, Вам предложат или войти под своим именем и паролем, если Вы уже зарегистрированный пользователь системы, или пройти процедуру регистрации, которая не займет у Вас много времени.</p>
<p>На Ваш контактный е-майл, указанный при регистрации в каталоге, прийдет сообщение о размещении Вашей заявки.</p>
<p>После размещения Вы получаете возможность общаться с покупателями по данному гаражу.</p>

<?php } ?>

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
<?php
if ($this->data['street']) 
{ ?><span class="form-field-value"><?php
    echo $this->data['street']; 
  ?></span><?php
}
else
{
    ?><span class="form-field-require">не указано</span><?php
}
?>
</td>
</tr>

<tr>
<td class="object-prompting">Дом</td>
<td>
<?php
if ($this->data['house_number']) 
{ ?><span class="form-field-value"><?php
    echo $this->data['house_number']; 
if ($this->data['building_number'])
{
    ?>, корпус <? echo $this->data['building_number'];
}
  ?></span><?php
}
else
{
  ?><span class="form-field-none">не указано</span><?php
}
?>
</td>
</tr>



<tr>
<td class="object-prompting">Номер</td>
<td>
<?php
if ($this->data['room']) 
{ ?><span class="form-field-value"><?php
    echo $this->data['room']; 
  ?></span><?php
}
else
{
  ?><span class="form-field-none">не указано</span><?php
}
?>

</td>
</tr>

<!--
<tr>
<td class="object-prompting">Тип гаража:</td>
<td>
<?php
$text = '';
foreach ($this->house_type as $value)
{
    if ($value['id'] == $this->data['house_type'])
        $text = $value['name'];
}
if ($text) 
{ ?><span class="form-field-value"><?php
    echo $text; 
  ?></span><?php
}
else
{
  ?><span class="form-field-none">не указано</span><?php
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
<td class="object-prompting">Площадь</td>
<td>
<?php
if ($this->data['space_total']) 
{ ?><span class="form-field-value"><?php
    echo $this->data['space_total']; ?>
    
   кв. м.</span><?php
}
else
{
  ?><span class="form-field-none">не указано</span><?php
}
?>

</td>
</tr>




</table>


<h3>Детали</h3>
<table>

<tr>
<td class="object-prompting">Состояние</td>
<td>

<?php
$text = '';
foreach ($this->condition as $value)
{
    if ($value['id'] == $this->data['condition'])
        $text = $value['name'];
}
if ($text) 
{ ?><span class="form-field-value"><?php
    echo $text; 
  ?></span><?php
}
else
{
  ?><span class="form-field-none">не указано</span><?php
}
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
<pre>
<?php echo $this->data['info_text']; ?>
</pre>
</dd>
</dl>

<dl class="dl-description">
<dt>Комментарий</dt>
<dd>
<?php 
//echo str_replace("\n", '<br />', $this->object->info_text);

?>
<pre>
<?php echo $this->data['comments_text']; ?>
</pre>
</dd>
</dl>



<table class="list-table-js" style="width:100%;">

<tr>
<td class="object-prompting">Возможность торга: </td>
<td>
<?php 
if ($this->data['haggling'] == 0) {
?> <span class="form-field-spec">торгуюсь для "порядка"</span>
<?php 
}
else if ($this->data['haggling'] == 1) {
?> <span class="form-field-spec">не торгуюсь</span>
<?php 
}
else if ($this->data['haggling'] == 2) {
?> <span class="form-field-spec">очень хочу продать</span>
<?php } 
else { ?>
<span class="form-field-none">не указано</span>
<?php } ?>

</td><td>
<p class="p-object-shot-price">Цена:
<?php
if ($this->data['price']) 
{ ?><span class="form-field-value">
    <?php echo $this->data['price']?> руб.
  </span><?php
}
else
{
  ?><span class="form-field-none">не указано</span><?php
}
?>

</p><p class="p-object-shot-price" style="padding-top: 5px;">
Цена за 1 кв.м.:
<?php
if ($this->data['price_one']) 
{ ?><span class="form-field-value">
    <?php echo $this->data['price_one'] ?> руб.
  </span><?php
}
else
{
  ?><span class="form-field-none">не указано</span><?php
}
?>

</p>
</td></tr>

</table>



<div class="form-part">

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


<?php if (count($this->array_plan)) { ?>
<dl>
<dt>Загруженная планировка</dt>
<dd>
<div class="pictures-float-list">
<div>
<a href="<?php echo $this->array_plan[1]; ?>" class="thickbox" ><img src="<?php echo $this->array_plan[2]; ?>" /></a>
<p><a href="<?php echo $this->url; ?>?delete=yes&name=<?php echo $this->array_plan[0]; ?>">Удалить</a></p>
</div>
</div>

</dd>
</dl>
<?php } ?>


</div>
<?php if (!$this->status) {?>
<form method="post">
<input type="hidden" name="_do_" value="save" />
<p class="submit-tipa-big">
<input type="submit" name="save" value="Отправить на рассмотрение модератору" />
</p>
</form>
<?php } ?>
</div>
</div>

<div class="ugol-left-top"></div>
<div class="ugol-left-bottom"></div>
<div class="ugol-right-top"></div>
<div class="ugol-right-bottom"></div>

</div>
