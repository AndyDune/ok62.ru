<span style="display:block; height: 40px; overflow:hidden; margin:0; padding:0;">&nbsp;</span>
<div id="catalogue-filter"><span style="display:block; height: 10px; overflow:hidden; margin:0; padding:0;">&nbsp;</span>
<div id="catalogue-filter-inside">
<h2>�����</h2>

<form method="post">
<p class="p-submit">
<input type="submit" name="save" value="������" />
<?php if ($this->saved['have']) 
{
    ?><input type="submit" name="clear" value="��������" /><?php
}
?>
</p>

<?php if (Special_Vtor_Users::$sellerSelectInFilter) { ?>
<h4>��������:</h4>
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
<option class="opt-main" value="a"<?php echo $select; ?>><span>���</span></option>

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
<option class="opt-main" value="sk"<?php echo $select; ?>><strong>������������ ��������</strong></option>
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
<option class="opt-main" value="an"<?php echo $select; ?>><strong>�������� ������������</strong></option>
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

<option class="opt-main" value="f"<?php echo $select; ?>><span>���. ����</span></option>

</select>



</li>



<li><input type="checkbox" name="online" value="1"<?php 
$this->saved->setDefaultValue(null);
if ($this->saved['online'])
{
    ?> checked="checked"<?php
}

?> /> �������� ������ �� �����</li>

<li style="padding-top:5px;"><input type="checkbox" name="fseller" value="1"<?php 
$this->saved->setDefaultValue(null);
if ($this->saved['fseller'])
{
    ?> checked="checked"<?php
}

?> /> ��� �����������</li>

</ul>
</div>
</div>
</div></div></div></div>
<?php } ?>

<!-- ������� -->
<h4>�������</h4>
<div class="filter-border-1"><div class="filter-border-2"><div class="filter-border-3"><div class="filter-border-4">
<div class="div-container">
<div style="padding: 5px;">

<ul class="ul-like-table ul-like-table-100">
<?php if (Special_Vtor_Users::$rubricInFilter) { ?>
<li><input type="checkbox" name="request_sale" value="1" class="input-deal-request" /> �����</li>
<?php } ?>
<li><input type="checkbox" name="sale" value="1" class="input-deal"<?php 
$this->saved->setDefaultValue(null);
if ($this->saved['deal'] === 2 or  $this->saved['deal'] === 0)
{
    ?> checked="checked"<?php
}

?> /> ������</li>
<?php if (Special_Vtor_Users::$rubricInFilter) { ?>
<li><input type="checkbox" name="request_sale" value="1" class="input-deal-request" /> �������</li>
<?php } ?>
<li><input type="checkbox" name="rent" value="1"  class="input-deal"<?php 
$this->saved->setDefaultValue(null);
if ($this->saved['deal'] === 2 or  $this->saved['deal'] === 1)
{
    ?> checked="checked"<?php
}

?> /> ���� � ������</li>
</ul>
</div>
</div>
</div></div></div></div>
<!--/ ������� -->


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

?> /> ��������� ����</li>
<li><input type="checkbox" name="new_building_flag_1" value="1"<?php 
$this->saved->setDefaultValue(null);
if ($this->saved['new_building_flag_1'] === 1)
{
    ?> checked="checked"<?php
}

?> /> �����������</li>
</ul>
</div>
</div>
</div></div></div></div>
<!--/ ��� ���� -->

<!-- ����� ������ -->
<h4>���������</h4>
<div class="filter-border-1"><div class="filter-border-2"><div class="filter-border-3"><div class="filter-border-4">
<div style="padding: 5px;">
<h5>����:</h5>
<ul class="ul-like-table ul-like-table-100">
  
 <li style="padding: 0 0 5px 22px;"><input type="checkbox" name="floor_socle" value="1" <?php
 if ($this->saved['floor_socle'])
 {
 ?>checked="checked" <?php    
 }
 ?>> ���������</li>
 
 <li>� <input type="text" name="floor_from" value="<?php echo $this->saved['floor_from']; ?>" size="2">
 �� <input type="text" name="floor_to" value="<?php echo $this->saved['floor_to']; ?>" size="2">
 </li>
</ul> 

<h5>��������:</h5>
<ul class="ul-param-two-on-line" style="margin: 5px 0 0 0;">
 <li>
 <p style="margin:0;padding:0;">
 �������:
 � <input type="text" name="value_from" value="<?php echo $this->saved['value_from']; ?>" size="3">
</p>
<p style="margin:0;padding:2px 0 5px 62px; ">
�� <input type="text" name="value_to" value="<?php echo $this->saved['value_to']; ?>" size="3"> �<sup>2</sup>
</p>
 </li>

  <li>
  <p style="margin:0;padding:0;">
  ����: � <input type="text" name="price_from" value="<?php echo $this->saved['price_from']; ?>" size="10">
  </p>
  <p style="margin:0; padding:2px 0 5px 36px; ">
 �� <input type="text" name="price_to" value="<?php echo $this->saved['price_to']; ?>" size="10"> ���.
 </p>
 </li>
</ul>

<h5>�������:</h5>
<ul class="ul-like-table ul-like-table-100">
 <li><input type="checkbox" name="photo" value="1" <?php
 if ($this->saved['photo'])
 {
 ?>checked="checked" <?php    
 }
 ?>> ����</li>

  <li><input type="checkbox" name="phone" value="1" <?php
 if ($this->saved['phone'])
 {
 ?>checked="checked" <?php    
 }
 ?>> �������</li>
 
  <li><input type="checkbox" name="have_panorama" value="1" <?php
 if ($this->saved['have_panorama'])
 {
 ?>checked="checked" <?php    
 }
 ?>> ��������</li>

 
  <li><input type="checkbox" name="have_plan" value="1" <?php
 if ($this->saved['have_plan'])
 {
 ?>checked="checked" <?php    
 }
 ?>> ����������</li>

 
 </ul>


</div>

</div></div></div></div>
<!--/ ����� ������ -->

<!-- ��� ���� -->
<?php 
$x = 0;
if (count($this->house_type) > 1)
{ $x++?>
<h4>��� ����</h4>
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
<!--/ ��� ���� -->


<!-- ��������� -->
<?php 
$x = 0;
if (count($this->condition) > 1)
{ $x++?>
  <h4>���������</h4>
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
<!--/ �������� -->


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

?> /> <span> �� ���������� ���������� ��� ������ ����</span></li>
</ul>
</div>
</div>
</div></div></div></div>


<input type="hidden" name="filter" value="save" >
<input type="hidden" name="type" value="<?php echo $this->type;?>" >
<p id="p-submit">
<input type="submit" name="save" value="������" />
<?php if ($this->saved['have']) 
{
    ?><input type="submit" name="clear" value="��������" /><?php
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
