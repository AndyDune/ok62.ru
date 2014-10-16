<?php



// Модуль, отдающий поле аутентифокации если пользовательне опознан
// Либо поле информации о пользователе.

if (Dune_Session::$auth)
{
   $view = Dune_Zend_View::getInstance();
   $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
    
   $talk = new Special_Vtor_PrivateTalk_One($session->user_id);
   $have_talk = $talk->isHaveNewMessage();
   $view->talk = $have_talk;
   $view->name = $session->user_name;
   if ($session->user_status > 999)
   {
       $view->admin = Dune_Variables::$commandNameAdmin;
   }
   if ($have_talk)
   {
       $list = new Special_Vtor_PrivateTalk_List();
       $view->list = $list->getListCumulateNoRead($session->user_id);
       Dune_Static_Header::charset();
      echo $view->render('bit/user/auth_have_ajax');
   }
   else '';
   $this->setStatus(Dune_Include_Command::STATUS_TEXT);
}
