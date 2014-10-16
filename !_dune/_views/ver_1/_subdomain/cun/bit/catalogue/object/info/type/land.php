<p id="object-page-info" class="object-page"><strong>����������</strong></p>
<?php
$heating = array(2 => '����������', '�����������');
$water_cold = array(2 => '����������', '�����������');
$sewer      = array(2 => '�������', '�����������');
?>

<div id="object-info">
<h2 class="h2-object-info">���������� �� �������</h2>
<table id="two-col-table">
<tr><td class="left">
<h3>������������</h3>
<p class="p-adress">
<!-- ������ �� �������� -->
<?php
if ($this->object->settlement_id == 1) {
if ($this->object->street_adding) { ?>����� <?php } else {?> <?php } echo $this->object->name_street;    
if ($this->object->house_number) {
?>, ��� <?php echo $this->object->house_number;
if ($this->object->building_number) {
    $word = $this->object->building_number;
    $word = str_replace(array('a', 'b', 'c', 'd', 'e'), array('�', '�', '�', '�', '�'), $word);

    ?>, ������ <?php echo $word; }
 if ($this->object->room) {?>
, ��������<?php echo $this->object->room; } 

}
?>
<p class="p-adress"><?php 

  if ($this->object->district_id_plus > 1)
  {
      echo $this->object->name_district_plus, ' <em>(', $this->object->name_district, ')</em>';
  }
  else 
	  echo $this->object->name_district;

?></p>
<p class="p-adress-no-main">�. <?php echo $this->object->name_settlement ?></p>
<?php

} else {
?>

	<?php echo $this->object->name_region?>,<br />
	
    <?php if ($this->object->settlement_id != 1) { ?>
	<?php echo $this->object->name_area?>,
	
	<?php if ($this->object->settlement_id and $this->object->type_settlement < 100)  { ?>
	<?php echo $this->object->name_settlement;
	  }
	  else 
	  {
	      echo $this->object->settlement_name;
	  } 
	
	
	 } else {
	    echo $this->object->name_district;?>,<?
                 }
	
	if ($this->object->street_id) { 
	  if ($this->object->street_adding) { ?>, ����� <?php } else {?> <?php }
	  echo $this->object->name_street;   
    } else if ($this->object->street_name)
	{
	       echo ', ', $this->object->street_name;
	} 
	if ($this->object->house_number)
	{
	?>, ��� <?php echo $this->object->house_number;
	}
	if ($this->object->building_number) { 
	?>, ������ <?php echo $this->object->building_number; }
	
	if ($this->object->room)
	 {
	    if ($this->object->type == 1) {
	 ?>, �������� <?php
        } else {
            ?>, ����� �<?php
        }
	   echo $this->object->room;
	    } ?>
<?php } ?>
<!--/ ������ �� �������� -->
</p>
    
<p class="preview_big">
<?php if ($this->preview_big) { ?>
<a class="thickbox" href="<?php echo $this->preview_sourse?>" />
<img width="300" height="300" src="<?php echo $this->preview_big?>" />
</a>
<?php } else { ?>
<img width="300" height="300" src="<?php echo $this->view_folder?>/img/house-300.png" />
<?php }?>
</p>
</td><td>

<h3>�������� ���������</h3>
<table class="object-parameters-list">

<?php if ($this->object->type_add > 1)
{ ?>
<tr>
<td class="object-prompting">��� :</td>
<td>
<?php
$text = '';
foreach ($this->type_add as $value)
{
    if ($value['id'] == $this->object->type_add)
        $text = $value['name'];
}
if ($text) 
{ ?><span class="form-field-value"><?php
    echo $text; 
  ?></span><?php
}
else
{
  ?><span class="form-field-none">�� �������</span><?php
}
?>
</td>
</tr>
<?php } ?>



<?php if ($this->object->condition) { ?>

<tr>
<td class="object-prompting">���������:</td>
<td>
<?php
$check = ' - ';
foreach ($this->condition as $value)
{
    if ($value['id'] == $this->object->condition)
    {
        $check = $value['name'];
        break;
    }
}
echo $check;
?>
</td>
</tr>

<?php } ?>






<?php if ($this->object->space_land) {?>
<tr>
<td class="object-prompting">�������:</td>
<td>
<?php echo $this->object->space_land ?> �����
</td>
</tr>
<?php } ?>




</table>

<!--
<h3>������</h3>

<table class="object-parameters-list">

</table>
-->

<?php if ($this->object->info_text) {?>
<dl class="dl-description-long">
<dt>��������</dt>
<dd>
<?php 
echo str_replace("\n", '<br />', $this->object->info_text);
?>
</dd>
</dl>
<?php } ?>


</td></tr>
</table>


<?php if ($this->object->info_comment) {?>
<dl class="dl-description-long" id="saler_comment">
<dt>�����������</dt>
<dd><em>
<?php 
echo str_replace("\n", '<br />', $this->object->info_comment);
?></em>
</dd>
</dl>
<?php } ?>

<?php if ($this->object->info_show_condition) {?>
<dl class="dl-description-long" id="info_show_condition">
<dt>������� ������</dt>
<dd>
<?php 
echo str_replace("\n", '<br />', $this->object->info_show_condition);
?>
</dd>
</dl>
<?php } ?>


<?php if ($this->object->info_contact) {?>
<dl class="dl-description-long" id="info_contact">
<dt>�������������� ���������� ����������</dt>
<dd>
<?php 
echo str_replace("\n", '<br />', $this->object->info_contact);
?>
</dd>
</dl>
<?php } ?>



<?php if ($this->object->price_one)
{
?><p class="p-object-shot-price">���� �� 1 ��.�.: <span class="focus-red"><?php echo number_format($this->object->price_one, '0', '.',' ')?> ���.</span>
</p><?php
}
?>


<?php if ($this->object->price or !$this->object->price_rent) { ?>

<p class="p-object-shot-price">����: 
<?php if (!$this->object->price) { ?>
<span class="focus-red">����������</span>
<?php } else  { ?>
<span class="focus-red"><?php echo number_format($this->object->price, '0', '.',' ')?> ���.</span>
<?php }?>
</p>

<?php } ?>

<?php if ($this->object->price_rent)
{
?><p class="p-object-shot-price">���� �� 1 ����� ������: <span class="focus-red"><?php echo number_format($this->object->price_rent, '0', '.',' ')?> ���.</span>
</p><?php
}
?>


<p class="p-object-shot-price-valuta"></p>

</div>

