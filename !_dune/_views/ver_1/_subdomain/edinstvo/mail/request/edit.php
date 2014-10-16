<div id="letter-body">
<h1>Была отредактирована заявка на приобретение недвижимости.</h1>
<p>Посмотреть заявку можете по аресу: <a href="http://<?php echo $this->domain; ?>/public/request/info/<?php echo $this->id; ?>/"><?php echo $this->domain?></a></p>
<p>Помните, для просмотра чужой заявки необходимо быть авторизованным на сайте <a href="http://<?php echo $this->domain?>"><?php echo $this->domain?></a> и иметь соответствующие права.</p>

<hr />
Текст заявки:
<hr />
<h2>Хочу <?php
$x= 0;
if ($this->data['sale'])
{
    $x = 1;
    ?> купить<?php    
}

if ($this->data['rent'])
{
    if ($x)
    {
        ?> или <?php
    }
    ?> арендовать<?php    
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

<dl><dt><strong>Местоположение:</strong></dt>
<dd>
<p class="in-dd">
<?php echo str_replace("\r\n", '<br />', $this->data['adress']) ?>
</p>
</dd>
</dl>

<?php ob_start(); ?>
<p class="in-dd"><strong>Комнат:</strong>
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
     if ($x) { ?> или <?php }      
     $x = true; ?>более 3-х<?php } ?>
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
 


<p><strong>Стоимость до:</strong> <?php echo $this->data['price_to']; ?></p>

<dl><dt><strong>Готов заплатить сразу:</strong></dt><dd>
<p class="in-dd">
<?php echo $this->data['variant_text'] ?>

<?php if ($this->data['variant_date']) { ?>
 <em>остальное заплачу до</em> <?php echo $this->data['variant_date'] ?>
<?php } ?>
</p>
</dd></dl>

<dl><dt><strong>Контакты:</strong></dt>
<dd>
<p class="in-dd">
<?php echo str_replace("\r\n", '<br />', $this->data['contact']) ?>
</p>
</dd>
</dl>

</div>