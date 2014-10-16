<?php

class Module_Catalogue_Object_PublicTalk_PrepareMessage extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);
    $post = Dune_Filter_Post_Total::getInstance();
    $post->trim();
    $post->setLength(Special_Vtor_Settings::$maxLengthMessagePublic);
    $post->htmlSpecialChars();

    $cooc['mail']  = $post->mail;
    $cooc['login'] = $post->login;
    $cooc['text']  = $post->text;
        
        
    $this->results['success'] = false;
        
    if (
        ($post->getDigit('object_id') < 1)
       )
    {
        $cooc['message'] = array(
                                 'code'    => 1,
                                 'section' => 'error.form'
                                 );
       return;
    }
        
    if (
        (strlen($post->text) < 5)
       )
    {
        $cooc['message'] = array(
                                 'code'    => 1,
                                 'section' => 'message'
                                 );
       return;
    }
        
    $object = new Special_Vtor_Object_Data($post->getDigit('object_id'));
    if (!$object->check())
    {
        $cooc['message'] = array(
                                 'code'    => 1,
                                 'section' => 'error.form'
                                 );
        return;
    }
        
/*    $auth = new Module_System_RegistrationAndMail();
    $auth->make();

    if ($auth->getResult('success'))
    {
        unset($cooc['mail']);
        unset($cooc['login']);
        $cooc['message'] = array(
                                 'code'    => 2,
                                 'section' => 'message'
                                 );
        $this->results['success'] = true;
    }
    else 
    {
        return;
    }
*/    
    $this->results['success'] = true;
    
    $session = Dune_Session::getInstance();
    
    
    $cooc['object_id'] = $post->getDigit('object_id');
    $cooc['have_pablic_message'] = 1;
    $cooc['url'] = Dune_Parameters::$pageInternalReferer;
    
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    