<?php

class Module_Display_SubDomain_MainPage extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
$vars = Dune_Variables::getInstance();

$this->setResult('objects_search', '');
$this->setResult('objects_list_elected', '');

$go = true;
if ($vars->subdomainFocusUserId)
{
    $file = $_SERVER['DOCUMENT_ROOT'] . '/data/subdomain/' . $vars->subDomain . '/mainpage.php';
    if (is_file($file))
    {
        $go = false;
        include($file);
    }
}
if ($go)
{    
    
    $session_zone = 'filter';
    $text = Dune_Zend_Cache::loadIfAllow('filter_on_main');
    if (!$text)
    {
        $display = new Module_Display_Catalogue_Filter_OnMain();
        $display->objects_count = $objects_count = 0;//$display_main_info->getResult('count');
        $display->session_zone = $session_zone;
        $display->make();
        $text = $display->getOutput();
        Dune_Zend_Cache::saveIfAllow($text, 'filter_on_main', array(Special_Vtor_Settings::CACHE_TAG_CATALOGUE));
    }
    echo $text;
    
    Dune_Static_StylesList::add('main/objects_list_elected');
    $display = new Module_Display_Catalogue_Object_List_OnMain();
    $display->objects_count = $objects_count = 0;//$display_main_info->getResult('count');
    $display->session_zone = $session_zone;
    $display->make();
    $this->setResult('objects_list_elected', $display->getOutput());
    
}    



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    