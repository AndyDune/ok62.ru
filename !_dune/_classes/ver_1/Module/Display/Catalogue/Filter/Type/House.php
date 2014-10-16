<?php

class Module_Display_Catalogue_Filter_Type_House extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
        $view = Dune_Zend_View::getInstance();
        $session = Dune_Session::getInstance($this->session_zone);
        $view->saved = $session->getZone(true);
        $view->type = $this->type;
        
        $type_add = new Special_Vtor_Object_Add_Type();
        $view->type_add = $type_add->getListTypeWithObjectsActiveHave(2);
        
        $wall = new Special_Vtor_Object_Add_MaterialWall();
        $view->type_wall = $wall->getListTypeWithObjectsActiveHave(2);
        
        $condition = new Special_Vtor_Object_Condition();
        $view->condition = $condition->getListWithObjects($this->type);
        echo $view->render('bit/catalogue/filter/type/house');
    


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    