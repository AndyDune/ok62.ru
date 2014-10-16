<?php

class Module_Display_Catalogue_Object_InfoOneSub extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
$GET = Dune_Filter_Get_Total::getInstance();
$name_cache = 'object_info_' . $this->object->id . $this->mode . $GET->getDigit('number');
$time_cache = 240;

$text = false;

if (Dune_Variables::$userStatus < 500)
{
    Dune_Data_Zend_Cache::setLifeTime($time_cache);
    $text = Dune_Zend_Cache::loadIfAllow($name_cache);
    Dune_Data_Zend_Cache::setLifeTime();
}

if (!$text)
{
//echo 111;
    
//echo $this->object;

$view = Dune_Zend_View::getInstance();
$view->object = $this->object;
$planer = new Special_Vtor_Catalogue_Info_Plan($this->object->id, $this->object->time_insert); // а есть ли планеровка (план)

$plan_situa = new Special_Vtor_Catalogue_Info_PlanSitua($this->object->id, $this->object->time_insert); // а есть ли ситуационный план
if (!$plan_situa->count())
    $plan_situa = new Special_Vtor_Catalogue_Info_HouseSituaCommon($this->object->street_id, $this->object->house_number, $this->object->building_number);

$plan_floor = new Special_Vtor_Catalogue_Info_PlanFloor($this->object->id, $this->object->time_insert); // а есть ли план этажа
$plan_platform = new Special_Vtor_Catalogue_Info_PlanPlatform($this->object->id, $this->object->time_insert); // а есть ли план этажа

$seller = Dune_Auth_Mysqli_UserTime::getInstance($this->object->saler_id);
$view->seller_time_last_visit = $seller->getTimeLastVisit('last_visit');


if ($planer->count())
{
    $temp = $planer->getOneImage();
    $view->preview = $temp->getPreviewFileUrl();
}
// стало
else 
{
    $image = new Special_Vtor_Catalogue_Info_Image($this->object->id, $this->object->time_insert);
    if ($image->count())
    {
        $temp = $image->getOneImage();
        $view->preview = $temp->getPreviewFileUrl();
    }
    else 
        $view->preview = '';
}
// было
/*else if ($this->object->pics)
{
    $image = new Special_Vtor_Catalogue_Info_Image($this->object->id, $this->object->time_insert);
    $temp = $image->getOneImage();
    $view->preview = $temp->getPreviewFileUrl();
}
else 
    $view->preview = '';
*/


if ($this->object->gm_x and $this->object->gm_y)
{
    $have_gm   = true;
    $source_gm = '';
}
else if ($this->object->house_gm_x and $this->object->house_gm_y)
{
    $have_gm   = true;
    $source_gm = 'house_';
}
else if ($this->object->complex_gm_x and $this->object->complex_gm_y)
{
    $have_gm   = true;
    $source_gm = 'complex_';
}
else if ($this->object->settlement_gm_x and $this->object->settlement_gm_y)
{
    $have_gm   = true;
    $source_gm = 'settlement_';
}
else
{ 
    $have_gm = false;
    $source_gm = '';
}   
$view->source_gm = $source_gm;
    
if ($planer->count())
{
    $temp = $planer->getOneImage();
    $view->preview_big = $temp->getPreviewFileUrl(400);
    $view->preview_sourse = $temp->getSourseFileUrl();
}
// стало
else 
{
    $image = new Special_Vtor_Catalogue_Info_Image($this->object->id, $this->object->time_insert);
    if ($image->count())
    {
    $temp = $image->getOneImage();
    $view->preview_big = $temp->getPreviewFileUrl(400);
    $view->preview_sourse = $temp->getSourseFileUrl();
    }
    else 
        $view->preview_big = '';
}

/*
else if ($this->object->pics)
{
    $image = new Special_Vtor_Catalogue_Info_Image($this->object->id, $this->object->time_insert);
    $temp = $image->getOneImage();
    $view->preview_big = $temp->getPreviewFileUrl(400);
    $view->preview_sourse = $temp->getSourseFileUrl();
}
else 
    $view->preview_big = '';
    
*/   
    
    
// !! Информация о наличии бывает в базе - можно оптимизировать 
$house = new Special_Vtor_Catalogue_Info_House($this->object->id, $this->object->time_insert); // а есть ли фото дома
if (!$house->count())
{
    $house = new Special_Vtor_Catalogue_Info_HousePhotoCommon($this->object->street_id, $this->object->house_number, $this->object->building_number);
}   
$panorama = new Special_Vtor_Catalogue_Info_Panorama($this->object->id, $this->object->time_insert); // а есть ли панораы

if (!$panorama->count() and $this->object->panorama)
    $panorama = new Special_Vtor_Catalogue_Info_PanoramaCommon($this->object->panorama); // а есть ли панораы


// Выяснение похожих объектов
$have_group = 0;
if ($this->object->type == 1)    // пока тоько для квартир
{
    $list = new Special_Vtor_Object_List();
    $list->setActivity(1);
    $list->setRegion(null);
    $list->setOrder('floor');
    $list->setShowWitoutHouseNumber();
    $array_group = $list->getListCumulateInGroup($this->object->group_list);
    $count = count($array_group) - 1;
    if (count($array_group) > 0)
        $have_group = $count;
}    
    
$have_modif = false;


if (is_null($this->object->have_situa)) // Фиксируем наличие ситуационного плана
{
    $this->object->have_situa = $plan_situa->count();
    $have_modif = true;
}


if (is_null($this->object->have_plan)) // Фиксируем наличие плана
{
    $this->object->have_plan = $planer->count();
    $have_modif = true;
}

if (is_null($this->object->have_panorama)) // Фиксируем наличие панорамы
{
    $this->object->have_panorama = $panorama->count();
    $have_modif = true;
}
if (is_null($this->object->pics)) // Фиксируем наличие картинки
{
    $pics = new Special_Vtor_Catalogue_Info_Image($this->object->id, $this->object->time_insert);
    $this->object->pics = $pics->count();
    $have_modif = true;
}
if (is_null($this->object->have_photo_house)) // Фиксируем наличие фото дома
{
    $this->object->have_photo_house = $house->count();
    $have_modif = true;
}

if ($have_modif) // Сохраняем ченжи
{
    $this->object->save();
}


try
{
    
if ($have_group and $this->mode == 'group')
{
    throw new Dune_Exception_Control('Показать похожие объеты', 7);
}

if ($view->object->house_pd and $this->mode == 'pd')
{
    throw new Dune_Exception_Control('Показать проектную документацию', 10);
}


    
if ($view->object->pics and $this->mode == 'photo')
{
    throw new Dune_Exception_Control('Показать фото объекта', 1);
}

if ($planer->count() and $this->mode == 'plan')
{
    throw new Dune_Exception_Control('Показать плат объекта', 2);
}

if ($house->count() and $this->mode == 'house')
{
    throw new Dune_Exception_Control('Показать дом', 3);
}

if ($panorama->count() and $this->mode == 'panorama')
{
    throw new Dune_Exception_Control('Показать панораму', 4);
}

if ($plan_situa->count() and $this->mode == 'situa')
{
    throw new Dune_Exception_Control('Показать ситуационный план', 5);
}
if ($plan_floor->count() and $this->mode == 'floor')
{
    throw new Dune_Exception_Control('Показать план этажа', 6);
}


if ($have_gm and $this->mode == 'gm')
{
    throw new Dune_Exception_Control('Показать на карте google', 8);
}


switch ($this->object->type)
{
        case 1: // Квартиры
            $object_condition = new Special_Vtor_Object_Condition();
            $object_condition = $object_condition->getList(1);
            $object_planning = new Special_Vtor_Object_Planning();
            $object_planning = $object_planning->getList();
           
            $house_type = new Special_Vtor_Object_Add_HouseType();
            $view->house_type = $house_type->getListType(1);
            
            $view->condition = $object_condition;
            $view->planning = $object_planning;
            
            $object_card = $view->render('bit/catalogue/object/info/type/room');
        break;
        case 3: // Гараж
            $object_condition = new Special_Vtor_Object_Condition();
            $object_condition = $object_condition->getList(3);
            $object_planning = new Special_Vtor_Object_Planning();
            $object_planning = $object_planning->getList();
            
            $house_type = new Special_Vtor_Object_Add_HouseType();
            $view->house_type = $house_type->getListType(3);
           
            $view->condition = $object_condition;
            $view->planning = $object_planning;
            
            $object_card = $view->render('bit/catalogue/object/info/type/garage');
        break;

        case 4: // Нежилое
            $object_condition = new Special_Vtor_Object_Condition();
            $object_condition = $object_condition->getList(4);
            $view->condition = $object_condition;
            
            $house_type = new Special_Vtor_Object_Add_HouseType();
            $view->house_type = $house_type->getListType(4);
            
            $object_card = $view->render('bit/catalogue/object/info/type/nolife');
        break;
        
        case 5: // Нежилое
            $object_condition = new Special_Vtor_Object_Condition();
            $object_condition = $object_condition->getList(1);
            
            $house_type = new Special_Vtor_Object_Add_HouseType();
            $view->house_type = $house_type->getListType(5);
            
            $view->condition = $object_condition;
            $object_card = $view->render('bit/catalogue/object/info/type/pantry');
        break; 
        case 2: // Дом коттттдж
            $object_condition = new Special_Vtor_Object_Condition();
            $object_condition = $object_condition->getList(2);
            
           
            $type_add = new Special_Vtor_Object_Add_Type(2); // Дополнительный тип
            $view->type_add = $type_add->getListType();

            $walls = new Special_Vtor_Object_Add_MaterialWall(); // Материал стен
            $view->walls = $walls->getList();
            
            
            $view->condition = $object_condition;
            $object_card = $view->render('bit/catalogue/object/info/type/house');
        break;

        case 6: // Земельный участок
            $object_condition = new Special_Vtor_Object_Condition();
            $object_condition = $object_condition->getList(6);

            $view->condition = $object_condition;
            $object_card = $view->render('bit/catalogue/object/info/type/land');
        break;
        
        default:
            $object_card = $view->render('bit/catalogue/object/info/type/common');
}
        $view->object_card = $object_card;
//        Dune_Static_StylesList::add('thickbox');
//        Dune_Static_StylesList::add('catalogue/info_one');
}
catch (Dune_Exception_Control $e)
{
    switch ($e->getCode())
    {
        case 1:
            // Dune_Static_StylesList::add('catalogue/info_one_photo');
            $pics = new Special_Vtor_Catalogue_Info_Image($this->object->id, $this->object->time_insert);
            $view->data = $pics;
            $object_card = $view->render('bit/catalogue/object/info/photo');
        break;
        case 2:
            // Dune_Static_StylesList::add('catalogue/info_one_plan');
            $view->data = $planer;
            $object_card = $view->render('bit/catalogue/object/info/plan');
        break;
        case 3:
            // Dune_Static_StylesList::add('catalogue/info_one_photo');
            $view->data = $house;
            $object_card = $view->render('bit/catalogue/object/info/house');
        break;
        case 4:
            // Dune_Static_StylesList::add('catalogue/info_panorama');
            $view->data = $panorama;
            $view->adress_object = $this->adress_object;
            $view->type = $this->type;
            $view->mode = $this->mode;
            $view->object_id = $this->object->id;
            $view->number = $GET->getDigit('number', 1, 2);
            
            // Сборка ссылки на текущий объект
            $collect = new Special_Vtor_Catalogue_Url_Collector();
            $collect->setAdress($this->adress_object);
            $collect->setType($this->type);
            $collect->setMode($this->mode);
            $collect->setObject($this->object->id);
            $view->base_url = $collect->get();
            
            if (Dune_Parameters::$ajax)
            {
                $object_card = $view->render('bit/catalogue/object/info/panorama_ajax');
            }
            else 
                $object_card = $view->render('bit/catalogue/object/info/panorama');
        break;
        
        case 5:
            // Dune_Static_StylesList::add('catalogue/info_one_plan');
            $view->data = $plan_situa;
            $object_card = $view->render('bit/catalogue/object/info/plan_situa');
        break;
        case 6:
            // Dune_Static_StylesList::add('catalogue/info_one_plan');
            $view->data = $plan_floor;
            $object_card = $view->render('bit/catalogue/object/info/plan_floor');
        break;
        case 7:
            // Dune_Static_StylesList::add('catalogue/info_one_plan');
            
            
            //Dune_Static_StylesList::add('catalogue/list');
            
            $objects_list_list = array();
            foreach ($array_group as $key => $value)
            {
                $objects_list_list[$key] = $value;
                
                $cat_url = new Special_Vtor_Catalogue_Url_Collector();
                $cat_url->setRegion($value['region_id']);
                $cat_url->setArea($value['area_id']);
                $cat_url->setSettlement($value['settlement_id']);
                $cat_url->setStreet($value['street_id']);
                $cat_url->setHouse($value['house_number']);
                
                if (Special_Vtor_Settings::$districtPlus)
                    $cat_url->setDistrict($value['district_id_plus'], true);
                else 
                    $cat_url->setDistrict($value['district_id']);
                
                $cat_url->setType($value['type']);
                $cat_url->setObject($value['id']);
                $objects_list_list[$key]['link'] = $cat_url->get();
                
                $pics = new Special_Vtor_Catalogue_Info_Plan($value['id'], $value['time_insert']);
                //echo $pics->count();
                if ($pics->count())    
                {
                    $prew = $pics->getOneImage();
                    $objects_list_list[$key]['preview'] = $prew->getPreviewFileUrl(100);
                }    
                else if ($value['pics'])
                {
                    $pics = new Special_Vtor_Catalogue_Info_Image($value['id'], $value['time_insert']);
                    $prew = $pics->getOneImage();
                    $objects_list_list[$key]['preview'] = $prew->getPreviewFileUrl(100);
                }
                else 
                    $objects_list_list[$key]['preview'] = '';
            }
            
            $view->data = $objects_list_list;
            $object_card = $view->render('bit/catalogue/object/info/group');
        break;
        case 8:
            // Dune_Static_StylesList::add('catalogue/info_one_plan');
            $view->to_map_add = Special_Vtor_Vars::$googleMapData;
//            $module = new Module_Display_Catalogue_Object_InfoOneGM();
//            $module->object = $this->object;
//            $module->preview = $view->preview;
//            $module->make();
            $view->comment = '';
            $object_card = $view->render('bit/catalogue/object/info/gm');
        break;
        

        case 10:
            $view->comment = '';
            $object_card = $view->render('bit/catalogue/object/info/pd');
        break;
        
        
    }
    $view->object_card = $object_card;
    
}

    $url = new Special_Vtor_Catalogue_Url_Collector();
    $url->setType($this->type);
    $url->setObject($this->object->id);
//    $url->setAdress($this->adress_object);
    $url->setAdressWord(1);
    $bookmarks[1] = array('Информация', 'info', $url->get(), false);

    if ($view->object->house_pd)
    {
        $url->setMode('pd');
        $bookmarks[10] = array('Проектная документация', 'pd', $url->get(), false);
    }
    
    if ($planer->count())
    {
        $url->setMode('plan');
        $bookmarks[2] = array('Планировка', 'plan', $url->get(), false);
    }
    if ($plan_floor->count())
    {
        $url->setMode('floor');
        $bookmarks[3] = array('План этажа', 'floor', $url->get(), false);
    }
    if ($view->object->pics)
    {
        $url->setMode('photo');
        $bookmarks[4] = array('Фото', 'photo', $url->get(), false);
    }
    
    
    if ($house->count())
    {
        $url->setMode('house');
        $bookmarks[5] = array('Дом', 'house', $url->get(), false);
    }
    if ($panorama->count())
    {
        $url->setMode('panorama');
        $bookmarks[6] = array('Панорама', 'panorama', $url->get(), false);
    }
    if ($plan_situa->count())
    {
        $url->setMode('situa');
        $bookmarks[7] = array('Ситуационный план', 'situa', $url->get(), false);
    }

    if ($have_group)
    {
        $url->setMode('group');
        $bookmarks[8] = array('Квартиры в стояке', 'group', $url->get(), false);
    }
    if ($have_gm)
    {
        $url->setMode('gm');
        $bookmarks[9] = array('На карте', 'gm', $url->get(), false);
    }
    
    
    $default = true;
    foreach ($bookmarks as $key => $value)
    {
        if ($this->mode == $value[1])
        {
            $bookmarks[$key][3] = true;
            $default = false;
        }
    }
    if ($default)
    {
        $bookmarks[1][3] = true;
    }
    $view->bookmarks = $bookmarks;
    
    $view->count_comments = $this->object->countComments();
    
$URL = Dune_Parsing_UrlSingleton::getInstance();    
$session = Dune_Session::getInstance('talk');
$view->talk_mode = $session->talk_mode;

$view->self_url = $URL->getCommandString();

    
    $text = $view->render('bit/catalogue/object/info/index');
    
if (Dune_Variables::$userStatus < 500)
{
    
    Dune_Data_Zend_Cache::setLifeTime($time_cache);
    Dune_Zend_Cache::saveIfAllow($text, $name_cache);
    Dune_Data_Zend_Cache::setLifeTime();
}

} // было закешено   
    echo $text;

    
    
   Dune_Static_StylesList::add('catalogue/info_one_plan');
   Dune_Static_StylesList::add('catalogue/info_panorama'); 
   Dune_Static_StylesList::add('catalogue/info_one_photo');
   
   Dune_Static_StylesList::add('catalogue/list');
   Dune_Static_StylesList::add('catalogue/info_one');



    Dune_Static_StylesList::add('catalogue/info_one');   
    
    Dune_Static_StylesList::add('jquery.tooltip');
    Dune_Static_JavaScriptsList::add('jquery.tooltip.min');    
    
    Dune_Static_JavaScriptsList::add('jquery.dimensions');
//    Dune_Static_JavaScriptsList::add('jquery.tooltip.min');
    Dune_Static_JavaScriptsList::add('dune.object');
    


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    