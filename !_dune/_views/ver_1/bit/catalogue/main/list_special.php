<div id="div-catalogue-main-new">
<br />
<?php 
//    $count = count($main_value['list']);
    ?>
    <div class="one-new">
    <ul><?php
    foreach ($this->data as $key => $value) {?>
    <li>
    <a href="<?php echo $value['link']?>">
<?php if ($value['price']) { ?>
<p style="color:red; padding: 0; margin:0; font-weight: bold;"><?php echo number_format($value['price'], 0, ',', ' ') ?> руб.</p>
<?php } ?>
    
    <?php if ($value['preview']) {?>
    <img src="<?php echo $value['preview'];?>" height="100" width="100" />
    <?php } else {?>
    
    <img src="<?php echo $this->view_folder?>/img/house-3.png" height="100" width="100" />
    <?php } ?>
    
    <p><?php
    switch ($value['type']) {
    	case 1:
    		echo $value['rooms_count'] . '-комнатная квартира';
    		if($value['planning'] == 2) {
    			echo ' улучшенной планировки';
    		}
    		break;
    	default:
    		echo $value['name_type'];
    		if (($value['type'] == 1 or $value['type'] == 2) and $value['rooms_count'] ) {?>, комнат: <?php echo $value['rooms_count']; }
    		break;
    }
    ?>
    
    <?php if ($value['settlement_id'] == 1) { ?>
    
    <?php if ($value['street_adding']) { ?>улица <?php } echo $value['name_street']; 
    if ($value['house_number']) {
    ?>, дом <?php echo $value['house_number']; }?>
    
    <?php } else
    { 
    echo $value['name_region'];
    if ($value['region_id'] == 1) {
        ?>, <?php echo $value['name_area'];
    } 
    if ($value['type_settlement'] < 100) {
        ?>, <?php echo $value['name_settlement'];
    } else {
        ?>, <?php echo $value['settlement_name'];
    }
    } 

    if ($value['space_land']) {
    ?>, участок&nbsp;<?php echo $value['space_land']; ?>&nbsp;соток<?php } ?>
    
    </p>
    
    </a>
<div class="ugol-left-top"></div><div class="ugol-left-bottom"></div><div class="ugol-right-top"></div><div class="ugol-right-bottom"></div>

    </li>
    <?php }?>
    </ul>
    </div>
 
 

</div>