<?php
if ($this->link_to)
{
$array = array(
               'main'  => array('name' => '��� �����������', 'url' => '/user/nearby/'),
               'list'  => array('name' => '���������', 'url' => '/user/nearby/list/')
               );
}
else 
{
$array = array(
               'main'  => array('name' => '��� �����������', 'url' => '/user/nearby/')
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
