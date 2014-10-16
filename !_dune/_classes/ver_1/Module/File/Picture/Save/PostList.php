<?php

class Module_File_Picture_Save_PostList extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
        if (!$this->name or !$this->folder)
            throw new Dune_Exception_Base('Отсутствует обязательный параметр.');
            
        $name_file_ex = '';
            
        $this->setResult('file_result', $name_file_ex);        
    
        if (!$this->size)
            $this->size = 900;
            
        if (!$this->resize_mode)
            $this->resize_mode = 'both';
            
        if (!$this->max_files_count)
            $this->max_files_count = 10;

        if (!$this->proportion_x)
            $this->proportion_x = 10;
        if (!$this->proportion_y)
            $this->proportion_y = 10;
                    
        if (!$this->proportion_mode)
            $this->proportion_mode = 'add';
        if (!$this->proportion_color)
            $this->proportion_color = 0xffffff;

				


//$files = new Dune_Array_Container($_FILES);
//echo $files;

if (!is_dir($this->folder))
{
    $this->setResult('success', false);
    $this->setResult('error_code', 1);
    $this->setResult('error_text', 'Нет папки для сохранения: ' . $this->folder);
    return;    
}    

$oo = new Dune_Upload_FileMulti($this->name);
$files = new Dune_Array_Container($_FILES);
echo $files;

if ($this->name_result)
{
    $count_files_to_load = 1;
}
else 
{
    $folder_content = new Dune_Directory_List($this->folder);
    $count_files_to_load = $this->max_files_count - $folder_content->getCountFiles();
}

$files = $oo->getList();
$good = false;
if ($count_files_to_load < 0)
{
    $this->setResult('success', false);
    $this->setResult('error_code', 2);
    $this->setResult('error_text', 'Превышено масксимальное колличество загруженных файлов.');
    return;    
    
}

if (count($files))
{ 
    $current = 1;
	foreach ($files as $key => $value)
	{
	    if ($current > $count_files_to_load)  // Блокирует большее чем разрешено число файлов.
	       break;
		$good = false;
	    if (!$value['error'])
	    {
	    	$o_file_info = new Dune_Image_Info($value['tmp_name']);
	        if ($o_file_info->isCorrect())
	        {
	            $good = true;
	            $current++;
	        }
	    }
	    
	    if ($o_file_info->getFileSize() > 1015491)
	    {
	        return;
	    }
	    
	    if ($good)
	    {
	    	$tumb = new Dune_Image_Transform($o_file_info);
	        $tumb->setPathToResultImage($this->folder);
	        $tumb->setModeThumb($this->resize_mode);
	        $tumb->setProportions($this->proportion_x, $this->proportion_y);
	        $tumb->setModeProportion($this->proportion_mode);
	        $tumb->setBackgroundColor($this->proportion_color);
	        if ($tumb->changeProportion())
	        	$good = $tumb->createThumb($this->size);
	        else 
	        	$good = false;

	        if ($this->name_result)
	        {
	            $name_file_ex = $this->name_result . $o_file_info->getExtension();
	            $file_full = $this->folder . '/' . $name_file_ex;
	            if (is_file($file_full))
	            {
	                unlink($file_full);
	            }
	            if ($tumb->save($this->name_result))
	            {
	                $good = true;
	            }
	        }
			else if ($tumb->save(uniqid('pic', true)))
			{
	    			$good = true;     
			}
	    }
	}
}

    $this->setResult('file_result', $name_file_ex);
    $this->setResult('success', $good);
        

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    