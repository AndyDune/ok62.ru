
<?php
$array = array(
               'request'  => array('name' => 'Заявки на размещение', 'url' => '/user/sell/request/'),
               'sell'     => array('name' => 'В каталоге', 'url' => '/user/sell/'),
//               'noactive' => array('name' => 'Зарезервированные', 'url' => '/user/sell/noactive'),
               'history'  => array('name' => 'Проданные (архив)', 'url' => '/user/sell/history/'),
//               'pay'      => array('name' => 'Оплата', 'url' => '/user/sell/pay/') // закладка оплаты               
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
