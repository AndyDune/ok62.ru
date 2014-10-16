<?php

class Module_Display_Catalogue_Filter_Base extends Dune_Include_Abstract_Code
{

    protected function code()
    {
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    $types_array = array(1,2,3,4,5,6);
    if (!in_array($this->type, $types_array))
    {
        return;
    }
    $session = Dune_Session::getInstance($this->session_zone);
//    if ($session->type != $this->type)
//        $session->killZone();
    $view = Dune_Zend_View::getInstance();
    switch ($this->type)
    {
        case 1: // Квартира
            $filter = new Module_Display_Catalogue_Filter_Type_Room();
            $filter->type          = $this->type;
            $filter->session_zone  = $this->session_zone;
            $filter->objects_count = $this->objects_count;
            $filter->make();
            echo $filter;
            //echo $view->render('bit/catalogue/adress/list_add');
        break;
        case 4: // Нежилое помещение
            $filter = new Module_Display_Catalogue_Filter_Type_NoLife();
            $filter->type          = $this->type;
            $filter->session_zone  = $this->session_zone;
            $filter->objects_count = $this->objects_count;
            $filter->make();
            echo $filter;
            //echo $view->render('bit/catalogue/adress/list_add');
        break;

        case 5: // Кладоваки
            $filter = new Module_Display_Catalogue_Filter_Type_Pantry();
            $filter->type          = $this->type;
            $filter->session_zone  = $this->session_zone;
            $filter->objects_count = $this->objects_count;
            $filter->make();
            echo $filter;
            //echo $view->render('bit/catalogue/adress/list_add');
        break;
        
        
        case 3: // Нежилое помещение
            $filter = new Module_Display_Catalogue_Filter_Type_Garage();
            $filter->type          = $this->type;
            $filter->session_zone  = $this->session_zone;
            $filter->objects_count = $this->objects_count;
            $filter->make();
            echo $filter;
            //echo $view->render('bit/catalogue/adress/list_add');
        break;
        case 2: // Дом
            $filter = new Module_Display_Catalogue_Filter_Type_House();
            $filter->type          = $this->type;
            $filter->session_zone  = $this->session_zone;
            $filter->objects_count = $this->objects_count;
            $filter->make();
            echo $filter;
            //echo $view->render('bit/catalogue/adress/list_add');
        break;
        case 6: // Земельный участок
            $filter = new Module_Display_Catalogue_Filter_Type_Land();
            $filter->type          = $this->type;
            $filter->session_zone  = $this->session_zone;
            $filter->objects_count = $this->objects_count;
            $filter->make();
            echo $filter;
            //echo $view->render('bit/catalogue/adress/list_add');
        break;

        
        default:
            //echo $view->render('bit/catalogue/adress/list_add');
    }
    


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    