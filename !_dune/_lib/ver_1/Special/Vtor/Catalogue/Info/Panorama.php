<?php
/**
 * 
 * 
 * 
 */
class Special_Vtor_Catalogue_Info_Panorama
{
    static $folder = '/catalogue/objects';
        
    protected $_folderFlash = '';
    protected $_folderFlashSystem = '';
    protected $_folderExist = false;

    protected $_folderPreview       = '';
    protected $_folderPreviewSystem = '';
    
    protected $_folderText = '';
    protected $_folderTextSystem = '';
    
    protected $_countFlash   = 0;
    protected $_countPreview = 0;
    protected $_countText    = 0;
    
    protected $_arrayFlash   = array();
    protected $_arrayPreview = array();
    protected $_arrayText    = array();
    
    
	public function __construct($id, $time, $create = false)
	{
	    $folder = '/' . substr($time, 0, 4) . '/' . $id . '/panorama';
	    $this->_folderFlash   = self::$folder . $folder . '/flash';
	    $this->_folderPreview = self::$folder . $folder . '/preview';
	    
	    $this->_folderFlashSystem   = $_SERVER['DOCUMENT_ROOT'] . $this->_folderFlash;
	    $this->_folderPreviewSystem = $_SERVER['DOCUMENT_ROOT'] . $this->_folderPreview;
	    if (is_dir($this->_folderFlashSystem))
	    {
	       $this->_folderExist = true;
	       $this->_collectFlashe();
	       $this->_collectPreview();
	       $this->_collectText();
	    }
	}
	
	
	protected function _collectFlashe()
	{
	    $dir = new DirectoryIterator($this->_folderFlashSystem);
	    $x = 1;
	    foreach ($dir as $file)
	    {
            if (!$file->isFile()) {continue;}
            
            if (strripos($file->getFilename(),".swf"))
            {
                $this->_arrayFlash[$x] = $file->getFilename();
                $x++;
            }
	    }
	    $this->_countFlash = count($this->_arrayFlash);
	}

	protected function _collectFlash()
	{
	    $dir = new DirectoryIterator($this->_folderFlashSystem);
	    $x = 1;
	    foreach ($dir as $file)
	    {
            if (!$file->isFile()) {continue;}
            
            if (strripos($file->getFilename(),".swf"))
            {
                $this->_arrayFlash[$x] = $file->getFilename();
                $x++;
            }
	    }
	    $this->_countFlash = count($this->_arrayFlash);
	}
	
	
	protected function _collectPreview()
	{
	    if (!is_dir($this->_folderPreviewSystem))
	       return;
	    $dir = new DirectoryIterator($this->_folderPreviewSystem);
	    $x = 1;
	    foreach ($dir as $file)
	    {
            if (!$file->isFile()) {continue;}
            
            if (strripos($file->getFilename(),".jpg"))
            {
                $this->_arrayPreview[$x] = $file->getFilename();
                $x++;
            }
	    }
	    $this->_countPreview = count($this->_arrayPreview);
	}
	
	protected function _collectText()
	{
	    if (!is_dir($this->_folderTextSystem))
	       return;
	    $dir = new DirectoryIterator($this->_folderTextSystem);
	    $x = 1;
	    foreach ($dir as $file)
	    {
            if (!$file->isFile()) {continue;}
            
            if (strripos($file->getFilename(),".txt"))
            {
                $this->_arrayText[$x] = file_get_contents($this->_folderTextSystem . '/' . $file);
                $x++;
            }
	    }
	    $this->_countText = count($this->_arrayText);
	}
	
	
	public function count()
	{
	    return $this->_countFlash;
	}
	
	public function getFlashFolderUrl()
	{
	    return $this->_folderFlash . '/';
	}
	
	public function getFlashFileUrl($number)
	{
	    if (isset($this->_arrayFlash[$number]))
	    {
	        return $this->_folderFlash . '/' . $this->_arrayFlash[$number];
	    }
	    else return false;
	}
	
	public function getFlashFileName($number)
	{
	    if (isset($this->_arrayFlash[$number]))
	    {
	        return $this->_arrayFlash[$number];
	    }
	    else return false;
	}
	
	
	public function getPreviewFileUrl($number)
	{
	    if (isset($this->_arrayPreview[$number]))
	    {
	        return $this->_folderPreview . '/' . $this->_arrayPreview[$number];
	    }
	    else return false;
	}
	
	public function getText($number)
	{
	    if (isset($this->_arrayText[$number]))
	    {
	        return $this->_arrayText[$number];
	    }
	    else return false;
	}
	
	
	
    public function __toString()
    {
    	$string = '<pre>';
    	ob_start();
    	print_r($this->_arrayFlash);
    	$string .= ob_get_clean();
    	return  '</pre>' . $string;
    }
	

}