
<?php if ($this->list and count($this->list) > 0) { ?>
<?php foreach ($this->list as $key => $value)
{
?>
<dl class="one-message<?php 
if ($this->i == $value['user_id']) 
{
    ?> my-message<?php
}
?>">
<dt>
<a href="/user/info/<?php echo $value['user_id'] ?>/"><?php echo $value['name_user'] ?></a>
 (<?php echo substr($value['time'], 0, 16) ?>)

</dt>
<dd><?php echo $value['text'] ?></dd>
</dl>
<?php }?>
<?php } else {?>

<?php }?>
