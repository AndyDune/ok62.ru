<?php

class Module_Log_SaveObject extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        

        $get = Dune_Filter_Get_Total::getInstance();
        
            if (!Special_Vtor_Settings::$log)    
                return;

           $session = Dune_Session::getInstance();
           $old_z = $session->getZoneName();
//           $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
           $session->openZone(Dune_Session::ZONE_AUTH);

//        if ($session->user_id == 1)
        if (false)
        {
           echo '<h1>Системный массив</h1><pre>';
           print_r($_SERVER);
           echo '</pre>';
           die();
        }
           
           
           $user_id = (int)$session->user_id;
/*           if ($session->user_id)
            $user_id = $session->user_id;
           else
            $user_id = 0;
*/            
           
           $session = Dune_Session::getInstance($old_z);
            
           $object_id = $this->id;
           
//           $was = $this->data_was;
           
           ob_start();
           echo '<h1>Сохранение объекта с данными</h1><pre>';
           print_r($this->data);
           echo '</pre>';
           $text = ob_get_clean();

           ob_start();
           echo '<h1>Былое</h1><pre>';
           print_r($this->data_was);
           echo '</pre>';
           $was = ob_get_clean();
           
           
           $q = 'INSERT INTO `unity_catalogue_log`
                 SET 
                  `object` = ?i,
                  `user` = ?i,
                  `text` = ?,
                  `desc` = ?,
                  `ip` = ?,
                  `referer` = ?,
                  `user_agent` = ?,
                  `request_url` = ?,
                  `was` = ?
                 ';
$ip = (isset($_SERVER["REMOTE_ADDR"]))?$_SERVER["REMOTE_ADDR"]:'';
$referer = (isset($_SERVER["HTTP_REFERER"]))?$_SERVER["HTTP_REFERER"]:'';
$user_agent = (isset($_SERVER["HTTP_USER_AGENT"]))?$_SERVER["HTTP_USER_AGENT"]:'';
$REQUEST_URI = (isset($_SERVER["REQUEST_URI"]))?$_SERVER["REQUEST_URI"]:'';
$desc = '';

           $db = Dune_MysqliSystem::getInstance();
           $db->query($q, array(
                                $object_id,
                                $user_id,
                                $text,
                                $desc,
                                substr($ip,0, 50),
                                substr($referer,0, 254),
                                substr($user_agent,0, 254),
                                substr($REQUEST_URI,0, 254),
                                $was
                                ));
           
/*         $session->user_code     = $cooc['user_code'];
           $session->user_mail     = $cooc['user_mail'];
           $session->user_login    = $cooc['user_login'];
           $session->user_name     = $cooc['user_name'];
           $session->user_status   = $cooc['user_status'];
           $session->user_array    = $cooc['user_array'];
           $session->user_id       = $cooc['user_id'];
*/    



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    