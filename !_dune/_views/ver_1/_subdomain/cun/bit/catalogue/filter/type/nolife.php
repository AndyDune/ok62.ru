<span style="display:block; height: 40px; overflow:hidden; margin:0; padding:0;">&nbsp;</span>
<div id="catalogue-filter"><span style="display:block; height: 10px; overflow:hidden; margin:0; padding:0;">&nbsp;</span>
<div id="catalogue-filter-inside">
<h2>Поиск</h2>

<form method="post">
<p class="p-submit">
<input type="submit" name="save" value="Искать" />
<?php if ($this->saved['have']) 
{
    ?><input type="submit" name="clear" value="Сбросить" /><?php
}
?>
</p>

<?php if (Special_Vtor_Users::$sellerSelectInFilter) { ?>
<h4>Продавец:</h4>
<div class="filter-border-1"><div class="filter-border-2"><div class="filter-border-3"><div class="filter-border-4">
<div class="div-container">
<div style="padding: 5px;">
<ul class="ul-like-table ul-like-table-100">

<li>
<?php
//echo $session = Dune_Session::getInstance('filter');
?>

<select multiple="multiple" size="4" id="select-seller" name="seller_array[]">
<?php
if ($this->saved['seller_all'])
    $select = ' selected="selected"';
else 
    $select = '';
?>
<option class="opt-main" value="a"<?php echo $select; ?>><span>Все</span></option>

<?php
if (!is_array($this->saved['seller_array']))
    $this->saved['seller_array'] = array();
    
if ($this->saved['seller_sk'])
{
    $have_parent = true;
    $select = ' selected="selected"';
}
else 
{
    $have_parent = false;
    $select = '';
}
?>
<option class="opt-main" value="sk"<?php echo $select; ?>><strong>Строительные компании</strong></option>
<?php foreach (Special_Vtor_Data::$sellerSpecial as $value) {
    if ($value['type'] == 1000 or $value['type'] == 30) {
        
if (in_array($value['id'], $this->saved['seller_array']) or ($value['id'] == 'e' and $this->saved['seller_e'] ))
    $select = ' selected="selected"';
else 
    $select = '';
    ?>
<option class="sk" rel="sk" value="<?php echo $value['id']; ?>"<?php echo $select; ?>>&nbsp;&nbsp;<span><?php echo $value['name']; ?></span></option>

<?php } } ?>
<?php
if ($this->saved['seller_an'])
{
    $have_parent = true;
    $select = ' selected="selected"';
}
else 
{
    $have_parent = false;
    $select = '';
}
?>
<option class="opt-main" value="an"<?php echo $select; ?>><strong>Агенства недвижимости</strong></option>
<?php foreach (Special_Vtor_Data::$sellerSpecial as $value) {
    if ($value['type'] == 1000 or  $value['type'] == 20) {
        
if (in_array($value['id'], $this->saved['seller_array']))
    $select = ' selected="selected"';
else 
    $select = '';
        
    ?>
<option class="an" value="<?php echo $value['id']; ?>"<?php echo $select; ?>>&nbsp;&nbsp;<span><?php echo $value['name']; ?></span></option>

<?php } } ?>

<?php
if ($this->saved['seller_f'])
    $select = ' selected="selected"';
else 
    $select = '';
?>

<option class="opt-main" value="f"<?php echo $select; ?>><span>Физ. лица</span></option>

</select>



</li>



<li><input type="checkbox" name="online" value="1"<?php 
$this->saved->setDefaultValue(null);
if ($this->saved['online'])
{
    ?> checked="checked"<?php
}

?> /> продавец сейчас на сайте</li>

<li style="padding-top:5px;"><input type="checkbox" name="fseller" value="1"<?php 
$this->saved->setDefaultValue(null);
if ($this->saved['fseller'])
{
    ?> checked="checked"<?php
}

?> /> без посредников</li>

</ul>
</div>
</div>
</div></div></div></div>
<?php } ?>

<!-- рубрика -->
<h4>Рубрика</h4>
<div class="filter-border-1"><div class="filter-border-2"><div class="filter-border-3"><div class="filter-border-4">
<div class="div-container">
<div style="padding: 5px;">

<ul class="ul-like-table ul-like-table-100">
<?php if (Special_Vtor_Users::$rubricInFilter) { ?>
<li><input type="checkbox" name="request_sale" value="1" class="input-deal-request" /> куплю</li>
<?php } ?>
<li><input type="checkbox" name="sale" value="1" class="input-deal"<?php 
$this->saved->setDefaultValue(null);
if ($this->saved['deal'] === 2 or  $this->saved['deal'] === 0)
{
    ?> checked="checked"<?php
}

?> /> продам</li>
<?php if (Special_Vtor_Users::$rubricInFilter) { ?>
<li><input type="checkbox" name="request_sale" value="1" class="input-deal-request" /> арендую</li>
<?php } ?>
<li><input type="checkbox" name="rent" value="1"  class="input-deal"<?php 
$this->saved->setDefaultValue(null);
if ($this->saved['deal'] === 2 or  $this->saved['deal'] === 1)
{
    ?> checked="checked"<?php
}

?> /> сдам в аренду</li>
</ul>
</div>
</div>
</div></div></div></div>
<!--/ рубрика -->


<br />
<div class="filter-border-1"><div class="filter-border-2"><div class="filter-border-3"><div class="filter-border-4">
<div class="div-container">
<div style="padding: 5px;">

<ul class="ul-like-table ul-like-table-100">
<li><input type="checkbox" name="new_building_flag_0" value="1"<?php 
$this->saved->setDefaultValue(null);
if ($this->saved['new_building_flag_0'] === 1)
{
    ?> checked="checked"<?php
}

