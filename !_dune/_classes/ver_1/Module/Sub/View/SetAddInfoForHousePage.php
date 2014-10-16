<?php

class Module_Sub_View_SetAddInfoForHousePage extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        

    $data = $this->data;
    $view = $this->view;

    if ($this->no_photo)
    {
        
    }
    if ($data['have_photo'])
    {
        $img = new Special_Vtor_Sub_Image_House($data['id']);
        $one = $img->getOneImage();
        $view->photo = $img->getOneImage($img->count() - 1);
        
    }
    else if ($data['complex_id'] and $data['complex_have_photo'])
    {
        $img = new Special_Vtor_Sub_Complex_Image_Photo($data['complex_id']);
        $one = $img->getOneImage();
        $view->photo = $img->getOneImage($img->count() - 1);
    }
    
    if ($data['have_situa'])
    {
        $img = new Special_Vtor_Sub_Image_Situa($data['id']);
        $one = $img->getOneImage();
        $view->situa = $img->getOneImage();
        
    }
    else if ($data['complex_id'] and $data['complex_have_situa'])
    {
        $img = new Special_Vtor_Sub_Complex_Image_Situa($data['complex_id']);
        $one = $img->getOneImage();
        $view->situa = $img->getOneImage($img->count() - 1);
    }

    if ($data['have_fasad'])
    {
        $img = new Special_Vtor_Sub_Image_Fasad($data['id']);
        $one = $img->getOneImage();
        $view->fasad = $img->getOneImage();
        
    }
    else if ($data['complex_id'] and $data['complex_have_fasad'])
    { 
        $img = new Special_Vtor_Sub_Complex_Image_Fasad($data['complex_id']);
        $one = $img->getOneImage();
        $view->fasad = $img->getOneImage($img->count() - 1);
    }



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    