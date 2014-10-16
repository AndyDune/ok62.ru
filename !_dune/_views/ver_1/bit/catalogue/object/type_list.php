<div id="type-list">
<ul>
<?php if (count($this->list)) {
    foreach ($this->list as $value) {
        
    if (strlen($value['name']) > 10 and strpos($value['name'], ' '))
    {
        $class_name = 'length_big_2lines';
    }
    else if (strlen($value['name']) > 10)
    {
        $class_name = 'length_big';
    }
    else if (strlen($value['name']) < 5)
        $class_name = 'length_very_small';
    else 
        $class_name = 'length_small';
        
        
?><li><?php 
      if ($value['current'])
      {
          ?><span class="<? echo $class_name ?>"><em><?php echo $value['name'];?></em></span><?php
      }
      else 
      {
        ?><a class="<? echo $class_name ?>" href="<?php echo $value['link'];?>" title="Объектов в сиcтеме <?php echo $value['count'];?>"><em><?php echo $value['name'];?></em></a><?php
      }

?></li><?php
}} ?>
</ul>
</div>