
<?php
$array = array(
               'request'  => array('name' => '������ �� ����������', 'url' => '/user/sell/request/'),
               'sell'     => array('name' => '� ��������', 'url' => '/user/sell/'),
//               'noactive' => array('name' => '�����������������', 'url' => '/user/sell/noactive'),
               'history'  => array('name' => '��������� (�����)', 'url' => '/user/sell/history/'),
//               'pay'      => array('name' => '������', 'url' => '/user/sell/pay/') // �������� ������               
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
