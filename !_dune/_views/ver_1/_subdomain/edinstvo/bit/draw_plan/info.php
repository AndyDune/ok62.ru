<?php
if ($this->data['contact_name'])
    $name = $this->data['contact_name'];
else 
    $name = $this->data['name'];
    ?>
<h1>Просмотр нарисованой планировки. Автор: <a href="/user/info/<?php echo $this->data['user_id']; ?>/"><?php echo $name; ?></a></h1>
<?php
// echo $this->steps_panel;
$this->setResult('title', 'Просмотр нарисованой планировки. ');
?>


<div id="object-under-bookmark">
<div id="object-info">
<div id="object-sell">
<?php if ($this->my_draw) { ?>
<p><a  class="buttom" href="/public/plan/draw/<?php echo $this->look; ?>/">Редактировать</a></p>


<?php if (false) { ?>
<?php if (!$this->data['public']) { ?>
<p><a href="/public/plan/info/<?php echo $this->look; ?>/topublic/">Сделать доступным всем для просмотра.</a></p>
<?php } else { ?>
<p><a href="/public/plan/info/<?php echo $this->look; ?>/frompublic/">Закрыть доступ для всех.</a></p>
<?php } ?>
<?php } ?>

<?php } ?>
<p>Сcылка на картинку: <em>http://ok62.ru/public/plan/info/<?php echo $this->look; ?>/pic/</em> </p>
<img src="/public/plan/info/<?php echo $this->look; ?>/pic/" / >
</div>



</div>

<div class="ugol-left-top"></div>
<div class="ugol-left-bottom"></div>
<div class="ugol-right-top"></div>
<div class="ugol-right-bottom"></div>

</div>
