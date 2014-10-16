<?php
/**
 * ������ ����� � ���������� � �������� ����������� ����� �������� � ��������.
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Preview.php                                 |
 * | � ����������: Dune/Image/Preview.php              |
 * | �����: ������ ����� (Dune) <dune@rznlf.ru>        |
 * | ������: 0.93                                      |
 * | ����: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * 
 * ������ 0.92 -> 0.93 ����-������
 * ����� ������� ��������������� �������.
 * �� ���� ������� ������� �������� � �� ���������. �� ��������� �� ����.
 * 
 * 
 * ������ 0.91 -> 0.92 ����-������
 * ��������� ������� ���� ������.
 * 
 */

class Dune_Image_Preview
{
    protected $_previewFolder = '_preview';
    protected $_previewFolderFull;
    protected $_previewFolderDisplay;
    
    protected $_previewSize = array(1 => 100);
    protected $_previewSizeCount = 1;
    
    protected $_sourseFolder;
    protected $_sourseFolderFull;
    protected $_sourseFolderDisplay;
    
    protected $_haveDir = false;
    
    protected $_sourseFilesList = array();
    protected $_sourseFilesCount = false;

    protected $_sourseFolderList = array();
    protected $_sourseFolderCount = false;
    
    protected $_notHaveSourse = true;
    
    protected $_resultArray = array();
    
    
    
    protected $_currentResultSize = 0;
    
    
    /**
     * �������� ��������� �� ������� ������� � ������� � ����� ������ ��������.
     */
    const RESULT_SIZE_ONE = 0;
    
    /**
     * �������� ��������� �� ������� ������� � ������� � ����������� ������ ���������.
     */
    const RESULT_SIZE_MULTI = 1;
    
    /**
     * ��������� ���� � ����� � ������� ��������. ��������� �� �������������.
     * ���� � ����� ������� �� ����� �����. !!! �� �� ����� �������.
     * ����� � ������ ������ ���������.
     *
     * @param string $path ���� � ����� �� ����� �����.
     */
    public function __construct($path)
    {
        if (($path[0] == '/') or ($path[0] == '\\'))
        {
            $path = substr($path, 1);
        }
        $this->_sourseFolder = $path;
        $this->_sourseFolderFull = $_SERVER['DOCUMENT_ROOT'] . '/' . $path;
        $this->_sourseFolderDisplay = '/' . $path;
        if (is_dir($this->_sourseFolderFull))
        {
            $this->_haveDir = true;
            $this->_previewFolderFull = $this->_sourseFolderFull . '/' . $this->_previewFolder;
            $this->_previewFolderDisplay = $this->_sourseFolderDisplay . '/' . $this->_previewFolder;
            if (!is_dir($this->_previewFolderFull))
            {
                if (!mkdir($this->_previewFolderFull, 0777))
                    throw new Dune_Exception_Base('�� ������� ������� ����� ������, ��� ������������ �������� �����.');
            }
        }
    }

	/**
	 * ���������� ������ ������ �������� ��� ��������.
	 * ������ ��������� ����� ���� ���������. ��� ����� ������� ������� ��������� ���, ������ ������ ��������.
	 *
	 * @param integer $size ������ �������� ������
	 */
    public function setPreviewSize($size)
    {
        $this->_previewSize[$this->_previewSizeCount] = $size;
        $this->_previewSizeCount++;
    }
	
    
    /**
     * ��������� ������� ��������������� �������.
     * ������������ ��������� ������:
     * RESULT_SIZE_ONE - ������ ���� ������, ������ �������������. ���������� �� ���������.
     * ������:
     *  array = (
     * 			'sourse'  => ���� � �����-���������. ����� ��� ������� �� ��������.
     * 			'preview' => ���� � ��������-������ �������, �������������� ������
     *  		)
     * 
     * RESULT_SIZE_MULTI - ��������� ��������. ��� �� �������������� ����.
     * ������ ������������� �������:
     * array = (
     * 			'sourse'  => ���� � �����-���������. ����� ��� ������� �� ��������.
     * 			'preview' => array(
     * 								<������ 1> => ���� � ��������-������ �������, �������������� ������
     *  							<������ 2> => ���� � ��������-������ �������, �������������� ������
     * 								...
     * 							  )
     * 		   )

     * 
     * @param integer $format
     */
    
    public function setResultFormat($format)
    {
        $this->_currentResultSize = (int)$format;
    }
    
    /**
     * �������� ����� ������ �������� (������� ��� �����). ��������� ����� ����������� 
     *
     */
    public function clear()
    {
        $dir = new Dune_Directory_Delete($this->_previewFolderFull);
        $dir->deleteFiles();
    }
    
    /**
     * �������� ����� ������-������� ���������.
     *
     */
    public function delete()
    {
        $dir = new Dune_Directory_Delete($this->_previewFolderFull);
        $dir->deleteContent();
    }
    
    
    /**
     * ���������� ����� ������ � ��������������� �����.
     *
     * @return integer ����� ������ � ������
     */
    public function sourseCount()
    {
    	$this->_getSourse();
        return $this->_sourseFilesCount;
    }
    
