<?php

$destin_add = '';
$destin = '';

$URL = Dune_Parsing_UrlSingleton::getInstance();
switch (true)
{
    
///////////////////////////////////////////////////////////////    
// Сохраняем сообщение из базара по объекту.    
    case ($URL[3] == 'save-message-to-publictalk-na'):
        $module = new Module_Catalogue_Object_PublicTalk_PrepareMessage();
        $module->make();
        $post = Dune_Filter_Post_Total::getInstance();
        if ($module->getResult('success'))
        {
            $destin = '/user/regorenter/';            
        }
        else 
        {
            $destin_add = $post->back_anchor;
        }
    break;
// Сохраняем сообщение из базара по объекту.    
    case ($URL[3] == 'save-message-to-privatetalk-na'):
        $module = new Module_Catalogue_Object_PrivateTalk_PrepareMessage();
        $module->make();
        $post = Dune_Filter_Post_Total::getInstance();
        if ($module->getResult('success'))
        {
            $destin = '/user/regorenter/';            
        }
        else 
        {
            $destin_add = $post->back_anchor;
        }
    break;
    
    
    
    case (!Dune_Session::$auth):
    break;
    case ($URL[3] == 'savetobasket'):
        if ($URL[4])
        {
            $basket = new Special_Vtor_Object_User_Save($URL[4]);
            $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
            $basket->save($session->user_id);
        }
    break;
    case ($URL[3] == 'savefrombasket'):
        if ($URL[4])
        {
            $basket = new Special_Vtor_Object_User_Save($URL[4]);
            $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
            $basket->saveNo($session->user_id);
        }
    break;
///////////////////////////////////////////////////////////////    
// Сохраняем сообщение из базара по объекту.    
    case ($URL[3] == 'save-message-to-publictalk'):
        
        $module = new Module_Catalogue_Object_PublicTalk_SaveMessage();
        $module->make();
    break;
    
///////////////////////////////////////////////////////////////    
// Сохраняем сообщение из базара по объекту.    
    case ($URL[3] == 'save-message-to-privatetalk'):
        $module = new Module_Catalogue_Object_PrivateTalk_SaveMessage();
        $module->make();
    break;
    case ($URL[3] == 'save-message-to-privatetalksaler'):
        $module = new Module_Catalogue_Object_PrivateTalk_SaveMessageSaler();
        $module->make();
    break;
    
    case ($URL[3] == 'deletefromquery'):
        
        $module = new Module_Catalogue_Object_Edit_DeleteFromQuery();
        $module->id = $URL[4];
        $module->make();
    break;
    
}
if ($destin)
{
    $this->status = Dune_Include_Command::STATUS_GOTO;
    $this->results['goto'] = $destin;
}
else if ($destin_add)
{
    $this->status = Dune_Include_Command::STATUS_GOTO;
    $this->results['goto'] = Dune_Parameters::$pageInternalReferer . $destin_add;
}
else 
    $this->status = Dune_Include_Command::STATUS_EXIT;