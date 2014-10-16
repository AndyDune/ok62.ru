<?php

class Module_Catalogue_Filter_Save extends Dune_Include_Abstract_Code
{

    protected function code()
    {
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    $session = Dune_Session::getInstance($this->session_zone);
    if ($session->type != $this->type and !$this->save_price)
        $session->killZone();
    $session->have = true;
    $post = Dune_Filter_Post_Total::getInstance();
    
    $filter = new Module_Catalogue_Filter_Save_Type_Common();
    $filter->session_zone  = $this->session_zone;
    $filter->save_price    = $this->save_price;
    $filter->make();
    
    if ($this->save_price != 'save_price')
    {
        switch ($post->type)
        {
            case 1: // Квартира
                $filter = new Module_Catalogue_Filter_Save_Type_Room();
                $filter->session_zone  = $this->session_zone;
                $filter->save_price    = $this->save_price;
                $filter->make();
            break;
            case 2: // Дом
                $filter = new Module_Catalogue_Filter_Save_Type_House();
                $filter->session_zone  = $this->session_zone;
                $filter->save_price    = $this->save_price;
                $filter->make();
            break;
            
            case 3: // Гараж
                $filter = new Module_Catalogue_Filter_Save_Type_Garage();
                $filter->session_zone  = $this->session_zone;
                $filter->save_price    = $this->save_price;
                $filter->make();
            break;
            case 4: // Нежилое помещение
                $filter = new Module_Catalogue_Filter_Save_Type_NoLife();
                $filter->session_zone  = $this->session_zone;
                $filter->save_price    = $this->save_price;
                $filter->make();
            break;
            case 5: // Кладовка
                $filter = new Module_Catalogue_Filter_Save_Type_Pantry();
                $filter->session_zone  = $this->session_zone;
                $filter->save_price    = $this->save_price;
                $filter->make();
            break;
            case 6: // Земельный
                $filter = new Module_Catalogue_Filter_Save_Type_Land();
                $filter->session_zone  = $this->session_zone;
                $filter->save_price    = $this->save_price;
                $filter->make();
            break;
            
        }
    }


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    