    /**
     * ������� ���� ������ ��� ����� ��������.
     * ������ ������������� �������:
     * array = (
     * 			'sourse'  => ���� � �����-���������. ����� ��� ������� �� ��������.
     * 			'preview' => array(
     * 								<������ 1> => ���� � ��������-������ �������, �������������� ������
     *  							<������ 2> => ���� � ��������-������ �������, �������������� ������
     * 								...
     * 							  )
     * 		   )
     *
     * @param integer $number ����� �������� � �����,������� � 0(����) ������������� �� ��������.
     * @return array ������ ����. �������
     */
    public function getOne($number = 0)
    {
        $array = array();
        $this->_getSourse();
        if ($this->_sourseFilesCount)
        {
            if (!isset($this->_sourseFilesList[$number]))
                $number = 0;
            if ($this->_makeOnePreview($number))
                $array = $this->_resultArray[$number];
        }
        return $array;
    }
    
    
    
    /**
     * ������� ����� ���� ������ �������� ������ � ����������. 
     * ������������ ��� ������ �������� �������� �������� ��������� �������:
     * array = (
     * 			'sourse'  => ���� � �����-���������. ����� ��� ������� �� ��������.
     * 			'preview' => array(
     * 								<������ 1> => ���� � ��������-������ �������, �������������� ������
     *  							<������ 2> => ���� � ��������-������ �������, �������������� ������
     * 								...
     * 							  )
     * 		   )
     * 
     * @return array
     */
    public function getAll()
    {
    	$this->_getSourse();
    	foreach ($this->_sourseFilesList as $key => $value)
    	{
            $this->_makeOnePreview($key);
    	}
    	return $array = $this->_resultArray;
    }
    
    protected function _makeOnePreview($number)
    {
        $good = false;
        if ($this->_currentResultSize == 0)
            $result = $this->_makeOneOnly($number);
        else 
            $result = $this->_makeOneMulti($number);
        if ($result !== false)
        {
            $this->_resultArray[$number] = $result;
            $good = true;
        }
        return $good;
    }
    
   
   /**
    * ���������� ������ � ������� �� ������-�������� �����, ��������� ��������-���������.
    *
    * @param integer $number ���������� ����� �������� � �������-���������.
    * @return mixed
    * 
    * @access private
    */
   
    protected function _makeOneMulti($number)
    {
        $good = true;
        $array['sourse'] =  $this->_sourseFolderDisplay . '/' . $this->_sourseFilesList[$number];
        $array['preview'] = array();
        foreach ($this->_previewSize as $key => $value)
        {
            $sizeFolder = $this->_previewFolderFull . '/' . $value;
            $pathDisplay = $this->_previewFolderDisplay . '/'  . $value . '/' . $this->_sourseFilesList[$number];
            if (!is_dir($sizeFolder))
                $good = mkdir($sizeFolder);
            if ($good)
            {
                $file = $sizeFolder . '/' . $this->_sourseFilesList[$number];
                if (is_file($file))
                {
                    $array['preview'][$value] = $pathDisplay;
                }
                else 
                {
    				$original_pic = new Dune_Image_Info($this->_sourseFolderFull . '/' . $this->_sourseFilesList[$number]);
    				if ($original_pic->isCorrect())
    				{
    					$thumbPic = new Dune_Image_Thumbnail($original_pic);
    					$thumbPic->setPathToResultImage($sizeFolder);
    					$thumbPic->createThumb($value);
    					if (!$thumbPic->save($original_pic->getFileName()))
    					{
    					    $good = false;
    					}
    					else 
    					{
    					    $array['preview'][$value] = $pathDisplay;
    					}
                        
                    }
                    else 
                        $good = false;
                }
            }
            if (!$good)
                break;                
        }
        if ($good)
            $good = $array;
        return $good;
    }
    
    

    
   /**
    * ���������� ������, ��� ������ �������� ������ �������, ���������� ������.
    *
    * @param integer $number ���������� ����� �������� � �������-���������.
    * @return mixed
    * 
    * @access private
    */
    protected function _makeOneOnly($number)
    {
        $good = true;
        $array['sourse'] =  $this->_sourseFolderDisplay . '/' . $this->_sourseFilesList[$number];
        $array['preview'] = '';
        
        $value = $this->_previewSize[1];
            
        $sizeFolder = $this->_previewFolderFull . '/' . $value;
        $pathDisplay = $this->_previewFolderDisplay . '/'  . $value . '/' . $this->_sourseFilesList[$number];
        if (!is_dir($sizeFolder))
            $good = mkdir($sizeFolder);
        if ($good)
        {
            $file = $sizeFolder . '/' . $this->_sourseFilesList[$number];
            if (is_file($file))
            {
                $array['preview'] = $pathDisplay;
            }
            else 
            {
    		    $original_pic = new Dune_Image_Info($this->_sourseFolderFull . '/' . $this->_sourseFilesList[$number]);
    		    if ($original_pic->isCorrect())
    			{
    				$thumbPic = new Dune_Image_Thumbnail($original_pic);
    				$thumbPic->setPathToResultImage($sizeFolder);
    				$thumbPic->createThumb($value);
    				if (!$thumbPic->save($original_pic->getFileName()))
    				{
    				    $good = false;
    				}
    				else 
    				{
    				    $array['preview'] = $pathDisplay;
    				}
                       
                 }
                 else 
                     $good = false;
            }
        }
        if ($good)
            $good = $array;
        return $good;
    }
    
    protected function _getSourse()
    {
        if ($this->_notHaveSourse)
        {
            $dir = new Dune_Directory_List($this->_sourseFolderFull);
            $this->_sourseFilesList = $dir->getListFiles();
            $this->_sourseFilesCount = $dir->getCountFiles();
        
            $this->_sourseFolderList = $dir->getListDir();
            $this->_sourseFilesCount = count($this->_sourseFolderList);
            $this->_notHaveSourse = false;
        }
    }
}