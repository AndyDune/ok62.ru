<div id="request">
<table class="table-verska">
<tr><td style="vertical-align:top;">

<p>
<?php if ($this->have)
{ ?>
<a href="/user/request/" class="buttom">Мои заявки</a>
<?php
} ?>
<a href="/public/request/list/" class="buttom">Все заявки</a>
<?php if ($this->my)
{ ?>
<a href="/public/request/edit/?edit=<?php echo $this->edit; ?>" class="buttom">Редактировать эту заявку</a>
<?php
} ?>
</p>

<p><strong><?php echo $this->data['name']; ?></strong></p>
<?php if ($this->data['sale'] or $this->data['rent'])  { ?>
<p>Хочу: 
<?php
$x = 0;
if ($this->data['sale'])
{ $x = 1;
    ?>купить<?php    
}
?>
<?php
if ($this->data['rent'])
{
    if ($x) {?>, <?php }
    ?>арендовать<?php    
}
?> 
</p>
<?php } ?>
<?php if ($this->data['price']) { ?>
<p>Стоимость: <?php echo $this->data['price']; ?></p>
<?php } ?>
<?php if ($this->data['text']) { ?>
<dl class="no_format"><dt>Описание:</dt><dd style="padding-left: 20px;"><pre style="padding:0; margin:0;">
<?php echo $this->data['text']; ?>
</pre></dd></dl>
<?php } ?>

</td><td class="small-td" style="width: 200px; text-align:center; vertical-align:top;">

	  <h3 class="ex">Заявитель</h3>
      <?php
      if ($this->array_photo)
      {
          ?><a class="thickbox" href="/user/info/<?php echo $this->user->getUserId(); ?>/"><img src="<?php
        echo $this->array_photo[2];
        ?>" width="100" height="100" /></a><?php
      }
      else 
      {
        ?><img src="<?php echo $this->view_folder;?>/img/user/avatars/first.gif" width="100" height="100" /><?
      }
      ?>
      <?php if ($this->user) { ?>
	  <dl class="no_format">
	  <dt></dt>
	  <dd><a href="/user/info/<?php echo $this->user->getUserId(); ?>/"><?php echo $this->user->getUserName(); ?></a></dd>
	  </dl>
	  <?php } else {?>
	  <dl class="no_format">
	  <dt></dt>
	  <dd>Имя</dd>
	  </dl>

	  <?php }?>

</td></tr>
</table>
</div>