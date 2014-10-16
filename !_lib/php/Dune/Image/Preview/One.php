<?php
/**
 * ������ ����� � ���������� � �������� ����������� ����� �������� � ��������.
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: One.php                                     |
 * | � ����������: Dune/Image/Preview.One.php          |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 0.95                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * 
 * ������:
 * 
 * 0.95 (2008 ���� 26)
 * Trim ������������ �� ����������
 * 
 * 0.94 (2008 ������� )
 * ����� ����� getSourseFileUrlSystem() ���������� ������ ���� � �������� �����.
 * 
 * 0.92 -> 0.93 ����-������
 * 
 */

class Dune_Image_Preview_One
{
    protected $_previewFolderFull;
    protected $_previewFolderDisplay;
    
    protected $_previewSize = array(1 => 100);
    protected $_previewSizeCount = 1;
    
    protected $_sourse;
    protected $_sourseFull;
    protected $_sourseDisplay;
    
    
    protected $_haveDir = false;
    
    protected $_sourseFileName;
   
    protected $_notHaveSourse = true;
    
    protected $_resultArray = array();
    
    
    
    /**
     * ��������� ���� � ����� � ������� ��������. ��������� �� �������������.
     * ���� � ����� ������� �� ����� �����. !!! �� �� ����� �������.
     * ����� � ������ ������ ���������.
     *
     * @param string $path ���� � ����� �� ����� �����.
     */
    public function __construct($file_name, $path_sourse, $path_preview)
    {
//        $path_sourse = trim($path_sourse, '/\\');
//        $path_preview = trim($path_preview, '/\\');
        $str = Dune_String_Factory::getStringContainer($path_sourse);        
        $path_sourse = $str->trim('/\\');
        $str->setString($path_preview);
        $path_preview = $str->trim('/\\');
        
        $this->_sourseFileName = $file_name;
        $this->_sourse = $path_sourse . '/'. $file_name;
        $this->_sourseFull = $_SERVER['DOCUMENT_ROOT'] . '/' . $this->_sourse;
        $this->_sourseDisplay = '/' . $this->_sourse;
        
        $this->_previewFolder = $path_preview;
        $this->_previewFolderFull = $_SERVER['DOCUMENT_ROOT'] . '/' . $path_preview;
        $this->_previewFolderDisplay = '/' . $path_preview;

        if (!is_file($this->_sourseFull))
        {
            throw new Dune_Exception_Base('����� ��������� ������ �� ����������: ' . $this->_sourseFull);
        }        
    }

    
    /**
     * ������� ��� ��������� ��������
     *
     */
    public function deletePreview()
    {
        if (isset($this->_previewFolderFull))
        {
            $dir = new DirectoryIterator($this->_previewFolderFull);
            foreach ($dir as $value)
            {
                if ($value->isDir() and !$value->isDot())
                {
                    //echo $file = $this->_previewFolderFull . '/' . $value . '/' . $this->_sourseFileName;
                    if (is_file($file))
                    {
                        unlink($file);
                    }
                }
            }
        }
    }
    
    
    public function getSourseFileUrl()
    {
        return $this->_sourseDisplay;
    }
    public function getSourseFileUrlSystem()
    {
        return $this->_sourseFull;
    }
    
    public function getSourseFileName()
    {
        return $this->_sourseFileName;
    }

    public function getPreviewFileUrl($size = 100)
    {
        if (isset($this->_resultArray[$size]))
            return $this->_resultArray[$size];
        if ($this->_makePreview($size))
        {
            $result = $this->_resultArray[$size];
        }
        else
        {
            $result = false;
        }
            
        return $result;
    }
    
    
    protected function _makeDir($path, $count = 7)
    {
        if (!$count)
            return false;
        $result = false;
        if (!is_dir($path))
        {
            $path_t = substr($path, 0, strrpos($path, '/'));
            if ($this->_makeDir($path_t, $count - 1))
            {
                mkdir($path, 0777);
                $result = true;
            }
        }
        else 
        {
            $result = true;
        }
        return $result;
    }
    
   /**
    * ������������ ������ ����������� �������.
    *
    * @param integer $size ������ ������
    * @return mixed
    * 
    * @access private
    */
    protected function _makePreview($size)
    {
            
        if (!$this->_makeDir($this->_previewFolderFull))
            return false;
        $sizeFolder = $this->_previewFolderFull . '/' . $size;
        $sizeFolderDispley = $this->_previewFolderDisplay . '/'  . $size;
        
        $good = $file = $sizeFolder . '/' . $this->_sourseFileName;
        if (!is_dir($sizeFolder))
            $good = mkdir($sizeFolder, 0777);
        if ($good)
        {
            if (is_file($file))
            {
                $this->_resultArray[$size] = $sizeFolderDispley . '/' . $this->_sourseFileName;
            }
            else 
            {
    		    $original_pic = new Dune_Image_Info($this->_sourseFull);
    		    if ($original_pic->isCorrect())
    			{
    				$thumbPic = new Dune_Image_Thumbnail($original_pic);
    				$thumbPic->setPathToResultImage($sizeFolder);
    				$thumbPic->createThumb($size);
    				if (!$thumbPic->save($original_pic->getFileName()))
    				{
    				    $good = false;
    				}
    				else 
    				{
    				    $this->_resultArray[$size] = $sizeFolderDispley . '/' . $this->_sourseFileName;
    				}
                       
                 }
                 else 
                     $good = false;
            }
        }
        return $good;
    }
    
}