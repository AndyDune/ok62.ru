<?php
$is_areas = false;
?>
<div id="content-adress-main">
<h2>Адреса</h2>
<ul id="adress-list-main-level-1">
<?php if (count($this->region_center)) 
      { 
        if ($this->region_center['current']) 
        {
        // Рисование текущего раздела        
        ?><li><span><?php echo $this->region_center['name'];?></span><?php
        
// Рисование городских районов 
//////////////////////////////////////////////////////////////// Формирование второго уровня - начало
        if (count($this->list_district))
        {
            ?><ul id="adress-list-main-level-2"><?php
            foreach ($this->list_district as $value_2)
            {
                if ($value_2['current']) 
                {
                // Рисование текущего раздела        
                ?><li><a href="<?php echo $value_2['link'];?>"><?php echo $value_2['name'];?> (<?php echo $value_2['count'];?>)</a><?php
                
// Рисование улиц городского района
//////////////////////////////////////////////////////////////// Формирование второго уровня - начало
        if (count($this->list_street))
        {
            ?><ul id="adress-list-main-level-3"><?php
            foreach ($this->list_street as $value_3)
            {
                if ($value_3['current']) 
                {
                // Рисование текущего раздела        
                ?><li><span><?php echo $value_3['name'];?> (<?php echo $value_3['count'];?>)</span><?php
                
                ?></li><?php
                }
                else 
                {
                    if ($value_3['count'])
                    {
                        ?><li><a href="<?php echo $value_3['link'];?>"><?php echo $value_3['name'];?>  (<?php echo $value_3['count'];?>)</a></li><?php
                    }
                    else 
                    {
                        ?><li><?php echo $value_3['name'];?></li><?php
                    }
                    
                }
            }
            ?></ul><?php
        }
///////////////////////////////////////////////////////////////  Формирование второго уровня - клнец
                
                
                
                ?></li><?php
                }
                else 
                {
                    if ($value_2['count'])
                    {
                    ?><li><a href="<?php echo $value_2['link'];?>"><?php echo $value_2['name'];?>  (<?php echo $value_2['count'];?>)</a></li><?php
                    }
                    else 
                    {
                    ?><li><?php echo $value_2['name'];?></li><?php
                    }
                    
                }
            }
            ?></ul><?php
        }
///////////////////////////////////////////////////////////////  Формирование второго уровня - клнец
        
        ?></li><?php
        }
        else 
        {
            ?><li><a href="<?php echo $this->region_center['link'];?>"><?php echo $this->region_center['name'];?></a></li><?php
        }

     };
 if ($is_areas)
 {
 foreach ($this->list_areas as $value) 
          {
?><li><?php

    if ($value['current']) {
// Рисование текущего раздела        
?>
<span><?php echo $value['name'];?></span>
<?php
// Рисование городов района - областной центр исключаем
//////////////////////////////////////////////////////////////// Формирование второго уровня - начало
if (count($this->list_settlement))
{
    ?><ul id="adress-list-main-level-2"><?php
    foreach ($this->list_settlement as $value_2)
    {
        if ($value_2['current']) 
        {
        // Рисование текущего раздела        
        ?><li><span><?php echo $value_2['name'];?></span><?php
        
        ?></li><?php
        }
        else 
        {
            ?><li><a href="<?php echo $value_2['link'];?>"><?php echo $value_2['name'];?></a></li><?php
        }
    }
    ?></ul><?php
}
///////////////////////////////////////////////////////////////  Формирование второго уровня - клнец

} else {?>
<a href="<?php echo $value['link'];?>"><?php echo $value['name'];?></a>

           <?php } ?>
</li>
<?php } }?>
</ul>

</div>
