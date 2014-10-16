<?php if ($this->count) {?>
<table>
<?php foreach ($this->list as $value) { ?>
<tr>

<td style="vertical-align:top;">
<p><strong><a href="/catalogue/object/<?php echo $value['id']; ?>/"><?php echo $value['name_type']; ?></a></strong><br />

<!-- Адресс на странице -->
<?php
if ($value['settlement_id'] == 1) {
if ($value['street_adding']) { ?>улица <?php } echo $value['name_street'];    
if ($value['house_number']) {
?>, дом <?php echo $value['house_number'];
if ($value['building_number']) {
    $word = $value['building_number'];
    $word = str_replace(array('a', 'b', 'c', 'd', 'e'), array('а', 'б', 'в', 'г', 'д'), $word);

    ?>, корпус <?php echo $word; }
 if ($value['type'] == 1 and $value['room']) {?>
, кв. <?php echo $value['room']; } 

}
?>
<br /><?php echo $value['name_district'] ?>
<br />г. <?php echo $value['name_settlement'] ?>
<?php

} else {
?>

	<?php echo $value['name_region']?>,<br />
	
    <?php if ($value['settlement_id'] != 1) { ?>
	<?php echo $value['name_area']?>,
	
	<?php if ($value['settlement_id'] and $value['type_settlement'] < 100)  { ?>
	<?php echo $value['name_settlement']?>,
	<?php } else { ?>
	<?php echo $value['settlement_name']?>,
	<?php }  ?>
	
	
	<?php } else {
	    echo $value['name_district'];?>,<?
                 }
	
	if ($value['street_id']) { 
	  if ($value['street_adding']) { ?> улица <?php } else {?> <?php }
	  echo $value['name_street'];   
    } else
	{
	       echo $value['street_name'];
	} 
	if ($value['house_number'])
	{
	?>, дом <?php echo $value['house_number'];
	}
	if ($value['building_number']) { 
	?>, корпус <?php echo $value['building_number']; }
	
	if ($value['room'])
	 {
	    if ($value['type'] == 1) {
	 ?>, квартира <?php
        } else {
            ?>, номер <?php
        }
	   echo $value['room'];
	    } ?>
<?php } ?>
<!--/ Адресс на странице -->




</p>
</td>

<td style="vertical-align:top; border-top: 1px solid #000; "> 

<p>


<?php $this->data = $value; ?>


<strong>Тип дома:</strong>
<?php
foreach ($this->house_type as $valuet)
{
    if ($valuet['id'] == $value['type_house'])
    {
        echo $valuet['name']; 
    }
}
?>

<strong>Площадь: общая/жилая/кухня :</strong>
<?php echo $value['space_total']?>
 / 
<?php echo $value['space_living']?>
 / 
<?php echo $value['space_kitchen']?>
<br />

<strong>Расчетная площадь:</strong>
<?php echo $value['space_calculation']?>
<br />

<strong>Высота потолков:</strong>
<?php echo $this->data['height_ceiling']?>
<br />

<strong>Комнаты:</strong>
<?php echo $this->data['rooms_count']?> 
<br />

<strong>Планировка:</strong>
<?php
foreach ($this->planning as $value2)
{
    if ($value2['id'] == $this->data['planning'])
        echo $value2['name'];
}
?>
<br />

<strong>Состояние:</strong>
<?php
foreach ($this->condition as $value2)
{
    if ($value2['id'] == $this->data['condition'])
        echo $value2['name'];
}
?>
<br />

<strong>Телефон:</strong>
<?php 
if ($this->data['have_phone'])
{
?> есть<?php
} else {
?> нет<?php
}
    
?>

<strong>Балкон:</strong>
<?php 
if ($this->data['balcony'])
{
?> есть (<?php echo $this->data['space_balcony'] ?> кв.м.) <?php
} else {
?> нет<?php
}
?>


<strong>Лоджия:</strong>
<?php 
if ($this->data['loggia'])
{
?> есть (<?php echo $this->data['space_loggia'] ?> кв.м.) <?php
} else {
?> нет<?php
}
?>
</p>

<p>
<strong>Описание</strong><br />
<?php 
echo $this->data['info_text']
?>
</p>

<p>
<strong>Коментарий</strong><br />
<?php 
echo $this->data['info_comment']
?>
</p>

<p>
<strong>Новостройка</strong>:
<?php 
if ($this->data['new_building_flag'])
{
?> есть (<?php echo $this->data['new_building_text'] ?>) <?php
} else {
?> нет<?php
}
?>


 <strong>Сделка</strong>:
<?php 
if ($this->data['deal'] == 2)
{
?> продажа, аренда<?php
} else if ($this->data['deal'] == 1) {
?> аренда<?php
} else {
?> продажа<?php
}

?>

<strong>Торг</strong>:
<?php 
if ($this->data['haggling'] == 0)
{
?> торгуюсь для "порядка"<?php
} else if ($this->data['haggling'] == 1) {
?> не торгуюсь<?php
} else {
?> очень хочу продать<?php
}
?>


</p>

<p>
<strong>Цена</strong>:
<?php
$value2 = '';
if ($this->data['price'])  
{
    $value2 = number_format($this->data['price'], '0', '.',' ');
}
echo $value2;
?>

<strong>Цена за 1 кв.м.</strong>:
<?php
$value2 = '';
if ($this->data['price_one'])  
{
    $value2 = number_format($this->data['price_one'], '0', '.',' ');
}
echo $value2;
?>



<strong>Цена за аренду в месяц</strong>:
<?php
$value2 = '';
if ($this->data['price_rent'])  
{
    $value2 = number_format($this->data['price_rent'], '0', '.',' ');
}
echo $value2;
?>



</p>









</p>
</td>

<td style="vertical-align:top;"> <p>
Продавец: <a href="/user/info/<?php echo $value['saler_id'] ?>/"><?php echo $value['name_user'] ?></a><br />
Мейл: <?php echo $value['user_mail'] ?><br />
Контактное имя: <?php echo $value['user_contact_name'] ?><br />
Телефон: <?php echo $value['user_phone'] ?><br />
</p>
</td>


</tr>
<?php } ?>

</table>
<?php } else { ?>

<?php } ?>