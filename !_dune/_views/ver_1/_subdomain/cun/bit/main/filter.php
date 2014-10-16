<div id="main-page-filter">

<h2>
Главное меню поиска недвижимости
</h2>

<div id="header-filter" class="header-filter">


<div class="div-inline-4 div-inline-4-1"><div class="div-inline-inside">  <h4><span>вид недвижимости</span></h4>
<div class="filter-border-1"><div class="filter-border-2"><div class="filter-border-3"><div class="filter-border-4">
<div class="header-filter-cell"> <!-- Временно -->

<select name="type" id="select-bookmark">
<?php
$count_total = 0;
$type = 1;
if (isset($this->list_type[$type]))
    $count = $this->list_type[$type]['count'];
else 
    $count = 0;
$str = (string)($count_total += $count);
/*$str = 1004;
$count = 5 - strlen($str);
$nbsp = '';
for ($x = 0; $x < $count; $x++)
{
    $str = '&nbsp;' . $str;
}
if ($count == 2)
    $str = '&nbsp;' . $str;
*/

?>

<?php if ( $str ) { ?>
<option value="#type_1" selected="selected"><span>Квартира</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $str; ?></option>
<?php
}
$type = 2;
if (isset($this->list_type[$type]))
    $count = $this->list_type[$type]['count'];
else 
    $count = 0;
$count_total += $count;
$str = (string)$count;
if ( $str ) {
?>
<option value="#type_2"><span>Дом</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $str; ?></option>
<?php
}
$type = 3;
if (isset($this->list_type[$type]))
    $count = $this->list_type[$type]['count'];
else 
    $count = 0;
$str = (string)$count;
$count_total += $count;
if ( $str ) {
?>
<option value="#type_3"><span>Гараж</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $str; ?></option>
<?php
}
$type = 4;
if (isset($this->list_type[$type]))
    $count = $this->list_type[$type]['count'];
else 
    $count = 0;
$str = (string)$count;
$count_total += $count;
if ( $str ) {
?>
<option value="#type_4"><span>Коммерческая недвижимость</span>&nbsp;&nbsp;&nbsp;<?php echo $str; ?></option>
<?php
}
$type = 5;
if (isset($this->list_type[$type]))
    $count = $this->list_type[$type]['count'];
else 
    $count = 0;
$str = (string)$count;
$count_total += $count;
if ( $str ) {
?>

<option value="#type_5"><span>Кладовое помещение</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $str; ?></option>
<?php
}
$type = 6;
if (isset($this->list_type[$type]))
    $count = $this->list_type[$type]['count'];
else 
    $count = 0;
$str = (string)$count;
$count_total += $count;
if ( $str ) {
?>

<option value="#type_6"><span>Земельный участок</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $str; ?></option>
<?php } ?>
</select>
<p id="p-total-count">Всего объектов в базе: <a title="Перейти на заглавную страницу каталога." href="/catalogue/"><strong> <?php echo $count_total ?></strong></a></p>
<?php
/*
<div id="filter-types-list-onmain">
<ul id="ul-bookmark">
<li class="current-bookmark-li">
<span class="current-bookmark-span"><a class="length_very_small" href="/catalogue/type/1/#type_1"><span>Вид объекта</span></a></span>
</li>
<li class="down-bookmark-li">

<ul class="ul-bookmark-down">
<li class="bookm-flop"><a rel="length_very_small" class="corners1" href="/catalogue/type/1/#type_1"><span>Квартира</span></a></li>
<li class="bookm-flop"><a rel="length_very_small" class="corners1" href="/catalogue/type/3/#type_3"><span>Гараж</span></a></li>
<li class="bookm-flop"><a rel="length_big_2lines" class="corners1 length_big_2lines" href="/catalogue/type/4/#type_4"><span>Нежилое помещение</span></a></li>
<li class="bookm-flop"><a rel="length_very_small" class="corners1 length_big_2lines" href="/catalogue/type/5/#type_5"><span>Кладовка</span></a></li>
</ul>

</li>
</ul> </div>
*/
?>

</div> <!--/ Временно -->
</div></div></div></div>
</div></div>

 <div class="div-inline-4 div-inline-4-2"><div class="div-inline-inside">  <h4><span>продавец</span></h4>
