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
<p id="request-menu">
<?php if (Dune_Variables::$userStatus > 499) {?>
<a href="/public/request/list/" class="buttom">��� ������</a>
<?php } ?>
<a href="/public/request/" class="buttom">������ ������ �� ������� ��� ������</a>
</p>
<table>
<?php
$name_type = new Dune_Array_Container($this->types, '������������');
foreach ($this->list as $value) { ?>
<tr>
<td><a href="/public/request/info/<?php echo $value['id']; ?>/"><?php echo ucfirst($name_type[$value['type']]['name']); ?></a></td>
<td class="small-td"><a href="/public/request/edit/?edit=<?php echo $value['id']; ?>">�������������</a></td>
<td class="small-td"><a href="/public/request/edit/?delete=delete&edit=<?php echo $value['id']; ?>">�������</a></td>
</tr>
<?php } ?>
</table>
</div>