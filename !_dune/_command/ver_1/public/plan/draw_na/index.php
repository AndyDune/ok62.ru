<?php
ini_set('always_populate_raw_post_data', 'On');

try {
//phpinfo(); die();
    
    


    $URL = Dune_Parsing_UrlSingleton::getInstance();
    
    
    if ($URL->getCommandPart(4) == 'do')
    {
        switch ($URL->getCommandPart(4, 2))
        {
                
            case 'loadxml':
                echo '<planning></planning>';
                throw new Dune_Exception_Control_Text();
            
            case 'savexml': 
                echo '<message>ok</message>';
                throw new Dune_Exception_Control_Text();

            case 'savepng':
                echo '<message>ok</message>';
                throw new Dune_Exception_Control_Text();
                return;
            break;
        }
        
        throw new Dune_Exception_Control('Сделали');
    }




    $view  = Dune_Zend_View::getInstance();
    
    
//    $view->session_id = $session->getId();
    
    
    $view->text = $view->render('bit/draw_plan/flash_na');
    
    echo $view->render('bit/general/container_padding_for_auth');    
    
    Dune_Variables::addTitle($view->getResult('title'));

}
catch (Dune_Exception_Control_Text $e)
{
    $this->setStatus(Dune_Include_Command::STATUS_TEXT);
}    