<div class="filter-border-1"><div class="filter-border-2"><div class="filter-border-3"><div class="filter-border-4">
<div class="header-filter-cell"> <!-- Временно -->
<?php if ($this->subdomainFocusUserId) { ?>
    <p style="text-align:center; font-size: 16px; padding-top: 1px; margin-top:1px;"><strong><?php echo $this->subdomainFocusUserData->contact_name; ?></strong></p>
<?php } else { ?>
<select multiple="multiple" size="4" id="select-seller">
<option class="opt-main" value="a" selected="selected"><a rel="length_very_small" class="corners1 length_big_2lines" href="#0"><span>Все</span></a></option>
<option class="opt-main" value="sk"><strong>Строительные компании</strong></option>
<?php foreach (Special_Vtor_Data::$sellerSpecial as $value) {
    if ($value['type'] == 1000 or $value['type'] == 30) {
        
//<li class="seller-flop"><a rel="length_very_small" class="corners1" href="#96"><span>СК «Владар»</span></a></li>
//<li class="seller-flop"><a rel="length_very_small" class="corners1 length_big_2lines" href="#112"><span>СК «Зеленый сад»</span></a></li>
        
    ?>
<option class="sk" rel="sk" value="<?php echo $value['id']; ?>">&nbsp;&nbsp;<span><?php echo $value['name']; ?></span></option>

<?php } } ?>
<option class="opt-main" value="an"><strong>Агенства недвижимости</strong></option>
<?php foreach (Special_Vtor_Data::$sellerSpecial as $value) {
    if ($value['type'] == 1000 or  $value['type'] == 20) {
        
//<li class="seller-flop"><a rel="length_very_small" class="corners1" href="#96"><span>СК «Владар»</span></a></li>
//<li class="seller-flop"><a rel="length_very_small" class="corners1 length_big_2lines" href="#112"><span>СК «Зеленый сад»</span></a></li>
        
    ?>
<option class="an" value="<?php echo $value['id']; ?>">&nbsp;&nbsp;<span><?php echo $value['name']; ?></span></option>

<?php } } ?>

<option class="opt-main" value="f"><a rel="length_very_small" class="corners1 length_big_2lines" href="#f"><span>Физ. лица</span></a></option>
</select>

<?php } ?>
</div> <!--/ Временно -->
</div></div></div></div>
</div></div>


<div class="div-inline-4 div-inline-4-3"><div class="div-inline-inside">  <h4><span>рубрика</span></h4>
<div class="filter-border-1"><div class="filter-border-2"><div class="filter-border-3"><div class="filter-border-4">
<div class="header-filter-cell"> <!-- Временно -->
 
<select size="4"  id="select-deal">
<option id="filter-deal-list-sale" value="sale">продам</option>
<?php if (!$this->subdomainFocusUserId) { ?>
<option id="filter-deal-list-sale-request" value="request_sale">куплю</option>
<option id="filter-deal-list-rent-request" value="request_rent">арендую</option>
<?php } ?>
<option id="filter-deal-list-rent" value="rent">сдам в аренду</option>
</select>

</div> <!--/ Временно -->
</div></div></div></div>
</div></div>


<div class="div-inline-4 div-inline-4-4"><div class="div-inline-inside">  <h4><span>дополнительно</span></h4>
<div class="filter-border-1"><div class="filter-border-2"><div class="filter-border-3"><div class="filter-border-4">
<div class="header-filter-cell"> <!-- Временно -->

<ul class="ul-like-table" id="total-add-list">
<li><span class="span-block"><input type="checkbox" id="filter-panorama" /> <label for="filter-panorama">c панорамой</label></span></li>
<?php if (!$this->subdomainFocusUserId) { ?>
<li><span class="span-block"><input type="checkbox" id="filter-online" /> <label for="filter-online">продавец на сайте</label></span></li>
<li><span class="span-block"><input type="checkbox" id="filter-fseller" /> <label for="filter-fseller">без посредников</label></span></li>
<?php } ?>
</ul>

</div> <!--/ Временно -->
</div></div></div></div>
</div></div>

<input id="to-find-top-bottom" type="image" style="z-index:100;" src="<?php echo $this->view_folder;?>/img/search.png" name="go" value="Найти" alt="Поиск недвижимости в Рязани" title="Поиск недвижимости в Рязани" />
 
</div>


