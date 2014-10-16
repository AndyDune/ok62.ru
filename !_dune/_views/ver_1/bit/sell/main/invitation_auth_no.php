<?php switch ($this->message_code) { 
case 51: ?>
<p id="system-message">������ ������. �������� ������ ����� ������ � ������� ������ �����.</p>
<?php break; ?> 

<?php case 52: ?>
<p id="system-message">������������� ������.</p>
<?php break; ?> 

<?php case 55: ?>
<p id="system-message">������ ������.
<?php if ($this->last_edit) { ?>
<br /><br /><span><a href="/public/sell/<?php echo $this->last_edit['type_code']?>/">������������� ���������</a></span>
</p>
<?php
}
break; ?> 

<?php case 54: ?>
<p id="system-message">����� ��������� ������ �� ��������������.</p>
<?php break; ?> 

<?php case 56: ?>
<p id="system-message">������ ������.</p>
<?php break; ?> 


<?php } ?>

<?php if ($this->last_edit) { ?>
<div id="div-sell-no-auth-have-edit">
<p>�� ������ ������� � ������� �� ���������� � ������� 
<?php
switch ($this->last_edit['type_code'])
{
    case 'room':
        ?> ��������<?php
    break;
    case 'garage':
        ?> �����<?php
    break;
    case 'nolife':
        ?> ������� ���������<?php
    break;
}
?>
</p>
<dl>
<dt>�� ������:</dt>
<dd>
<ul>
<li><a href="/public/sell/<?php echo $this->last_edit['type_code']?>/">���������� ��������������</a></li>
<li><a href="/public/sell/do/delete/">������� ��������� ���������� � ������ �������</a></li>
</ul>
</dd>
</dl>
</div>
<?php
} else {
?>

<dl id="dl-want-to-sell">
<dt>������� ������ �� ���������� � ��������:</dt>
<dd>
<ul>
<li>
<form method="post">
<input type="hidden" name="new" value="room" />
<input type="submit" name="go" value="��������" />
</form>
</li>

<li>
<form method="post">
<input type="hidden" name="new" value="nolife" />
<input type="submit" name="go" value="������������ ������������" />
</form>
</li>

<li>
<form method="post">
<input type="hidden" name="new" value="garage" />
<input type="submit" name="go" value="������" />
</form>
</li>

</ul>
</dd>
</dl>

<?php } ?>