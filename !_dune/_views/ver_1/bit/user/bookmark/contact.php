<?php
if ($this->one_user)
{
$array = array(
               'dialogs'  => array('name' => 'В контакте', 'url' => '/user/dialogs/'),
               'list'     => array('name' => 'Все пользователи', 'url' => '/user/list/'),
               'info'     => array('name' => 'Пользователь: ' . $this->user->getUserName(), 'url' => '/user/info/' . $this->user->getUserId() . '/')
//               'contact'  => array('name' => 'Общение', 'url' => '/user/contact/user_' . $this->user->getUserId() . '/')               
               );
if ($this->link_to_topic)
{
    if (strpos($this->link_to_topic, 'ic_dif') !== false)
        $name = 'Общение';
    else 
        $name = 'Обсуждение объекта';
    $array['contact'] = array('name' => $name, 'url' => '/user/contact/user_' . $this->user->getUserId() . '/'. $this->link_to_topic . '/');
}
}
else 
{
$array = array(
               'dialogs'  => array('name' => 'В контакте', 'url' => '/user/dialogs/'),
               'list'     => array('name' => 'Все пользователи', 'url' => '/user/list/')
               );
    
}
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