<div id="bookmark-filter-main-list">
<?php if (key_exists(1, $this->list_type)) { ?>
<form method="post" action="/catalogue/type/1/" id="type_1_form">
<input type="hidden" value="0" name="rent" class="filter-deal-list-rent" />
<input type="hidden" value="0" name="sale" class="filter-deal-list-sale" />

<input type="hidden" value="0" name="req_rent" class="filter-deal-list-rent-request" />
<input type="hidden" value="0" name="req_sale" class="filter-deal-list-sale-request" />

<input type="hidden" value="0" name="have_panorama" class="filter-panorama" />
<input type="hidden" value="0" name="online" class="filter-online" />
<input type="hidden" value="0" name="seller" class="filter-seller" />
<input type="hidden" value="0" name="fseller" class="filter-fseller" />
<div id="type_1" class="bookmark-filter-main-content">

<div class="div-inline-4 div-inline-4-1"><div class="div-inline-inside">  <h4><span>адрес</span></h4>
<div class="filter-border-1"><div class="filter-border-2"><div class="filter-border-3"><div class="filter-border-4">
<div class="filter-one-info-cell"> <!-- Временно -->
<p id="city-name"><a href="/catalogue/type/1/adress/1/1/1/">Рязань </a><span class="adress-count-city"><?php echo $this->count_in_ryazan_type_1; ?></span></p>
<div style="padding: 0 2px 0 0; margin:0;" >
<?php echo $this->adress_type_1 ?>
</div>


</div> <!--/ Временно -->
</div></div></div></div>
</div></div>

<div class="div-inline-4 div-inline-4-2"><div class="div-inline-inside small-arrow"> <h4><span>тип дома</span></h4>
<div class="filter-border-1"><div class="filter-border-2"><div class="filter-border-3"><div class="filter-border-4">
<!-- тип дома -->
<div class="type-condition-content">
<?php 
$x = 0;
if (count($this->house_type) > 1)
{ $x++?>
<ul class="ul-like-table">
<?php foreach ($this->house_type as $key => $value) {?>
 <li>
 <span class="span-block">
 <input type="checkbox" name="house_type[<?php echo $value['id'];?>]" value="<?php echo $value['id'];?>" /> <?php echo $value['name']; ?>
 </span>
 </li>
 
 <?php } ?>
</ul>
<?php }?>
<!--/ тип дома -->
</div>
</div></div></div></div>
</div></div>

<div class="div-inline-4 div-inline-4-3"><div class="div-inline-inside small-arrow">  <h4><span>состояние</span></h4>
<div class="filter-border-1"><div class="filter-border-2"><div class="filter-border-3"><div class="filter-border-4">
<!-- состояние -->
<div class="type-condition-content">
<?php 
$x = 0;
if (count($this->condition_room) > 1)
{ $x++?>
<ul class="ul-like-table">
<?php foreach ($this->condition_room as $key => $value) {?>
 <li>
 <span class="span-block" >
 <input type="checkbox" name="condition[<?php echo $value['id'];?>]" value="<?php echo $value['id'];?>" /> 
 
 <?php echo $value['name']; ?>
 </span>
 </li>
 
 <?php } ?>
</ul>
<?php }?>
<!--/ состяние -->
</div>
</div></div></div></div>
</div></div>

<div class="div-inline-4 div-inline-4-4"><div class="div-inline-inside small-arrow"> <h4><span>параметры</span></h4>
<div class="filter-border-1"><div class="filter-border-2"><div class="filter-border-3"><div class="filter-border-4">

<div class="filter-one-info-cell">

<h5>основные:</h5>
<ul class="ul-parameters" style="margin: 5px 0 0 0;">
 <li>площадь: с <input type="text" name="value_from" value="<?php echo $this->saved['value_from']; ?>" size="7">
 по <input type="text" name="value_to" value="<?php echo $this->saved['value_to']; ?>" size="7">&nbsp;м<span style="font-size:10px; vertical-align:super">2</span></a>
 </li>

  <li>цена:<span class="space-correct-on-main">&nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp; с <input type="text" name="price_from" value="<?php echo $this->saved['price_from']; ?>" size="7">
 по <input type="text" name="price_to" value="<?php echo $this->saved['price_to']; ?>" size="7"> руб.
 </li>
</ul>


<!-- Колво комнат -->
<h5>этаж:</h5>
<ul class="ul-like-table">
 <li>&nbsp;с <input type="text" name="floor_from" value="<?php echo $this->saved['floor_from']; ?>" size="2">
 по <input type="text" name="floor_to" value="<?php echo $this->saved['floor_to']; ?>" size="2">
 </li>
</ul>
<ul class="ul-like-table ul-like-table-100">
 <li>
 <span class="span-half"><input type="checkbox" name="floor_no_first" value="1" /> не первый</span>
 <span class="span-half"><input type="checkbox" name="floor_no_last" value="1" /> не последний</span>
 </li>
</ul> 

<h5>наличие:</h5>
<ul class="ul-like-table ul-like-table-100">
  <li>
  <span class="span-half"><input type="checkbox" name="photo" value="1" /> фото</span>
  <span class="span-half"><input type="checkbox" name="phone" value="1" /> телефон</span>
  </li>
</ul>

<h5>количество комнат:</h5>
<ul class="ul-like-table">
 <li><span><input type="checkbox" name="rooms_count_1" value="1" /> 1</span> &nbsp;
 <span><input type="checkbox" name="rooms_count_2" value="2" /> 2</span> &nbsp;
 <span><input type="checkbox" name="rooms_count_3" value="3" /> 3</span> &nbsp;
 <span><input type="checkbox" name="rooms_count_4" value="4" /> более 3-х</span></li>
 <li><input type="checkbox" name="levels" value="1" /> двухуровневые</li>
</ul>
<!--/ Колво комнат -->
</div>

</div></div></div></div>
</div></div>


<input type="hidden" name="filter" value="save" >
<input type="hidden" name="type" value="1" >
<p id="p-search-buttom">
<span class="show_bad_input">
<input type="checkbox" name="show_bad" value="1" checked="checked"/> <span>не показывать объявления без номера дома</span>
</span>
<input type="image" style="z-index:100;" src="<?php echo $this->view_folder;?>/img/search.png" name="go" value="Найти" alt="Поиск недвижимости в Рязани" title="Поиск недвижимости в Рязани" />
</p>


</div>
</form>
<!--------------------------------------------/ Закладка фильтра квартиры  --!>
<?php } ?>


