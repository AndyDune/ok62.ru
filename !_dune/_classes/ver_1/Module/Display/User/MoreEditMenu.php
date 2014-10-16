<?php

class Module_Display_User_MoreEditMenu extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        


        $view = Dune_Zend_View::getInstance();
        
        if (!$this->user)
            throw new Dune_Exception_Base('�� ������� ����������� �������� ��� ������ ������.');
        
        $basket = new Special_Vtor_User_Object_Save($this->user->id);
            
        $view->user_status = Dune_Variables::$userStatus;
        
        $view->code = $this->code;
        $view->have_basket = $basket->isSavedAny();
        echo $view->render('bit/user/edit/more_edit_menu');


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    