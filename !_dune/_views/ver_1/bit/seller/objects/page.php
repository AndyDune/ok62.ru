<div id="page-top">
<h1 style="text-align:right;">������� ��������.</h1>
</div>
<div id="content-with-left-table">
<div id="content-left-table-is">
<a href="/seller/tall">������� �� �� �������� ����</a>
<h2  <?php if ($this->type == 1) { ?> style="color:red;" <?php } ?>>�������� � ������</h2>
<ul> 
<li><a <?php if (!$this->rooms_count) { ?> style="color:red;" <?php } ?> href="?type=1&amp;region=1&amp;rooms_count=0&amp;settlement=1">���</a></li>
<li><a <?php if ($this->rooms_count == 1) { ?> style="color:red;" <?php } ?> href="?type=1&amp;region=1&amp;rooms_count=1&amp;settlement=1">1-���������</a></li>
<li><a <?php if ($this->rooms_count == 2) { ?> style="color:red;" <?php } ?> href="?type=1&amp;region=1&amp;rooms_count=2&amp;settlement=1">2-���������</a></li>
<li><a <?php if ($this->rooms_count == 3) { ?> style="color:red;" <?php } ?> href="?type=1&amp;region=1&amp;rooms_count=3&amp;settlement=1">3-���������</a></li>
<li><a <?php if ($this->rooms_count == 4) { ?> style="color:red;" <?php } ?> href="?type=1&amp;region=1&amp;rooms_count=4&amp;settlement=1">����� 3</a></li>
</ul>
<h2 <?php if ($this->type == 4) { ?> style="color:red;" <?php } ?>>������� � ������</h2>
<ul> 
<li><a href="?type=4&amp;region=1&amp;settlement=1">��� ���������</a></li>
</ul>
<h2  <?php if ($this->type == 3) { ?> style="color:red;" <?php } ?>>������ � ������</h2>
<ul> 
<li><a href="?type=3&amp;region=1&amp;settlement=1">��� ������</a></li>
</ul>
<h2 <?php if ($this->type == 2) { ?> style="color:red;" <?php } ?>>���� � ������</h2>
<ul> 
<li><a href="?type=2&amp;region=1&amp;settlement=1">��� ����</a></li>
</ul>

<h2 <?php if ($this->type == 5) { ?> style="color:red;" <?php } ?>>�������� � ������</h2>
<ul> 
<li><a href="?type=5&amp;region=1&amp;settlement=1">��� ��������</a></li>
</ul>

<h2 <?php if ($this->no_ryzan) { ?> style="color:red;" <?php } ?>>� ��������� �������</h2>
<ul> 
<li><a href="?type=0&amp;region=1&amp;settlement=0&amp;ryazan=no&amp;rooms_count=0">��</a></li>
</ul>

</div> <!--/ content-is -->

<div id="content-is">
<?php 
if ($this->settlement == 1)
{
    ?><p id="district-list"><?php
    foreach ($this->list_distrinct as $val)
    {
        ?><a <?php
if ($this->distrinct == $val['id']) { ?> style="color:red;" <? }
        ?>  class="buttom" href="?district=<?php echo $val['id'] ?>"><?php echo $val['name'] ?></a><?php
    }
     ?><a  class="buttom" href="?district=0">���</a><?php
    ?></p><?php
}
?>

    <p id="seller-panel">
    <a class="buttom" <?php if (!$this->seller) { ?> style="color:red;" <? } ?> href="?seller=0">��� ��������</a>
    <a class="buttom" <?php if ($this->seller === 3) { ?> style="color:red;" <? } ?> href="?seller=3">���� ������</a>
    <a class="buttom" <?php if ($this->seller !== 3) { ?> style="color:red;" <? } ?> href="?seller=3e">���������</a>
    <a class="buttom" href="/seller/who/?seller=0">�������� ���������</a>
    </p>


<?php echo $this->seller_choice ?>


<?php
if ($this->count) {
//////////// ����� ������ ��������    
?>
<table id="list-for-seller">
<?php foreach ($this->list as $value) { ?>
<tr>
<td style="border-right: 1px solid #666666"><a href="/catalogue/object/<?php echo $value['id'] ?>/"><?php echo $value['name_type'] ?></a><td>
<td style="border-right: 1px solid #666666"><p><?php echo $value['time_insert'] ?></p><td>
<td>

<p>
<strong>��������: </strong><a href="/user/info/<?php echo $value['saler_id'] ?>/"><?php echo $value['name_user'] ?> (<?php echo $value['user_contact_name'] ?>)</a><br />
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
, <?php echo $value['name_district'] ?>
, �. <?php echo $value['name_settlement'] ?>
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
</p>
<!--/ ������ �� �������� -->

</td>

<td>
<p>
<strong>����</strong>:
<?php
$value2 = '';
if ($value['price'])  
{
    $value2 = number_format($value['price'], '0', '.',' ');
}
echo $value2;
?>

<strong>���� �� 1 ��.�.</strong>:
<?php
$value2 = '';
if ($value['price_one'])  
{
    $value2 = number_format($value['price_one'], '0', '.',' ');
}
echo $value2;
?>


<br />
<strong>���� �� ������ � �����</strong>:
<?php
$value2 = '';
if ($value['price_rent'])  
{
    $value2 = number_format($value['price_rent'], '0', '.',' ');
}
echo $value2;
?>

</p>
</td>

</tr>
<?php } ?>
</table>
<?php
//////////// ����� ������ ��������    /
} else { ?>
<h1 style="text-align:center">��� �������� � ��������� ������� �/��� �����</h1>
<?php }  ?>

<?
if ($this->count > $this->navigator_per_page)
{

$navigator = new Dune_Navigate_Page('?page=', $this->count, $this->navigator_page, $this->navigator_per_page);
echo $navigator->getNavigator();
}
?>

</div> <!--/ content-is -->

</div> <!--/ content-with-left-table -->