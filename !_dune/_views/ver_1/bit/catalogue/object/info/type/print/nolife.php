<table id="two-col-table">
<tr><td class="left">

<div id="user">
<h3>���������� � ��������</h3>
<table id="table-object-saler-info">

<tr>
<td class="td-saler-info-name">
���������� ���:
</td><td class="td-saler-info-data">
<a href="/user/info/<?php echo $this->user_info->id; ?>/" title="������������ ��������">
<?php
if ($this->user_info->contact_name)
    echo $this->user_info->contact_name;
else 
    echo $this->user_info->name; 
  ?>
 </a>
</td>
<td class="td-saler-info-data-add">
</td>
</tr>


<?php
// ����� ������ ���������� �����
if ($this->user_info_allow->mail_allow) {?>
<tr>
<td class="td-saler-info-name">
��.�����:
</td><td class="td-saler-info-data">
 <?php echo $this->user_info->mail; ?>
</td>
<td class="td-saler-info-data-add">
</td>
</tr>
<?php } ?>



<?php
// ����� ������ ���������� �����
if ($this->user_info_allow->phone_allow) {?>
<tr>
<td class="td-saler-info-name">
�������:
</td><td class="td-saler-info-data">
 <?php echo $this->user_info->phone; ?>
</td>
<td class="td-saler-info-data-add">
</td>
</tr>
<?php } ?>

<?php
// ����� �����
if ($this->user_info_allow->icq_allow and $this->user_info->icq) {?>
<tr style="height: 30px;">
<td class="td-saler-info-name">
ICQ&nbsp; :
</td><td class="td-saler-info-data">
<img style="display:inline; line-height:12px; vertical-align:bottom; position:relative; bottom: 1px;" alt="������" src="http://wwp.icq.com/scripts/online.dll?icq=<?php echo str_ireplace(array(' ', '-', '(', ')'), '',$this->user_info->icq); ?>&img=5&rnd=<?php echo rand(1000, 9999) ?>" />
<a href="#" onclick='clientWindow = window.open("http://www.icq.com/icq2go/flicq.html","ICQ2Go","left=20,top=20,width=176,height=441,toolbar=0,resizable=0");return false;'>
 <?php echo $this->user_info->icq; ?>
 </a>
</td>
<td class="td-saler-info-data-add">
</td>
</tr>
<?php } ?>


<?php
// ����� ������ ���������� �����
if ($this->user_info->site) {?>
<tr>
<td class="td-saler-info-name">
����:
</td><td class="td-saler-info-data">
 <?php echo $this->user_info->site; ?>
</td>
<td class="td-saler-info-data-add">
</td>
</tr>
<?php } ?>



</table>


</div>





<p class="preview_big">
<?php if ($this->preview_big) { ?>
<a class="thickbox" href="<?php echo $this->preview_sourse?>" />
<img width="400" height="400" src="<?php echo $this->preview_big?>" />
</a>
<?php } else { ?>
<img width="400" height="400" src="<?php echo $this->view_folder?>/img/house-300.png" />
<?php }?>
</p>
</td><td>


<h3><?php echo $this->object->name_type; ?></h3>
<p class="p-adress">

<!-- ������ �� �������� -->
<?php
if ($this->object->settlement_id == 1) {
if ($this->object->street_adding) { ?>����� <?php } echo $this->object->name_street;    
if ($this->object->house_number) {
?>, ��� <?php echo $this->object->house_number;
if ($this->object->building_number) {
    $word = $this->object->building_number;
    $word = str_replace(array('a', 'b', 'c', 'd', 'e'), array('�', '�', '�', '�', '�'), $word);

    ?>, ������ <?php echo $word; }
 if ($this->object->type == 1 and $this->object->room) {?>
, ��. <?php echo $this->object->room; } 

}
?>, <?php echo $this->object->name_district ?>, �. <?php echo $this->object->name_settlement ?>
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
    



<table class="object-parameters-list">


<tr>
<td>
<h3>�������� ���������</h3>
</td>
<td></td>
</tr>


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

<?php if ($this->object->floor > 0)
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


<?php if ($this->object->floor < 0)
{ ?>
<p class="object-one-param">
<span>��������� ����</span>
</p>
<?php } ?>





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

<p class="object-one-param">
<?php if ($this->object->have_phone)
{ ?>
<span>���� ��������� �������</span>
<?php } ?>


<?php 
if ($this->object->balcony) { ?>
<br />���� <strong>������</strong><?php if ($this->object->space_balcony) { 
?>, ������� <span><?php echo $this->object->space_balcony; ?></span> ��. �.
<?php } ?>
<?php } ?>

<?php 
if ($this->object->loggia) { ?>
<br />���� <strong>������</strong><?php if ($this->object->space_loggia) { 
?>, ������� <span><?php echo $this->object->space_loggia; ?></span> ��. �.
<?php } ?>
<?php } ?>


</p>
<?php if ($this->object->info_text) {?>
<dl class="dl-description">
<dt>��������</dt>
<dd>
<?php 
echo str_replace("\n", '<br />', $this->object->info_text);
?>
</dd>
</dl>
<?php } ?>


<?php if ($this->object->info_comment) {?>
<dl class="dl-description" id="saler_comment">
<dt>�����������</dt>
<dd><em>
<?php 
echo str_replace("\n", '<br />', $this->object->info_comment);
?></em>
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

<?php if ($this->object->price_rent_day)
{
?><p class="p-object-shot-price">���� ������: <span class="focus-red"><?php echo number_format($this->object->price_rent_day, '0', '.',' ')?> ���./�����</span>
</p><?php
}
else if ($this->object->price_rent)
{
?><p class="p-object-shot-price">���� �� 1 ����� ������: <span class="focus-red"><?php echo number_format($this->object->price_rent, '0', '.',' ')?> ���.</span>
</p><?php
}
?>

</td></tr>
</table>




