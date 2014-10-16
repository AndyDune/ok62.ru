<?php
/**
 * 
 * 
 * 
 */
class Special_Vtor_Catalogue_Info_HousePhotoCommon implements Iterator, Countable
{
    protected $folder = 'catalogue/houses';
    protected $folderTemp = '_temp/catalogue/houses';
    
    protected $_folder = '';
    protected $_folderMain = '';
    protected $_folderSystem = '';
    protected $_folderMainSystem = '';
    protected $_folderExist = false;

    protected $_folderPreview = '';
    protected $_folderPreviewSystem = '';

    protected $_folderPreviewMain = '';
    protected $_folderPreviewMainSystem = '';
    
    
    protected $_count = false;
    
    protected $_array = array();
    
    protected $_aimFolder = 'photo';
    
        
	public function __construct($street_id, $house_number = '', $building_number = '', $create = false)
	{
	    if (!$house_number)
	    {
	        return;
	    }
	    else 
	    {
	        $house_number = $this->rusToEng($house_number);
	        $house_number = str_replace(array('/', '\\'), array('.', '.'), $house_number);
	    }
	    if ($building_number)
	    {
	        $building_number = '_' . $this->rusToEng($building_number);
	    }
	    
	    $folder = '/' . $street_id . '/'  . $house_number . $building_number . '/' . $this->_aimFolder;
	    $this->_folder        = $this->folder . $folder;
	    $this->_folderMain    = $this->folder . '/' . $street_id . '/'  . $house_number . $building_number;
	    
	    
	    $this->_folderPreview = $this->folderTemp . $folder;
	    $this->_folderPreviewMain = $this->folderTemp . '/' . $street_id . '/'  . $house_number . $building_number;
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
	
	
	
	protected function rusToEng($string)
	{
	    return str_replace(array('а', 'б', 'в', 'г', 'д', 'е'), array('a', 'b', 'c', 'd', 'e', 'f'), $string);
	}
	
	
	public function isExistFolder()
	{
	    return $this->_folderExist;
	}
	
	public function createFolder()
	{
        if (mkdir($this->_folderSystem, 0777, true))
	       $this->_folderExist = true;
	    return $this->_folderExist;
	}

	public function count()
	{
	    return $this->_count;
	}

	public function getDisplayUrl()
	{
	    return '/' . $this->_folder;
	}
	
	
	public function getSystemUrl()
	{
	    return $_SERVER['DOCUMENT_ROOT'] . '/' . $this->_folder;
	}

	public function clearPreviewFolder()
	{
	    $del = new Dune_Directory_Delete($this->_folderPreviewSystem);
	    $del->deleteContent();
	}

	public function deletePreviewFolder()
	{
	    $del = new Dune_Directory_Delete($this->_folderPreviewMainSystem);
	    $del->delete();
	}

	public function deleteFolder()
	{
	    $del = new Dune_Directory_Delete($this->_folderMainSystem);
	    $del->delete();
	}
	
  /**
   * возвращает текущий элемент
   *
   * @return Dune_Image_Preview_One
   */
  public function getOneImage($count = 0)
  {
      if (isset($this->_array[$count]))
        return new Dune_Image_Preview_One($this->_array[$count], $this->_folder, $this->_folderPreview);
      else 
        return false;
  }
	
	protected function _collectImages()
	{
	    $dir = new DirectoryIterator($this->_folderSystem);
	    foreach ($dir as $file)
	    {
            if (!$file->isFile()) {continue;}
            
            if (strripos($file->getFilename(),".jpg") or strripos($file->getFilename(),".gif") or strripos($file->getFilename(),".png"))
            {
                $this->_array[] = $file->getFilename();
            }
	    }
	    $this->_count = count($this->_array);
	}
	
	
    public function __toString()
    {
    	$string = '<pre>';
    	ob_start();
    	print_r($this->_array);
    	$string .= ob_get_clean();
    	return  '</pre>' . $string;
    }
	
	
    ////////////////////////////////////////////////////////////////
///////////////////////////////     Методы интерфейса Iterator
  // устанавливает итеретор на первый элемент
  public function rewind()
  {
        return reset($this->_array);
  }

  /**
   * возвращает текущий элемент
   *
   * @return Dune_Image_Preview_One
   */
  public function current()
  {
      return new Dune_Image_Preview_One(current($this->_array), $this->_folder, $this->_folderPreview);
  }
  // возвращает ключ текущего элемента
  public function key()
  {
    return key($this->_array);
  }
  
  // переходит к следующему элементу
  public function next()
  {
    return next($this->_array);
  }
  // проверяет, существует ли текущий элемент после выполнения мотода rewind или next
  public function valid()
  {
    return isset($this->_array[key($this->_array)]);
  }    
/////////////////////////////
////////////////////////////////////////////////////////////////   
	
	

	
}