
<?php
$array = array(
               'info'  => array('name' => 'Информация', 'url' => '/user/info/'),
               'edit'  => array('name' => 'Редактирование информации', 'url' => '/user/edit/'),
               'changepassword'  => array('name' => 'Смена пароля', 'url' => '/user/changepassword/')               
               );
?>
<ul id="bookmark">
<?php foreach ($array as $key => $value) { ?>
<li <?php
if ($key == $this->code)
{
 ?> class="current"<?php
} 
?>><a href="<?php echo $value['url'];?>"><span><em><?php
 echo $value['name'];
?></em></span></a></li><?php 
}
?>
</ul>
