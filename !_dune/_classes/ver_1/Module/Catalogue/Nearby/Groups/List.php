<?php

/**
 * Список наблюдаемых объектов.
 *
 */
class Module_Catalogue_Nearby_Groups_List extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        

        $list = new Special_Vtor_Nearby_List_Groups();
//        $list->setStatus(-1);
//        $list->setUserId($this->user_id);
        
        if ($this->order == 'count')
            $list->setOrder('count', 'DESC');
        
        $count = $list->getCount();
        $this->setResult('count', $count);
        
        $shift = $this->page * $this->per_page;
        
        if ($this->mode == 'all')
        {
            $files_array = Dune_AsArray_File_String::getInstance(Dune_Variables::$pathToArrayFiles);
            
            $time_catalogue_change = (int)$files_array['time_catalogue_change'];
            //$time_catalogue_change = 2000000; //Добавить динамичекую дату
            
            $list->setOrder('order');
            $result_list = $list->getList($shift, $this->per_page);
            $view = Dune_Zend_View::getInstance();
            foreach ($result_list as $key => $value)
            {
                $array_run[$key] = $value;
                if ($time_catalogue_change > $value['time_update_unix'])
                {
                    $array_run[$key]['count'] = $list->updateCountField($value['id'], Special_Vtor_Settings::$arrayEdinstvoSalers);
                }   
                $photo = new Special_Vtor_Nearby_PhotoGroup($value['id']);
                if (count($photo))
                {
                    $t = $photo->getOneImage();
                    $array_run[$key]['photo_preview'] = $t->getPreviewFileUrl(100);
                    $array_run[$key]['photo'] = $t->getSourseFileUrl();
                }
            }
            $result_list = $array_run;
            $this->setResult('list', $result_list);
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
    
    