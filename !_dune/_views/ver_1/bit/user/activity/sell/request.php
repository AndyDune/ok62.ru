<div id="catalogue-list">
<p><a href="/public/sell/" class="buttom">������ ������ �� ���������� ������ ������� ������������</a></p>
<table>
<tr>
<th>���</th>
<th>����</th>
<th>�����</th>
<th>����</th>
<th>������</th>
<th></th>
</tr>

<?php 
if ($this->count)
{
?>
<?php

foreach ($this->data as $one)
{  
     ?>
<tr>
<td><?php echo $one['name_type']?></td>
<td style="text-align:center;"><?php echo substr($one['time'], 0, 10)?><br /> <?php echo substr($one['time'], 10, 6)?></td>
<td>
<?php if ($one['status'] > 1) { ?>

<?php } else {?>
<a href="/public/sell/<?php echo $one['name_type_code']?>/?edit=<?php echo $one['id']?>" title="�������������">
<?php } ?>
������, ����� <?php echo $one['street'];
if ($one['house_number'])
{
    ?>, ��� <?php echo $one['house_number'];
}

if ($one['building_number'])
{
    ?>, ������ <?php echo $one['building_number'];
}

if ($one['room'] and $one['type'] == 1)
{
    ?>, �������� <?php echo $one['room'];
}
else if ($one['room'])
{
    ?>, ����� <?php echo $one['room'];
}

?>
<?php if ($one['status'] < 2) { ?>
</a>
<?php } ?>
</td>
<td><?php echo number_format($one['price'],0,'.',' ')?> ���.</td>
<td style="text-align:center;">
<?php if ($one['result_id']) {
    
    if (Special_Vtor_Settings::$districtPlus)
        $plus = Special_Vtor_Settings::$districtPlusPostFix;
    else 
        $plus = '';
    
    ?>
<a href="/catalogue/type/<?php echo $one['type']; ?>/object/<?php echo $one['result_id']; ?>/adress<?php echo $plus ?>/">������</a>
<?php } else  if ($one['status'] == 0) { ?>
�������������
<?php } else  if ($one['status'] == 1) { ?>
��������� �� ������������
<?php } else  if ($one['status'] == 2) { ?>
��������������
<?php } else  if ($one['status'] == 4) { ?>
��������
<?php } ?>

</td>

<td>
<?php if ($one['status'] != 2) { ?>
<a id="a-save-buttom" href="/user/do/deletefromquery/<?php echo $one['id']?>/" title="�������� �� ������� ������ �� ����������">�������</a>
<?php } ?>
</td>
</tr>
   <?php    
}
    
?></table><?php
} else {
?>
</table>
<p class="p-center-say">�� ������ ������ ��� �������� ������</p>
<?php } ?>

</div>