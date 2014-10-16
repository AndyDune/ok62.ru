<div id="letter-body">
<h1>Информация для входа на сайт <a href="http://<?php echo $this->domain?>"><?php echo $this->domain?></a></h1>
<p>Важные данные:</p>
<ul>
<li style="margin: 2px;"><span style="width:150px">Уникальное имя в системе: </span><span style="padding 2px; background-color:#FFFFCC;"><?php echo $this->name;?></span></li>
<li style="margin: 2px;"><span style="width:150px">Адрес e-mail: </span><span style="padding 2px; background-color:#FFFFCC;"><?php echo $this->mail;?></span></li>
<li style="margin: 2px;"><span style="width:150px">Пароль для входа: </span><span style="padding 2px; background-color:#FFFFCC;"><?php echo $this->password;?></span></li>
</ul>
<p>Для быстрого входа пройдите по ссылке: <a href="http://<?php echo $this->domain?>/user/enter/quickly/?login=<?php echo $this->mail?>&password=<?php echo $this->code?>"><?php echo $this->domain?></a></p>
</div>