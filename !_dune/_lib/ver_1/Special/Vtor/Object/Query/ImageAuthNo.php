<?php
/**
 * 
 * Данные о добавляемом объекте.
 * 
 */
class Special_Vtor_Object_Query_ImageAuthNo extends Special_Vtor_Catalogue_Info_Image
{
    protected $folder = '_temp/input/object';
    protected $folderTemp = '_temp/input/object/p';
    
    protected $_aimFolder = 'photo';

	public function __construct($id, $time = '', $create = false)
	{
	    $folder = '/' . $id . '/' . $this->_aimFolder;
	    $this->_folder        = $this->folder . $folder;
	    $this->_folderMain    = $this->folder . '/' . $id;
	    $this->_folderPreview = $this->folderTemp . $folder;
	    $this->_folderPreviewMain = $this->folderTemp . '/' . $id;
	    $this->_folderSystem  = $_SERVER['DOCUMENT_ROOT'] . '/' . $this->_folder;
	    $this->_folderMainSystem  = $_SERVER['DOCUMENT_ROOT'] . '/' . $this->_folderMain;
	    $this->_folderPreviewSystem = $_SERVER['DOCUMENT_ROOT'] . '/' . $this->_folderPreview;
	    $this->_folderPreviewMainSystem = $_SERVER['DOCUMENT_ROOT'] . '/' . $this->_folderPreviewMain;
	    if (is_dir($this->_folderSystem))
	    {
	       $this->_folderExist = true;
	       $this->_collectImages();
	    }
	    else if ($create)
	    { echo $this->_folderSystem;
	        $dir = new Dune_Directory_Make($this->_folder);
	        if ($dir->make(1))
	           $this->_folderExist = true;
//	        if (mkdir($this->_folderSystem, 0777, true))
//	           $this->_folderExist = true;
	    }
	}
    
    
}