<?php if (key_exists(3, $this->list_type)) { ?>
<!-------------------------------------------- Закладка фильтра гараж  -->
<form method="post" action="/catalogue/type/3/" id="type_3_form" >
<input type="hidden" value="0" name="rent" class="filter-deal-list-rent"/>
<input type="hidden" value="0" name="sale" class="filter-deal-list-sale" />
<input type="hidden" value="0" name="have_panorama" class="filter-panorama" />
<input type="hidden" value="0" name="online" class="filter-online" />
<input type="hidden" value="0" name="seller" class="filter-seller" />
<input type="hidden" value="0" name="fseller" class="filter-fseller" />
<div id="type_3" class="bookmark-filter-main-content">

<div class="div-inline-4 div-inline-4-1"><div class="div-inline-inside">  <h4><span>адрес</span></h4>
<div class="filter-border-1"><div class="filter-border-2"><div class="filter-border-3"><div class="filter-border-4">
<div class="filter-one-info-cell"> <!-- Временно -->
<p id="city-name"><a href="/catalogue/type/3/adress/1/1/1/">Рязань </a> <span class="adress-count-city"><?php echo $this->count_in_ryazan_type_3; ?></span></p>

<div style="padding: 0 2px 0 0;" >
<?php echo $this->adress_type_3 ?>
</div>                    

</div> <!--/ Временно -->
</div></div></div></div>
</div></div>


<?php
if (count($this->condition_pantry) > 1) { ?>
<div class="div-inline-4 div-inline-4-3"><div class="div-inline-inside small-arrow">  <h4><span>состояние</span></h4>
<div class="filter-border-1"><div class="filter-border-2"><div class="filter-border-3"><div class="filter-border-4">
<!-- состояние -->
<div class="type-condition-content">
<?php 
$x = 0;
 $x++?>
<ul class="ul-like-table">
<?php foreach ($this->condition_nolife as $key => $value) {?>
 <li<?php if ($value['order'] == 500) {?> style="border-top: 1px dotted #B0AFAF; padding-top: 3px"<?php  } ?>>
 <span class="span-block" >
 <input type="checkbox" name="condition[<?php echo $value['id'];?>]" value="<?php echo $value['id'];?>" /> <?php echo $value['name']; ?>
 </span>
 </li>
 <?php } ?>
</ul>
<!--/ состяние -->
</div>
</div></div></div></div>
</div></div>
<?php }?>


<div class="div-inline-4 div-inline-4-4"><div class="div-inline-inside small-arrow"> <h4><span>параметры</span></h4>
<div class="filter-border-1"><div class="filter-border-2"><div class="filter-border-3"><div class="filter-border-4">

<div class="filter-one-info-cell">

<h5>основные:</h5>
<ul class="ul-parameters" style="margin: 5px 0 0 0;">
 <li>площадь: с <input type="text" name="value_from" value="<?php echo $this->saved['value_from']; ?>" size="7">
 по <input type="text" name="value_to" value="<?php echo $this->saved['value_to']; ?>" size="7">&nbsp;м<span style="font-size:10px; vertical-align:super">2</span></a>
 </li>

  <li>цена:<span class="space-correct-on-main">&nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp; с <input type="text" name="price_from" value="<?php echo $this->saved['price_from']; ?>" size="7">
 по <input type="text" name="price_to" value="<?php echo $this->saved['price_to']; ?>" size="7"> руб.
 </li>
</ul>


<!-- Этаж  -->
<h5></h5>

<ul class="ul-parameters">
 </ul>
  
<ul class="ul-like-table">
 <li><input type="checkbox" name="floor_socle" value="1" /> подземная парковка</li>
</ul> 


<h5>наличие:</h5>
<ul class="ul-like-table ul-like-table-100">
  <li>
  <span class="span-half"><input type="checkbox" name="photo" value="1" /> фото</span>
  <span class="span-half"><input type="checkbox" name="phone" value="1" /> телефон</span>
  </li>
</ul>

<!--/ Колво комнат -->
</div>

</div></div></div></div>
</div></div>





<input type="hidden" name="filter" value="save" >
<input type="hidden" name="type" value="3" >
<p id="p-search-buttom">

<span class="show_bad_input">
<input type="checkbox" name="show_bad" value="1" checked="checked"/> <span>не показывать объявления без номера дома</span>
</span>

<input type="image" style="z-index:100;" src="<?php echo $this->view_folder;?>/img/search.png" name="go" value="Найти" alt="Поиск недвижимости в Рязани" title="Поиск недвижимости в Рязани" />
</p>

</div></form>
<!--------------------------------------------/ Закладка фильтра гараж  -->
<?php } ?>


