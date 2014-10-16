<?php

class Module_User_MakeAfterCheckMail extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    $this->results['goto'] = '';
    $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);
    
    switch (true)
    {
        case $cooc['have_pablic_message'] :

            if ($cooc['text'] and $cooc['object_id'])
            {
                $object_id = (int)$cooc['object_id'];
                $text = htmlspecialchars(substr($cooc['text'], 0, Special_Vtor_Settings::$maxLengthMessagePublic));
                    
                $object = new Special_Vtor_Object_Data($object_id);
                if ($object->check())
                {
                    $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
                    $pTalk = new Special_Vtor_Object_PublicTalkOne();
                    $pTalk->setText($text);
                    $pTalk->setUserId($session->user_id);
                    $pTalk->setObjectId($object_id);
                    $new_id = $pTalk->add();
                    if ($new_id and $cooc['url'])
                    {
                        if ($pos = strpos($cooc['url'], '#'))
                        {
                            $cooc['url'] = substr($cooc['url'], 0, $pos);
                        }
                        $this->results['goto'] = $cooc['url'] . '#mes_' . $new_id;
                    }
                }
            }
            unset($cooc['url']);
            unset($cooc['text']);
            unset($cooc['have_pablic_message']);
            unset($cooc['object_id']);
        break;
        case $cooc['have_object_to_sale'] :
            
        break;
        
    }


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    