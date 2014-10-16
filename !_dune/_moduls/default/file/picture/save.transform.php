<?php
/*				$mm->name_form = 'file';
				$mm->name_save = $post->id;
				$mm->size = 100;
				$mm->resize_mode = 'both';
				$mm->proportion_x = 10;
				$mm->proportion_y = 10;
				$mm->proportion_mode = 'add';
				$mm->proportion_color = 0xffffff;
*/

	$good = false;
    $o_file = new Dune_Upload_File($this->name_form);
    if ($o_file->uploaded())
    {
        $o_file_info = new Dune_Image_Info($o_file['tmp_name']);
        if ($o_file_info->isCorrect())
        {
            $good = true;
        }
    }
    
        
    if ($good)
    { echo 111;
        $tumb = new Dune_Image_Thumbnail($o_file_info);
        $tumb->setPathToResultImage($this->path_save);
        $tumb->setMode($mm->resize_mode);
        $tumb->createThumb($mm->size);
        $tumb->saveToType($page_id);
    }
        

