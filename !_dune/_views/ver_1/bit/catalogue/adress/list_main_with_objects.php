<?php
$is_areas = false;
?>
<div id="content-adress-main">
<div id="content-adress-main-in">
<h2>Адреса</h2>
<ul id="adress-list-main">
<?php if (count($this->region_center)) 
      { 
        if ($this->region_center['current']) 
        {
        // Рисование текущего раздела
        if ($this->plus)
            $adress_plus = Special_Vtor_Settings::$districtPlusPostFix;
        else 
            $adress_plus = '';
        ?><li><span class="main-adress"><a href="/catalogue/type/<?php echo $this->type; ?>/adress<?php echo $adress_plus; ?>/1/1/1/"><?php echo $this->region_center['name'];?></a></span><span class="adress-count-city"><?php echo $this->count_in_ryazan; ?></span><?php
        
// Рисование городских районов 
//////////////////////////////////////////////////////////////// Формирование второго уровня - начало
        if (count($this->list_district))
        {
            ?><ul class="adress-list-main-level-2"><?php
            foreach ($this->list_district as $value_2)
            {
                if ($value_2['current']) 
                {
                // Рисование текущего раздела        
                ?><li class="current"><a href="<?php echo $value_2['link'];?>"><span class="adress-name"><?php echo $value_2['name'];?></span>
                 <span class="adress-count"><?php echo $value_2['count'];?></span></a><?php
                
// Рисование улиц городского района
//////////////////////////////////////////////////////////////// Формирование второго уровня - начало
        if (count($this->list_street))
        {
            ?><ul class="adress-list-main-level-3"><?php
            foreach ($this->list_street as $value_3)
            {
                if ($value_3['current']) 
                {
                // Рисование текущего раздела        
                ?><li class="current"><a href="<?php echo $value_3['link'];?>"><div class="instead-a">
                 <span class="adress-name"><?php echo $value_3['name'];?></span>
                 <span class="adress-count"><?php echo $value_3['count'];?></span>
                 </div></a>
                 </li>
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
            ?><li><span class="main-adress"><a href="<?php echo $this->region_center['link'];?>"><?php echo $this->region_center['name'];?></a></span><span class="adress-count-city"><?php echo $this->count_in_ryazan; ?></span></li><li></li><?php
        }

     };
     
     
     
     
if (count($this->list_area)) 
      {
        if (true) 
        {
        // Рисование текущего раздела        
        ?><li><?php
// Рисование городских районов 
//////////////////////////////////////////////////////////////// Формирование второго уровня - начало
        if (count($this->list_area))
        {
            ?><ul class="adress-list-region"><?php
            foreach ($this->list_area as $value_2)
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


<?php
if (is_array($this->list_settlement_no_ryazan) and count($this->list_settlement_no_ryazan)) 
      {
          
          ?><li><hr /></li><?php
        if (true) 
        {
        // Рисование текущего раздела        
        ?><li><?php
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
?>
</ul>



</div>


<div class="ugol-left-top"></div>
<div class="ugol-left-bottom"></div>
<div class="ugol-right-top"></div>
<div class="ugol-right-bottom"></div>

</div>
