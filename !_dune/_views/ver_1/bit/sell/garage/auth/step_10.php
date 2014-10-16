<h1>������ �� ���������� ������ � ��������</h1>

<?php
Dune_Variables::$pageTitle = '�������������. ' . Dune_Variables::$pageTitle;
?>


<?php switch ($this->message_code) { 
case 1: ?>
<p id="system-message">�� ��������� ������������ ����. ������� ������� ������.</p>
<?php break; ?> 

<?php case 2: ?>
<p id="system-message">��������� ������� ����� ���������� ������.</p>
<?php break; ?> 

<?php case 3: ?>
<p id="system-message">������ ������.</p>
<?php break; ?> 

<?php case 4: ?>
<p id="system-message">�� �������� ������ ����������� �������� ������������ �� ��������� ����������. �����, �� � ���� ��������.</p>
<?php break; ?> 

<?php case 5: ?>
<p id="system-message">������. �������� ��������� ������� ���������� ������.</p>
<?php break; ?> 


<?php }
echo $this->steps_panel;
?>


<div id="object-under-bookmark">
<div id="object-info">
<div id="object-sell">

<?php
Dune_Session::getInstance();
if (Dune_Session::$auth) { // ������������ ���������������
?>

<p>������ ��� ���� ������ ����� ��������� � ��������, �� �������� ���������.</p>
<p>�� ��� ���������� �-���� (<B><?php  echo $_SESSION[Dune_Session::ZONE_AUTH]['user_mail'];?></B>), ��������� ��� ����������� � ��������, ������� ��������� � ���������� ����� ������.</p>
<p>����� ���������� �� ��������� ����������� �������� � ������������ �� ������� ������.</p>

<?php } else { // �� ������������������ ������������ ?>

<p>������ ��� ���� ������ ����� ��������� � ��������, �� �������� ���������.</p>
<p>������ <B>����������������� ������������</B> ����� ��������� ���� ������� � ��������!<BR>
��-�����, ����� ������� ������ "��������� �� ������������ ����������" ����� ��������, ��� ��������� ��� ����� ��� ����� ������ � �������, ���� �� ��� ������������������ ������������ �������, ��� ������ ��������� �����������, ������� �� ������ � ��� ����� �������.</p>
<p>�� ��� ���������� �-����, ��������� ��� ����������� � ��������, ������� ��������� � ���������� ����� ������.</p>
<p>����� ���������� �� ��������� ����������� �������� � ������������ �� ������� ������.</p>

<?php } ?>

<table id="two-col-table">
<tr><td class="left" style="width:40%">
<h3>������������</h3>
<table class="list-table-js">


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
<td class="object-prompting">�����</td>
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

<!--
<tr>
<td class="object-prompting">��� ������:</td>
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
-->

</table>

</td><td>

<h3>�������� ���������</h3>


<table class="list-table-js">

<tr>
<td class="object-prompting">�������</td>
<td>
<?php
if ($this->data['space_total']) 
{ ?><span class="form-field-value"><?php
    echo $this->data['space_total']; ?>
    
   ��. �.</span><?php
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
<td class="object-prompting">���������</td>
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
<a href="<?php echo $value[1]; ?>" class="thickbox" ><img src="<?php echo $value[2]; ?>" /></a>
<p><a href="<?php echo $this->url; ?>?delete=yes&name=<?php echo $value[0]; ?>">�������</a></p>
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
<div>
<a href="<?php echo $this->array_plan[1]; ?>" class="thickbox" ><img src="<?php echo $this->array_plan[2]; ?>" /></a>
<p><a href="<?php echo $this->url; ?>?delete=yes&name=<?php echo $this->array_plan[0]; ?>">�������</a></p>
</div>
</div>

</dd>
</dl>
<?php } ?>


</div>
<?php if (!$this->status) {?>
<form method="post">
<input type="hidden" name="_do_" value="save" />
<p class="submit-tipa-big">
<input type="submit" name="save" value="��������� �� ������������ ����������" />
</p>
</form>
<?php } ?>
</div>
</div>

<div class="ugol-left-top"></div>
<div class="ugol-left-bottom"></div>
<div class="ugol-right-top"></div>
<div class="ugol-right-bottom"></div>

</div>
