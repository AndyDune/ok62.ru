<?php

class Module_Sub_Display_ComplexHomeTable extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        

    $complex_id = $this->complex;
    $house_id      = $this->house;


    // Список комплексов
	$list_houses = new Special_Vtor_Sub_List_Complex();
	
    if (Special_Vtor_Object_List::$edinstvo)
        $list_houses->setEdinstvo();
    else if (Special_Vtor_Object_List::$user)
        $list_houses->setUser(Special_Vtor_Object_List::$user);
    else 
	   $list_houses->setEdinstvo();
	
	$result = $list_houses->getDataStatistic();

	if ($result and count($result))
	{
	    $list_complex = $result;
	}
    else 
        $list_complex = array();
        
    $list_house_in_complex   = array();
    $have_complex_in_house = false;
    if ($complex_id)
    { 
        // Список домов простых
    	$list_houses = new Special_Vtor_Sub_List_House();
    	$list_houses->setComplex($complex_id);
    
        if (Special_Vtor_Object_List::$edinstvo)
            $list_houses->setEdinstvo();
        else if (Special_Vtor_Object_List::$user)
            $list_houses->setUser(Special_Vtor_Object_List::$user);
        else 
    	   $list_houses->setEdinstvo();
    	
    	$result = $list_houses->getDataStatistic();
    	if ($result and count($result))
    	{ 
    	    $list_house_in_complex[$complex_id] = $result;
    	    $have_complex_in_house = true;
    	}
        else 
            $have_complex_in_house = array();
    }

    // Список домов простых
	$list_houses = new Special_Vtor_Sub_List_House();
	$list_houses->setComplexNo();

    if (Special_Vtor_Object_List::$edinstvo)
        $list_houses->setEdinstvo();
    else if (Special_Vtor_Object_List::$user)
        $list_houses->setUser(Special_Vtor_Object_List::$user);
    else 
	   $list_houses->setEdinstvo();
	
	$result = $list_houses->getDataStatistic();
    
	if ($result and count($result))
	{
	    $list_house = $result;
	}
    else 
        $list_house = array();
    
    
$data = '';


ob_start();    
?>	  
<div class="block-static-out">
<div class="block-static-inside"><?php
if (count($list_complex))
{
?><h3>Комплексы</h3>
<ul class="top-complex-home">
<?php foreach ($list_complex as $one_complex)
{
    if ($complex_id == $one_complex['id'])
        $active = ' class="active-complex"';
    else 
        $active = '';
    ?><li class="one-comlpex"><a<?php echo $active; ?> href="/complex/<?php echo $one_complex['id'] ?>/"><span><?php echo $one_complex['name_small'] ?><span></a><?php
    
    if ($have_complex_in_house and key_exists($one_complex['id'], $list_house_in_complex))
    {
        ?><ul class="house-in-complex"><?php
        foreach ($list_house_in_complex[$one_complex['id']] as $one_house)        
        {
            if ($house_id == $one_house['id'])
                $active = ' class="active-house"';
            else 
                $active = '';
            
            ?><li class="one-house-in-complex"><a<?php echo $active; ?> href="/house/<?php echo $one_house['id'] ?>/"><span><?php

            if ($one_house['build_turn'] and false)
            {
                echo $one_house['build_turn']; ?> очередь - <?php
            }
            ?>дом <?php echo $one_house['house_number'];
            if ($one_house['building_number'])
            {
                ?>, корпус <?php echo $one_house['building_number'];
             }
            
             ?><span></a></li><?php
        }
        ?></ul><?php
    }
    
    ?></li><?php
}
?>
</ul>
<?php }





if (count($list_house))
{
?><h3>Дома</h3>
<ul class="top-complex-home">
<?php foreach ($list_house as $one_house)
{
    if ($house_id == $one_house['id'])
        $active = ' class="active-house-single"';
    else 
        $active = '';
    ?><li class="one-house"><a<?php echo $active; ?> href="/house/<?php echo $one_house['id'] ?>/"><span><?php

    
    if ($one_house['build_turn'] and false)
    {
        echo $one_house['build_turn']; ?> очередь - <?php
    }
    ?>дом <?php echo $one_house['house_number'];
    if ($one_house['building_number'])
    {
        ?>, корпус <?php echo $one_house['building_number'];
    }

    ?><span></a></li><?php
        
}
?>
</ul>
<?php } ?>





</div>
<div class="ugol-left-top"></div>
<div class="ugol-left-bottom"></div>
<div class="ugol-right-top"></div>
<div class="ugol-right-bottom"></div>

</div>

<?php  $data = ob_get_clean();

    
    $this->setResult('data', $data);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    
