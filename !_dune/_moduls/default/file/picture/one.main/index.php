<?php

$have_files = false;
$have_dirs = true;
$this->results['array'] = array();
$this->results['pic'] = '';
$this->path_sourse_displey = '/' . $this->path_total . '/brand_' . $this->brand_id . '/model_' . $this->model_id;
$this->path_sourse = $_SERVER['DOCUMENT_ROOT'] . '/' . $this->path_total . '/brand_' . $this->brand_id . '/model_' . $this->model_id;
if (!is_dir($this->path_sourse))
{
	$have_dirs = false;
}

$array_result = array();

if ($have_dirs)
{
	$gallery_list = new Dune_Directory_List($this->path_sourse);
	$gallery_list->sort();


	$file_list = $gallery_list->getListFiles();
	reset($file_list);
	$file = current($file_list);
	$original_pic = new Dune_Image_Info($this->path_sourse . DIRECTORY_SEPARATOR . $file);
	
	if ($original_pic->isCorrect())
	{
		
/*		$thumbPic = new Dune_Image_Thumbnail($original_pic);
		$thumbPic->setPathToResultImage($this->path_small_full);
		$thumbPic->createThumb($this->size_small);
		if ($thumbPic->save($original_pic->getFileName()))
		{
			$array_result[$count] = $file_one;
			$count++;
		}
*/		$have_files = true;
		$this->results['pic'] = $this->path_sourse_displey . '/' . $file;
	}
}
$this->results['have'] = $have_files;
	
