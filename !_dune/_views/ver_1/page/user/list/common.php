<?php
Dune_Static_StylesList::add('talk/base');
?>
<h3>�������� ������</h3>
<p>����� ��������� ������������ �������, � �������� �� ���������� �� �����-���� ��������.</p>
<?php if (count($this->list_contact)) { ?>
<table>
<?php foreach ( $this->list_contact as $value) { ?>
<tr>
<td>
<?php
/*
echo '<pre>';
print_r($value);
echo '</pre>';
*/
if (!$value['talk_read'])
{
    ?>
<a class="talk-status-message-new" href="/user/info/<?php echo $value['id']; ?>/" title="����� ���������"><span>�����</span></a>
<?php } else {?>    
<a class="talk-status-message-new-no" href="/user/info/<?php echo $value['id']; ?>/"  title="��� ����� ���������"><span>��� �����</span></a>
<?php } ?>
</td>
<td>
<a href="/user/info/<?php echo $value['id']; ?>/"><?php echo $value['name'];  ?></a>
</td>
</tr>
<?php } ?>
</table>

<?php } else{?>
<B>��� �������������</B>
<?php } ?>


<h3>���������� � �������</h3>
<p>����� ��������� ������������ �������, � �������� �� ������ ������, �� ��� ���� �� ��������.</p>
<?php if (count($this->list_contact_begin)) { ?>
<table>
<?php foreach ( $this->list_contact_begin as $value) { ?>
<tr>
<td>
<a class="talk-status-no-message-no" href="/user/info/<?php echo $value['id']; ?>/" title="��� ���������"><span>��� ��������� ������</span></a>
</td>
<td>
<a href="/user/info/<?php echo $value['id']; ?>/"><?php echo $value['name'];  ?></a>
</td>
</tr>
<?php } ?>
</table>

<?php } else{?>
<B>��� �������������</B>
<?php } ?>