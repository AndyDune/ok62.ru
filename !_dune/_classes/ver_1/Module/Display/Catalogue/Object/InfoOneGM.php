<?php

class Module_Display_Catalogue_Object_InfoOneGM extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
$this->object = new Dune_Array_Container($this->object);

?><div><?php
$view = Dune_Zend_View::getInstance();
ob_start();
switch ($this->object->type) {
	case 1:
		echo $this->object->rooms_count;
		?>-���������<?php
		if($this->object->levels == 2) {
			?> �������������<?php
		} elseif ($this->object->levels == 3) {
			?> �������������<?php
		} elseif ($this->object->levels == 4) {
			?> ����������������<?php
		}
		?> ��������<?php
		if($this->object->planning == 2) {
			?> ���������� ����������<?php
		}
		break;
	case 2:
		

        $levels = '';
        $levels_temp = '';
         if ($this->object->floors_total > 1 and $this->object->floors_total < 10) 
            {
                $levels_temp = $this->object->floors_total . '-�����';
                $levels = $levels_temp . '�� ';
            }
            $name = '���';
            if ($this->object->type_add == 8)
            {
                $name = '����';
                if ($levels_temp)
                    $levels = $levels_temp . '�� ';
            }
            
            else if ($this->object->type_add == 10)
                $name = '�������';
            else if ($this->object->type_add == 11)
                $name = '����-����';
            else if ($this->object->type_add == 12)
            {
                $levels_temp = '';
                $name = '�������';
            }
                
            if (!$levels_temp)
        	   $name = ucfirst($name);
        	echo $levels, $name;
        	if($this->object->have_land) {
        		?> � ��������� ��������<?php
        	}
		
		
		break;
		
	default:
		echo $this->object->name_type;
		if (
          ($this->object->type == 1 or $this->object->type == 2)
      		and ($this->object->rooms_count)
          	) {?>, ������: <?php echo $this->object->rooms_count; }
			break;
}
$title = ob_get_clean(); // ��������� title



ob_start();
?>
    <?php if ($this->object->region_id != 1) { ?>
	<?php echo $this->object->name_region?>,
	<?php } ?>
	
    <?php if ($this->object->settlement_id != 1)
    {
	   echo $this->object->name_area; ?>, <?php
	
    	if ($this->object->settlement_id and $this->object->type_settlement < 100 and $this->object->name_settlement)
    	{ 
    	 echo $this->object->name_settlement;?>, <?php
    	}
    	else if ($this->object->settlement_name)
    	{ 
    	    echo $this->object->settlement_name;?>, <?php
    	}
    }
    else if ($this->object->settlement_name)
    {
        if ($this->object->district_id_plus > 1)
        {
	       echo $this->object->name_district_plus; ?><br /> <?php
        }
	    echo $this->object->settlement_name;?>, <?php
    }
	
	if ($this->object->street_id) {
	    
        if ($this->object->district_id_plus > 1)
        {
	       echo $this->object->name_district_plus; ?><br /> <?php
        }
	    
	    
	  if ($this->object->street_adding) { ?> ����� <?php } else {?> <?php }
	  echo $this->object->name_street;?>, <?php   
    } else 
	{
	    if ($this->object->street_name)
	    {
	       echo ' ' . $this->object->street_name;?>, <?php
	    }
	} 
	if ($this->object->house_number)
	{
	?> ��� <?php echo $this->object->house_number;
	}
	if ($this->object->building_number) { 
	?>, ������ <?php echo $this->object->building_number; }
	
	if ($this->object->room)
	 {
	    if ($this->object->type == 1) {
	 ?>, �������� <?php
        } else {
            ?>, ����� <?php
        }
	   echo $this->object->room;
	    }

 $adress = ob_get_clean();


?>
<h1>
<?php
echo $title; // ��������� title
?>
</h1>

<style type="text/css">
.values
{
margin: 0;
padding:0;
font-size:12px;
}
</style>


<table id="table-object-shot-info">
<tr>
<td class="td-object-shot-image">
<!--
<img src="<?php echo $view->view_folder?>/img/house-100.png" />
-->
<img height="100" width="100" src="/data/img/gm_object/<?php echo $this->object->id;  ?>/" />

</td>
<td class="td-object-shot-info td-object-shot-price" style="text-align:left; font-size:13px;">

<p style="color:#717171; font-size:18px; margin:0 0 10px 0;">
<?php if (!$this->object->price and !$this->object->price_rent and !$this->object->price_rent_day) { ?>
����: <span <span class="price-number" style="color: #000;">����������</span>
<?php } else if ($this->object->price_rent_day){ ?>
���� ������: <span <span class="price-number" style="color: #000;"><?php echo number_format($this->object->price_rent_day, 0, ',', ' ')?></span> <span class="price-red">���./�����</span>

<?php } else if ($this->object->price_rent){ ?>
���� ������: <span class="price-number" style="color: #000;"><?php echo number_format($this->object->price_rent, 0, ',', ' ')?></span> <span class="price-red">���./�����</span>
<?php } else { ?>
����: <span class="price-number" style="color: #000;"><?php echo number_format($this->object->price, 0, ',', ' ')?></span> <span class="price-red">���.</span>
<?php } ?>
</p>


<?php if ($this->object->group_name) { ?>
<p style="font-size:13px;"><strong>
<?php echo $this->object->group_name;  ?></strong></p>
<?php } else if ($this->object->name_complex) { ?>
<p style="font-size:13px;"><strong>
<?php echo $this->object->name_complex;  ?></strong></p>
<?php } ?>


<p class="object-shot-adress" style="font-size:13px; margin: 0 0 5px 0;"><strong>
<?php

echo trim($adress, ' ,');
?></strong>
</p>

<?php if ($this->object->deal == 2) {
    ?>
<p style="font-size:13px; color:#717171;"> �������, ������
</p>
<?php }
 else if ($this->object->deal == 1) {
    ?>
<p style="font-size:13px; color:#717171;"> ������
</p>
<?php } ?>

<?php if ($this->object->new_building_flag) { ?>
<p style="font-size:13px; color:#717171;">�����������<?php
if ($this->object->new_building_text) { ?>
, <?php echo $this->object->new_building_text;  } ?></p>
<?php } ?>


<p style="color:#717171; font-size:13px; margin: 0 0 0 0;">
<?php if ($this->object->space_total) { ?>
�������: <span style="color: #000;"><?php echo $this->object->space_total; ?></span> �<span class="up-word-small">2</span>
<?php } else if ($this->object->space_land) { ?>
�������: <span style="color: #000;"><?php echo $this->object->space_land; ?></span> �����
<?php } ?>
</p>
</tr>
</table>
<p style="padding:5px 0 0 0; margin:0;"><a href="<?php echo $this->link; ?>">��������� ����������</a></p>
</div>
<?php

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    