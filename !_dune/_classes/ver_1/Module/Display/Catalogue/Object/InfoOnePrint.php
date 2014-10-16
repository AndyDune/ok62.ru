<?php

class Module_Display_Catalogue_Object_InfoOnePrint extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
$GET = Dune_Filter_Get_Total::getInstance();
    
$view = Dune_Zend_View::getInstance();
$view->object = $this->object;
$planer = new Special_Vtor_Catalogue_Info_Plan($this->object->id, $this->object->time_insert); // а есть ли планеровка (план)

$plan_situa = new Special_Vtor_Catalogue_Info_PlanSitua($this->object->id, $this->object->time_insert); // а есть ли ситуационный план
if (!$plan_situa->count())
    $plan_situa = new Special_Vtor_Catalogue_Info_HouseSituaCommon($this->object->street_id, $this->object->house_number, $this->object->building_number);



if ($planer->count())
{
    $temp = $planer->getOneImage();
    $view->preview = $temp->getPreviewFileUrl();
}
else if ($this->object->pics)
{
    $image = new Special_Vtor_Catalogue_Info_Image($this->object->id, $this->object->time_insert);
    $temp = $image->getOneImage();
    $view->preview = $temp->getPreviewFileUrl();
}
else 
    $view->preview = '';

    
if ($planer->count())
{
    $temp = $planer->getOneImage();
    $view->preview_big = $temp->getPreviewFileUrl(400);
    $view->preview_sourse = $temp->getSourseFileUrl();
}
else if ($this->object->pics)
{
    $image = new Special_Vtor_Catalogue_Info_Image($this->object->id, $this->object->time_insert);
    $temp = $image->getOneImage();
    $view->preview_big = $temp->getPreviewFileUrl(400);
    $view->preview_sourse = $temp->getSourseFileUrl();
}
else 
    $view->preview_big = '';
    
    
    
    $user_info = new Dune_Auth_Mysqli_UserActive($this->object->saler_id);
    //echo $user_info;
    $allow_array = $user_info->getUserArrayConfig(true);
    
    
    $this->setResult('seller', $user_info);
    
    $view->user_info = $user_info;
    $view->user_info_allow = new Dune_Array_Container($allow_array->info_access);
    
//    echo $view->render('bit/user/info/with_object_view_open');
    

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
            
            $object_card = $view->render('bit/catalogue/object/info/type/print/room');
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
            
            $object_card = $view->render('bit/catalogue/object/info/type/print/garage');
        break;

        case 4: // Нежилое
            $object_condition = new Special_Vtor_Object_Condition();
            $object_condition = $object_condition->getList(4);
            $view->condition = $object_condition;
            
            $house_type = new Special_Vtor_Object_Add_HouseType();
            $view->house_type = $house_type->getListType(4);
            
            $object_card = $view->render('bit/catalogue/object/info/type/print/nolife');
        break;
        
        case 5: // Нежилое
            $object_condition = new Special_Vtor_Object_Condition();
            $object_condition = $object_condition->getList(1);
            
            $house_type = new Special_Vtor_Object_Add_HouseType();
            $view->house_type = $house_type->getListType(5);
            
            $view->condition = $object_condition;
            $object_card = $view->render('bit/catalogue/object/info/type/print/pantry');
        break; 
        case 2: // Дом коттттдж
            $object_condition = new Special_Vtor_Object_Condition();
            $object_condition = $object_condition->getList(2);
            
           
            $type_add = new Special_Vtor_Object_Add_Type(2); // Дополнительный тип
            $view->type_add = $type_add->getListType();

            $walls = new Special_Vtor_Object_Add_MaterialWall(); // Материал стен
            $view->walls = $walls->getList();
            
            
            $view->condition = $object_condition;
            $object_card = $view->render('bit/catalogue/object/info/type/print/house');
        break;
        
        default:
            $object_card = $view->render('bit/catalogue/object/info/type/print/common');
}
        $view->object_card = $object_card;
//        Dune_Static_StylesList::add('thickbox');
//        Dune_Static_StylesList::add('catalogue/info_one');
                    
            
   
//echo  $object_card;
Dune_Static_StylesList::clear();   
Dune_Static_StylesList::add('catalogue/info_one_print');
$view_array = array(
                    'js' => Dune_Static_JavaScriptsList::get(),
                    'css' => Dune_Static_StylesList::get(),
                    );
$view->assign($view_array);
   
   
   echo $view->render('page:catalogue:default_object_info_print');   
    

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    