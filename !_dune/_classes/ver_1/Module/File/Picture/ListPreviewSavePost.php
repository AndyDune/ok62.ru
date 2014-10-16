<?php

class Module_File_Picture_ListPreviewSavePost extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        

	   $this->size = 900;
	   $this->resize_mode = 'both';
	   $this->proportion_x = Special_Vtor_Settings::$pictureProportionX;
	   $this->proportion_y = Special_Vtor_Settings::$pictureProportionY;
	   $this->proportion_mode = Special_Vtor_Settings::$pictureProportionMode;
	   $this->proportion_color = Special_Vtor_Settings::$pictureProportionBGColor;
	   $this->max_files_count = 10;

    $this->results['done'] = false;
	$this->results['pic_count'] = 0;
				
if ($this->local_folder)
	$this->path_main = $this->path_main . '/' . $this->local_folder;
else 
    $this->path_main = $this->path_main . '/img';

$mdir = new Dune_Directory_Make($this->path_main);
if (!$mdir->make(3))
    return;
$this->path_main = $_SERVER['DOCUMENT_ROOT'] . '/' . $this->path_main;
echo $this->path_preview = $_SERVER['DOCUMENT_ROOT'] . '/' . $this->path_preview;


//$files = new Dune_Array_Container($_FILES);
//echo $files;

	$gallery_small_list = new Dune_Directory_Delete($this->path_preview);
	$gallery_small_list->deleteFiles();


$oo = new Dune_Upload_FileMulti('pic');
//$files = new Dune_Array_Container($oo->getList());

$files = $oo->getList();
$good = false;
if (count($files))
{
	foreach ($files as $key => $value)
	{
	    if ($key > $this->max_files_count)  // Блокирует большее чем разрешено число файлов.
	       break;
		$good = false;
//	    $o_file = new Dune_Upload_File($this->name_form);
	    if (!$value['error'])
	    {
	    	$o_file_info = new Dune_Image_Info($value['tmp_name']);
	        if ($o_file_info->isCorrect())
	        {
	            $good = true;
	        }
	    }
	    
	        
	    if ($good)
	    {
	    	$tumb = new Dune_Image_Transform($o_file_info);
	        $tumb->setPathToResultImage($this->path_main);
	        $tumb->setModeThumb($this->resize_mode);
	        $tumb->setProportions($this->proportion_x, $this->proportion_y);
	        $tumb->setModeProportion('add');
	        $tumb->setBackgroundColor($this->proportion_color);
	        if ($tumb->changeProportion())
	        	$good = $tumb->createThumb($this->size);
	        else 
	        	$good = false;
	        	echo 'Имя: ' ,$key;
			if ($tumb->save($key))
			{
	    			$good = true;     
			}
	    }
	}
}



	$good = false;
    $o_file = new Dune_Upload_File('new');
    if ($o_file->uploaded())
    {
        $o_file_info = new Dune_Image_Info($o_file['tmp_name']);
        if ($o_file_info->isCorrect())
        {
            $good = true;
        }
    }
    
   	$gallery_list = new Dune_Directory_List($this->path_main);
   	if ($gallery_list->getCountFiles() >= $this->max_files_count)    
   	    $good = false;
   	$new_one = 0;
    if ($good)
    {
    	$file_name = $gallery_list->getCountFiles() + 1;
        $tumb = new Dune_Image_Transform($o_file_info);
        $tumb->setPathToResultImage($this->path_main);
        $tumb->setModeThumb($this->resize_mode);
        $tumb->setProportions($this->proportion_x, $this->proportion_y);
        $tumb->setModeProportion('add');
        $tumb->setBackgroundColor($this->proportion_color);
        if ($tumb->changeProportion())
        	$good = $tumb->createThumb($this->size);
        else 
        	$good = false;
		if ($tumb->save($file_name))
		{
    		$good = true;        	
    		$new_one = 1;
		}
        
    }

    $this->results['done'] = $good;
        
	$this->results['pic_count'] = $gallery_list->getCountFiles() + $new_one;
    





/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    