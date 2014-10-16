<?php
/**
 * Класс меньшения размеров картинок gif, jpg, png до указанного
 * 
 * Искодные данные (картинка) принимается в объекте Dune_Image_Info
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Thumbnail.php                               |
 * | В библиотеке: Dune/Image/Thumbnail.php            |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.01                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 *  1.01 (2008 ноябрь 29) Для картинки источника типа gif используется для изменения функция imagecopyresized()
 * 
 * Версия 0.99 -> 1.00
 * Новый метод: saveToType()
 * 
 * 
 * 
 */
class Dune_Image_Thumbnail
{
    /**
     * Enter description here...
     *
     * @var unknown_type
     * @access private;
     */
	private $image;
	
    /**
     * Enter description here...
     *
     * @var unknown_type
     * @access private;
     */
	private $quality = 80;
	
    /**
     * Enter description here...
     *
     * @var unknown_type
     * @access private;
     */
	private $imageInfoObject;
	
    /**
     * Enter description here...
     *
     * @var unknown_type
     * @access private;
     */
	private $correct = false;

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
	protected $mode = 'both'; // Контроль размера картинки
							// height - по высоте
							// width - по ширине
							
////////////////////////////////////////////////////////
//constructor
////////////////////////////////////////////////////////
	public function __construct(Dune_Image_Info $object)
	{
		$this->imageInfoObject = $object;
		if ($this->imageInfoObject->isCorrect())
		{
    		switch($this->imageInfoObject->getType())
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
     * Установка папки для сохранения результирующей картинки.
     *
     * @param string $str папка
     * @return boolean флаг существования папки
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
     * Сохранение картинки-результата.
     * Имя указывается в параметре либо по умолчанию идентично источнику.
     * При отсутвтвии явного указания папки для сохранения - картинка сохранена не будет
     *
     * @param string $name имя картинки-результата
     * @return путь по которому сохранена картика либо false
     */
	public function save($name = '')
	{
  		if (!$this->correct)
		{
		    return false;
		}
		if ($name === '')
		{
		    $name = $this->imageInfoObject->getFileName();
		}
		$flag = false;
		// Исли указана папка
		if ($this->pathToResultImage != '')
			switch($this->imageInfoObject->getType())
			{
				case IMAGETYPE_JPEG:
					if (imagejpeg($this->image, $this->pathToResultImage . '/' . $name . $this->imageInfoObject->getExtension()
					           ,$this->quality))
					   $flag = $this->pathToResultImage.'/' . $name . $this->imageInfoObject->getExtension();
					break;
				case IMAGETYPE_GIF:
					if (imagegif($this->image, $this->pathToResultImage.'/'.$name. $this->imageInfoObject->getExtension()))
					   $flag = $this->pathToResultImage . '/' . $name . $this->imageInfoObject->getExtension();
				break;
				case IMAGETYPE_PNG:
					if (imagepng($this->image, $this->pathToResultImage . '/' . $name . $this->imageInfoObject->getExtension()))
					   $flag = $this->pathToResultImage . '/' . $name . $this->imageInfoObject->getExtension();
				break;
			}
		return $flag;
	}

    /**
     * Сохранение картинки-результата.
     * Имя указывается в параметре либо по умолчанию идентично источнику.
     * При отсутвтвии явного указания папки для сохранения - картинка сохранена не будет
     *
     * @param string $name имя картинки-результата
     * @return путь по которому сохранена картика либо false
     */
	public function saveToType($name = '', $type = 'jpg')
	{
  		if (!$this->correct)
		{
		    return false;
		}
		if ($name === '')
		{
		    $name = $this->imageInfoObject->getFileName();
		}
		$flag = false;
		// Исли указана папка
		if ($this->pathToResultImage != '')
			switch($type)
			{
				case 'jpg':
					if (imagejpeg($this->image, $this->pathToResultImage . '/' . $name . $this->imageInfoObject->getExtension()
					           ,$this->quality))
					   $flag = $this->pathToResultImage.'/' . $name . $this->imageInfoObject->getExtension();
					break;
				case 'gif':
					if (imagegif($this->image, $this->pathToResultImage.'/'.$name. $this->imageInfoObject->getExtension()))
					   $flag = $this->pathToResultImage . '/' . $name . $this->imageInfoObject->getExtension();
				break;
				case 'png':
					if (imagepng($this->image, $this->pathToResultImage . '/' . $name . $this->imageInfoObject->getExtension()))
					   $flag = $this->pathToResultImage . '/' . $name . $this->imageInfoObject->getExtension();
				break;
			}
		return $flag;
	}
	
	
	/**
	 * Выводит картинку в браузер. Заголовок с указанием mine-типа тоже выводит.
	 *
	 * @return boolean флаг успешного вывода картинки в браузер
	 */
	public function get()
	{
  		if (!$this->correct)
		{
		    return false;
		}
		$flag = true;

		header("Content-type: " . $this->imageInfoObject->getMimeType());
    	switch($this->imageInfoObject->getType())
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
     * Установка режима уменьшения картинки:
     * both - учитываются ширина и высота
     * width - учитывается только ширина
     * height - учитывается только высота
     *
     * @param string $str одно из: both, height, width
     * @return boolean
     */
	public function setMode($str = 'both')
	{
		if (($str == 'both') OR ($str == 'height') OR ($str == 'width'))
		{
			$this->mode = $str;
			return true;
		}
		else
			throw new Dune_Exception_Base('Передан неверный параметр для уменьшения картинки.');
	}

////////////////////////////////////////////////////////
    /**
     * Возвращает цифру - уровень качества для jpeg
     *
     * @return integer
     */
	public function getQuality(){
		$quality = null;
		if($this->imageInfoObject->getType() == IMAGETYPE_JPEG)
		{
			$quality = $this->quality;
		}
		return $quality;
	}
////////////////////////////////////////////////////////
    /**
     * Устанавливает уровень качества для jpeg
     *
     * @param integer $quality цифра >= 1 и <= 100
     */
	public function setQuality($quality)
	{
		if($quality > 100 || $quality  <  1)
		{
			$quality = 75;
        }
		if($this->imageInfoObject->getType() == IMAGETYPE_JPEG)
		{
			$this->quality = $quality;
		}
	}
	
	/**
	 * Уменьшения картинки до указанного размера с указанным ранее режимом.
	 * Редим по умолчанию - both (по обеим сторонам).
	 * 
	 * @param integer $max_size максимально допустимый размер
	 * @return boolean успешность операции
	 */
    public function createThumb($max_size = 150)
	{
		if (!$this->correct)
		{
		    return false;
		}
	    $good = false;

		$srcW = $this->imageInfoObject->getWidth();
		$srcH = $this->imageInfoObject->getHeight();
		//only adjust if larger than reduction size
		if(($this->mode == 'both') AND (($srcW >$max_size) OR ($srcH > $max_size)))
		{
			$reduction = $this->calculateReduction($max_size);
		}
		else if(($this->mode == 'height') AND ($srcH > $max_size))
		{
			$reduction = $this->calculateReductionH($max_size);
		}			
		else if(($this->mode == 'width') AND ($srcW > $max_size))
		{
			$reduction = $this->calculateReductionW($max_size);
		}	
		else 		
			$reduction = 1;
		
		if ($reduction > 1)
		{
			//get proportions
  		    $desW = ceil($srcW / $reduction);
  		    $desH = ceil($srcH / $reduction);		
			$copy = imagecreatetruecolor($desW, $desH);			
			
			// Попытка внедрить прозрачность в уменьшаемые картинки в стиле gif
			if ($this->imageInfoObject->getType() == IMAGETYPE_GIF)
			{
//                $background = imagecolorallocate($copy, 4, 2, 4);
//                ImageColorTransparent($copy, $background);
//                imagealphablending($copy, false);			
                $res = imagecopyresized($copy,$this->image,0,0,0,0,$desW, $desH, $srcW, $srcH);
			}
			else 
			     $res = imagecopyresampled($copy,$this->image,0,0,0,0,$desW, $desH, $srcW, $srcH);
			
			if ($res)
			{
				 $good = true;
			     //destroy original
			     imagedestroy($this->image);
			     $this->image = $copy;			
			}
		}
		else 
		  $good = true;
		  
		$this->correct = $good;
		return $good;
	}
	
////////////////////////////////////////////////////////
//private methods
////////////////////////////////////////////////////////
    /**
     * Enter description here...
     *
     * @param integer $thumbnailsize
     * @return unknown
     * @access private
     */
	private function calculateReduction($thumbnailsize)
	{
		//adjust
		$srcW = $this->imageInfoObject->getWidth();
		$srcH = $this->imageInfoObject->getHeight();
      	if($srcW < $srcH)
      	{
      		$reduction = $srcH / $thumbnailsize;
      	}
      	else
      	{  			
      		$reduction = $srcW / $thumbnailsize;
      	}
        return $reduction;
	}
	
    /**
     * Enter description here...
     *
     * @param integer $thumbnailsize
     * @return unknown
     * @access private
     */
	private function calculateReductionW($thumbnailsize)
	{
		//adjust
  		return $this->imageInfoObject->getWidth() / $thumbnailsize;
	}
	
    /**
     * Enter description here...
     *
     * @param integer $thumbnailsize
     * @return unknown
     * @access private
     */
	private function calculateReductionH($thumbnailsize)
	{
		//adjust
  		return $this->imageInfoObject->getHeight() / $thumbnailsize;
	}
	
}
//end class
////////////////////////////////////////////////////////