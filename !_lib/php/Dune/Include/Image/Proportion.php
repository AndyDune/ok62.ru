<?php
/**
 * ����� ��������� ��������� �������� gif, jpg, png �� ����������.
 * ������ ���������� ���� ����������� �������.
 * 
 * �������� ������ (��������) ����������� � ������� Dune_Image_Info
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Proportion.php                              |
 * | � ����������: Dune/Image/Proportion.php           |
 * | �����: ������ ����� (Dune) <dune@rznlf.ru>        |
 * | ������: 1.00                                      |
 * | ����: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * ������ 0.99 -> 1.00
 * ��������� ��������� �������� �� ���������� ���������� - ����� ��� �� ������������� ���������.
 * ����� saveToType() - ���������� �������� � ��������� ����.
 * 
 */



/*    $img = new Dune_Image_Info(dirname(__FILE__) . '/res.jpg');
    if ($img->isCorrect())
        echo '���� ����';
     
    $tumb = new Dune_Image_Proportion($img);
    $tumb->setProportions(10, 1);
    //$tumb->setMode('add');
    $tumb->setBackgroundColor(0x00aa44);
    $tumb->createThumb();
    $tumb->setPathToResultImage(dirname(__FILE__));
    $tumb->save('res1');
*/


class Dune_Image_Proportion
{
    /**
     * Enter description here...
     *
     * @var unknown_type
     * @access private;
     */
	protected $image;
	
    /**
     * Enter description here...
     *
     * @var unknown_type
     * @access private;
     */
	protected $quality = 80;
	
    /**
     * Enter description here...
     *
     * @var unknown_type
     * @access private;
     */
	protected $imageInfoObject;
	
    /**
     * Enter description here...
     *
     * @var unknown_type
     * @access private;
     */
	protected $correct = false;

    /**
     * Enter description here...
     *
     * @var unknown_type
     * @access private;
     */
	protected $pathToResultImage = '';
	
    /**
     * Enter description here...
     *
     * @var unknown_type
     * @access private;
     */
	protected $modeProp = 'cut'; // ����� ����������� ��������
							// cut - ������ ����������
							// add - �����������
							
    protected $proportionWidth = 100;
    protected $proportionHeight = 100;
    protected $backgroundColor = 0xffffff;
    
/////////// ���������� �� ������� ��������� � ��������
    protected $_imageType = 0;
    protected $_imageMimeType = 0;
    protected $_imageWidth = 0;
    protected $_imageHeight = 0;
    protected $_imageExtension = '';
    protected $_imageExtensionNoDot = '';
    
    
////////////////////////////////////////////////////////
//constructor
////////////////////////////////////////////////////////
	public function __construct(Dune_Image_Info $object)
	{
		$this->imageInfoObject = $object;
		if ($this->imageInfoObject->isCorrect())
		{
		    $this->_imageExtension =  $this->imageInfoObject->getExtension();
		    $this->_imageExtensionNoDot = $this->imageInfoObject->getExtension(false);
		    $this->_imageType = $this->imageInfoObject->getType();
		    $this->_imageMimeType = $this->imageInfoObject->getMimeType();
		    $this->_imageWidth = $this->imageInfoObject->getWidth();
		    $this->_imageHeight = $this->imageInfoObject->getHeight();
		    
    		switch($this->_imageType)
    		{
    			case IMAGETYPE_JPEG:
    				$this->image = imagecreatefromjpeg($this->imageInfoObject->getPath());	
    				$this->correct = true;
    				break;
    			case IMAGETYPE_GIF:	
    				$this->image = imagecreatefromgif($this->imageInfoObject->getPath());
    				$this->correct = true;
    				break;
    			case IMAGETYPE_PNG:
    				$this->image = imagecreatefrompng($this->imageInfoObject->getPath());
    				$this->correct = true;
    				break;
    		}
		}
	}
////////////////////////////////////////////////////////
//destructor
////////////////////////////////////////////////////////
	public function __destruct(){
		if(isset($this->image)){
			imagedestroy($this->image);			
		}
	}
////////////////////////////////////////////////////////
//public methods
////////////////////////////////////////////////////////
    /**
     * ��������� ����� ��� ���������� �������������� ��������.
     *
     * @param string $str �����
     * @return boolean ���� ������������� �����
     */
	public function setPathToResultImage($str = '')
	{
		if (!is_dir($str))
			return false;
		else
		{ 
			$this->pathToResultImage = $str;
			return true;
		}
		
	}


	
	
	
/////////////////////////////////////////////////////////	
    /**
     * ���������� ��������-����������.
     * ��� ����������� � ��������� ���� �� ��������� ��������� ���������.
     * ��� ���������� ������ �������� ����� ��� ���������� - �������� ��������� �� �����
     *
     * @param string $name ��� ��������-����������
     * @return ���� �� �������� ��������� ������� ���� false
     */
	public function save($name = '')
	{
  		if (!$this->correct)
		{
		    return false;
		}
		if (!$name)
		{
		    $name = $this->imageInfoObject->getFileName();
		}
		$flag = false;
		// ���� ������� �����
		if ($this->pathToResultImage != '')
			switch($this->_imageType)
			{
				case IMAGETYPE_JPEG:
					if (imagejpeg($this->image, $this->pathToResultImage . '/' . $name . $this->_imageExtension
					           ,$this->quality))
					   $flag = $this->pathToResultImage.'/' . $name . $this->_imageExtension;
					break;
				case IMAGETYPE_GIF:
					if (imagegif($this->image, $this->pathToResultImage.'/'.$name. $this->_imageExtension))
					   $flag = $this->pathToResultImage . '/' . $name . $this->_imageExtension;
				break;
				case IMAGETYPE_PNG:
					if (imagepng($this->image, $this->pathToResultImage . '/' . $name . $this->_imageExtension))
					   $flag = $this->pathToResultImage . '/' . $name . $this->_imageExtension;
				break;
			}
		return $flag;
	}
	
	
	
