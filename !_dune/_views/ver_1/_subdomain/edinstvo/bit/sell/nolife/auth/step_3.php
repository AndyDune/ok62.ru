<h1>������ �� ���������� ������������ ������������ � ��������</h1>

<?php
//echo $this->steps_panel;
?>

<?php switch ($this->message_code) { 
case 1: ?>
<p id="system-message">�� ��������� ������������ ����.</p>
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

<?php } 

echo $this->steps_panel;
?>

<div id="object-under-bookmark">
<div id="object-sell">




<?php if (count($this->array_plan)) { ?>
<dl>
<dt>�� ��������� ���������� (������������):</dt>
<dd><BR><div class="pictures-float-list"><a href="<?php echo $this->array_plan[1]; ?>" class="thickbox" ><img src="<?php echo $this->array_plan[2]; ?>" /></a></div></dd>
<dt><p>�� ������ <a href="<?php echo $this->array_plan[1]; ?>" class="thickbox" >����������� ����������� �����������</A> ��� <a href="<?php echo $this->url; ?>?delete=yes&name=<?php echo $this->array_plan[0]; ?>">�������</a> ��� ���������� � ��������� ������.</p></dt>
</dl>
<?php } else {?>



<form method="post" enctype="multipart/form-data">

<div class="form-part">
<p>���������� ������ �������� ��������� �������� ����� �� ����� ������������� � �������� ������������ ������ ����������!</p>
<p>���� ������ ����������, ������� ����� ����� "���������" ��� � ��� �� ��������� ���� ������������, ���� ������� ����� ����������� � ��� ������ �������������� ������� ������������ ����� �����.</p>
<p>�������, �������� ���������� �������� ��������� � ������������� � ���� �� ������ ��� ������� - ��� ����������� ��� ����������.</p>
<p></p>
<p>�� ���� �������� �� ������ �������� � ������ ���������� ���������� ������ �������� ���������.<BR>
��� ����� ���������� ������ ������ "�����..." � �����, ������������� ����, � ������� ����������� ���� �� ����� ���������� � ����������� �������� ���������.</p>
<p>����������� ���� �� ������ ��������� 1 ��������� � ������ ���� ������� .gif ��� .jpg ��� .png.</p>


<p><input type="file" name="plan[]" /></p>


<BR><BR>
<dl>
<dt><B>� ���� ���� ����������� ���� � �����������. ��� ���������� ��� ������ � ������?</B></dt>
<dd><I>��� ����� ���������� ������ �� ��� ����� �������� ����; � ����������� ���������� ���� ������� ����� "��������".</I></dd>
<dd><I>���� "��� �����" ������ ���������� ���� "Graphics Interchange Format Image" (��� ������� .gif) ���� "JPEG Image" (��� ������� .jpg) ���� "Portable Network Graphics Image" (��� ������� .png)</I></dd>
<dd><I>���� "������" �� ������ ���� ������ 1�� (�������������� 1 000 000 ����).</I></dd>
<dt><B>� ���� ���� ���������� � ����������� �� ������� ���������. ��� ��� �������� � ���������� ����������?</B></dt>
<dd><I>��� ����� ����� ������� ���� �� ��������� ��������:</I></dd>
<dd><li><I>������������� �� ������� ��� ���������� � ������������ ����������� ���� �������� � ������ ������.</I></li></dd>
<dd><li><I>��������� �� ����� �� �����: (4912) 953-953 � �������� "��� ���������� �� ����� ok62.ru".</I></li></dd>
<dd><li><I>�������� ��� ���������� � ��� � ���� �� ������: ����� ������, ��.���������, ��� 47, ���� ��� "������ �������� "��������", � ���� ����������� ��������� ���������� ��� ����������� ��������.</I></li></dd>
<dt><B>� ���� ��� ����������� �� ������� ��������� ��� ���������� ��� ����������. ��� ��� �������� � ���������� ����������?</B></dt>
<dd><I>��� ����� ���������� ���������� ���������� ���� ���������� �� ����� ������. ���������� ����� ��� ������� �������� �������� ��������� ������ �������� ���������. ����� ���������� ����� ���� ������� �������� ������� �������� ��������� (����� ����).</I></dd>
<dd><I>����� ���� ������������� ������� �����:</I></dd>
<dd><li><I>�������� � ��� � ���� �� ������: ����� ������, ��.���������, ��� 47, ���� ��� "������ �������� "��������";</I></li></dd>
<dd><li><I>��������� �� ����� �� �����: 390005, ����� ������, ��.���������, ��� 47, ���� ��� "������ �������� "��������";</I></li></dd>
<dd><li><I>��������� �� ����� �� �����: (4912) 953-953 � �������� "��� ���������� �� ����� ok62.ru".</I></li></dd>
<dd><I>���� ����������� ��������� ���������� ��� ����������� �������� �� ��������� � ���������� ����� ����������.</I></dd>
</dl>
</div>

<input name="_do_" type="hidden" value="save" />
<input name="id" type="hidden" value="<?php echo $this->id; ?>" />
<p class="submit-tipa-big">
<input name="go" type="submit" value="���������" />
</p>
</form>
</div>

<div class="ugol-left-top"></div>
<div class="ugol-left-bottom"></div>
<div class="ugol-right-top"></div>
<div class="ugol-right-bottom"></div>

<?php } ?>



</div>
