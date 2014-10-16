<?php
/**
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Info.php                                    |
 * | � ����������: Dune/Image/Info.php                 |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 1.00                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * 1.00 (2008 ������� 05)
 * ��������� ����� ����� ��������� (��� ����� ��������� �����)
 * 
 * ������ 0.99 -> 0.99a
 * ���������� �������� ��� ������� ��������:
 * $this->fileArray['filename'] = substr($this->fileArray['basename'], 0, strpos($this->fileArray['basename'], '.') + 1) ;
 * ��� php ���� 5.20
 * 
 * ������ 0.98 -> 0.99
 * ������� ���������� $extensionNoDot - ���������� ��� �����.
 * ���� ������ � ������� ���������� ���������� ����� - ���������.
 * 
 */

class Dune_Image_Info
{
    /**
     * Enter description here...
     *
     * @var string
     * @access private
     */
    protected $fullPath;
    
    /**
     * Enter description here...
     *
     * @var array
     * @access private
     */
    protected $fileArray;
    
    /**
     * ���������� � ������
     *
     * @var string
     * @access private
     */
    protected $extension;
    
    /**
     * ���������� ��� �����
     *
     * @var string
     * @access private
     */
    protected $extensionNoDot;
    
    
    /**
     * Enter description here...
     *
     * @var boolean
     * @access private
     */
    protected $correctness = false;
    
    /**
     * Enter description here...
     *
     * @var boolean
     * @access private
     */
    protected $existence = false;
    
    /**
     * Mine-Type �����
     *
     * ��������� ��������
     * 
     *   IMAGETYPE_GIF	image/gif
     *   IMAGETYPE_JPEG	image/jpeg
     *   IMAGETYPE_PNG	image/png
     *   IMAGETYPE_SWF	application/x-shockwave-flash
     *   IMAGETYPE_PSD	image/psd
     *   IMAGETYPE_BMP	image/bmp
     *   IMAGETYPE_TIFF_II (intel byte order)	image/tiff
     *   IMAGETYPE_TIFF_MM (motorola byte order) 	image/tiff
     *   IMAGETYPE_JPC	application/octet-stream
     *   IMAGETYPE_JP2	image/jp2
     *   IMAGETYPE_JPX	application/octet-stream
     *   IMAGETYPE_JB2	application/octet-stream
     *   IMAGETYPE_SWC	application/x-shockwave-flash
     *   IMAGETYPE_IFF	image/iff
     *   IMAGETYPE_WBMP	image/vnd.wap.wbmp
     *   IMAGETYPE_XBM	image/xbm
     * 
     *  @var unknown_type
     *  @access private
     */
    protected $mimeType;
    
    /**
     * Enter description here...
     *
     * @var integer
     * @access private
     */
    protected $fileSize = 0;
    
    /**
     * Enter description here...
     *
     * @var array
     * @access private
     */
    protected $imageProperties = array();
    
    public function __construct($file)
    {
		if (is_file($file))
		{
		    $this->existence = true;
		    $this->fullPath = $file;
		    $this->fileArray = pathinfo($file);
		    
		    ///
		    ///		!!!!!!!!!!!!!!!!!!!!!!!!!!
		    ///			��� php ���� 5.20
		    if (phpversion() < '5.2')
		    {
		    	$this->fileArray['filename'] = substr($this->fileArray['basename'], 0, strrpos($this->fileArray['basename'], '.')) ;
		    }
		    
    		$this->fileSize = filesize($file);
/*���������� ������ �� 4 ���������.
������ 0 �������� ������/width ����������� � ��������.
������ 1 �������� ������/height.
������ 2 ��� ����, ����������� ��� �����������.1 = GIF, 2 = JPG, 3 = PNG, 4 = SWF, 5 = PSD, 6 = BMP, 7 = TIFF(�������� ������� intel), 8 = TIFF(�������� ������� motorola), 9 = JPC, 10 = JP2, 11 = JPX.
������ 3 ��� ��������� ������ � ���������� ������� height="yyy" width="xxx", ������� ����� �������������� ��������������� � ���� IMG.    		
*/
    		if ($this->imageProperties = getimagesize($file))
    		{
    		    $this->correctness = true;
    		    $this->extensionNoDot = image_type_to_extension($this->imageProperties[2], false);
                if ($this->extensionNoDot == 'jpeg')
                    $this->extensionNoDot = 'jpg';
                $this->extension = '.' . $this->extensionNoDot;
        		$this->mimeType = image_type_to_mime_type($this->imageProperties[2]);	
		    }
        }
    }

    /**
     * ���������� ���� ������������� �����
     *
     * @return boolean
     */
    public function isExist()
    {
        return $this->existence;
    }
    
    /**
     * ���������� ���� ������������ �����
     * ���� ���������, ���� �������� ���������
     * 
     * @return boolean
     */
    public function isCorrect()
    {
        return $this->correctness;
    }
    
    /**
     * ���������� ������ ��������
     *
     * @return integer
     */
    public function getWidth()
    {
        return $this->imageProperties[0];
    }
    
    /**
     * ���������� ������ ��������
     *
     * @return integer
     */
    public function getHeight()
    {
        return $this->imageProperties[1];
    }
    
    /**
     * ���������� ������ �����
     *
     * @return integer
     */
    public function getFileSize()
    {
        return $this->fileSize;
    }
    
    /**
     * ���������� mine-type �������
     *
     * @return string
     */
    public function getMimeType()
    {
        return $this->imageProperties['mime'];
    }
    
    /**
     * ���������� ���������� ����� �������. C ������ �� ���������.
     * ���� �������� $dot = false - ��� �����
     *
     * @return string
     */
    public function getExtension($dot = true)
    {
        if ($dot)
        {
            return $this->extension;
        }
        else 
        {
            return $this->extensionNoDot;
            //return $this->fileArray['extension'];
        }
    }
    
    /**
     * ���������� ��� ����� ��� ����������
     *
     * @return string
     */
    public function getFileName()
    {
//        $this->fileArray['filename'] = substr($this->fileArray['basename'],0
//        ,strlen($this->fileArray['basename']) - (strlen($this->fileArray['extension']) + 1) );        
        return $this->fileArray['filename'];
    }
    
    /**
     * ���������� ��� ����� � �����������
     *
     * @return string
     */
    public function getBaseName()
    {
        return $this->fileArray['basename'];
    }
    
    /**
     * ���������� ��� ����������
     *
     * @return string
     */
    public function getDirName()
    {
        return $this->fileArray['dirname'];
    }
    
    /**
     * ���������� ��� ��������
     *
     * @return string
     */
    public function getType()
    {
        return $this->imageProperties[2];
    }
    
    /**
     * ���������� ������ ���� � �����
     *
     * @return string
     */
    public function getPath()
    {
        return $this->fullPath;
    }
    
}