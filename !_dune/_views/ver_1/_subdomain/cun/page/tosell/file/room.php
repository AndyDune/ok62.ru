<h1>������ �� ������� ��������.</h1>

<p>������ �� ��������� �������� � �������� �� ������������ <a href="http://<?php echo $this->domain ?>/user/info/<?php echo $this->user_id ?>"><?php echo $this->user_name ?></a></p>
<p>E-mail ������������ <?php echo $this->user_mail ?></p>

<div id="object-under-bookmark">
<div id="object-info">
<div id="object-sell">


<table id="two-col-table">
<tr><td class="left" style="width:40%">
<h3>������������</h3>
<table class="list-table-js">


<tr>
<td class="object-prompting">����������:</td>
<td>
<p>X: <?php echo $this->data['gm_x']; ?></p>
<p>Y: <?php echo $this->data['gm_y']; ?></p>
</td>
</tr>



<tr>
<td class="object-prompting">�������</td>
<td>
���������
</td>
</tr>

<tr>
<td class="object-prompting">�����</td>
<td>
������
</td>
</tr>

<tr>
<td class="object-prompting">�����</td>
<td>
<?php
if ($this->data['street']) 
{ ?><span class="form-field-value"><?php
    echo $this->data['street']; 
  ?></span><?php
}
else
{
    ?><span class="form-field-require">�� �������</span><?php
}
?>
</td>
</tr>

<tr>
<td class="object-prompting">���</td>
<td>
<?php
if ($this->data['house_number']) 
{ ?><span class="form-field-value"><?php
    echo $this->data['house_number']; 
if ($this->data['building_number'])
{
    ?>, ������ <? echo $this->data['building_number'];
}
  ?></span><?php
}
else
{
  ?><span class="form-field-none">�� �������</span><?php
}
?>
</td>
</tr>

<tr>
<td class="object-prompting">������ � ����</td>
<td>
<?php
if ($this->data['floors_total']) 
{ ?><span class="form-field-value"><?php
    echo $this->data['floors_total']; 
  ?></span><?php
}
else
{
  ?><span class="form-field-none">�� �������</span><?php
}
?>

</td>
</tr>


<tr>
<td class="object-prompting">�������</td>
<td>
<?php
if ($this->data['porch']) 
{ ?><span class="form-field-value"><?php
    echo $this->data['porch']; 
  ?></span><?php
}
else
{
  ?><span class="form-field-value">�� �������</span><?php
}
?>
</td>
</tr>


<tr>
<td class="object-prompting">����� ��������</td>
<td>
<?php
if ($this->data['room']) 
{ ?><span class="form-field-value"><?php
    echo $this->data['room']; 
  ?></span><?php
}
else
{
  ?><span class="form-field-none">�� �������</span><?php
}
?>

</td>
</tr>

<tr>
<td class="object-prompting">����</td>
<td>
<?php
if ($this->data['floor']) 
{ ?><span class="form-field-value"><?php
    echo $this->data['floor']; 
  ?></span><?php
}
else
{
  ?><span class="form-field-none">�� �������</span><?php
}
?>

</td>
</tr>

<tr>
<td class="object-prompting">��� ����:</td>
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
  ?><span class="form-field-none">�� �������</span><?php
}
?>

</td>
</tr>


</table>

</td><td>

<h3>�������� ���������</h3>


<table class="list-table-js">

<tr>
<td class="object-prompting">�������:<br /> �����/�����/�����</td>
<td>
<?php
if ($this->data['space_total']) 
{ ?><span class="form-field-value"><?php
    echo $this->data['space_total']; ?>
 / 
 <?php echo $this->data['space_living']?>
 / 
<?php echo $this->data['space_kitchen']
    
  ?> ��. �.</span><?php
}
else
{
  ?><span class="form-field-none">�� �������</span><?php
}
?>

</td>
</tr>

<tr>
<td class="object-prompting">��������� �������:</td>
<td>
<?php
if ($this->data['space_calculation']) 
{ ?><span class="form-field-value"><?php
    echo $this->data['space_calculation']; 
  ?> ��. �.</span><?php
}
else
{
  ?><span class="form-field-none">�� �������</span><?php
}
?>

</td>
</tr>

