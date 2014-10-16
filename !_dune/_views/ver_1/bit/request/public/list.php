<?php switch ($this->message_code) { 
case 51: ?>
<p id="system-message">������ �������.</p>
<?php break; ?> 

<?php case 52: ?>
<p id="system-message">������������� ������.</p>
<?php break; ?> 

<?php case 53: ?>
<p id="system-message">������������� ����� ������.</p>
<?php break; ?> 

<?php case 4: ?>
<p id="system-message">�������� ����� ���������� ������.</p>
<?php break; ?> 


<?php case 55: ?>
<p id="system-message">������ ������.
<?php if ($this->last_edit) { ?>
<br /><br /><span><a href="/public/request/<?php echo $this->last_edit['type_code']?>/?edit=<?php echo $this->last_edit['id']?>">������������� ���������</a></span>
</p>
<?php }
break; ?> 

<?php case 54: ?>
<p id="system-message">����� ��������� ������.</p>
<?php break; ?> 

<?php } ?>
<div id="request">
<?php if (false) { ?>
<p>
<?php if ($this->have)
{ ?>
<a href="/user/request/" class="buttom">��� ������</a>
<?php
} ?>
<a href="/public/request/" class="buttom">������ ������ �� ������� ��� ������</a>
</p>
<?php } ?>


<p>
<?php
$active_sale = '';
$active_rent = '';
if ($this->deal == 'sale')
{
    $active_sale = ' active"';
}
if ($this->deal == 'rent')
{
    $active_rent = ' active"';
}
$link_rent = $this->link_rent;
$link_sale = $this->link_sale;

?>

<a href="<?php echo $link_sale; ?>" class="buttom<?php echo $active_sale ?>">�����</a>
<a href="<?php echo $link_rent ?>" class="buttom<?php echo $active_rent ?>">������ � ������</a>
</p>

<?php if (count($this->list)) {?>
<table>
<tr>
<th>������</th>
<th>��������</th>
<th>��������� ��</th>
<th>���� ����������</th>
<th>���������</th>
</tr>
<?php
$name_type = new Dune_Array_Container($this->types, '������������');
foreach ($this->list as $value) {
    $arr = @unserialize($value['data']);
    if (is_array($arr))
        $data_array = new Dune_Array_Container($arr);
    else 
        $data_array = new Dune_Array_Container(array());
    ?>
<tr>
<td style="vertical-align:top;"><a  style="font-weight:bold; font-size:16px; color: #EF6600; " href="/public/request/info/<?php echo $value['id_req']; ?>/"><?php echo ucfirst($name_type[$value['type']]['name']); ?></a>
<?php if ($data_array['adress']) { ?>
<br />
<strong>��������������:</strong> <?php echo $data_array['adress'] ?>
<?php } ?>
<?php if ($data_array['variant_text']) { ?>
<br />
<strong>����� ��������� �����: </strong> <?php echo $data_array['variant_text'] ?>
<?php if ($data_array['variant_date']) { ?>
 <em>��������� ������� ��</em> <?php echo $data_array['variant_date'] ?>
<?php } } ?>

<?php ob_start(); ?>
<br /><strong>���������� ������:</strong>
<?php
$x = false;
 if ($data_array['rooms_count_1']) { $x = true; ?>1<?php } 
 if ($data_array['rooms_count_2']) {
    if ($x) { ?>, <?php }      
    $x = true; ?>2<?php } 
 if ($data_array['rooms_count_3']) {
     if ($x) { ?>, <?php }      
     $x = true; ?>3<?php } 
 if ($data_array['rooms_count_4']) {
     if ($x) { ?> ��� <?php }      
     $x = true; ?>����� 3-�<?php } ?>
<?php if ($data_array['rooms_count_text']) { 
    if ($x) { ?> (<?php }
echo $data_array['rooms_count_text'];
    if ($x) { ?>) <?php }
    $x = true;
} ?> 

<?php 
$text = ob_get_clean();
if ($x)
   echo $text;
?>


 

</td>
<td>
<?php echo str_replace("\r\n", '<br />', $data_array['contact']) ?>
</td>

<td style="width:120px; text-align:center;">
<?php
if ($data_array['price_to']) { echo $data_array['price_to']; }
else { ?> - <?php }

?>
</td>
<td style="width:90px; white-space:nowrap;">
<?php echo (int)substr($value['time'], 8, 2);?>
<?php
switch ((int)substr($value['time'], 5, 2))
{
    case 1:
        ?> ������ <?php
    break;
    case 2:
        ?> ������� <?php
    break;
    case 3:
        ?> ����� <?php
    break;
    case 4:
        ?> ������ <?php
    break;
    case 5:
        ?> ��� <?php
    break;
    case 6:
        ?> ���� <?php
    break;
    case 7:
        ?> ���� <?php
    break;
    case 8:
        ?> ������� <?php
    break;
    case 9:
        ?> �������� <?php
    break;
    case 10:
        ?> ������� <?php
    break;
    case 11:
        ?> ������ <?php
    break;
    case 12:
        ?> ������� <?php
    break;
    
}
?>

<?php echo substr($value['time'], 0, 4);?>

</td>
<td class="small-td" style="text-align:center;">
<?php if ($value['user_id']) {

if ($value['contact_name'])
    $name = $value['contact_name'];
else 
    $name = $value['name'];
?>
<a href="/user/info/<?php echo $value['user_id']; ?>/"><span style="white-space:nowrap;"><?php echo $name; ?></span></a>
<?php } else { ?>
<span>�����</span>
<?php } ?>

</td>
</tr>
<?php } ?>
</table>
<?php echo $this->navigator; ?>
</div>
<?php } else {?>

<p style="text-align:center; font-size:20px;">������ ���</p>

<?php } ?>