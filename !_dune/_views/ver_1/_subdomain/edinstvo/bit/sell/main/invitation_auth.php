<?php switch ($this->message_code) { 
case 51: ?>
<p id="system-message">������ ������ �� ������� �� ��������������.</p>
<?php break; ?> 

<?php case 52: ?>
<p id="system-message">������������� ������.</p>
<?php break; ?> 

<?php case 53: ?>
<p id="system-message">������������� ����� ������.</p>
<?php break; ?> 

<?php case 4: ?>
<p id="system-message">�������� ����� ����������� ��������, ����������� �� ���������.</p>
<?php break; ?> 


<?php case 55: ?>
<p id="system-message">������ ������.
<?php if ($this->last_edit) { ?>
<br /><br /><span><a href="/public/sell/<?php echo $this->last_edit['type_code']?>/?edit=<?php echo $this->last_edit['id']?>">������������� ���������</a></span>
</p>
<?php }
break; ?> 

<?php case 54: ?>
<p id="system-message">����� ��������� ������ �� ��������������.</p>
<?php break; ?> 

<?php } ?>

<!--
<dl>
<dt>�� ������ �������:</dt>
<dd>
<ul>
<li><a href="/public/sell/room/">��������</a></li>
<li><a href="/public/sell/garage/">�����</a></li>
<li><a href="/public/sell/nolife/">������� ���������</a></li>
</ul>
</dd>
</dl>
-->

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
