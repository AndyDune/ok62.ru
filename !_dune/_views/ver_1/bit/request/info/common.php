<div id="request">
<p id="request-menu">
<?php if ($this->have)
{ ?>
<a href="/user/request/" class="buttom">������������ ������</a>
<?php
} ?>
<?php if (Dune_Variables::$userStatus > 499 or true)
{ ?>
<a href="/public/request/list/" class="buttom">��� ������</a>
<?php } ?>
<?php if ($this->my)
{ ?>
<a href="/public/request/edit/?edit=<?php echo $this->edit; ?>" class="buttom">������������� ��� ������</a>
<?php
} ?>
</p>


<table class="table-verska">
<tr><td style="vertical-align:top;">


<!--
<h2><?php echo $this->data['name']; ?></h2>
-->

<h2>���� <?php
$x= 0;
if ($this->data['sale'])
{
    $x = 1;
    ?> ������<?php    
}

if ($this->data['rent'])
{
    if ($x)
    {
        ?> ��� <?php
    }
    ?> ����������<?php    
}
?>

<?php foreach ($this->types as $key => $value) 
{
    
    if ($this->data['type'] == $key)
    {
        ?> <?php echo $value['nameTo'];
    }
} ?>
</h2>

<dl><dt><strong>��������������:</strong></dt>
<dd>
<p class="in-dd">
<?php echo str_replace("\r\n", '<br />', $this->data['adress']) ?>
</p>
</dd>
</dl>

<?php ob_start(); ?>
<p class="in-dd"><strong>������:</strong>
<?php
$x = false;
 if ($this->data['rooms_count_1']) { $x = true; ?>1<?php } 
 if ($this->data['rooms_count_2']) {
    if ($x) { ?>, <?php }      
    $x = true; ?>2<?php } 
 if ($this->data['rooms_count_3']) {
     if ($x) { ?>, <?php }      
     $x = true; ?>3<?php } 
 if ($this->data['rooms_count_4']) {
     if ($x) { ?> ��� <?php }      
     $x = true; ?>����� 3-�<?php } ?>
<?php if ($this->data['rooms_count_text']) { 
    if ($x) { ?> (<?php }
echo $this->data['rooms_count_text'];
    if ($x) { ?>) <?php }
    $x = true;
} ?> 
</p>
<?php 
$text = ob_get_clean();
if ($x)
   echo $text;
?>


<p><strong>��������� ��:</strong> <?php echo $this->data['price_to']; ?></p>

<dl><dt><strong>����� ��������� �����:</strong></dt><dd>
<p class="in-dd">
<?php echo $this->data['variant_text'] ?>

<?php if ($this->data['variant_date']) { ?>
 <em>��������� ������� ��</em> <?php echo $this->data['variant_date'] ?>
<?php } ?>
</p>
</dd></dl>

<dl><dt><strong>��������:</strong></dt>
<dd>
<p class="in-dd">
<?php echo str_replace("\r\n", '<br />', $this->data['contact']) ?>
</p>
</dd>
</dl>


</td><td class="small-td" style="width: 200px; text-align:center; vertical-align:top;">

	  <h3 class="ex">���������</h3>
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
	  <dd>�� ���������������</dd>
	  </dl>

	  <?php }?>

</td></tr>
</table>


</div>