<tr>
<td class="object-prompting">����������� ������</td>
<td>
<?php
if ($this->data['rooms_count']) 
{ ?><span class="form-field-value"><?php
    echo $this->data['rooms_count']; 
  ?></span><?php
}
else
{
  ?><span class="form-field-none">�� �������</span><?php
}
?>

</td>
</tr>


</table>


<h3>������</h3>
<table>
<tr>
<td class="object-prompting">����������:</td>
<td>
<?php
$text = '';
foreach ($this->planning as $value)
{
    if ($value['id'] == $this->data['planning'])
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

<tr>
<td class="object-prompting">���������:</td>
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
  ?><span class="form-field-none">�� �������</span><?php
}
?>


</td>
</tr>


<tr>
<td class="object-prompting">������� ��������</td>
<td>
<span class="form-field-value"> 
<?php 
if ($this->data['have_phone']) 
{ ?>��<?php
} else { ?>
���
<?php }?>
</span>
</td>
</tr>

<tr>
<td class="object-prompting">������</td>
<td>

<span class="form-field-value">
<?php 
if ($this->data['balcony']) 
{ ?>��<?php
if ($this->data['space_balcony'])
{
    ?>, �������: <?php echo $this->data['space_balcony'] ?> ��. �.<?php
}
} else { ?>
���
<?php }?>
</span>

</td>
</tr>

<tr>
<td class="object-prompting">������� ������ / �������</td>
<td>

<span class="form-field-value">
<?php 
if ($this->data['loggia']) 
{ ?> ��<?php
if ($this->data['space_loggia'])
{
    ?>, �������: <?php echo $this->data['space_loggia'] ?> ��. �.<?php
}
} else { ?>
���
<?php }?>
</span>

</td>
</tr>



</table>

</td></tr>
</table>


<dl class="dl-description">
<dt>��������</dt>
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
<dt>�����������</dt>
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
<td class="object-prompting">����������� �����: </td>
<td>
<?php 
if ($this->data['haggling'] == 0) {
?> <span class="form-field-spec">�������� ��� "�������"</span>
<?php 
}
else if ($this->data['haggling'] == 1) {
?> <span class="form-field-spec">�� ��������</span>
<?php 
}
else if ($this->data['haggling'] == 2) {
?> <span class="form-field-spec">����� ���� �������</span>
<?php } 
else { ?>
<span class="form-field-none">�� �������</span>
<?php } ?>

</td><td>
<p class="p-object-shot-price">����:
<?php
if ($this->data['price']) 
{ ?><span class="form-field-value">
    <?php echo $this->data['price']?> ���.
  </span><?php
}
else
{
  ?><span class="form-field-none">�� �������</span><?php
}
?>

</p><p class="p-object-shot-price" style="padding-top: 5px;">
���� �� 1 ��.�.:
<?php
if ($this->data['price_one']) 
{ ?><span class="form-field-value">
    <?php echo $this->data['price_one'] ?> ���.
  </span><?php
}
else
{
  ?><span class="form-field-none">�� �������</span><?php
}
?>

</p>
</td></tr>

</table>


<div class="form-part">

<?php if (count($this->array_photo)) { ?>
<dl>
<dt>����������� ���������� �������</dt>
<dd><div class="pictures-float-list">
<?php foreach ($this->array_photo as $key => $value) {?>
<div>
<a href="photo/<?php echo $value; ?>" class="thickbox" ><img src="photo/<?php echo $value; ?>" width="100" height="100" /></a>
</div>
<?php } ?>
</div></dd>
</dl>
<?php } ?>


<?php if (count($this->array_plan)) { ?>
<dl>
<dt>����������� ����������</dt>
<dd>
<div class="pictures-float-list">
<?php foreach ($this->array_plan as $key => $value) {?>
<div>
<a href="plan/<?php echo $value; ?>" class="thickbox" ><img src="plan/<?php echo $value; ?>" width="100" height="100" /></a>
</div>
<?php } ?>
</div>

</dd>
</dl>
<?php } ?>


</div>
</div>
</div>

<div class="ugol-left-top"></div>
<div class="ugol-left-bottom"></div>
<div class="ugol-right-top"></div>
<div class="ugol-right-bottom"></div>

</div>
