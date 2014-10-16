<?php

class Display_Complex_OneInList extends Dune_Include_Abstract_Display
{

    /**
     * Используемые стили
     *
     * @var array
     */
    protected $______styles = array(
                                   'complex_house',
                                   'thickbox'
                                   );

    /**
     * Используемые скрипты
     *
     * @var array
     */
    protected $______scripts = array(
                                   'thickbox'
                                   );
                                   
    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
$id = $this->id;
$data = $this->data;

/*$url_catalogue = new Special_Vtor_Catalogue_Url_Collector();
$url_catalogue->setRegion($data['region_id']);
$url_catalogue->setArea($data['area_id']);
$url_catalogue->setSettlement($data['settlement_id']);


$url_catalogue->setStreet($data['street_id']);
$url_catalogue->setHouse($data['house_number']);
$url_catalogue->setBuilding($data['building_number']);

$url_catalogue->setGroup($data['complex_id']);
    
if (Special_Vtor_Settings::$districtPlus)
    $url_catalogue->setDistrict($data['district_id_plus'], true);
else 
    $url_catalogue->setDistrict($data['district_id']);


if ($data['have_fasad'])
{
    $img = new Special_Vtor_Sub_Image_Fasad($data['id']);
    $this->fasad = $img->getOneImage();
}
*/
?>



<?php
if ($data['have_fasad'])
{
    $img = new Special_Vtor_Sub_Complex_Image_Fasad($data['id']);
    $fasad = $img->getOneImage();
    $url_fasad = $fasad->getPreviewFileUrl(250);
}
?>

	<table class="table-one-complex-in-list">
	
			<tr>
				<td colspan="2" class="list-td-complex-name">
					<a class="a-object-name" href="/complex/<?php echo $data['id']; ?>/"><?php echo $data['name']; ?></a>
			    </td>
			    <td width="50px"><p class="info-photo-complex">
			    
			    
			    
			    
			    
<?php
$goo = false;
if ($data['gm_x'])
{
    $gm = array('x' => $data['gm_x'], 'y' => $data['gm_y']);
    $goo = true;
}
else if ($data['group_gm_x'])
{
    $gm = array('x' => $data['group_gm_x'], 'y' => $data['group_gm_y']);
    $goo = true;
}
if ($goo)
{
    ?><a href="/map/public/<?php echo $gm['x']; ?>_<?php echo $gm['y']; ?>/"><img width="21" height="21" src="/data/img/subdomain/edinstvo/img/info/map.gif" alt="Смотреть на карте" /></a> <?php
}
if ($data['panorama_id'] or $data['complex_panorama_id'])
{
    ?><a href="/complex/<?php echo $data['id']; ?>/panorama/"><img width="21" height="21" src="/data/img/subdomain/edinstvo/img/info/pan.gif" alt="Панорамный обзор" /></a> <?php
}

if ($data['have_photo'] or $data['complex_have_photo'])
{
    ?><a href="/complex/<?php echo $data['id']; ?>/photo/"><img width="21" height="21" src="/data/img/subdomain/edinstvo/img/info/photo.gif" alt="Фоторепортаж" /></a> <?php
}
?>
			    
			    
			    
			    
			    </p></td>
			</tr>
			
			
			<tr>
			<td class="list-td-complex-fasad"><a href="/complex/<?php echo $data['id']; ?>/"><img border="0" src="<?php echo $url_fasad; ?>" width="250" alt=""></a></td>
			<td class="list-td-complex-info"><div class="list-div-complex-info">
					<p>
                    <?php if ($data['settlement_id'] == 1)
                    {
                        ?>Рязань<?php
                    } else 
                    {
                        echo $data['name_region']; 
                        if ($data['area_id'])
                        {
                            ?>, <?php echo $data['name_area'];
                        }
                        if ($data['settlement_id'])
                        {
                            ?>, <?php echo $data['name_settlement'];
                        }
                        
                    }
                    if ($data['street_id'])
                    {
                    ?>, <?php if ($data['street_adding']) { ?>улица <?php } echo $data['name_street'];
                    }
                    ?></p><?php
                    if ($data['district_plus_id'])
                    {
                        ?><p>Район:  <?php echo $data['name_district_plus']; ?></p><?php
                    }
            ?>
</div>
			<?php
			
            	$list_houses = new Special_Vtor_Sub_List_House();
            	$list_houses->setComplex($data['id']);
            	$list_houses->setOrder('build_turn');
            	$result = $list_houses->getDatas();
            	
            	if (count($result))
            	{ ?><ul class="house-in-complex-build-turn"><?php
            	    foreach ($result as $value)
            	    {
            	        ?><li><p><a href="/house/<?php echo $value['id']; ?>/"><?php

            	        if ($value['build_turn'])
            	        { ?><strong><?php
            	            echo $value['build_turn']; ?> очередь</strong> - <?php
            	        }
            	        ?>дом <?php echo $value['house_number'];
            	        if ($value['building_number'])
            	        {
            	            ?>, корпус <?php echo $value['building_number'];
            	        }
            	         ?></a></p>
            	         <p>Шахматки: <?php

            	        $zap = '';
            	        if ($value['count_room'])
            	        {
            	            $zap = ', ';
            	            ?><a href="/house/<?php echo $value['id'] ?>/grid/room/">Квартиры</a><?php
            	        }
            	        if ($value['count_pantry'])
            	        {
            	            echo $zap;
            	            ?><a href="/house/<?php echo $value['id'] ?>/grid/pantry/">Кладовки</a><?php
            	            $zap = ', ';
            	        }
            	        if ($value['count_nolife'])
            	        {
            	            echo $zap;
            	            ?><a href="/house/<?php echo $value['id'] ?>/grid/nolife/">Нежилые</a><?php
            	        }
            	        
            	         ?></p>
            	         </li><?php
            	    }
            	  ?></ul><?php  
            	}
			
			
			?>
															
		   </td>
				
				
				<td class="list-td-complex-add">
				
					 
<div class="div-house-list-count" style="text-align:right"><?php
// Свободных квартир
if ($data['count_room'])
{
    ?><p>Квартир: <span><?php echo $data['count_room']; ?></span></p><?php
}
// Свободных нежилых
if ($data['count_nolife'])
{
    ?><p>Нежилых: <span><?php echo $data['count_nolife']; ?></span></p><?php
}
// Свободных кладовых
if ($data['count_pantry'])
{
    ?><p>Кладовок: <span><?php echo $data['count_pantry']; ?></span></p><?php
}

?></div>
    	
					 
					 
        <div class="div-house-list-info-add"><?php
        
        ?>
        
        <?php
        if ($data['have_situa'] and false)
        {
            $img = new Special_Vtor_Sub_Complex_Image_Situa($data['id']);
            $one = $img->getOneImage();
            
            ?><p><a class="thickbox" href="<?php echo $one->getSourseFileUrl(); ?>">Ситуационый план</a></p><?php
        }
        ?>
        
        
        </div>
        
        </td>
			</tr>
		</table>	




<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    