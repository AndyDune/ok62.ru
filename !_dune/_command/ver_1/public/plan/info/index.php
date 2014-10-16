<?php
ini_set('always_populate_raw_post_data', 'On');

try {
//phpinfo(); die();
    $post = Dune_Filter_Post_Total::getInstance();
    $get = Dune_Filter_Get_Total::getInstance();
    
    $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
    if ($session->user_id)
        $user_id = $session->user_id;
    else 
        $user_id = 0;
    
    $draw = new Special_Vtor_DrawPlan();
    
    
    $URL = Dune_Parsing_UrlSingleton::getInstance();
    $id = (int)$URL[4];
    
    if ($id < 1)
    {
        throw new Dune_Exception_Control_Text('Нет картинки', 1);
    }
    $draw = new Special_Vtor_DrawPlan();
    $data = $draw->getOneWithUser($id);
    if (!$data or strlen($data['file']) < 50)
    {
        throw new Dune_Exception_Control_Text('Нет картинки', 1);
    }
    
    
    if (($user_id > 0) and ($user_id == $data['user_id']))
    {
        $my_draw = true;
    }
    else 
        $my_draw = false;
    
        
    if (
        (!($my_draw))
        and
        ($data['public'] != 1)
        and false
        )
    {
        throw new Dune_Exception_Control_Text('Нет доступа', 2);
    }
    $list = $data;
    if ($URL[5])
    {
/*        $files_array = Dune_AsArray_File_String::getInstance(Dune_Variables::$pathToArrayFiles);
        $files_array['1'] = 'Загрузили xml ' . time();
        Dune_BeforePageOut::registerObject($files_array);
*/
        switch ($URL[5])
        {
                
            case 'topublic': 
                    if ($my_draw)
                    {
                        $draw->setDrawId($data['id'])->savePublic(1);
                    }
                    
                throw new Dune_Exception_Control_Goto();
            break;                
            case 'frompublic':
                    if ($my_draw)
                    {
                        $draw->setDrawId($data['id'])->savePublic(0);
                    }
                    
                throw new Dune_Exception_Control_Goto();
            break;                
            
            
            case 'pic':            
                header("Content-type: image/png");
                Dune_Static_Header::noCache();
                echo $list['file'];
            throw new Dune_Exception_Control_Text();
        }
        
    }
    
    
    $view  = Dune_Zend_View::getInstance();
    
    $view->my_draw = $my_draw; 
    $view->data = $data;
    
    $list = $data;
    if ($list and strlen($list['file']) > 50)
    {
        $view->look = $list['id'];
    }
    
    
    $view->text = $view->render('bit/draw_plan/info');
    
    echo $view->render('bit/general/container_padding_for_auth');    
    
    Dune_Variables::addTitle($view->getResult('title'));
    
}
catch (Dune_Exception_Control_Text $e)
{
    switch ($e->getCode())
    {
        case 1:
            $view  = Dune_Zend_View::getInstance();
            $view->data = $data;
            $view->user_id = $user_id;
            $view->my_draw = $my_draw;
            $view->text = $view->render('bit/draw_plan/info_no_pic');
                echo $view->render('bit/general/container_padding_for_auth');    
        break;            
        case 2:
            $view  = Dune_Zend_View::getInstance();
            $view->data = $data;
            $view->user_id = $user_id;
            $view->my_draw = $my_draw;
            $view->text = $view->render('bit/draw_plan/info_no_access');
                echo $view->render('bit/general/container_padding_for_auth');    
        break;
        default:
            $this->setStatus(Dune_Include_Command::STATUS_TEXT);
    }
    
}