    /**
     * ���������� ��������-���������� d ��������� ����.
     * ��� ����������� � ��������� ���� �� ��������� ��������� ���������.
     * ��� ���������� ������ �������� ����� ��� ���������� - �������� ��������� �� �����
     *
     * @param string $name ��� ��������-����������
     * @param string $type ���� ��: jpg, gif, png
     * @return ���� �� �������� ��������� ������� ���� false
     */
	public function saveToType($name = '', $type = 'jpg')
	{
		if (!in_array($type, array('jpg', 'gif', 'png')))
			throw new Dune_Exception_Base('������� �������� ��� ��������: ' . $type);
  		if (!$this->correct)
		{
		    return false;
		}
		if ($name === '')
		{
		    $name = $this->imageInfoObject->getFileName();
		}
		$flag = false;
		// ���� ������� �����
		if ($this->pathToResultImage != '')
			switch($type)
			{
				case 'jpg':
					if (imagejpeg($this->image, $this->pathToResultImage . '/' . $name . $this->_imageExtension
					           ,$this->quality))
					   $flag = $this->pathToResultImage.'/' . $name . $this->_imageExtension;
					break;
				case 'gif':
					if (imagegif($this->image, $this->pathToResultImage.'/'.$name. $this->_imageExtension))
					   $flag = $this->pathToResultImage . '/' . $name . $this->imageInfoObject->getExtension();
				break;
				case 'png':
					if (imagepng($this->image, $this->pathToResultImage . '/' . $name . $this->_imageExtension))
					   $flag = $this->pathToResultImage . '/' . $name . $this->_imageExtension;
				break;
			}
		return $flag;
	}
	
	
	/**
	 * ������� �������� � �������. ��������� � ��������� mine-���� ���� �������.
	 *
	 * @return boolean ���� ��������� ������ �������� � �������
	 */
	public function get()
	{
  		if (!$this->correct)
		{
		    return false;
		}
		$flag = true;

		header("Content-type: " . $this->_imageMimeType);
    	switch($this->_imageType)
		{
			case IMAGETYPE_JPEG:
				imagejpeg($this->image,"",$this->quality);				
			break;
			case IMAGETYPE_GIF:
				imagegif($this->image);
			break;
			case IMAGETYPE_PNG:
				imagepng($this->image);
			break;
			default:
				$flag = false;
		}
		return $flag;
	}
	
/////////////////////////////////////////////////////////
    /**
     * ��������� ������ ��������� ��������:
     * cut - ������ ��������
     * add - ����������� ��������� ��������� ������, ���� �� ���������
     *
     * @param string $str ���� ��: cut, add
     * @return boolean
     */
	public function setModeProportion($str = 'cut')
	{
		if (($str == 'cut') OR ($str == 'add'))
		{
			$this->modeProp = $str;
			return true;
		}
		else
			throw new Dune_Exception_Base('������� �������� �������� ��� ���������� ��������.');
	}

/////////////////////////////////////////////////////////
    /**
     * ��������� ��������� ��������.
     *
     * @param integer $width
     * @param integer $height
     * @return boolean
     */
	public function setProportions($width = 100, $height = 100)
	{
       $this->proportionWidth = $width;
       $this->proportionHeight = $height;	    
	}
	

/////////////////////////////////////////////////////////
    /**
     * ��������� ����� ���� ��������.
     *
     * @param integer $width
     * @param integer $height
     * @return boolean
     */
	public function setBackgroundColor($color)
	{
       $this->backgroundColor = $color;
	}
	
	
////////////////////////////////////////////////////////
    /**
     * ���������� ����� - ������� �������� ��� jpeg
     *
     * @return integer
     */
	public function getQuality(){
		$quality = null;
		if($this->_imageType == IMAGETYPE_JPEG)
		{
			$quality = $this->quality;
		}
		return $quality;
	}
////////////////////////////////////////////////////////
    /**
     * ������������� ������� �������� ��� jpeg
     *
     * @param integer $quality ����� >= 1 � <= 100
     */
	public function setQuality($quality)
	{
		if($quality > 100 || $quality  <  1)
		{
			$quality = 75;
        }
		if($this->_imageType == IMAGETYPE_JPEG)
		{
			$this->quality = $quality;
		}
	}
	
