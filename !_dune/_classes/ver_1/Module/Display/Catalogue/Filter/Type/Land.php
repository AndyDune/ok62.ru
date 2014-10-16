<?php

class Module_Display_Catalogue_Filter_Type_Land extends Dune_Include_Abstract_Code
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
        
        $condition = new Special_Vtor_Object_Condition();
        $view->condition = $condition->getListWithObjects($this->type);
        echo $view->render('bit/catalogue/filter/type/land');
    


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    