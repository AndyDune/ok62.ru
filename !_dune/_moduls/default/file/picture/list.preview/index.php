<?php

$have_files = false;
$have_dirs = true;
$this->results['array'] = array();
$this->path_small_full = $this->path_main . '/' . $this->path_small;
if (!is_dir($this->path_main))
{
	$have_dirs = false;
}
else if (!is_dir($this->path_small_full))
{
	if (!mkdir($this->path_small_full, 0777))
		$have_dirs = false;
}

$array_result = array();

if ($have_dirs)
{
	$gallery_list = new Dune_Directory_List($this->path_main);
	$gallery_small_list = new Dune_Directory_List($this->path_small_full);
										  
	if (
		($gallery_small_list->getCountFiles() > 0)
		and 
		($gallery_small_list->getCountFiles() == $gallery_list->getCountFiles())
		)
	{ // Всё в порядке создаём текст из существующих файлов
		$have_files = true;
	}
	else 
	{
		$gallery_small_list->deleteFiles();

		if ($gallery_list->getCountFiles())
		{
			$file_list = $gallery_list->getListFiles();
			
			$count = 1;
			foreach ($file_list as $file_one)
			{
				$original_pic = new Dune_Image_Info($this->path_main . DIRECTORY_SEPARATOR . $file_one);
				if ($original_pic->isCorrect())
				{
					$thumbPic = new Dune_Image_Thumbnail($original_pic);
					$thumbPic->setPathToResultImage($this->path_small_full);
					$thumbPic->createThumb($this->size_small);
					if ($thumbPic->save($original_pic->getFileName()))
					{
						$array_result[$count] = $file_one;
						$count++;
					}
				}
			}
			$have_files = true;
			$gallery_small_list = new Dune_Directory_List($this->path_small_full);
		}
	}

	if ($have_files)
	{
			$array = array();
			$gallery_small_list->sort();
			$arr_small = $gallery_small_list->getListFiles();
			$temp_count = 1;
			foreach ($arr_small as $key => $value)
			{
				$array[$temp_count] = $value;
				$temp_count++;
			}
			
			$this->results['array'] = new Dune_Array_Container($array);
	}

}
