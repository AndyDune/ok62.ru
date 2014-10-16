<?php
$is_areas = false;
$limit_street = 5;
?><ul id="adress-list-main"><?php if (count($this->region_center)) 
      { 
        if ($this->region_center['current']) 
        {
        // Рисование текущего раздела        
        
        ?><li class="adress-blocks"><?php
        
// Рисование городских районов 
//////////////////////////////////////////////////////////////// Формирование второго уровня - начало
        if (count($this->list_district) and !$this->plus)
        {
            ?><ul class="adress-list-main-level-2">
            <?php
            foreach ($this->list_district as $value_2)
            {
                if ($value_2['current']) 
                {
                // Рисование текущего раздела        
                ?><li class="current" style="margin:0; padding:0;"><a href="<?php echo $value_2['link'];?>"><span class="adress-name"><?php echo $value_2['name'];?></span>
                 <span class="adress-count"><?php echo $value_2['count'];?></span></a><?php
                
// Рисование улиц городского района
//////////////////////////////////////////////////////////////// Формирование второго уровня - начало
        if (count($this->list_street))
        {
            ?><ul class="adress-list-main-level-3"><?php
            $x = 0;
            foreach ($this->list_street as $value_3)
            {
                $x++;
                if ($x > $limit_street)
                    break;
                if ($value_3['current']) 
                {
                // Рисование текущего раздела        
                ?><li class="current"><div class="instead-a">
                 <span class="adress-name"><?php echo $value_3['name'];?></span>
                 <span class="adress-count"><?php echo $value_3['count'];?></span>
                 </div></li>
                 <?php
                }
                else 
                {
                    if ($value_3['count'])
                    {
                        ?><li><a href="<?php echo $value_3['link'];?>"><span class="adress-name"><?php echo $value_3['name'];?></span>
                         <span class="adress-count"><?php echo $value_3['count'];?></span></a></li><?php
                    }
                    else 
                    {
                        ?><li><div class="instead-a">
                        <span class="adress-name"><?php echo $value_3['name'];?></span>
                        <span class="adress-count">0</span>
                        </div></li><?php
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
                    ?><li><a href="<?php echo $value_2['link'];?>"><span class="adress-name"><?php echo $value_2['name'];?></span>
                      <span class="adress-count"><?php echo $value_2['count'];?></span></a></li><?php
                    }
                    else 
                    {
                    ?><li><div class="instead-a">
                    <span class="adress-name"><?php echo $value_2['name'];?></span>
                    <span class="adress-count">0</span>
                    </div>
                    </li><?php
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
     
     
     
if (count($this->list_area)) 
      {
        if (true) 
        {
        // Рисование текущего раздела        
        ?><li class="adress-blocks"><?php
// Рисование городских районов 
//////////////////////////////////////////////////////////////// Формирование второго уровня - начало
        if (count($this->list_area))
        {
            ?><ul class="adress-list-region" ><?php
            $x = 0;
            foreach ($this->list_area as $value_2)
            {
                $x++;
                if ($x > 2 and !$this->plus)
                    break;
                if ($value_2['current']) 
                {
                // Рисование текущего раздела        
                ?><li class="current"><a href="<?php echo $value_2['link'];?>"><span class="adress-name"><?php echo $value_2['name'];?></span>
                 <span class="adress-count"><?php echo $value_2['count'];?></span></a><?php
                
// Рисование улиц городского района
//////////////////////////////////////////////////////////////// Формирование второго уровня - начало
        if (count($this->list_settlement))
        {
            ?><ul class="adress-list-main-level-3"><?php
            foreach ($this->list_settlement as $value_3)
            {
                    if ($value_3['type'] == 100)
                        $name = 'Другие';
                    else 
                        $name = $value_3['name'];
                
                if ($value_3['current']) 
                {
                // Рисование текущего раздела        
                ?><li class="current"><a href="<?php echo $value_3['link'];?>"><div class="instead-a">
                 <span class="adress-name"><?php echo $name;?></span>
                 <span class="adress-count"><?php echo $value_3['count'];?></span>
                 </div></a></li>
                 <?php
                }
                else 
                {
                        
                    if ($value_3['count'])
                    {
                        ?><li><a href="<?php echo $value_3['link'];?>"><span class="adress-name"><?php echo $name;?></span>
                         <span class="adress-count"><?php echo $value_3['count'];?></span></a></li><?php
                    }
                    else 
                    {
                        ?><li><div class="instead-a">
                        <span class="adress-name"><?php echo $name;?></span>
                        <span class="adress-count">0</span>
                        </div></li><?php
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
                    ?><li><a href="<?php echo $value_2['link'];?>"><span class="adress-name"><?php echo $value_2['name'];?></span>
                      <span class="adress-count"><?php echo $value_2['count'];?></span></a></li><?php
                    }
                    else 
                    {
                    ?><li><div class="instead-a">
                    <span class="adress-name"><?php echo $value_2['name'];?></span>
                    <span class="adress-count">0</span>
                    </div>
                    </li><?php
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
     
     
          
if (is_array($this->list_settlement_no_ryazan) and count($this->list_settlement_no_ryazan)) 
      {
          
          ?><li><hr /></li><?php
        if (true) 
        {
        // Рисование текущего раздела        
        ?><li class="adress-blocks"><?php
// Рисование городских районов 
//////////////////////////////////////////////////////////////// Формирование второго уровня - начало
        if (count($this->list_settlement_no_ryazan))
        {
            ?><ul class="adress-list-region"><?php
            foreach ($this->list_settlement_no_ryazan as $value_2)
            {
                if ($value_2['current']) 
                {
                // Рисование текущего раздела        
                ?><li class="current"><a href="<?php echo $value_2['link'];?>"><span class="adress-name"><?php echo $value_2['name'];?></span>
                 <span class="adress-count"><?php echo $value_2['count'];?></span></a><?php
                
// Рисование улиц городского района
//////////////////////////////////////////////////////////////// Формирование второго уровня - начало

        if (count($this->list_settlement))
        {
            ?><ul class="adress-list-main-level-3"><?php
            foreach ($this->list_settlement as $value_3)
            {
                    if ($value_3['type'] == 100)
                        $name = 'Другие';
                    else 
                        $name = $value_3['name'];
                
                if ($value_3['current']) 
                {
                // Рисование текущего раздела        
                ?><li class="current"><a href="<?php echo $value_3['link'];?>"><div class="instead-a">
                 <span class="adress-name"><?php echo $name;?></span>
                 <span class="adress-count"><?php echo $value_3['count'];?></span>
                 </div></a></li>
                 <?php
                }
                else 
                {
                        
                    if ($value_3['count'])
                    {
                        ?><li><a href="<?php echo $value_3['link'];?>"><span class="adress-name"><?php echo $name;?></span>
                         <span class="adress-count"><?php echo $value_3['count'];?></span></a></li><?php
                    }
                    else 
                    {
                        ?><li><div class="instead-a">
                        <span class="adress-name"><?php echo $name;?></span>
                        <span class="adress-count">0</span>
                        </div></li><?php
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
                    ?><li><a href="<?php echo $value_2['link'];?>"><span class="adress-name"><?php echo $value_2['name'];?></span>
                      <span class="adress-count"><?php echo $value_2['count'];?></span></a></li><?php
                    }
                    else 
                    {
                    ?><li><div class="instead-a">
                    <span class="adress-name"><?php echo $value_2['name'];?></span>
                    <span class="adress-count">0</span>
                    </div>
                    </li><?php
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