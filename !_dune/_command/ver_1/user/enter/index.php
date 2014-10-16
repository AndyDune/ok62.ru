<?php
// Модуль, отдающий поле аутентифокации если пользовательне опознан
// Либо поле информации о пользователе.

$view = Dune_Zend_View::getInstance();
Dune_Static_StylesList::add('user/auth');
    $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);    

$folder = Dune_Data_Collector_UrlSingleton::getInstance();
$URL = Dune_Parsing_UrlSingleton::getInstance();
if (!strcmp($URL[3], 'exit'))
{
    $cooc->clear();
    $session = Dune_Session::getInstance();
    $session->destroy();
    $this->status = Dune_Include_Command::STATUS_EXIT;
    $this->results['goto'] = $folder->get();
    return;
}
else if (!strcmp($URL[3], 'exittotal'))
{
    $cooc->clear();    
    $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
    $user = new Dune_Auth_Mysqli_UserActive($session->user_id);
    $user->regenerateCode();
    $session->destroy();
    $this->status = Dune_Include_Command::STATUS_GOTO;
    $this->results['goto'] = '/';
    echo '/';
    return;
}
else if (Dune_Session::$auth)
{
   echo $view->render('page:user:auth_done');
   return;
}
$post = Dune_Filter_Post_Total::getInstance();
$post->trim();
if ($post->_do_ == 'enter' or !strcmp($URL[3], 'quickly'))
{
    //$object = new Dune_Include_Module('system:auth.enter'); // Старое
    $object = new System_Auth_Enter();
    $object->login = $post->login;
    $object->password = $post->password;
    $get = Dune_Filter_Get_Total::getInstance();
    
    if (!strcmp($URL[3], 'quickly'))
    {    
        $object->password = $get->password;
        $object->md5 = true;
        $object->login = $get->login;
    }
    else 
        $object->md5 = false;
    $object->attempt_interval = 3600; // Время на повторные попытки
    $object->attempt_count = 5; // Число попыток за интервал
    $object->make();
    if ($object->getResult('success'))
    {
        $module = new Module_User_MakeAfterEnter();
        $module->make();
        if ($module->getResult('goto'))
        {
            $this->status = Dune_Include_Command::STATUS_GOTO; // В будущем - отправить на страницу до входа на страницу входа
            $this->setResult('goto', $module->getResult('goto'));
            echo $module->getResult('goto');
        }
        else         
            $this->status = Dune_Include_Command::STATUS_EXIT; // В будущем - отправить на страницу до входа на страницу входа
    }
    else 
    {
        $this->status = Dune_Include_Command::STATUS_GOTO;
        $this->results['goto'] = $folder->get();
        echo $folder;
    }
    
    return;
}

    $view->assign('login', $cooc['user_login']);
    $view->assign('action', $folder->get());
    $view->assign('message', Dune_Static_Message::$text);
    echo $view->render('page:user:auth_form_to_enter');
    
    // Запрет отображения панели пользователя
    $this->results['no_user_panel'] = true;
