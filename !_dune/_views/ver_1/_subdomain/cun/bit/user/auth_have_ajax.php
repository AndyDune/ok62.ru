<div id="user-enter-form-common">
<p id="p-main-line">
<?php if ($this->talk) {?>
<a href="/user/message/" id="user-talk" title="Новое сообщение"><img src="<?php echo $this->view_folder;?>/user/nmes.gif" alt="" /></a>
<?php } ?>
<a id="user-name" href="/user/info/"><?php echo $this->name;?></a>
<a href="/user/enter/exit/">Выход</a>
</p>
</div>
<?php if (($this->list) and count($this->list)) {
$z_index = 10;
foreach ($this->list as $value)
{
    if ($value['name_user_contact'])
        $name = $value['name_user_contact'];
    else 
        $name = $value['name_user'];
        
    if (!$value['topic_code'])
        $topic = $value['topic_id'];
    else 
        $topic = 'dif';
        
?>
<div class="look-for-message" style="z-index: <?php echo $z_index ?>;">
<p class="look-for-message-user">Новое сообщение от пользователя:<br /> <a href="/user/info/<?php echo $value['user_id'] ?>/"><?php echo $name ?></a></p>
<p class="links-to-message">
<a class="buttom" href="/user/contact/user_<?php echo $value['user_id'] ?>/topic_<?php echo $topic; ?>/#edge">Читать</a>
&nbsp;&nbsp;<a class="buttom setread" href="/user/check/setread/<?php echo $value['id'] ?>">Игнорировать</a>
</p>
</div>
<?php    
$z_index++;
}
?>

<?php } ?>