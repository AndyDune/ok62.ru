<div id="user-enter-form-common">

<p id="p-main-line">
<a href="/user/enter/" id="user-enter-form-show" class="a-underline-dashed">����</a>
<a href="/user/registration/" class="a-underline-line">�����������</a>
</p>

</div>

<div id="user-enter-form-hidden" class="no-display">
<p id="p-close-hidden">
<a href="#" id="user-enter-form-hide"><span>�������</span></a>
</p>

<form action="/user/enter/" method="post">
<input name="_do_" type="hidden" value="enter" />
<p class="name-parol">
<span>���(e-mail):</span> 
<input name="login" type="text" value="<?php echo $this->login; ?>" size="30" maxlength="50" />
</p>
<p class="name-parol">
<span>������:</span> 
<input name="password" type="password" value="" size="30" maxlength="30" />
</p>

<p id="p-enter-buttom">
<input id="enter-buttom" type="image" src="<?php echo $this->view_folder;?>/img/enter.png" name="go" value="����" alt="����" />
</p>
</form>
<p id="p-get-pass">
<span><a href="/user/recall/">�������� ������</a></span>
<span><a href="/user/registration/">�����������</a></span>
</p>

</div>