	/**
	 * ��������� �������� �������� �������� ����������.
	 * 
	 * @return boolean ���������� ��������
	 */
    public function changeProportion()
	{
		if (!$this->correct)
		{
		    return false;
		}
	    $good = false;

		$srcW = $this->_imageWidth;
		$srcH = $this->_imageHeight;
		//only adjust if larger than reduction size
		
		
		if($this->modeProp == 'cut')
		{
			$size = $this->calculateResultImageSizeCut();
		}
		else if($this->modeProp == 'add')
		{
			$size = $this->calculateResultImageSizeAdd();
		}			

					
		$coordinate = $this->calculateCoordinate($size['w'], $size['h']);
		
		$copy = imagecreatetruecolor($size['w'], $size['h']);
		imagefill($copy, 0, 0, $this->backgroundColor);
			
			// ������� �������� ������������ � ����������� �������� � ����� gif
			if ($this->_imageType == IMAGETYPE_GIF)
			{
                $background = imagecolorallocate($copy, 4, 2, 4);
                ImageColorTransparent($copy, $background);
                imagealphablending($copy, false);			
			}

		if($this->modeProp == 'cut')
		{
			if (imagecopyresampled($copy,
			                       $this->image,0,0,$coordinate['x'],$coordinate['y'],
			                       $size['w'], $size['h'], $size['w'], $size['h']))
		    {
			    $good = true;
			    //destroy original
			    imagedestroy($this->image);
			    $this->image = $copy;
			    $this->_imageWidth  = $size['w'];
			    $this->_imageHeight = $size['h'];
		    }
		}
		else 
		{
		    if ($size['w'] > $srcW)
		        $x = (int)round(($size['w'] - $srcW)/2);
            else 
                $x = 0;
		    if ($size['h'] > $srcH)
		        $y = (int)round(($size['h'] - $srcH)/2);
            else 
                $y = 0;
                
			if (imagecopyresampled($copy,
			                       $this->image,
			                       $x,$y,
			                       0,0,
			                       $srcW , $srcH,
			                       $srcW , $srcH))
		    {
			    $good = true;
			    //destroy original
			    imagedestroy($this->image);
			    $this->image = $copy;			
			    $this->_imageWidth  = $size['w'];
			    $this->_imageHeight = $size['h'];
		    }
		    
		}
		$this->correct = $good;
		return $good;
	}
	
////////////////////////////////////////////////////////
//private methods
////////////////////////////////////////////////////////

    protected function calculateResultImageSizeCut()
    {
		$srcW = $this->_imageWidth;
		$srcH = $this->_imageHeight;
		
		
        $propCorr = $this->proportionHeight / $this->proportionWidth;
        
        $resW = $srcW;
        $resH = round($resW * $propCorr);
        if ($resH > $srcH)
        {
            $corr = $resH / $srcH;
            $resW = round($resW / $corr);
            $resH = $srcH;
        }
        
        return array(
                     'w' => $resW,
                     'h' => $resH
                    );
    }

    protected function calculateResultImageSizeAdd()
    {
	
		$srcW = $this->_imageWidth;
		$srcH = $this->_imageHeight;
		
		
		
        $propCorr = $this->proportionHeight / $this->proportionWidth;
        
        $resW = $srcW;
        $resH = round($resW * $propCorr);
        if ($resH < $srcH)
        {
            $corr = $resH / $srcH;
            $resW = round($resW / $corr);
            $resH = $srcH;
        }
        
        return array(
                     'w' => $resW,
                     'h' => $resH
                    );
		
    }
    
    protected function calculateCoordinate($w, $h)
    {
		$srcW = $this->_imageWidth;
		$srcH = $this->_imageHeight;
		
        
        if ($w < $srcW)
            $x = (int)round(($srcW - $w)/2);
        else 
            $x = 0;
            
        if ($h < $srcH)
            $y = (int)round(($srcH - $h)/2);
        else 
            $y = 0;
        return array(
                     'x' => $x,
                     'y' => $y
                    );
           
    }    
}
//end class
////////////////////////////////////////////////////////