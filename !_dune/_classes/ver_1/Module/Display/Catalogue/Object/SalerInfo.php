<?php

class Module_Display_Catalogue_Object_SalerInfo extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        

Dune_Static_StylesList::add('catalogue/info/user');

    $view = Dune_Zend_View::getInstance();
    $view->auth = Dune_Session::$auth;
    $view->user_status = Dune_Variables::$userStatus;
    $user_info = new Dune_Auth_Mysqli_UserActive($this->object->saler_id);
    //echo $user_info;
    $allow_array = $user_info->getUserArrayConfig(true);
    
    
    $this->setResult('seller', $user_info);
    
    $view->user_info = $user_info;
    
    $view->object = $this->object;
    
    $developer_gm = false;
    if (!$this->object->developer_gm and $this->object->developer) // Смотрим координаты офисов застройщиков. Сохраняе если есть.
    { // die();
    	$q = 'SELECT * FROM `unity_catalogue_object_developer_gm` WHERE `developer_id` = ?i';
    	$db = Dune_MysqliSystem::getInstance();
    	$developer_gm = $db->query($q, array($this->object->developer), Dune_MysqliSystem::RESULT_IASSOC);
    	if ($developer_gm and count($developer_gm) > 0)
    	{
    	    $str = serialize($developer_gm);
    	}
    	else 
    	{
    	   $developer_gm = false;
    	   $str = 'no';
    	}
    	$q = 'UPDATE `unity_catalogue_object_developer` SET `gm` = ? WHERE `id` = ?i';
    	$db->query($q, array($str, $this->object->developer), Dune_MysqliSystem::RESULT_AR);
    }
    else if ($this->object->developer and $this->object->developer_gm and strlen($this->object->developer_gm) > 4)
    {
        $developer_gm = @unserialize($this->object->developer_gm);
        if (!($developer_gm instanceof Dune_Mysqli_Iterator_ResultAssoc))
        {
            $developer_gm = false;
        }
    }
    
//    echo $this->object;
//    print_array($developer_gm);
//    die();
    
    
    $view->developer_gm = $developer_gm;
    $view->user_info_allow = new Dune_Array_Container($allow_array->info_access);
    
    if ($this->object->developer_name)
    {
        echo $view->render('bit/user/info/with_object_view_developer');
    }
    else 
        echo $view->render('bit/user/info/with_object_view_open');




/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    