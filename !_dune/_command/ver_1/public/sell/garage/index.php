<?php
Dune_Static_Header::noCache();
$URL = Dune_Parsing_UrlSingleton::getInstance();
$object_type = 3;
$object_type_code = 'garage';
try
{
    $get = Dune_Filter_Get_Total::getInstance();
    $session = Dune_Session::getInstance('control');
    if (isset($get['edit']))
    {
        $current_object = Special_Vtor_Object_Query_DataSingleton::getInstance($get->getDigit('edit'));
        if (!$current_object->isFromBd())
        {
            throw new Dune_Exception_Control_Goto('Объект уделен из очереди на редактирования.', 51);
        }
        if ($current_object->getStatus() > 1)
        {
            throw new Dune_Exception_Control_Goto('Редактировать нельзя.', 52);
        }
        if ($current_object->getUserId() != Special_Vtor_User_Auth::$id)
        {
            throw new Dune_Exception_Control_Goto('Редактировать чужое нельзя.', 53);
        }
// Не обозначается как редактируемое
//        $current_object->setStatus(0);
//        $current_object->save();
        $session->edit = $current_object->getId();
    }
    else 
    {

        $session = Dune_Session::getInstance('control');
        if (!isset($session->edit))
        {
            throw new Dune_Exception_Control_Goto('Пришли откуда не надо. Отправляем куда надо', 55);
        }
        $current_object = Special_Vtor_Object_Query_DataSingleton::getInstance();
        if ($session->edit > 0)
        {
            $current_object->useIdGetDataFromDb($session->edit);

            if (!$current_object->isFromBd())
            {
                throw new Dune_Exception_Control_Goto('Объект уделен из очереди на редактирования.', 51);
            }
            if ($current_object->getStatus() > 1)
            {
                throw new Dune_Exception_Control_Goto('Редактировать нельзя.', 52);
            }
            if ($current_object->getUserId() != Special_Vtor_User_Auth::$id)
            {
                throw new Dune_Exception_Control_Goto('Редактировать чужое нельзя.', 53);
            }
        }
        else 
        {
            throw new Dune_Exception_Control_Goto('/public/sell/');
            
/*            $current_object->setUserId(Special_Vtor_User_Auth::$id); 
            $time = $current_object->getLastObjectInsertTime();
            if (
                $time !== false
                 and
                 time() - $time < Special_Vtor_Settings::$timeIntervalObjectToAdd
               )
                throw new Dune_Exception_Control('Часто создается объект на редактирование.', 54);

            if ($current_object->getCountObjectsInsertInQuery() >= Special_Vtor_Settings::$maxObjectsInQueryToAdd)
                throw new Dune_Exception_Control('Слишком много.', 4);
                
                
            $current_object->setTypeId($object_type);
            $current_object->setUserId(Special_Vtor_User_Auth::$id);
            $session->edit = $current_object->add();
*/
        }
    }
    
//    $session = Dune_Session::getInstance('control');
    
    // Выбираем номер шага из урла в4-ой команде, формае <слово>_<номер>
    $session->step = $URL->getCommandPart(4, 2, $session->getInt('step', 1));
    
//    if (!$current_object) // Если нет обрабатываемого объекта переход всегда к 1-му шагу
//        $session->step = 1;
        
    $view    = Dune_Zend_View::getInstance();
    $view->step        = $session->step;

    $view->object_type_code = $object_type_code;
    $view->steps_panel = $view->render('bit/sell/garage/auth/steps_panel');
    
    $text = '';
    $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);
    $array['type_code'] = $object_type_code;
    $array['id'] = $session->edit;
    $cooc['temp'] = $array;
    
    switch (true)
    {
        case (!$session->step or $session->step == 1):
            include(dirname(__FILE__) . '/step_1/index.php');
        break;
        case ($session->step == 2):
            include(dirname(__FILE__) . '/step_2/index.php');
        break;
        case ($session->step == 3):
            include(dirname(__FILE__) . '/step_3/index.php');
        break;
        case ($session->step == 9):
            include(dirname(__FILE__) . '/step_9/index.php');
        break;
        
        case ($session->step == 4): // GM
            include(dirname(__FILE__) . '/step_4/index.php');
        break;
        
        case ($session->step == 10):
            include(dirname(__FILE__) . '/step_10/index.php');
        break;
        
        default:
            include(dirname(__FILE__) . '/step_1/index.php');
    }
    
        
    Dune_Variables::$pageTitle = 'Продажа гаража. ' .  Dune_Variables::$pageTitle;
    Dune_Variables::$pageDescription = 'Отправка заявки на продажу гаража.';
    
    //$URL[4] = 'step';
    
    $view->text = $text;
    
    echo $view->render('bit/general/container_padding_for_auth');

}

catch (Dune_Exception_Control_Goto $e)
{
    if ($e->getCode() > 50)
    {
        $session = Dune_Session::getInstance('control');
        unset($session->edit);
        $this->setResult('goto', '/public/sell/');
        
        Dune_Static_Message::setCode($e->getCode());
    }
    else 
    {
        $this->setResult('goto', $e->getMessage());
    }
    $this->setStatus(Dune_Include_Command::STATUS_GOTO);
}
catch (Dune_Exception_Control $e)
{
    if ($e->getCode())
    {
        Dune_Static_Message::setCode($e->getCode());
        $this->setStatus(Dune_Include_Command::STATUS_EXIT);
    }
    else 
        $this->setStatus(Dune_Include_Command::STATUS_EXIT);
}