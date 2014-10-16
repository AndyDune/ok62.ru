<?php
    $status = Dune_Include_Command::STATUS_TEXT;
    $URL = Dune_Parsing_UrlSingleton::getInstance();

    $id = (int)$URL[4];
    
    
try {
    

    /////   Для теста
/*    $file = Dune_AsArray_File_String::getInstance(Dune_Variables::$pathToArrayFiles);
    Dune_BeforePageOut::registerObject($file);
    $file['gm_img'] = 'запросили';
*/    
    
    
    if (!$id)
        throw new Dune_Exception_Control();
    
        
    $object = new Special_Vtor_Object_Data($id);
    if (!$object->check())
    {
        throw new Dune_Exception_Control();
    }
    
    $pics = new Special_Vtor_Catalogue_Info_Plan($id, $object->time_insert);
    //echo $pics->count();
    if ($pics->count())    
    {
        $prew = $pics->getOneImage();
        $img = $prew->getPreviewFileUrl(100);
        $file['gm_img'] = 'план';
    }
    else 
    {
        $pics = new Special_Vtor_Catalogue_Info_Image($id, $object->time_insert);
        if ($pics->count())
        {
            $prew = $pics->getOneImage();
            $img = $prew->getPreviewFileUrl(100);
        }
        else 
            throw new Dune_Exception_Control();
    }
    
}
catch (Dune_Exception_Control $e)
{
    $img = Dune_Variables::$pathToViewFolder . '/img/house-100.png';
}

    $this->setStatus($status);
    
    $img_o = new Dune_Image_Info($_SERVER['DOCUMENT_ROOT'] . $img);
    header("Content-type: " . $img_o->getMimeType());
    echo file_get_contents($_SERVER['DOCUMENT_ROOT'] . $img);    