<?php
$array = array(
               'all'  => array('name' => '���������', 'url' => '/user/message/'),
//               'list'     => array('name' => '��� ������������', 'url' => '/user/list/')
               );
    

?>
<br />
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
