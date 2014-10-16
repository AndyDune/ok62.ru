<div id="ocatalogue">
<h1><?php echo $this->data['name'] ?></h1>
<div  id="ocatalogue-one">
<div id="ocatalogue-one-img"><?php

        if ($this->data['pic'])
        {
            $link_pic = '/ddata/ocatalogue/logo/' . $this->data['pic'];
        }
        else 
            $link_pic = $this->view_folder .'/img/ocatalogue_text_pic.gif';

?><img width="150" height="150" src="<?php echo $link_pic; ?>" alt="<?php echo $this->data['name']; ?>" /></div>
<div  id="ocatalogue-one-info">
<p><?php echo $this->data['description'] ?></p>

<?php if ($this->data['adress'])
{
?>
<dl>
<dt>Адреса в городе Рязани:</dt><dd>
<?php
$str = new Dune_String_Transform($this->data['adress']);
$str->deleteLineFeed(2)->setLineFeedToBreak();
echo $str
?></dd></dl><?php    
}
?>


<?php if ($this->data['phone'])
{
?>
<dl>
<dt>Телефон(ы):</dt><dd><?php
$str = new Dune_String_Transform($this->data['phone']);
$str->deleteLineFeed(1)->setLineFeedToBreak();
echo $str
?></dd></dl><?php    
}
?>

<?php if ($this->data['site'])
{
?>
<p><strong>Сайт:</strong>
<?php
if (strpos($this->data['site'], 'http://') !== false)
{
    $link = $this->data['site'];
    $name = substr($this->data['site'], 7);
}
else 
{
    $link = 'http://' . $this->data['site'];
    $name = $this->data['site'];
}
?>
<noindex>
<a target="_blank" rel="nofollow" href="<?php echo $link; ?>"><?php echo $name; ?></a>
</noindex>
</p>
<?php    
}
?>


<?php if ($this->data['diskont'])
{
?>
<p><strong>Дисконт:</strong>
<strong class="diskont">
<?php echo $this->data['diskont']; ?>
</strong>
</p>
<?php    
}
?>


<?php if (Dune_Variables::$userStatus > 499)  {?>
<p style="text-align:right;"><a class="buttom" href="/adminocatalogue/edit/<?php echo $this->data['id'] ?>/">Редактировать</a></p>
<?php } ?>


</div></div>
</div>