<h1 id="h1-for-auth-forms">�������� ������ ����������� �����</h1>
<?php switch ($this->message_code) { 
      case 17: ?>
<p id="system-message-good">�� ���������� ��� ����������� ������ ��. ����� ���������� ������ � ��������� �����.
���������� ������ ��� � ��������������� ���� ��� ���������� �����������.</p>
<?php break;
      default: ?>
       <p id="system-message"><?php echo $this->message;?></p>
 
<?php }  ?>

<div id="user-enter-form-page">
<p><span><a href="/user/registration/">�����������</a></span> <span><a href="/user/recall/">�������� ������</a></span></p>
<form action="/user/checkmail/" method="post">
<input name="_do_" type="hidden" value="enter" />
<dl id="user-logo-dl">
<dt>E-mail</dt>
<dd><input name="mail" type="text" value="<?php echo $this->mail; ?>" size="50" maxlength="50" /></dd>
</dl>
<dl id="user-password-dl">
<dt>������</dt>
<dd><input name="code" type="text" value="<?php echo $this->code; ?>" size="35" maxlength="35" /></dd>
</dl>
<p id="user-enter-page-submit"><input name="go" type="submit" value="������!" /></p>
</form>
</div>