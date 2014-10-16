<p id="object-page-info" class="object-page"><strong>����������</strong></p>
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
, ����� �<?php echo $this->object->room; } 

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
	<?php echo $this->object->name_settlement?>,
	<?php } else { ?>
	<?php echo $this->object->settlement_name?>,
	<?php }  ?>
	
	
	<?php } else {
	    echo $this->object->name_district;?>,<?
                 }
	
	if ($this->object->street_id) { 
	  if ($this->object->street_adding) { ?> ����� <?php } else {?> <?php }
	  echo $this->object->name_street;   
    } else
	{
	       echo $this->object->street_name;
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

<?php if ($this->object->type_house > 1)
{ ?>
<tr>
<td class="object-prompting">��� ����:</td>
<td>
<?php
$text = '';
foreach ($this->house_type as $value)
{
    if ($value['id'] == $this->object->type_house)
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


<?php if ($this->object->porch_text)
{ ?>
<tr>
<td class="object-prompting">�������</td>
<td>
<?php echo $this->object->porch_text ?>
</td>
</tr>
<?php } else if ($this->object->porch_text) {?> 
<tr>
<td class="object-prompting">�������</td>
<td>
<?php echo $this->object->porch ?>
</td>
</tr>
<?php } ?>


<?php
$no_cok = false;
if ($this->object->floor_2 > 0 and ($this->object->floor > 0 or $this->object->floor < 0))
{ 
    $no_cok = true;
    ?>
<tr>
<td class="object-prompting">������������� ����� �������: </td>
<td>
<?php
if ($this->object->floor < 0)
{
    ?>��������� � <?php
} else 
{
    ?> <?php echo $this->object->floor ?> � <?php
}
?>
<?php echo $this->object->floor_2; ?>
</td>
</tr>

<?php if ($this->object->floors_total) { ?>
<tr>
<td class="object-prompting">������ � ����</td>
<td>
<?php echo $this->object->floors_total; ?>
</td>
</tr>
<?php } ?>


<?php } else if ($this->object->floor > 0)
{ ?>
<tr>
<td class="object-prompting">����/������ � ����</td>
<td>
<?php echo $this->object->floor;
if ($this->object->floors_total) { ?>/<?php echo $this->object->floors_total; } else {?>/-<?php } ?>
</td>
</tr>
<?php } ?>



<?php if ($this->object->type_add and $this->object->type_add >  1)
{
?><tr>
<td class="object-prompting">���</td>
<td>
<?php echo $this->object->name_type_add ?>
</td>
</tr>
<?php } ?>



<tr>
<td class="object-prompting">�������:</td>
<td>
<?php echo $this->object->space_total ?> ��.�.
</td>
</tr>


<?php if ($this->object->height_ceiling) {?>
<tr>
<td class="object-prompting">������ ��������</td>
<td>
<?php echo $this->object->height_ceiling ?> �.
</td>
</tr>
<?php } ?>



</table>


<?php if ($this->object->floor < 0 and !$no_cok)
{ ?>
<p class="object-one-param">
<span>��������� ����</span>
</p>
<?php } ?>





<?php ob_start();
$have = false;
?>

<h3>������</h3>

<table class="object-parameters-list">


<?php if ($this->condition) { ?>
<tr>
<td class="object-prompting">���������:</td>
<td>
<?php
$check = ' - ';
foreach ($this->condition as $value)
{
    if ($value['id'] == $this->object->condition)
    {
        $have = true;
        $check = $value['name'];
        break;
    }
}
echo $check;
?>
</td>
</tr>

<?php } ?>
</table>

<?php if ($this->object->have_phone)
{
    $have = true;
    ?>
<p class="object-one-param">
<span>���� ��������� �������</span>
</p>
<?php } ?>


<?php if ($this->object->balcony) {
    $have = true;
    ?>
<p class="object-one-param">���� <span>������</span><?php if ($this->object->space_balcony) { 
?>, ������� <span><?php echo $this->object->space_balcony; ?></span> ��. �.
<?php } ?></p>
<?php } ?>

<?php 
if ($this->object->loggia) { 
    $have = true;
    ?>
<p class="object-one-param">���� <span>������</span><?php if ($this->object->space_loggia) { 
?>, ������� <span><?php echo $this->object->space_loggia; ?></span> ��. �.
<?php } ?></p>
<?php } ?>

<?php 
$text = ob_get_clean();
if ($have)
    echo $text;
 ?>

</td></tr>
</table>



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

<?php if ($this->object->info_comment) {?>
<dl class="dl-description-long">
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

