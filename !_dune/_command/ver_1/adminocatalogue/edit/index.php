<?php
// Команда публичных форм для отсылки сообщений

try {
    
    $max_count = 5;
    
    $URL = Dune_Parsing_UrlSingleton::getInstance();
    
    $id = (int)$URL->getCommand(3);

    
    $crumbs = $this->crumbs;
    $crumbs->addCrumb('Редактирование', '/');
    $this->setResult('crumbs', $crumbs);
    
    $table = 'unity_organization_text';

    $post = Dune_Filter_Post_Total::getInstance();    
    $one = new Dune_Mysqli_Table($table);
    
    if ($id)
    {
        $one->useId($id);
        $data = $one->getData(true);
        $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
        if (!$data or ($data['user_id'] != $session->user_id and $session->user_status < 1000))
        {
            throw new Dune_Exception_Control_Goto('/ocatalogue/edit/');
        }
        
        if (!strcmp($post->_do_,  'save_info'))
        {
            if (Dune_Variables::$userStatus < 500)
                $post->htmlSpecialChars();
                
            $data = $post->get();
            
            $str = new Dune_String_Transform($data['name']);
            $str->setQuoteRussian();
            $data['name'] = $str->getResult();
            
            $str = new Dune_String_Transform($data['annotation']);
            $str->setQuoteRussian();
            $data['annotation'] = $str->getResult();

            $str = new Dune_String_Transform($data['description']);
            $str->setQuoteRussian();
            $data['description'] = $str->getResult();

            
//            $data['time_insert'] = date('Y-m-d H:i:s');
            $data['time_insert'] = time();
//            die();
            
            $str = new Dune_String_Transform($data['adress']);
            $str->setQuoteRussian();
            $data['adress'] = $str->getResult();

            $str = new Dune_String_Transform($data['diskont']);
            $str->setQuoteRussian();
            $data['diskont'] = $str->getResult();

            $str = new Dune_String_Transform($data['site']);
            $str->setQuoteRussian();
            $data['site'] = $str->getResult();
            
            $str = null;
            
            $one->loadData($data);
            if ($post->section)
            {
                $corr = new Special_Vtor_Organization_Sections_Corr($id);
                $corr->clearCorr();
                $corr->setCorrOne($post->section);
                
            }
            $one->save();
            
            
    // Список детишек
    $section_children_o = new Special_Vtor_Organization_Children_List();
    $section_children_o->refreshCountText();
    $section_children_o->refreshCountChildren();
            
            throw new Dune_Exception_Control_Goto('');
            
        }
        
        if (!strcmp($post->_do_,  'save_logo'))
        {
            $module = new Module_File_Picture_Save_PostList();
            $module->folder = $_SERVER['DOCUMENT_ROOT'] . '/ddata/ocatalogue/logo';
            $module->name = 'file';
            $module->name_result = $id;
            $module->size = 250;
            $module->max_files_count = 1;
            $module->make();
            $name_file_ex = $module->getResult('file_result');
            $one->pic = $name_file_ex;
            $one->save();
            throw new Dune_Exception_Control_Goto('');
        }        
        
        
    }
    else 
    {
        if (!strcmp($post->_do_,  'save_info'))
        {
            if (Dune_Variables::$userStatus < 500)
            {
                $text_list_o = new Special_Vtor_Organization_List();
                $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
            
                $text_list_o->setUser($session->user_id);
                $count = $text_list_o->getCout();    

                if ($count > $count_max)
                {
                    $session->openZone('ocatalogue');
                    $session->message = 'overcount';
                    throw new Dune_Exception_Control_Goto('/adminocatalogue/');
                    
                }
                $post->htmlSpecialChars();
            }
            $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
            $one->loadData($post);
            $one->user_id = $session->user_id;
            $one->name_code = $session->user_id;
            $id = $one->add();
            
            if ($post->section)
            {
                $corr = new Special_Vtor_Organization_Sections_Corr($id);
                $corr->clearCorr();
                $corr->setCorrOne($post->section);
            }
            
            
            $one->name_code = $id;
            $one->useId($id);
            $one->save();
            $URL->cutCommands(2);
            $URL->setCommand($id, 3);
            
    // Список детишек
    $section_children_o = new Special_Vtor_Organization_Children_List();
    $section_children_o->refreshCountText();
    $section_children_o->refreshCountChildren();
            
            
            throw new Dune_Exception_Control_Goto($URL->getCommandString());
            
        }
        
        
        $data = new Dune_Array_Container(array());
    }
    

    $view = Dune_Zend_View::getInstance();
    
    $module = new Module_OCatalogue_SectionTree();
    $module->make();
    $sections_array = $module->getResult('array');
    $view->sections_array = $sections_array;
    unset($sections_array);
    
    if ($id)
    {
        $corr = new Special_Vtor_Organization_Sections_Corr($id);
        $arr = $corr->getOneFirst();
        if ($arr)
            $view->section_current = $arr['id'];
    }
    $view->sections_select = $view->render('bit/organization/form/section_select');
    
    Dune_Variables::addTitle('Редактирование - ');
    
    $view->data = $data;
    $view->url = $URL->getCommandString();
    if ($id)
        $text = $view->render('bit/organization/one/info_edit');
    else 
        $text = $view->render('bit/organization/one/info_new');
    
    echo $text;
}
catch (Dune_Exception_Control_Goto $e)
{
    if ($e->getCode())
    {
        Dune_Static_Message::setCode($e->getCode());
    }
    if ($e->getMessage())
    {
        $this->setStatus(Dune_Include_Command::STATUS_GOTO);
        $this->setResult('goto', $e->getMessage());
    }
    else 
    {
        $this->setStatus(Dune_Include_Command::STATUS_EXIT);
    }
}
catch (Dune_Exception_Control_NoAccess $e)
{
    if ($e->getCode())
    {
        Dune_Static_Message::setCode($e->getCode());
    }
    if ($e->getMessage())
    {
        Dune_Static_StylesList::add('user/info/message');
        $view = Dune_Zend_View::getInstance();
        echo $view->render($e->getMessage());
    }
    else 
    {
        $this->setResult('goto', '/');
        $this->setStatus(Dune_Include_Command::STATUS_EXIT);
    }
}    