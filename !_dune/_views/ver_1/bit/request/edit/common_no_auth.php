<div id="request-up-text">
<p style="margin: 20px 0 0 0;">
������ ������ ��������, �� �� ��������� ���������� �������?
</p>
<p style="margin: 7px 0 20px 0;">
�������� ���� ������� � �� ������ ���� <strong>�����</strong>.
</p>
</div>

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

<?php case 5: ?>
<p id="system-message">������.</p>
<?php break; ?> 

<?php case 6: ?>
<p id="system-message">������ �������� �������� ���. ��������� �������.</p>
<?php break; ?> 


<?php case 54: ?>
<p id="system-message">����� ��������� ������.</p>
<?php break; ?> 

<?php } ?>

<div id="form">

<p id="request-menu">
<?php if ($this->have)
{ ?>
<a href="/userna/request/" class="buttom">������������ ������</a>
<?php
} ?>
<?php if (Dune_Variables::$userStatus > 499 or true)
{ ?>
<a href="/public/request/list/" class="buttom">��� ������</a>
<?php } ?>
</p>


<form method="post" action="<?php echo $this->action; ?>">
<input type="hidden" name="edit" value="<?php echo $this->edit; ?>" />
<input type="hidden" name="save" value="save" />
<!--
<dl><dt>���������:</dt><dd><input style="width:500px;" name="name" type="text" value="<?php echo $this->data['name']; ?>" maxlength="250" /></dd></dl>
-->

<dl><dt>��� �� �� ������?</dt><dd><ul style="list-style-type:none;">
<li><input type="checkbox" name="sale" value="1"<?php
if ($this->data['sale'])
{
    ?> checked="checked"<?php    
}
?> /> ������</li>
<li><input type="checkbox" name="rent" value="1"<?php
if ($this->data['rent'])
{
    ?> checked="checked"<?php    
}
?> /> ����������</li>
</ul>
</dd></dl>

<dl><dt>��� ���������(���������):</dt>
<dd>
<p class="in-dd">
<select name="type">
<?php foreach ($this->types as $key => $value) { ?>
<option value="<?php echo $key; ?>"<?php 
if ($this->data['type'] == $key)
{
    ?> selected="selected" <?php
}
?>><?php echo $value['nameTo'] ?></option>
<?php } ?>
</select>
</p>
</dd>
</dl>

<dl><dt>�����������������:</dt>
<dd>
<textarea name="adress" rows="3"><?php echo $this->data['adress'] ?></textarea>
</dd>
</dl>

<dl><dt>������� ������:</dt>
<dd>
<ul>
 <li><input type="checkbox" name="rooms_count_1" value="1" <?php if ($this->data['rooms_count_1']) { ?>checked="checked"<?php } ?> /> 1</li>
 <li><input type="checkbox" name="rooms_count_2" value="2" <?php if ($this->data['rooms_count_2']) { ?>checked="checked"<?php } ?> /> 2</li>
 <li><input type="checkbox" name="rooms_count_3" value="3" <?php if ($this->data['rooms_count_3']) { ?>checked="checked"<?php } ?> /> 3</li>
 <li><input type="checkbox" name="rooms_count_4" value="4" <?php if ($this->data['rooms_count_4']) { ?>checked="checked"<?php } ?> /> ����� 3-�</li>
 <li>�����������: <input type="text" name="rooms_count_text" value="<?php echo $this->data['rooms_count_text'] ?>" maxlength="250" style="width:500px;" /></li>
 
</ul>
</dd>
</dl>


<dl><dt>��������� ��:</dt><dd>
<input name="price_to" type="text" value="<?php echo $this->data['price_to']; ?>" />
</dd></dl>

<dl><dt>����� ��������� �����:</dt><dd>
<p class="in-dd">
<input name="variant_text" style="width:500px;" class="title-to-value" title="������� �� ��������� ��� �����" id="variant_text" type="text" value="<?php echo $this->data['variant_text']; ?>" maxlength="250" />
</p><p class="in-dd">��������� ������� ��</p><p class="in-dd">
<input name="variant_date" style="width:500px;" class="title-to-value" title="���� �������������� �������" type="text" value="<?php echo $this->data['variant_date']; ?>" maxlength="250" />
</p>
</dd></dl>

<dl><dt>��������:</dt>
<dd>
<?php 
if (!$this->data['contact'])
{
    $this->data['contact'] =
'����� ��. �����:
�������(�):
ICQ: ';
}
?>
<textarea name="contact" rows="4"><?php echo $this->data['contact'] ?></textarea>
</dd>
</dl>

<?php if (!$this->edit) { ?>
<dl><dt>������� ���, ������������ �� ��������:</dt><dd>
<p>
<input name="captcha" type="text" value=""  style="width:200px; font-size: 20px; text-align:center;" />
</p>

<p>
<img  src="<?php echo $this->captcha; ?>" />
</p>
</dd></dl>
<?php } ?>

<p><input type="submit" name="go" value="���������" /></p>
</form>
