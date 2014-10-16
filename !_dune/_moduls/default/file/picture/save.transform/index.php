<?php
/*				$this->name_form = 'file';
				$this->name_save = $post->id;
				$this->size = 100;
				$this->resize_mode = 'both';
				$this->proportion_x = 10;
				$this->proportion_y = 10;
				$this->proportion_mode = 'add';
				$this->proportion_color = 0xffffff;
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
    {
    	
        $tumb = new Dune_Image_Transform($o_file_info);
        $tumb->setPathToResultImage($this->path_save);
        $tumb->setModeThumb($this->resize_mode);
        $tumb->setProportions($this->proportion_x, $this->proportion_y);
        $tumb->setModeProportion('add');
        $tumb->setBackgroundColor($this->proportion_color);
        if ($tumb->changeProportion())
        	$good = $tumb->createThumb($this->size);
        else 
        	$good = false;
		if ($tumb->saveToType($this->name_save))
    			$good = true;        	
        /*	
        if ($tumb->saveToType($this->name_save))
        {
        	$o_file_info = new Dune_Image_Info($this->path_save . '/' . $this->name_save .'.jpg');
        	$tumb = new Dune_Image_Proportion($o_file_info);
        	$tumb->setProportions($this->proportion_x, $this->proportion_y);
        	$tumb->setBackgroundColor($this->proportion_color);
        	$tumb->setMode($this->proportion_mode);
    		$tumb->createThumb();
    		$tumb->setPathToResultImage($this->path_save);
    		if ($tumb->save($this->name_save))
    			$good = true;
        }*/
        
    }
    $this->results['done'] = $good;
        

