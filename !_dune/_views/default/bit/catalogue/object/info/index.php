<?php
// catalogue/info_one.css
?>
<h1><?php echo $this->object->name_type?></h1>
<ul id="bookmark">
<?php foreach ($this->bookmarks as $value) { ?>
<li <?php
if ($value['3'])
{
 ?> class="current"<?php
} 
?>><a href="<?php echo $value['2'];?>"><span><?php
if ($value['1'] == 'photo')
{
    ?>����<?php
}
else if ($value['1'] == 'plan')
{
    if ($this->object->type == 1)
    {
        ?>����������<?php
    }
    else 
    {
        ?>����<?php
    }
    
}
else if ($value['1'] == 'house')
{
        ?>���<?php
}
else if ($value['1'] == 'situa')
{
        ?>������������ ����<?php
}
else if ($value['1'] == 'floor')
{
        ?>���� �����<?php
}

else if ($value['1'] == 'panorama')
{
        ?>��������<?php
}
else
{
    ?>����������<?php
}
?></span></a></li><?php 
}
?>
</ul>
<div id="object-under-bookmark">
<?php 
echo $this->object_card;
?>
<span class="bookmark-bottom-left"></span>
<span class="bookmark-bottom-right"></span>
</div>