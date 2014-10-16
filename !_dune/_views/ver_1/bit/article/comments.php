<div id="article-comment">
<div id="article-comment-list">
<h2>Комментарии</h2>
<?php
if (count($this->list))
{
    foreach ($this->list as $value)
    {
        ?><div class="table-outside">
        <div class="ugol-left-top"></div><div class="ugol-left-bottom"></div><div class="ugol-right-top"></div><div class="ugol-right-bottom"></div>
        <table><tr>
        <td class="first">
        <div>
        <?php if ($value['user_id'] > 0)
        {
            if ($value['ruser_contact_name'])
                $name = $value['ruser_contact_name'];
            else 
                $name = $value['ruser_name'];
            ?><p class="user-name"><a href="/user/info/<?php echo $value['user_id'] ?>/"><?php echo $name ?></a></p>
            <p class="user-img">
            <img src="<?php
            $photo = new Special_Vtor_User_Image_Photo($value['user_id'], $value['ruser_time']);
            
            if (count($photo))
            {
                $t = $photo->getOneImage();
                echo $t->getPreviewFileUrl(50);
            }
            else 
            {
                echo $this->view_folder; ?>/img/user/avatars/first-50.gif<?php
            }
             ?>" width="50" height="50" />
                        </p>
<!--            <p class="user-reg">Зарегистрированый пользователь</p> -->
            <?php
        }
        else 
        {
            if ($value['user_site'])
            {
                $site = $value['user_site'];
                if (strpos($site, 'http:') === false)
                {
                    $site = 'http://' .$site;
                }
                ?><p class="user-name"><noinedx><a rel="noindex" href="<?php echo $site ?>"><?php echo $value['user_name'] ?></a></noindex></p><?php
            }
            else 
            {
            ?><p class="user-name"><?php echo $value['user_name'] ?></p><?php
            }
            ?>
            <p class="user-img">
            <img src="<?php
             echo $this->view_folder; ?>/img/user/avatars/first-50.gif<?php
             ?>" width="50" height="50" />
            </p>
            <p class="user-reg">Гость</p><?php
        }
        ?>
        
        </div>
        </td>
        <td>
        <?php echo $value['text']; ?>
<p class="time-insert">Оставлено: <?php echo $value['time']; ?></p>        
        </td>
        </tr></table></div><?php
//        print_array($value);
    }
}
else 
{
    ?><p style="text-align:center; padding:0; margin: 10px; 0 0 0;">Нет комметариев</p><?php
}
?>
</div>
<div id="article-comment-do">
<h2>Добавить комментарий</h2>
<?php
switch ($this->message)
{
    case 'no_1': // 
    ?><p class="message-comment-no-saved">Пустое сообщение не сохранено.</p><?php
    break;
    case 'no_2': // 
    ?><p class="message-comment-no-saved">Неверный защитный код. Повторите ввод.</p><?php
    break;
    case 'no_3': // 
    ?><p class="message-comment-no-saved">Не заполнены обязательные поля.</p><?php
    break;
    case 'no_4': // 
    ?><p class="message-comment-no-saved">Введен неверный адрес электронной почты.</p><?php
    break;
    case 'no_5': // 
    ?><p class="message-comment-no-saved">Двойные кавычки в имени и адресе эл. почты недопустимы.</p><?php
    break;
    
    case 'yes_1': // 
    ?><p class="message-comment-saved">Ваше сообщение сохранено. Спасибо.</p><?php
    break;
    
}
?>
<form method="post">
<?php
if ($this->use_captcha)
{
?>
<table>
    <tr><td>Имя<span style="color:red">*</span>:</td><td><input name="name" value="<?php echo $this->name; ?>" /></td></tr>
    <tr><td>Адрес эл. почты:</td><td><input name="mail" value="<?php echo $this->mail; ?>" />
    <em>На сайте не публикуется</em>
    </td></tr>
    <tr><td>Защитный код<span style="color:red">*</span>:</td>
    <td>
    <img src="<?php echo $this->captcha_link; ?>" /><br />
    <input name="captcha" style="width:200px; text-align:center; padding:4px; margin-top: 4px;" value="<?php echo $this->captcha; ?>" />
    </td></tr>
</table>
<?php if ($this->prem) { ?>
<p>Сообщения незарегистрированых пользователей проходят премодерацию.</p>
<?php } ?>
<?
}
?>
<p style="padding:0; margin:5px 0 0 0;">Текст комметария:</p>
<textarea name="text" style="width:97%; height: 100px;"><?php echo $this->text ?></textarea>
<input type="hidden" name="com" value="comment" />
<input type="hidden" name="article_id" value="<?php echo $this->article_id ?>" />
<p>
<input type="submit" name="Save" value="Добавить комментарий" />
</p>
<?php
if ($this->use_captcha)
{
?>
<p><span style="color:red">*</span> - поля, обязательные для заполнения</p>
<?php } ?>
</form>
</div>
</div>