<?php if (key_exists(4, $this->list_type)) { ?>
<!-------------------------------------------- Закладка фильтра нежилое  -->
<form method="post" action="/catalogue/type/4/" id="type_4_form" >
<input type="hidden" value="0" name="rent" class="filter-deal-list-rent" />
<input type="hidden" value="0" name="sale" class="filter-deal-list-sale" />
<input type="hidden" value="0" name="have_panorama" class="filter-panorama" />
<input type="hidden" value="0" name="online" class="filter-online" />
<input type="hidden" value="0" name="seller" class="filter-seller" />
<input type="hidden" value="0" name="fseller" class="filter-fseller" />
<div id="type_4" class="bookmark-filter-main-content">

<div class="div-inline-4 div-inline-4-1"><div class="div-inline-inside">  <h4><span>адрес</span></h4>
<div class="filter-border-1"><div class="filter-border-2"><div class="filter-border-3"><div class="filter-border-4">
<div class="filter-one-info-cell"> <!-- Временно -->
<p id="city-name"><a href="/catalogue/type/4/adress/1/1/1/">Рязань</a> <span class="adress-count-city"><?php echo $this->count_in_ryazan_type_4; ?></span></p>

<div style="padding: 0 2px 0 0;" >
<?php echo $this->adress_type_4 ?>
</div>

</div> <!--/ Временно -->
</div></div></div></div>
</div></div>








<div class="div-inline-4 div-inline-4-2"><div class="div-inline-inside small-arrow"> <h4><span>тип дома</span></h4>
<div class="filter-border-1"><div class="filter-border-2"><div class="filter-border-3"><div class="filter-border-4">
<!-- тип дома -->
<div class="type-condition-content">
<?php 
$x = 0;
if (count($this->house_type_nolife) > 1)
{ $x++?>
<ul class="ul-like-table">
<?php foreach ($this->house_type_nolife as $key => $value) {?>
 <li>
 <span class="span-block">
 <input type="checkbox" name="house_type[<?php echo $value['id'];?>]" value="<?php echo $value['id'];?>" /> 
 <?php echo $value['name']; ?>
 </span>
 </li>
 <?php } ?>
</ul>
<?php }?>
<!--/ тип дома -->
</div>

</div></div></div></div>
</div></div>

<div class="div-inline-4 div-inline-4-3"><div class="div-inline-inside small-arrow">  <h4><span>состояние</span></h4>
<div class="filter-border-1"><div class="filter-border-2"><div class="filter-border-3"><div class="filter-border-4">
<!-- состояние -->
<div class="type-condition-content">
<?php 
$x = 0;
if (count($this->condition_nolife) > 1)
{ $x++?>
<ul class="ul-like-table">
<?php foreach ($this->condition_nolife as $key => $value) {?>
 <li<?php if ($value['order'] == 500) {?> style="border-top: 1px dotted #B0AFAF; padding-top: 3px"<?php  } ?>>
 <span class="span-block">
 <input type="checkbox" name="condition[<?php echo $value['id'];?>]" value="<?php echo $value['id'];?>" /> <?php echo $value['name']; ?>
 </span>
 </li>
 <?php } ?>
</ul>
<?php }?>
<!--/ состяние -->
</div>
</div></div></div></div>
</div></div>

<div class="div-inline-4 div-inline-4-4"><div class="div-inline-inside small-arrow"> <h4><span>параметры</span></h4>
<div class="filter-border-1"><div class="filter-border-2"><div class="filter-border-3"><div class="filter-border-4">

<div class="filter-one-info-cell">

<h5>основные:</h5>
<ul class="ul-parameters" style="margin: 5px 0 0 0;">
 <li>площадь: с <input type="text" name="value_from" value="<?php echo $this->saved['value_from']; ?>" size="7">
 по <input type="text" name="value_to" value="<?php echo $this->saved['value_to']; ?>" size="7">&nbsp;м<span style="font-size:10px; vertical-align:super">2</span></a>
 </li>

  <li>цена:<span class="space-correct-on-main">&nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp; с <input type="text" name="price_from" value="<?php echo $this->saved['price_from']; ?>" size="7">
 по <input type="text" name="price_to" value="<?php echo $this->saved['price_to']; ?>" size="7"> руб.
 </li>
</ul>


<!-- Колво комнат -->
<h5>этаж:</h5>
<ul class="ul-like-table">
 <li>&nbsp;с <input type="text" name="floor_from" value="<?php echo $this->saved['floor_from']; ?>" size="2">
 по <input type="text" name="floor_to" value="<?php echo $this->saved['floor_to']; ?>" size="2">
 </li>
</ul>
<ul class="ul-like-table">
 <li><input type="checkbox" name="floor_socle" value="1" /> цокольный этаж</li>
</ul> 


<h5>наличие:</h5>
<ul class="ul-like-table ul-like-table-100">
  <li>
  <span class="span-half"><input type="checkbox" name="photo" value="1" /> фото</span>
  <span class="span-half"><input type="checkbox" name="phone" value="1" /> телефон</span>
  </li>
</ul>

<!--/ Колво комнат -->
</div>

</div></div></div></div>
</div></div>



<input type="hidden" name="filter" value="save" >
<input type="hidden" name="type" value="4" >



<p id="p-search-buttom">

<span class="show_bad_input">
<input type="checkbox" name="show_bad" value="1" checked="checked"/> <span>не показывать объявления без номера дома</span>
</span>


<input type="image" style="z-index:100;" src="<?php echo $this->view_folder;?>/img/search.png" name="go" value="Найти" alt="Поиск недвижимости в Рязани" title="Поиск недвижимости в Рязани" />
</p>

</div></form>

<!--------------------------------------------/ Закладка фильтра нежилое  -->
<?php } ?>







