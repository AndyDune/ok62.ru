<?php

class Module_Display_Catalogue_Object_InfoHouseGM extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
$value_o = $this->object = new Dune_Array_Container($this->object);

$view = Dune_Zend_View::getInstance();

$house_image_path = '/img/house/';
$group_image_path = '/img/group/';
?><div><?php
ob_start();
?>
    <?php if ($this->object->region_id != 1) { ?>
	<?php echo $this->object->name_region?>,
	<?php } ?>
	
    <?php if ($this->object->settlement_id != 1)
    {
	   echo $this->object->name_area;
	
    	if ($this->object->settlement_id and $this->object->type_settlement < 100 and $this->object->name_settlement)
    	{ 
    	 ?>, <?php echo $this->object->name_settlement;?>, <?php
    	}
    	else if ($this->object->settlement_name)
    	{ 
    	    ?>, <?php echo $this->object->settlement_name;?>, <?php
    	}
    }
    else
    {
//	  echo $this->object->name_district;
//	  echo $this->object->settlement_name;
    }
	
	if ($this->object->street_id and $this->object->name_street) { 
        if ($this->object->district_id_plus > 1)
        {
	       echo $this->object->name_district_plus; ?><br /> <?php
        }
	    
	  if ($this->object->street_adding) { ?> улица <?php } else {?> <?php }
	  echo $this->object->name_street;?>, <?php   
    } else
	{
	    if ($this->object->street_name)
	       ?> <?php echo $this->object->street_name;?>, <?php
	} 
	if ($this->object->house_number)
	{
	?> дом <?php echo $this->object->house_number;
	}
	if ($this->object->building_number) { 
	?>, корпус <?php echo $this->object->building_number; }
	

 $adress = ob_get_clean();

$show_adress = true;
?>

<h1>
<?php if ($this->object->group_name) { ?>
<?php echo $this->object->group_name;  ?>
<?php } else if ($this->object->name_complex) { ?>
<?php echo $this->object->name_complex;  ?>
<?php } else
{
    echo $adress;
    $show_adress = false;
}
?>
</h1>


<table id="table-object-shot-info">
<tr>
<td class="td-object-shot-image">
<?php
if ($this->object->house_image)
{
    ?><img height="100" width="100" src="<?php echo $house_image_path , $this->object->house_image ?>" /><?php
}
else if ($this->object->group_image)
{
    ?><img height="100" width="100" src="<?php echo $group_image_path , $this->object->group_image ?>" /><?php
} else {
    ?><img height="100" width="100" src="<?php echo $view->view_folder?>/img/house-100.png" /><?php
} ?>
</td>
<td class="td-object-shot-info  td-object-shot-price" style="text-align:left; font-size:13px;">

<style type="text/css">
.values
{
margin: 0;
padding:0;
font-size:12px;
}
</style>

<p style="color:#717171; font-size:18px; margin:0 0 10px 0;">
<?php
if ((int)$this->object->price_min > 1 and (int)$this->object->price_min < (int)$this->object->price_max)
{
?>Цена: <span class="price-number" style="color: #000;">от  <?php echo number_format($this->object->price_min, 0, ',', ' '); ?> до <?php echo number_format($this->object->price_max, 0, ',', ' '); ?></span> руб.<?php
}
else if ((int)$this->object->price_max > 1)
{
?>Цена: <span class="price-number" style="color: #000;">до <?php echo number_format($this->object->price_max, 0, ',', ' '); ?></span> руб.<?php
}


if ($show_adress) {
?><p class="object-shot-adress" style="font-size:13px; margin: 0 0 5px 0;"><strong>
<?php
echo trim($adress, ' ,');
?>
</strong></p><?php }
//echo $this->object; die();

?><p style="color:#717171; font-size:13px;"><?php
if ((int)$this->object->space_min > 1 and (int)$this->object->space_min < (int)$this->object->space_max)
{
?>Площадь: <span style="color: #000;">от <?php echo round($this->object->space_min); ?> до <?php echo round($this->object->space_max); ?> м<sup>2</sup></span><?php
}
else if ((int)$this->object->space_max > 1)
{
?>Площадь: <span style="color: #000;">до <?php echo round($this->object->space_max); ?> м<sup>2</sup></span><?php
} ?>
</p>

<p style="color:#717171; font-size:13px;"><?php
if ((int)$this->object->rooms_count_min > 0 and (int)$this->object->rooms_count_min < (int)$this->object->rooms_count_max)
{
?>Кол-во комнат: <span style="color: #000;">от <?php echo round($this->object->rooms_count_min); ?> до <?php echo round($this->object->rooms_count_max); ?></span><?php
}
else if ((int)$this->object->rooms_count_max == (int)$this->object->rooms_count_min)
{
?>Кол-во комнат: <span style="color: #000;"><?php echo round($this->object->rooms_count_max); ?></span><?php
}
else if ((int)$this->object->rooms_count_max > 1)
{
?>Кол-во комнат: <span style="color: #000;">до <?php echo round($this->object->rooms_count_max); ?></span><?php
}
else if ((int)$this->object->rooms_count_max > 0)
{
?>Кол-во комнат: <span style="color: #000;"><?php echo round($this->object->rooms_count_max); ?></span><?php
} ?>

</p>


<?php if ($this->object->house_building_number_array and is_array($this->object->house_building_number_array) and count($this->object->house_building_number_array) > 1)
{
    $str = '';
    ?><ul style="list-style-type:none; margin:0; padding:0; color:#717171;">
<li>Дома: <?php echo $str;    
  foreach ($this->object->house_building_number_array as $value)  
  {
        $cat_url = new Special_Vtor_Catalogue_Url_Collector();
        $cat_url->setRegion($value_o['region_id']);
        $cat_url->setArea($value_o['area_id']);
        $cat_url->setSettlement($value_o['settlement_id']);
        $cat_url->setStreet($value_o['street_id']);
        $cat_url->setHouse($value[0]);
        $cat_url->setBuilding($value[1]);
        $cat_url->setGroup($value_o['group']);
        $cat_url->setDistrict($value_o['district_id']);
        $cat_url->setType($value_o['type']);
        echo $str;
        $str = ', ';
     ?><a href="<?php echo $cat_url->get(); ?>"><?php echo $value[0];
     if ($value[1]) {?>( корпус <?php echo $value[1]; ?>)<?php  } ?></a><?php
  }
  ?></ul><?php
}
?>

</td>

</tr>
</table>
<?php
//$this->object->count_in_group = 901;
$name = ' предложений';
if ($this->object->count_in_group >= 100)
    $number = $this->object->count_in_group % 100;
else 
    $number = $this->object->count_in_group;

$zero = $number % 10;
if (!$zero)
{
    $name = ' предложений';
}
else if ($number > 10 and $number < 20)
{
    $name = ' предложений';
}
else if ($zero == 1)
{
    $name = ' предложение';
}
else if ($zero < 5)
{
    $name = ' предложения';
}

?>
<p><a href="<?php echo $this->link; ?>">Всего <?php echo $this->object->count_in_group, $name; ?></a></p>
</div>
<?php

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    