<ul>
<?php if (count($this->list)) {
    foreach ($this->list as $value) {
?><li><?php 
      if ($value['current'])
      {
          ?><span><?php echo $value['name'];?>  (<?php echo $value['count'];?>)</span><?php
      }
      else 
      {
        ?><a href="<?php echo $value['link'];?>"><?php echo $value['name'];?> (<?php echo $value['count'];?>)</a><?php
      }

?></li><?php
}} ?>
</ul>