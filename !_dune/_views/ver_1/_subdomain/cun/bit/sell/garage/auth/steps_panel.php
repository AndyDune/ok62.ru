
<p id="link-to-panel"><a href="/user/sell/request/" class="buttom">Выставленные на продажу</a></p>

<!--
<ul id="steps-panel">
<li>
<?php if ($this->step == 1) {
?><span>1. Информация</span>
<?php } else { ?>
<a href="/public/sell/room/step_1">1. Информация</a>
<?php }?>
</li>

<li class="bg">
<?php if ($this->step == 2) {
?><span>2. Графика</span>
<?php } else { ?>
<a href="/public/sell/room/step_2">2. Графика</a>
<?php }?>
</li>

<li class="bg">
<?php if ($this->step == 10) {
?><span>3. Продажа</span>
<?php } else { ?>
<a href="/public/sell/room/step_10">3. Продажа</a>
<?php }?>
</li>
</ul>
-->

<?php
$array = array(
               1  => array('name' => '1. Информация', 'url' => '/public/sell/' . $this->object_type_code . '/step_1/'),
               3  => array('name' => '2. Планировка', 'url' => '/public/sell/' . $this->object_type_code . '/step_3/'),               
               2  => array('name' => '3. Фотографии', 'url' => '/public/sell/' . $this->object_type_code . '/step_2/'),
               4  => array('name' => '4. На карте', 'url' => '/public/sell/' . $this->object_type_code . '/step_4/'),
               9  => array('name' => '5. Панорамные обзоры', 'url' => '/public/sell/' . $this->object_type_code . '/step_9/'),
               10 => array('name' => '6. Подтверждение', 'url' => '/public/sell/' . $this->object_type_code . '/step_10/'),
               );
               
?>
<ul id="bookmark">
<?php foreach ($array as $key => $value) { ?>
<li <?php
if ($key == $this->step)
{
 ?> class="current"<?php
} 
?>><a href="<?php echo $value['url'];?>"><span><em><?php
 echo $value['name'];
?></em></span></a></li><?php 
}
?>
</ul>
