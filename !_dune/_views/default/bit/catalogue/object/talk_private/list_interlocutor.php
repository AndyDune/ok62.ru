<div id="interlocutor-list">
<?php if ($this->count) { ?>
<h2>�������</h2>
<?php foreach ($this->list as $key => $value)
{
?>
<ul class="user-info-shot">
<li><a href="<?php echo $this->url; ?>?user=<?php echo $value['id'] ?>"><?php echo $value['name'] ?></a></li>
</ul>
<?php }?>
<?php } else {?>
<h2 class="h2-message">��� ���������</h2>
<?php }?>
</div>