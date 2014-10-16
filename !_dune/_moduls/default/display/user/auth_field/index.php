<?php
// Модуль, отдающий поле аутентифокации если пользовательне опознан
// Либо поле информации о пользователе.
$view = Dune_Zend_View::getInstance();
Dune_Static_StylesList::add('user/auth');
//$view->view_folder = Dune_Variables::$pathToViewFolder;

if (Dune_Session::$auth)
{
   $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
    
   $view->name = $session->user_name;
   if ($session->user_status > 499)
   {
       $view->admin = Dune_Variables::$commandNameAdmin;
   }
   echo $view->render('bit:user:auth_have');
?>
<?php
}
else 
{
    $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);    
    $view->assign('login', $cooc['user_login']);
    echo $view->render('bit:user:auth_form_to_enter');
}
?>