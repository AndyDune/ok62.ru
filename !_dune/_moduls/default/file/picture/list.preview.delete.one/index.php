<?php
$have_files = false;
$have_dirs = true;

if ($this->local_folder)
	$this->path_main = $this->path_main . '/' . $this->local_folder;
else 
    $this->path_main = $this->path_main . '/img';

//$this->path_main = $_SERVER['DOCUMENT_ROOT'] . '/' . $this->path_main . '/img';
$this->path_preview = $_SERVER['DOCUMENT_ROOT'] . '/' . $this->path_preview;
if (!is_dir($this->path_main))
{
	$have_dirs = false;
}

if (is_dir($this->path_preview))
{
    $deldir = new Dune_Directory_Delete($this->path_preview);
    $deldir->delete();
}


$pic_count = 0;
if ($have_dirs)
{
	$gallery_list = new Dune_Directory_List($this->path_main);
	$gallery_list->sort();
	$array = $gallery_list->getListFiles();
	$pic_count = $gallery_list->getCountFiles();
	$this->results['pic_count'] = $gallery_list->getCountFiles();
	if ($pic_count)
	{
		$array_last_key = $pic_count - 1;
		@unlink($this->path_main . '/' . $array[$array_last_key]);
		$pic_count--;
	}
}

	$this->results['pic_count'] = $pic_count;