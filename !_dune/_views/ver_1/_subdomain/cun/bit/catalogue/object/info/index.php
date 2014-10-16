<?php
// catalogue/info_one.css
$title = '';
?>
<div id="object-shot-info">
<div id="object-shot-info-bookmarks">
<ul>
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
<!--
<li id="bm-number"><span>Код объекта в каталоге: <?php echo $code, $zeros, $this->object->id; ?></span></li>
-->
<li id="bm-number"><span>Продавец: <a href="/user/info/<?php echo $this->seller->id ?>/"><?php
if ($this->seller->contact_name)
    $name = $this->seller->contact_name;
else 
    $name = $this->seller->name;
echo $name;
    
 ?></a><?php

if (time() - $this->seller_time_last_visit < 1200)
{
    ?> <a  class="tooltip" href="<?php echo $this->self_url; ?>?talk_mode=private#talk-mode-change" title="Продавец <?php echo $name; ?> в сети. - Нажмите для приватного общения с продавцом.">(сейчас на сайте)</a><?php
}
?></span></li>

<li class="link"><a class="tooltip" href="<?php echo $this->self_url; ?>?talk_mode=private#talk-mode-change" title="Приватное общение с продавцом. - Переписка для просмотра доступна только Вам и вашему собеседнику."><span>Приватное общение</span></a></li>

<li class="link"><a class="tooltip" href="<?php

echo $this->self_url;
if ($this->talk_mode == 'private')
{
    ?>?talk_mode=public<?php
}

?>#talk-mode-change"  title="Комментарии. - Оставьте комментарий об объекте для всеобщего просмотра. "><span>Комментарии<?php
if ($this->count_comments)
{
    ?> (<?php echo $this->count_comments;  ?>)<?php
}
?></span></a></li>

</ul>
</div>