<?php if (key_exists(5, $this->list_type)) { ?>
<!-------------------------------------------- Закладка фильтра кладовые  -->
<form method="post" action="/catalogue/type/5/" id="type_5_form">
<input type="hidden" value="0" name="rent" class="filter-deal-list-rent" />
<input type="hidden" value="0" name="sale" class="filter-deal-list-sale" />
<input type="hidden" value="0" name="have_panorama" class="filter-panorama" />
<input type="hidden" value="0" name="online" class="filter-online" />
<input type="hidden" value="0" name="seller" class="filter-seller" />
<input type="hidden" value="0" name="fseller" class="filter-fseller" />
<div id="type_5" class="bookmark-filter-main-content">

<div class="div-inline-4 div-inline-4-1"><div class="div-inline-inside">  <h4><span>адрес</span></h4>
<div class="filter-border-1"><div class="filter-border-2"><div class="filter-border-3"><div class="filter-border-4">
<div class="filter-one-info-cell"> <!-- Временно -->
<p id="city-name"><a href="/catalogue/type/5/adress/1/1/1/">Рязань</a> <span class="adress-count-city"><?php echo $this->count_in_ryazan_type_5; ?></span></p>

<div style="padding: 0 2px 0 0;" >
<?php echo $this->adress_type_5 ?>
</div>                    

</div> <!--/ Временно -->
</div></div></div></div>
</div></div>


<?php 
$x = 0;
if (count($this->condition_pantry) > 1)
{ $x++?>
<div class="div-inline-4 div-inline-4-3"><div class="div-inline-inside small-arrow">  <h4><span>состояние</span></h4>
<div class="filter-border-1"><div class="filter-border-2"><div class="filter-border-3"><div class="filter-border-4">
<!-- состояние -->
<div class="type-condition-content">
<ul class="ul-like-table">
<?php foreach ($this->condition_nolife as $key => $value) {?>
 <li<?php if ($value['order'] == 500) {?> style="border-top: 1px dotted #B0AFAF; padding-top: 3px"<?php  } ?>>
 <span class="span-block">
 <input type="checkbox" name="condition[<?php echo $value['id'];?>]" value="<?php echo $value['id'];?>" /> <?php echo $value['name']; ?>
 </span>
 </li>
 <?php } ?>
</ul>
<!--/ состяние -->
</div>
</div></div></div></div>
</div></div>
<?php }?>

<div class="div-inline-4 div-inline-4-4"><div class="div-inline-inside small-arrow"> <h4><span>параметры</span></h4>
<div class="filter-border-1"><div class="filter-border-2"><div class="filter-border-3"><div class="filter-border-4">

<div class="filter-one-info-cell">

<h5>основные:</h5>
<ul class="ul-parameters" style="margin: 5px 0 0 0;">
 <li>площадь: с <input type="text" name="value_from" value="<?php echo $this->saved['value_from']; ?>" size="7">
 по <input type="text" name="value_to" value="<?php echo $this->saved['value_to']; ?>" size="7">&nbsp;м<span style="font-size:10px; vertical-align:super">2</span></a>
 </li>

  <li>цена:<span class="space-correct-on-main">&nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp; с <input type="text" name="price_from" value="<?php echo $this->saved['price_from']; ?>" size="7">
 по <input type="text" name="price_to" value="<?php echo $this->saved['price_to']; ?>" size="7"> руб.
 </li>
</ul>


<!-- Колво комнат -->
<h5>этаж:</h5>
<ul class="ul-like-table">
 <li>&nbsp;с <input type="text" name="floor_from" value="<?php echo $this->saved['floor_from']; ?>" size="2">
 по <input type="text" name="floor_to" value="<?php echo $this->saved['floor_to']; ?>" size="2">
 </li>
</ul>
<ul class="ul-like-table">
 <li><input type="checkbox" name="floor_socle" value="1" /> цокольный этаж</li>
</ul> 


<h5>наличие:</h5>
<ul class="ul-like-table ul-like-table-100">
  <li>
  <span class="span-half"><input type="checkbox" name="photo" value="1" /> фото</span>
  <span class="span-half"><input type="checkbox" name="phone" value="1" /> телефон</span>
  </li>
</ul>

<!--/ Колво комнат -->
</div>

</div></div></div></div>
</div></div>


<input type="hidden" name="filter" value="save" >
<input type="hidden" name="type" value="5" >
<p id="p-search-buttom">

<span class="show_bad_input">
<input type="checkbox" name="show_bad" value="1" checked="checked"/> <span>не показывать объявления без номера дома</span>
</span>


<input type="image" style="z-index:100;" src="<?php echo $this->view_folder;?>/img/search.png" name="go" value="Найти" alt="Поиск недвижимости в Рязани" title="Поиск недвижимости в Рязани" />
</p>

</div></form>
<!--------------------------------------------/ Закладка фильтра кладовые  -->
<?php } ?>




















