<h1>Получено сообщение с &laquo;публичного чата&raquo; при <a href="http://<?php echo $this->domain; ?>/catalogue/object/<?php
        echo $this->objectId;
        ?>/">объекте</a></h1>
<dl>
<dt>Пользователь</dt>
<dd><a href="http://<?php echo $this->domain; ?>/user/info/<?php echo $this->senderId ?>/"><?php echo $this->senderName; ?></a></dd>
        <dt>Текст сообщения</dt>
        <dd><pre><?php echo $this->ttext; ?></pre></dd>
        <dt>Страница</dt>
        <dd><a href="http://<?php echo $this->domain; ?>/catalogue/object/<?php
        echo $this->objectId;
        ?>/">Карточка объекта</a></dd>
        </dl>
        
