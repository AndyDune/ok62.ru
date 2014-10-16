<?php
$URL = Dune_Parsing_UrlSingleton::getInstance();
try
{

    if (!Dune_Session::$auth) // ������������ �� ����� �������� ���������� � ���������
    {
        throw new Dune_Exception_Control('���������� ������������������', 1);
    }    
    $user = false;
    if ($URL[3] > 0) // ������� id ������������
    {
        $user = new Dune_Auth_Mysqli_UserActive($URL[3]);
    }
    $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
    if (!$user or !$user->getUserId())    
    {
        $user = new Dune_Auth_Mysqli_UserActive($session->user_id);
        if (!$user->getUserId())
        {
            throw new Dune_Exception_Control('������', 2);
        }
    }
    //echo $user;
    $view = Dune_Zend_View::getInstance();
    //$view->view_folder = Dune_Variables::$pathToViewFolder;
    
    $view->user = $user;
    Dune_Static_StylesList::add('user/info/base');
    $allow_array = $user->getUserArrayConfig(true);
    $view->user_info_allow = new Dune_Array_Container($allow_array->info_access);
    
    if ($session->user_id == $user->getUserId())
    {
        // ������� ���� ����������
        ////////////////////////////////////////////////////
        ///     ���� ���������� � ����������� ����������
            $list = new Special_Vtor_User_Object_Save($user->id);
            $list->setActivity(1);
            $view->objects_in_busket = $list->count();

            $list = new Special_Vtor_User_Object_List($user->id);
            $list->setActivity(1);
            $view->objects_in_sale = $list->count();
            
        ///
        ///////////////////////////////////////////////////
        echo $view->render('page/user/info/look_my');
    }
    else 
    {
        // ������� ��������� ����������
        echo $view->render('page/user/info/look_not_my');
    }

}
catch (Dune_Exception_Control $e)
{
    $view = Dune_Zend_View::getInstance();
    if ($e->getCode() == 1)
    {
        Dune_Static_StylesList::add('user/info/message');
        echo $view->render('page/user/info/can_not_look_info');
    }
    else if ($e->getCode() == 2)
    {
        Dune_Static_StylesList::add('user/info/message');
        echo $view->render('page/user/info/can_not_look_info_error');
    }   
}