?> /> вторичный фонд</li>
<li><input type="checkbox" name="new_building_flag_1" value="1"<?php 
$this->saved->setDefaultValue(null);
if ($this->saved['new_building_flag_1'] === 1)
{
    ?> checked="checked"<?php
}

?> /> новостройка</li>
</ul>
</div>
</div>
</div></div></div></div>
<!--/ тип дома -->

<!-- Колво комнат -->
<h4>Параметры</h4>
<div class="filter-border-1"><div class="filter-border-2"><div class="filter-border-3"><div class="filter-border-4">
<div style="padding: 5px;">
<h5>этаж:</h5>
<ul class="ul-like-table ul-like-table-100">
  
 <li style="padding: 0 0 5px 22px;"><input type="checkbox" name="floor_socle" value="1" <?php
 if ($this->saved['floor_socle'])
 {
 ?>checked="checked" <?php    
 }
 ?>> цокольный</li>
 
 <li>с <input type="text" name="floor_from" value="<?php echo $this->saved['floor_from']; ?>" size="2">
 по <input type="text" name="floor_to" value="<?php echo $this->saved['floor_to']; ?>" size="2">
 </li>
</ul> 

<h5>основные:</h5>
<ul class="ul-param-two-on-line" style="margin: 5px 0 0 0;">
 <li>
 <p style="margin:0;padding:0;">
 площадь:
 с <input type="text" name="value_from" value="<?php echo $this->saved['value_from']; ?>" size="3">
</p>
<p style="margin:0;padding:2px 0 5px 62px; ">
по <input type="text" name="value_to" value="<?php echo $this->saved['value_to']; ?>" size="3"> м<sup>2</sup>
</p>
 </li>

  <li>
  <p style="margin:0;padding:0;">
  цена: с <input type="text" name="price_from" value="<?php echo $this->saved['price_from']; ?>" size="10">
  </p>
  <p style="margin:0; padding:2px 0 5px 36px; ">
 по <input type="text" name="price_to" value="<?php echo $this->saved['price_to']; ?>" size="10"> руб.
 </p>
 </li>
</ul>

<h5>наличие:</h5>
<ul class="ul-like-table ul-like-table-100">
 <li><input type="checkbox" name="photo" value="1" <?php
 if ($this->saved['photo'])
 {
 ?>checked="checked" <?php    
 }
 ?>> фото</li>

  <li><input type="checkbox" name="phone" value="1" <?php
 if ($this->saved['phone'])
 {
 ?>checked="checked" <?php    
 }
 ?>> телефон</li>
 
  <li><input type="checkbox" name="have_panorama" value="1" <?php
 if ($this->saved['have_panorama'])
 {
 ?>checked="checked" <?php    
 }
 ?>> панорама</li>

 
  <li><input type="checkbox" name="have_plan" value="1" <?php
 if ($this->saved['have_plan'])
 {
 ?>checked="checked" <?php    
 }
 ?>> планировка</li>

 
 </ul>


</div>

</div></div></div></div>
<!--/ Колво комнат -->

<!-- тип дома -->
<?php 
$x = 0;
if (count($this->house_type) > 1)
{ $x++?>
<h4>Тип дома</h4>
<div class="filter-border-1"><div class="filter-border-2"><div class="filter-border-3"><div class="filter-border-4">
<div class="div-container">
<div style="padding: 5px;">

<ul class="ul-like-table ul-like-table-100">
<?php foreach ($this->house_type as $key => $value) {?>
 <li><input type="checkbox" name="house_type[<?php echo $value['id'];?>]" value="<?php echo $value['id'];?>" <?php
 if (isset($this->saved['house_type'][$value['id']]))
 {
 ?>checked="checked" <?php    
 }
 ?>> <?php echo $value['name']; ?></li>
 <?php } ?>
</ul>
</div>
</div>
</div></div></div></div>
<?php }?>
<!--/ тип дома -->


<!-- состояние -->
<?php 
$x = 0;
if (count($this->condition) > 1)
{ $x++?>
  <h4>Состояние</h4>
<div class="filter-border-1"><div class="filter-border-2"><div class="filter-border-3"><div class="filter-border-4">
<div class="div-container">
<div style="padding: 5px;">
<ul class="ul-like-table ul-like-table-100">
<?php foreach ($this->condition as $key => $value) {?>
 <li><input type="checkbox" name="condition[<?php echo $value['id'];?>]" value="<?php echo $value['id'];?>" <?php
 if (isset($this->saved['condition'][$value['id']]))
 {
 ?>checked="checked" <?php    
 }
 ?>> <?php echo $value['name']; ?></li>
 <?php } ?>
</ul>
</div>
</div>
</div></div></div></div>
<?php }?>
<!--/ состяние -->


<h4>&nbsp;</h4>
<div class="filter-border-1"><div class="filter-border-2"><div class="filter-border-3"><div class="filter-border-4">
<div class="div-container">
<div style="padding: 5px;">
<ul class="ul-like-table ul-like-table-100">
<li><input type="checkbox" name="show_bad" value="1"<?php 
$this->saved->setDefaultValue(null);
if (!$this->saved['show_bad'])
{
    ?> checked="checked"<?php
}

?> /> <span> не показывать объявления без номера дома</span></li>
</ul>
</div>
</div>
</div></div></div></div>


<input type="hidden" name="filter" value="save" >
<input type="hidden" name="type" value="<?php echo $this->type;?>" >
<p id="p-submit">
<input type="submit" name="save" value="Искать" />
<?php if ($this->saved['have']) 
{
    ?><input type="submit" name="clear" value="Сбросить" /><?php
}
?>

</p>
</form>

</div>
&nbsp;
<div class="ugol-left-top"></div>
<div class="ugol-left-bottom"></div>
<div class="ugol-right-top"></div>
<div class="ugol-right-bottom"></div>

</div>