<?php if (key_exists(2, $this->list_type)) { ?>
<!-------------------------------------------- Закладка фильтра дома  -->
<form method="post" action="/catalogue/type/2/" id="type_2_form">
<input type="hidden" value="0" name="rent" class="filter-deal-list-rent" />
<input type="hidden" value="0" name="sale" class="filter-deal-list-sale" />
<input type="hidden" value="0" name="have_panorama" class="filter-panorama" />
<input type="hidden" value="0" name="online" class="filter-online" />
<input type="hidden" value="0" name="seller" class="filter-seller" />
<input type="hidden" value="0" name="fseller" class="filter-fseller" />
<div id="type_2" class="bookmark-filter-main-content">

<div class="div-inline-4 div-inline-4-1"><div class="div-inline-inside">  <h4><span>адрес</span></h4>
<div class="filter-border-1"><div class="filter-border-2"><div class="filter-border-3"><div class="filter-border-4">
<div class="filter-one-info-cell"> <!-- Временно -->
<p id="city-name"><a href="/catalogue/type/2/adress/1/1/1/">Рязань</a> <span class="adress-count-city"><?php echo $this->count_in_ryazan_type_2; ?></span></p>

<div style="padding: 0 2px 0 0;" >
<?php echo $this->adress_type_2 ?>
</div>                    

</div> <!--/ Временно -->
</div></div></div></div>
</div></div>


<?php 
$x = 0;
if (count($this->condition_pantry) > 1)
{ $x++?>
<div class="div-inline-4 div-inline-4-2"><div class="div-inline-inside small-arrow">  <h4><span>тип</span></h4>
<div class="filter-border-1"><div class="filter-border-2"><div class="filter-border-3"><div class="filter-border-4">
<!-- состояние -->
<div class="type-condition-content">
<ul class="ul-like-table">
<?php foreach ($this->house_type_add as $key => $value) {?>
 <li>
 <span class="span-block">
 <input type="checkbox" name="type_add[<?php echo $value['id'];?>]" value="<?php echo $value['id'];?>" /> <?php echo $value['name']; ?>
 </span>
 </li>
 <?php } ?>
</ul>
<!--/ состяние -->
</div>
</div></div></div></div>
</div></div>
<?php }?>


<?php 
$x = 0;
if (count($this->condition_pantry) > 1)
{ $x++?>
<div class="div-inline-4 div-inline-4-3"><div class="div-inline-inside small-arrow">  <h4><span>материал стен</span></h4>
<div class="filter-border-1"><div class="filter-border-2"><div class="filter-border-3"><div class="filter-border-4">
<!-- состояние -->
<div class="type-condition-content">
<ul class="ul-like-table">
<?php foreach ($this->house_type_wall as $key => $value) {?>
 <li>
 <span class="span-block">
 <input type="checkbox" name="type_wall[<?php echo $value['id'];?>]" value="<?php echo $value['id'];?>" /> <?php echo $value['name']; ?>
 </span>
 </li>
 <?php } ?>
</ul>
<!--/ состяние -->
</div>
</div></div></div></div>
</div></div>
<?php }?>


<div class="div-inline-4 div-inline-4-4"><div class="div-inline-inside small-arrow"> <h4><span>параметры</span></h4>
<div class="filter-border-1"><div class="filter-border-2"><div class="filter-border-3"><div class="filter-border-4">

<div class="filter-one-info-cell">

<h5>основные:</h5>
<ul class="ul-parameters" style="margin: 5px 0 0 0;">
 <li>площадь: с <input type="text" name="value_from" value="<?php echo $this->saved['value_from']; ?>" size="7">
 по <input type="text" name="value_to" value="<?php echo $this->saved['value_to']; ?>" size="7">&nbsp;м<span style="font-size:10px; vertical-align:super">2</span></a>
 </li>

  <li>цена:<span class="space-correct-on-main">&nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp; с <input type="text" name="price_from" value="<?php echo $this->saved['price_from']; ?>" size="7">
 по <input type="text" name="price_to" value="<?php echo $this->saved['price_to']; ?>" size="7"> руб.
 </li>
</ul>


<!-- Колво комнат -->
<h5>этажность:</h5>
<ul class="ul-like-table">
 <li><span><input type="checkbox" name="floor_count_1" value="1" /> 1</span> &nbsp;
 <span><input type="checkbox" name="floor_count_2" value="1" /> 2</span> &nbsp;
 <li><input type="checkbox" name="floor_count_0" value="1" /> более 2-х</li>
</ul>

<h5>наличие:</h5>
<ul class="ul-like-table ul-like-table-100">
  <li>
  <span class="span-half"><input type="checkbox" name="photo" value="1" /> фото</span>
  <span class="span-half"><input type="checkbox" name="phone" value="1" /> телефон</span>
  </li>
</ul>

<!--/ Колво комнат -->
</div>

</div></div></div></div>
</div></div>


<input type="hidden" name="filter" value="save" >
<input type="hidden" name="type" value="2" >
<p id="p-search-buttom">

<span class="show_bad_input">
<input type="checkbox" name="show_bad" value="1" checked="checked"/> <span>не показывать объявления без номера дома</span>
</span>


<input type="image" style="z-index:100;" src="<?php echo $this->view_folder;?>/img/search.png" name="go" value="Найти" alt="Поиск недвижимости в Рязани" title="Поиск недвижимости в Рязани" />
</p>

</div></form>
<!--------------------------------------------/ Закладка фильтра дома  -->
<?php } ?>





















