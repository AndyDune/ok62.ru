<?php

class Module_User_List_Contact extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
        $list = new Special_Vtor_User_Contact_List();
        $list->setStatus(-1);
        $list->setUserId($this->user_id);
        
        if ($this->order == 'time')
            $list->setOrder('last_visit', 'DESC', 'time');
        else 
            $list->setOrder('name');
        
        $count = $list->getCount();
        $this->setResult('count', $count);
        
        $shift = $this->page * $this->per_page;
        
        if ($this->mode == 'all')
        {
            $result_list = $list->getListWithTime($shift, $this->per_page);
            $view = Dune_Zend_View::getInstance();
            foreach ($result_list as $key => $value)
            {
                $array_run[$key] = $value;
                $timeInterval = new Dune_Time_IntervalParse($value['last_visit'], time());
                $photo = new Special_Vtor_User_Image_Photo($value['id'], $value['time']);
                if (count($photo))
                {
                    $t = $photo->getOneImage();
                    $array_run[$key]['photo_preview'] = $t->getPreviewFileUrl(50);
                }

                
                $view->time_inteval = $timeInterval->getResultArray();
                $array_run[$key]['time_last_visit'] = $view->render('bit/elements/time_last_visit');     // !!!!!!!!  - возможна смена на обработку без шаблона
            }
            $result_list = $array_run;
            $this->setResult('list_contact', $result_list);
        }
        else 
        {
            $result_list = $list->getListContactHave();
            $array_exept = array();
            foreach ($result_list as $value)
            {
                $array_exept[] = $value['id'];
                $result_list_t[] = $value;
            }
            
            $this->setResult('list_contact', $result_list_t);
            
            
            $result_list = $list->getListContactBegin(0, 1000, $array_exept);
            $this->setResult('list_contact_begin', $result_list);
        }        
        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    