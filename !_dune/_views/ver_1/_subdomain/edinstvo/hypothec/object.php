<?php
$o = new Dune_Data_Parsing_Date($this->object->time_insert);
$code = $o->getMonth() . $o->getYear(1);
switch (strlen($this->object->id))
{
    case 1:
        $zeros = '0000';
    break;
    case 2:
        $zeros = '000';
    break;
    case 3:
        $zeros = '00';
    break;
    case 4:
        $zeros = '0';
    break;
    default:
        $zeros = '';
}
?>

<div id="object-shot-info">

<div id="object-shot-info-this">
<div id="object-shot-info-this-inside-up-left-u"><div id="object-shot-info-this-inside-up-right-u"><div id="object-shot-info-this-inside-down-right-u">
<div id="object-shot-info-this-inside-u">
<table id="table-object-shot-info">
<tr>
<td class="td-object-shot-image">

<?php if ($this->preview) {?>
<img src="<?php echo $this->preview;?>" />
<?php } else {?>

<img src="<?php echo $this->view_folder?>/img/house-100.png" />
<?php } ?>

</td>
<td class="td-object-shot-info">

<h1>
<?php
ob_start();
switch ($this->object->type) {
	case 1:
		echo $this->object->rooms_count;
		?>-комнатная<?php
		if($this->object->levels == 2) {
			?> двухуровневая<?php
		} elseif ($this->object->levels == 3) {
			?> трехуровневая<?php
		} elseif ($this->object->levels == 4) {
			?> четырехуровневая<?php
		}
		?> квартира<?php
		if($this->object->planning == 2) {
			?> улучшенной планировки<?php
		}
		break;
	case 2:
		

        $levels = '';
        $levels_temp = '';
         if ($this->object->floors_total > 1 and $this->object->floors_total < 10) 
            {
                $levels_temp = $this->object->floors_total . '-этажн';
                $levels = $levels_temp . 'ый ';
            }
            $name = 'дом';
            if ($this->object->type_add == 8)
            {
                $name = 'дача';
                if ($levels_temp)
                    $levels = $levels_temp . 'ая ';
            }
            
            else if ($this->object->type_add == 10)
                $name = 'коттедж';
            else if ($this->object->type_add == 11)
                $name = 'таун-хаус';
            else if ($this->object->type_add == 12)
            {
                $levels_temp = '';
                $name = 'участок';
            }
                
            if (!$levels_temp)
        	   $name = ucfirst($name);
        	echo $levels, $name;
        	if($this->object->have_land) {
        		?> с земельным участком<?php
        	}
		
		
		break;
		
	default:
		echo $this->object->name_type;
		if (
          ($this->object->type == 1 or $this->object->type == 2)
      		and ($this->object->rooms_count)
          	) {?>, комнат: <?php echo $this->object->rooms_count; }
			break;
}
$title = ob_get_clean(); // Дополняем title
?>
<a href="/catalogue/type/<?php echo $this->object->type; ?>/object/<?php echo $this->object->id; ?>/"><?php echo $title; ?></a>
</h1>
<?php
//echo $this->object; die();


if ($this->object->group_name)
 {
    ?><p class="objects-list-add-info-focus"><strong><?php 
    echo $this->object->group_name;
    ?></strong></p><?php
 } else if ($this->object->name_complex) { ?>
<p class="objects-list-add-info-focus"><strong>
<?php echo $this->object->name_complex;  ?></strong></p>
<?php } ?>


<p class="object-shot-adress">
<!-- Адресс в заголовке -->
<?php
ob_start();
?>

    <?php if ($this->object->region_id != 1) { ?>
	<?php echo $this->object->name_region?>,
	<?php } ?>
	
    <?php if ($this->object->settlement_id != 1)
    {
	   echo $this->object->name_area; ?>, <?php
	
    	if ($this->object->settlement_id and $this->object->type_settlement < 100)
    	{ 
    	 echo $this->object->name_settlement;
    	}
    	else
    	{ 
    	    echo $this->object->settlement_name;
    	}
    }
    else
    {
	   echo $this->object->name_district;
    }
	
	if ($this->object->street_id) { 
	  if ($this->object->street_adding) { ?>, улица <?php } else {?>, <?php }
	  echo $this->object->name_street;   
    } else
	{
	    if ($this->object->street_name)
	       echo ', ' . $this->object->street_name;
	} 
	if ($this->object->house_number)
	{
	?>, дом <?php echo $this->object->house_number;
	}
	if ($this->object->building_number) { 
	?>, корпус <?php echo $this->object->building_number; }
	
	if ($this->object->room)
	 {
	    if ($this->object->type == 1) {
	 ?>, квартира <?php
        } else {
            ?>, номер <?php
        }
	   echo $this->object->room;
	    } ?>

<?php
$text = ob_get_clean();
$title .= '. ' . $text; // Дополняем title
?>
<?php echo $text; ?>
<!--/ Адресс в заголовке -->	    
</p>

<?php if ($this->object->deal == 2) {
    $title .= '. Продажа, аренда';
    ?>
<p class="object-shot-deal"> Продажа, аренда
</p>
<?php }
 else if ($this->object->deal == 1) {
    $title .= '. Аренда';
    ?>
<p class="object-shot-deal"> Аренда
</p>
<?php } else  $title .= '. Продажа'; ?>

<?php if ($this->object->new_building_flag) { ?>
<p class="object-shot-deal">новостройка<?php
if ($this->object->new_building_text) { ?>
, <?php echo $this->object->new_building_text;  } ?></p>
<?php } ?>


</td>

<td class="td-object-shot-price">

<p class="object-shot-code">Код объекта в каталоге: <span><?php echo $code, $zeros, $this->object->id; ?></span></p>

<?php if ($this->object->space_total) { ?>
<p class="object-shot-code">Площадь: <span><?php echo $this->object->space_total; ?></span> м<span class="up-word-small">2</span></p>
<?php } ?>

<?php if (!$this->object->price and !$this->object->price_rent and !$this->object->price_rent_day) { ?>
<p class="object-shot-price">Цена: <span class="price-number">Договорная</span></p>
<?php } else if ($this->object->price_old) {?>
<p class="object-shot-price"><span class="price-number"><?php echo number_format($this->object->price, 0, ',', ' ')?></span> <span class="hide">руб.</span></p>
<p class="object-shot-price">Цена: <span class="price-number price-old"><?php echo number_format($this->object->price_old, 0, ',', ' ')?></span> <span>руб.</span></p>

<?php } else if ($this->object->price_rent_day){ ?>
<p class="object-shot-price">Цена аренды: <span class="price-number"><?php echo number_format($this->object->price_rent_day, 0, ',', ' ')?></span> <span class="price-red">руб./сутки</span></p>

<?php } else if ($this->object->price_rent){ ?>
<p class="object-shot-price">Цена аренды: <span class="price-number"><?php echo number_format($this->object->price_rent, 0, ',', ' ')?></span> <span class="price-red">руб./месяц</span></p>
<?php } else { ?>
<p class="object-shot-price">Цена: <span class="price-number"><?php echo number_format($this->object->price, 0, ',', ' ')?></span> <span class="price-red">руб.</span></p>
<?php } ?>
</td>
</tr>
</table>
</div>
</div></div></div></div> <!-- конец блока инфы -->
</div>
