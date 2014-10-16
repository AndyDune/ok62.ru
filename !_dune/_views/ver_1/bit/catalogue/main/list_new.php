<div id="div-catalogue-main-new">

<?php 
foreach ($this->data as $key => $main_value)
{
    if (!$main_value['count'])
        continue;
    $count = count($main_value['list']);
ob_start();    
    ?>
    <div class="one-new">
    <?php 
        $cat_url = new Special_Vtor_Catalogue_Url_Collector();
        $cat_url->setRegion($this->url_info->getRegion());
        $cat_url->setArea($this->url_info->getArea());
        $cat_url->setSettlement($this->url_info->getSettlement());
        $cat_url->setStreet($this->url_info->getStreet());
        
        if ($this->adress_object->getDistrictPlus())
            $cat_url->setDistrict($this->url_info->getDistrict(), true);
        else 
            $cat_url->setDistrict($this->url_info->getDistrict());
//        $cat_url->setType($value['type']);
    
    
    $cat_url->setType($key); ?>
    <h3 id="type_<?php echo $key ?>"><a href="<?php echo $cat_url->get() ?>"><?php
    
    // ���������� ��� ����
    switch ($key)
    {
        case 1:
            ?>�������� (� ��������: <?php echo $main_value['count']; ?>)<?php
        break;
        case 2:
            ?>���� (� ��������: <?php echo $main_value['count']; ?>)<?php
        break;
        case 3:
            ?>������ (� ��������: <?php echo $main_value['count']; ?>)<?php
        break;
        case 4:
            ?>������������ ������������ (� ��������: <?php echo $main_value['count']; ?>)<?php
        break;
        case 5:
            ?>�������� ��������� (� ��������: <?php echo $main_value['count']; ?>)<?php
        break;
        case 6:
            ?>��������� ������� (� ��������: <?php echo $main_value['count']; ?>)<?php
        break;
        
        
    }
    ?></a><a class="add" href="<?php echo $cat_url->get() ?>">� ������</a></h3>
    <ul><?php
    foreach ($main_value['list'] as $value) {?>
    <li>
    <a href="<?php echo $value['link']?>">
    <?php if ($value['preview']) {?>
    <img src="<?php echo $value['preview'];?>" height="100" width="100" />
    <?php } else {?>
    
    <img src="<?php echo $this->view_folder?>/img/house-3.png" height="100" width="100" />
    <?php } ?>
    
    <p><?php
    switch ($value['type']) {
    	case 1:
    		echo $value['rooms_count'] . '-��������� ��������';
    		if($value['planning'] == 2) {
    			echo ' ���������� ����������';
    		}
    		break;
    	default:
    		echo $value['name_type'];
    		if (($value['type'] == 1 or $value['type'] == 2) and $value['rooms_count'] ) {?>, ������: <?php echo $value['rooms_count']; }
    		break;
    }
    ?>
    
    <?php if ($value['settlement_id'] == 1) { ?>
    
    <?php if ($value['street_adding']) { ?>����� <?php } echo $value['name_street']; 
    if ($value['house_number']) {
    ?>, ��� <?php echo $value['house_number']; }?>
    
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
    } ?>
    
    </p>
    
    </a>
<div class="ugol-left-top"></div><div class="ugol-left-bottom"></div><div class="ugol-right-top"></div><div class="ugol-right-bottom"></div>

    </li>
    <?php }?>
    </ul>
    </div>
<?php
$result[$key]['text'] = ob_get_clean();
$result[$key]['count'] = $main_value['count'];
//$result[$key]['count'] = $count;
 }
 ?>
 <h3 style="padding-bottom: 0; margin-bottom:3px;">����� �������� � ��������:</h3>
 <ul id="preview-list-new">
 <?php
 foreach ($result as $key => $value)
 {
     ?><li><a href="#type_<?php echo $key ?>"><?php
     
    switch ($key)
    {
        case 1:
            ?>�������: <?php echo $value['count'];
        break;
        case 2:
            ?>�����: <?php echo $value['count']; 
        break;
        case 3:
            ?>�������: <?php echo $value['count']; 
        break;
        case 4:
            ?>������������ ������������: <?php echo $value['count']; 
        break;
        case 5:
            ?>�������� ���������: <?php echo $value['count']; 
        break;
        case 6:
            ?>��������� ��������: <?php echo $value['count']; 
        break;
        
        
    }
     
     ?></a></li><?
 }
 ?>
 </ul>
 <?php

foreach ($result as $key => $value)
    echo $value['text'];
 ?>
 
 

</div>