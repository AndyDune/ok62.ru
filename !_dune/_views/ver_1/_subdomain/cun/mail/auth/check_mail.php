<div id="letter-body">
<h1>Проверка подлинности введенного адреса эл. почты</h1>
<p>Была совершена попытка зарегистрироватся на сайте <a href="http://<?php echo $this->domain?>"><?php echo $this->domain?></a></p>
<p>Если Вы согласны продолжить, пожалуйста, пройдите по ссылке: <a href="http://<?php echo $this->domain?>/user/checkmail/?mail=<?php echo $this->mail?>&code=<?php echo $this->code?>"><?php echo $this->domain?></a></p>
<p>Либо пройдите на страницу сайта <a href="http://<?php echo $this->domain?>/user/checkmail/"><?php echo $this->domain?></a> и введите:</p>
<ul>
<li style="margin: 2px;"><span style="width:100px">Адрес e-mail: </span><span style="padding 2px; background-color:#FFFFCC;"><?php echo $this->mail;?></span></li>
<li style="margin: 2px;"><span style="width:100px">Код: </span><span style="padding 2px; background-color:#FFFFCC;"><?php echo $this->code;?></span></li>
</ul>
</div>