<?php if (key_exists(6, $this->list_type)) { ?>
<!-------------------------------------------- Закладка фильтра зем. уч.  -->
<form method="post" action="/catalogue/type/6/" id="type_6_form">
<input type="hidden" value="0" name="rent" class="filter-deal-list-rent" />
<input type="hidden" value="0" name="sale" class="filter-deal-list-sale" />
<input type="hidden" value="0" name="have_panorama" class="filter-panorama" />
<input type="hidden" value="0" name="online" class="filter-online" />
<input type="hidden" value="0" name="seller" class="filter-seller" />
<input type="hidden" value="0" name="fseller" class="filter-fseller" />
<div id="type_6" class="bookmark-filter-main-content">

<div class="div-inline-4 div-inline-4-1"><div class="div-inline-inside">  <h4><span>адрес</span></h4>
<div class="filter-border-1"><div class="filter-border-2"><div class="filter-border-3"><div class="filter-border-4">
<div class="filter-one-info-cell"> <!-- Временно -->
<p id="city-name"><a href="/catalogue/type/6/adress/1/1/1/">Рязань</a> <span class="adress-count-city"><?php echo $this->count_in_ryazan_type_6; ?></span></p>

<div style="padding: 0 2px 0 0;" >
<?php echo $this->adress_type_6 ?>
</div>                    

</div> <!--/ Временно -->
</div></div></div></div>
</div></div>


<?php 
$x = 0;
if (false)
{ $x++?>
<div class="div-inline-4 div-inline-4-2"><div class="div-inline-inside small-arrow">  <h4><span>тип</span></h4>
<div class="filter-border-1"><div class="filter-border-2"><div class="filter-border-3"><div class="filter-border-4">
<!-- состояние -->
<div class="type-condition-content">
<ul class="ul-like-table">
<?php foreach ($this->house_type_add as $key => $value) {?>
 <li>
 <span class="span-block">
 <input type="checkbox" name="type_add[<?php echo $value['id'];?>]" value="<?php echo $value['id'];?>" /> <?php echo $value['name']; ?>
 </span>
 </li>
 <?php } ?>
</ul>
<!--/ состяние -->
</div>
</div></div></div></div>
</div></div>
<?php }?>



<div class="div-inline-4 div-inline-4-4"><div class="div-inline-inside small-arrow"> <h4><span>параметры</span></h4>
<div class="filter-border-1"><div class="filter-border-2"><div class="filter-border-3"><div class="filter-border-4">

<div class="filter-one-info-cell">

<h5>основные:</h5>
<ul class="ul-parameters" style="margin: 5px 0 0 0;">
 <li>площадь: с <input type="text" name="value_from_land" value="<?php echo $this->saved['value_from_land']; ?>" size="7">
 по <input type="text" name="value_to_land" value="<?php echo $this->saved['value_to_land']; ?>" size="7">&nbsp;соток</a>
 </li>

  <li>цена:<span class="space-correct-on-main">&nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp; с <input type="text" name="price_from" value="<?php echo $this->saved['price_from']; ?>" size="7">
 по <input type="text" name="price_to" value="<?php echo $this->saved['price_to']; ?>" size="7"> руб.
 </li>
</ul>


<h5>наличие:</h5>
<ul class="ul-like-table ul-like-table-100">
  <li>
  <span class="span-half"><input type="checkbox" name="photo" value="1" /> фото</span>
  </li>
</ul>

<!--/ Колво комнат -->
</div>

</div></div></div></div>
</div></div>


<input type="hidden" name="filter" value="save" >
<input type="hidden" name="type" value="6" >
<p id="p-search-buttom">

<span class="show_bad_input">
<input type="checkbox" name="show_bad" value="1" checked="checked"/> <span>не показывать объявления без номера дома</span>
</span>


<input type="image" style="z-index:100;" src="<?php echo $this->view_folder;?>/img/search.png" name="go" value="Найти" alt="Поиск недвижимости в Рязани" title="Поиск недвижимости в Рязани" />
</p>

</div></form>
<!--------------------------------------------/ Закладка фильтра дома  -->
<?php } ?>








</div>

<div class="ugol-left-top"></div>
<div class="ugol-left-bottom"></div>
<div class="ugol-right-top"></div>
<div class="ugol-right-bottom"></div>
</div>


<div id="main-page-filter1">


</div>
