<div id="talk-form">
<h3>�������� ���������</h3>
<?php switch ($this->message_code) { 
case 1: ?>
<p id="system-message">������ ����������� �������� - ���������� �������� ����� 7 ������.</p>
<?php break; ?> 

<?php case 2: ?>
<p id="system-message">������� ���� �������� � ���������. ����������� �� 3-� �� 500 ��������.</p>
<?php break; ?> 

<?php case 3: ?>
<p id="system-message">� ���� ��������� ��������� ���������.</p>
<?php break; ?> 


<?php } ?>
<p id="output"></p>
<form method="post" id="t-form">
<input type="hidden" id="this_url" name="this_url" value="<?php echo $this->this_url?>" />
<input type="hidden" name="object_id" value="<?php echo $this->object_id?>" />
<input type="hidden" name="interlocutor" value="<?php echo $this->interlocutor?>" />
<input type="hidden" name="what_comment" value="<?php echo $this->what_comment?>" />
<input id="_do_" type="hidden" name="_do_" value="save" />
<textarea name="text" id="textarea-text"><?php echo $this->text; ?></textarea>
<p><input id="buttom-submit" type="submit" name="go" value="���������" /><span> Ctrl+Enter</span></p>
</form>
</div>