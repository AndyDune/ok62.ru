<?php
/**
 * 
 * 
 * 
 */
class Special_Vtor_Catalogue_Info_PanoramaCommon extends Special_Vtor_Catalogue_Info_Panorama
{
    static $folder = '/data/panorama';
    
	public function __construct($id)
	{
	    $folder =  '/' . $id;
	    $this->_folderFlash   = self::$folder . $folder . '/flash';
	    $this->_folderPreview = self::$folder . $folder . '/preview';
	    $this->_folderText    = self::$folder . $folder . '/text';
	    
	    $this->_folderFlashSystem   = $_SERVER['DOCUMENT_ROOT'] . $this->_folderFlash;
	    $this->_folderPreviewSystem = $_SERVER['DOCUMENT_ROOT'] . $this->_folderPreview;
	    $this->_folderTextSystem = $_SERVER['DOCUMENT_ROOT'] . $this->_folderText;
	    if (is_dir($this->_folderFlashSystem))
	    {
	       $this->_folderExist = true;
	       $this->_collectFlash();
	       $this->_collectPreview();
	       $this->_collectText();
	    }
	}
	
}