<div id="object-shot-info-this">
<div id="object-shot-info-this-inside-up-left"><div id="object-shot-info-this-inside-up-right"><div id="object-shot-info-this-inside-down-right">
<div id="object-shot-info-this-inside">
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
echo $title = ob_get_clean(); // Дополняем title
?>
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
	   if ($this->object->region_id < 2)
	   {
	       echo $this->object->name_area?>, <?php
	   }
	
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
        if ($this->object->district_id_plus > 1)
        {
            echo $this->object->name_district_plus, ' (', $this->object->name_district, ')';
        }
        else 
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
  	if ($this->object->house_number_comment)
   	{
   	?> <?php echo $this->object->house_number_comment;
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
echo $text = ob_get_clean();
$title .= '. ' . $text; // Дополняем title
?>
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

<?php if (Dune_Variables::$userStatus > 999) { ?>
<p><a href="/<?php echo Dune_Variables::$commandNameAdmin ?>/catalogue/object/edit/<?php echo $this->object->id ?>/" target="_blank">редактировать</a></p>
<?php  } ?>

<p id="object-shot-grafic-param">
<?php 
$URL = Dune_Parsing_UrlSingleton::getInstance();
$URL->cutCommands(12);


if ($this->object->price and $this->object->price > 1000) { ?>
<a href="/modules.php?name=Hypothec&op=Calculation&object=<?php echo $this->object->id ?>" title="Ипотечный калькулятор.">
<img src="<?php echo $this->view_folder ?>/img/param/big/v1.png" height="35" width="35" />
</a>
<?php if ($this->object->have_hypothec_privilege) { ?>
<a href="/modules.php?name=Hypothec&op=Calculation&object=<?php echo $this->object->id ?>" title="Ипотечный калькулятор. Возможна льготная ипотека.">
<img src="<?php echo $this->view_folder ?>/img/param/big/v2.png" height="35" width="35" />
</a>
<?php } ?>
<?php } ?>

<?php if ($this->object->have_plan and false) { ?>
<a href="<?php echo $URL->getCommandString(); ?>mode/plan/" title="Планировка.">
<img src="<?php echo $this->view_folder ?>/img/param/big/k2.png" height="35" width="35" />
</a>
<?php } ?>

<?php if ($this->object->pics and false) { ?>
<a href="<?php echo $URL->getCommandString(); ?>mode/photo/" title="Фотографии.">
<img src="<?php echo $this->view_folder ?>/img/param/big/k5.png" height="35" width="35" />
</a>
<?php } else if ($this->object->have_photo_house and false) { ?>
<a href="<?php echo $URL->getCommandString(); ?>mode/house/" title="Фотографии дома.">
<img src="<?php echo $this->view_folder ?>/img/param/big/k5.png" height="35" width="35" />
</a>
<?php } ?>


<?php if (($this->object->have_panorama or $this->object->panorama) and false) { ?>
<a href="<?php echo $URL->getCommandString(); ?>mode/panorama/" title="Панорамные обзоры.">
<img src="<?php echo $this->view_folder ?>/img/param/big/k6.png" height="35" width="35" />
</a>
<?php } ?>



</p>



</td>

<td class="td-object-shot-price">

<p class="object-shot-code">Код объекта в каталоге: <span><?php echo $code, $zeros, $this->object->id; ?></span></p>

<?php if ($this->object->space_total) { ?>
<p class="object-shot-code">Площадь: <span><?php echo $this->object->space_total; ?></span> м<span class="up-word-small">2</span></p>
<?php } ?>

<?php if (!$this->object->price and !$this->object->price_rent and !$this->object->price_rent_day and !$this->object->price_rent_metre and !$this->object->price_one) { ?>
<p class="object-shot-price">Цена: <span class="price-number">Договорная</span></p>
<?php } else if ($this->object->price_old) {?>
<p class="object-shot-price"><span class="price-number"><?php echo number_format($this->object->price, 0, ',', ' ')?></span> <span class="hide">руб.</span></p>
<p class="object-shot-price">Цена: <span class="price-number price-old"><?php echo number_format($this->object->price_old, 0, ',', ' ')?></span> <span>руб.</span></p>

<?php } else if ($this->object->price){ ?>
<p class="object-shot-price">Цена: <span class="price-number"><?php echo number_format($this->object->price, 0, ',', ' ')?></span> <span class="price-red">руб.</span></p>

<?php } else if ($this->object->price_one){ ?>
<p class="object-shot-price">Цена 1м<sup>2</sup>: <span class="price-number"><?php echo number_format($this->object->price_one, 0, ',', ' ')?></span> <span class="price-red">руб.</span></p>

<?php } else if ($this->object->price_rent_day){ ?>
<p class="object-shot-price">Цена аренды: <span class="price-number"><?php echo number_format($this->object->price_rent_day, 0, ',', ' ')?></span> <span class="price-red">руб./сутки</span></p>

<?php } else if ($this->object->price_rent){ ?>
<p class="object-shot-price">Цена аренды: <span class="price-number"><?php echo number_format($this->object->price_rent, 0, ',', ' ')?></span> <span class="price-red">руб./месяц</span></p>
<?php } else if ($this->object->price_rent_metre){ ?>
<p class="object-shot-price">Цена аренды 1м<sup>2</sup>: <span class="price-number"><?php echo number_format($this->object->price_rent_metre, 0, ',', ' ')?></span> <span class="price-red">руб./месяц</span></p>
<?php } else { ?>
<p class="object-shot-price">Цена: <span class="price-number"><?php echo number_format($this->object->price, 0, ',', ' ')?></span> <span class="price-red">руб.</span></p>
<?php } ?>
<?php
if ($this->object->haggling == 0)
{
    ?><p class="object-shot-haggling">торгуюсь для «порядка»</p><?php
}
else if ($this->object->haggling == 1)
{
    ?><p class="object-shot-haggling">не торгуюсь</p><?php
}
else if ($this->object->haggling == 2)
{
    ?><p class="object-shot-haggling">очень хочу продать</p><?php
}
?>
</td>
</tr>
</table>
</div>
</div></div></div></div> <!-- конец блока инфы -->
</div>

<ul id="bookmark-object">
<?php foreach ($this->bookmarks as $value) { ?>
<li <?php

if ($value['1'] == 'photo')
{
    ?>id="bookmark-photo"<?php
}
else if ($value['1'] == 'plan')
{
      ?>id="bookmark-plan"<?php
}
else if ($value['1'] == 'house')
{
        ?>id="bookmark-house"<?php
}
else if ($value['1'] == 'situa')
{
        ?>id="bookmark-situa"<?php
}
else if ($value['1'] == 'floor')
{
        ?>id="bookmark-floor"<?php
}

else if (($value['1'] == 'group'))
{
    ?>id="bookmark-group"<?php
}
else if ($value['1'] == 'panorama')
{
        ?>id="bookmark-panorama"<?php
}
else if ($value['1'] == 'gm')
{
        ?>id="bookmark-gm"<?php
}
else if ($value['1'] == 'pd')
{
        ?>id="bookmark-pd"<?php
}

else
{
    ?>id="bookmark-info"<?php
}



if ($value['3'])
{
 ?> class="current"<?php
} 
?>><a href="<?php echo $value['2'];?>"><span><em><?php
if ($value['1'] == 'photo')
{
    ?>Фото<?php
}
else if ($value['1'] == 'plan')
{
    if ($this->object->type == 1)
    {
        ?>Планировка<?php
    }
    else 
    {
        ?>План<?php
    }
}
else if ($value['1'] == 'house')
{
        ?>Дом<?php
}
else if ($value['1'] == 'situa')
{
        ?>Ситуационный план<?php
}
else if ($value['1'] == 'pd')
{
        ?>Проектная декларация<?php
}

else if ($value['1'] == 'floor')
{
        ?>План этажа<?php
}

else if (($value['1'] == 'group'))
{
    ?>Квартиры в стояке<?php
}
else if ($value['1'] == 'panorama')
{
        ?>Панорама<?php
}
else if ($value['1'] == 'gm')
{
        ?>На карте<?php
}
else
{
    ?>Информация<?php
}
?></em></span></a></li><?php 
}
?>
</ul>
<div id="object-under-bookmark">
<?php 
Dune_Variables::addTitle($title . '. '); // Дополняем title
echo $this->object_card;
?>
<div class="ugol-left-top"></div>
<div class="ugol-left-bottom"></div>
<div class="ugol-right-top"></div>
<div class="ugol-right-bottom"></div>

</div>