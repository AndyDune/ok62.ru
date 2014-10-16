<?php if ($this->count) {?>
<table>
<?php foreach ($this->list as $value) { ?>
<tr>

<td style="vertical-align:top;">
<p><strong><a href="/catalogue/object/<?php echo $value['id']; ?>/"><?php echo $value['name_type']; ?></a></strong><br />

<!-- ������ �� �������� -->
<?php
if ($value['settlement_id'] == 1) {
if ($value['street_adding']) { ?>����� <?php } echo $value['name_street'];    
if ($value['house_number']) {
?>, ��� <?php echo $value['house_number'];
if ($value['building_number']) {
    $word = $value['building_number'];
    $word = str_replace(array('a', 'b', 'c', 'd', 'e'), array('�', '�', '�', '�', '�'), $word);

    ?>, ������ <?php echo $word; }
 if ($value['type'] == 1 and $value['room']) {?>
, ��. <?php echo $value['room']; } 

}
?>
<br /><?php echo $value['name_district'] ?>
<br />�. <?php echo $value['name_settlement'] ?>
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
	  if ($value['street_adding']) { ?> ����� <?php } else {?> <?php }
	  echo $value['name_street'];   
    } else
	{
	       echo $value['street_name'];
	} 
	if ($value['house_number'])
	{
	?>, ��� <?php echo $value['house_number'];
	}
	if ($value['building_number']) { 
	?>, ������ <?php echo $value['building_number']; }
	
	if ($value['room'])
	 {
	    if ($value['type'] == 1) {
	 ?>, �������� <?php
        } else {
            ?>, ����� <?php
        }
	   echo $value['room'];
	    } ?>
<?php } ?>
<!--/ ������ �� �������� -->




</p>
</td>

<td style="vertical-align:top; border-top: 1px solid #000; "> 

<p>


<?php $this->data = $value; ?>


<strong>��� ����:</strong>
<?php
foreach ($this->house_type as $valuet)
{
    if ($valuet['id'] == $value['type_house'])
    {
        echo $valuet['name']; 
    }
}
?>

<strong>�������: �����/�����/����� :</strong>
<?php echo $value['space_total']?>
 / 
<?php echo $value['space_living']?>
 / 
<?php echo $value['space_kitchen']?>
<br />

<strong>��������� �������:</strong>
<?php echo $value['space_calculation']?>
<br />

<strong>������ ��������:</strong>
<?php echo $this->data['height_ceiling']?>
<br />

<strong>�������:</strong>
<?php echo $this->data['rooms_count']?> 
<br />

<strong>����������:</strong>
<?php
foreach ($this->planning as $value2)
{
    if ($value2['id'] == $this->data['planning'])
        echo $value2['name'];
}
?>
<br />

<strong>���������:</strong>
<?php
foreach ($this->condition as $value2)
{
    if ($value2['id'] == $this->data['condition'])
        echo $value2['name'];
}
?>
<br />

<strong>�������:</strong>
<?php 
if ($this->data['have_phone'])
{
?> ����<?php
} else {
?> ���<?php
}
    
?>

<strong>������:</strong>
<?php 
if ($this->data['balcony'])
{
?> ���� (<?php echo $this->data['space_balcony'] ?> ��.�.) <?php
} else {
?> ���<?php
}
?>


<strong>������:</strong>
<?php 
if ($this->data['loggia'])
{
?> ���� (<?php echo $this->data['space_loggia'] ?> ��.�.) <?php
} else {
?> ���<?php
}
?>
</p>

<p>
<strong>��������</strong><br />
<?php 
echo $this->data['info_text']
?>
</p>

<p>
<strong>����������</strong><br />
<?php 
echo $this->data['info_comment']
?>
</p>

<p>
<strong>�����������</strong>:
<?php 
if ($this->data['new_building_flag'])
{
?> ���� (<?php echo $this->data['new_building_text'] ?>) <?php
} else {
?> ���<?php
}
?>


 <strong>������</strong>:
<?php 
if ($this->data['deal'] == 2)
{
?> �������, ������<?php
} else if ($this->data['deal'] == 1) {
?> ������<?php
} else {
?> �������<?php
}

?>

<strong>����</strong>:
<?php 
if ($this->data['haggling'] == 0)
{
?> �������� ��� "�������"<?php
} else if ($this->data['haggling'] == 1) {
?> �� ��������<?php
} else {
?> ����� ���� �������<?php
}
?>


</p>

<p>
<strong>����</strong>:
<?php
$value2 = '';
if ($this->data['price'])  
{
    $value2 = number_format($this->data['price'], '0', '.',' ');
}
echo $value2;
?>

<strong>���� �� 1 ��.�.</strong>:
<?php
$value2 = '';
if ($this->data['price_one'])  
{
    $value2 = number_format($this->data['price_one'], '0', '.',' ');
}
echo $value2;
?>



<strong>���� �� ������ � �����</strong>:
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
��������: <a href="/user/info/<?php echo $value['saler_id'] ?>/"><?php echo $value['name_user'] ?></a><br />
����: <?php echo $value['user_mail'] ?><br />
���������� ���: <?php echo $value['user_contact_name'] ?><br />
�������: <?php echo $value['user_phone'] ?><br />
</p>
</td>


</tr>
<?php } ?>

</table>
<?php } else { ?>

<?php } ?>