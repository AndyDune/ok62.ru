
<p id="link-to-panel"><a href="/user/sell/request/" class="buttom">������������ �� �������</a></p>

<!--
<ul id="steps-panel">
<li>
<?php if ($this->step == 1) {
?><span>1. ����������</span>
<?php } else { ?>
<a href="/public/sell/room/step_1">1. ����������</a>
<?php }?>
</li>

<li class="bg">
<?php if ($this->step == 2) {
?><span>2. �������</span>
<?php } else { ?>
<a href="/public/sell/room/step_2">2. �������</a>
<?php }?>
</li>

<li class="bg">
<?php if ($this->step == 10) {
?><span>3. �������</span>
<?php } else { ?>
<a href="/public/sell/room/step_10">3. �������</a>
<?php }?>
</li>
</ul>
-->

<?php
$array = array(
               1  => array('name' => '1. ����������', 'url' => '/public/sell/' . $this->object_type_code . '/step_1/'),
               3  => array('name' => '2. ����������', 'url' => '/public/sell/' . $this->object_type_code . '/step_3/'),               
               2  => array('name' => '3. ����������', 'url' => '/public/sell/' . $this->object_type_code . '/step_2/'),
               4  => array('name' => '4. �� �����', 'url' => '/public/sell/' . $this->object_type_code . '/step_4/'),
               9  => array('name' => '5. ���������� ������', 'url' => '/public/sell/' . $this->object_type_code . '/step_9/'),
               10 => array('name' => '6. �������������', 'url' => '/public/sell/' . $this->object_type_code . '/step_10/'),
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
