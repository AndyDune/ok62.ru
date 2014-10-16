<?php if ($this->count)
{
    if (isset($this->price_min_max['min']) and (int)$this->price_min_max['min'] > 1000)
        $price_min =  number_format($this->price_min_max['min'], 0, ',', ' '); 
    else 
        $price_min = '';
    if (isset($this->price_min_max['max']) and (int)$this->price_min_max['max'] > 1000)
        $price_max =  number_format($this->price_min_max['max'], 0, ',', ' '); 
    else 
        $price_max = '';
        
  ?><div>
  <form method="post">
  <?php
  if ($this->count_no_group < 1)
    $this->count_no_group = $this->count;
  ?>
  Найдено: <strong><?php echo $this->count_no_group ?></strong> по цене
  от <input type="text" name="price_from" value="<?php echo $price_min ?>" size="10" />
  до <input type="text" name="price_to" value="<?php echo $price_max ?>" size="10" />
  <input type="hidden" name="save_price" value="save_price" />
  <input type="hidden" name="type" value="<?php echo $this->type ?>" />
  <input type="hidden" name="filter" value="save" />
  <input type="submit" name="OK" value="Отобрать" />
  </form>
  <?php
    if ($this->count_no_group > 0 and $this->count_no_group != $this->count)
    {
        ?><p>Объекты, различающиеся только этажом, в списке сгруппированы.</p><?php
    }
  ?>
  </div><?php  
}
?>