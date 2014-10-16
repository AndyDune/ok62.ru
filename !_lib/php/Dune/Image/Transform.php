<?php
/**
 * Класс изменения пропорций картинок gif, jpg, png до указанного.
 * Лишнее отрубается либо добавляется фоновое.
 * 
 * И для изменения размера картинки, подобно классу Dune_Image_Thumbnail
 * 
 * Наследует классу Dune_Image_Proportion
 *  
 * Искодные данные (картинка) принимается в объекте Dune_Image_Info
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Transform.php                               |
 * | В библиотеке: Dune/Image/Transform.php            |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.02                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 *  1.02 (2009 яеварь 23)
 *  Реализованы цепочки методов
 * 
 *  1.01 (2008 ноябрь 29) Для картинки источника типа gif используется для изменения функция imagecopyresized()
 * 
 */



/* 
    $img = new Dune_Image_Info(dirname(__FILE__) . '/res.jpg');
    if ($img->isCorrect())
        echo 'Файл есть';
      echo 11;
    $tumb = new Dune_Image_Transform($img);
    $tumb->setProportions(5, 10);
    //$tumb->setModeProportion('add');
    $tumb->setBackgroundColor(0x00aa44);
    $tumb->changeProportion();
    $tumb->createThumb(400);
    $tumb->setPathToResultImage(dirname(__FILE__));
    $tumb->save('res1');
*/


class Dune_Image_Transform extends Dune_Image_Proportion
{
	
    
    /**
     * Enter description here...
     *
     * @var unknown_type
     * @access private;
     */
	protected $modeThumb = 'both'; // Контроль размера картинки
							// height - по высоте
							// width - по ширине
							
    /**
     * Установка режима уменьшения картинки:
     * both - учитываются ширина и высота
     * width - учитывается только ширина
     * height - учитывается только высота
     *
     * @param string $str одно из: both, height, width
     * @return boolean
     */
	public function setModeThumb($str = 'both')
	{
		if (($str == 'both') OR ($str == 'height') OR ($str == 'width'))
		{
			$this->mode = $str;
//			return true;
		}
		else
			throw new Dune_Exception_Base('Передан неверный параметр для уменьшения картинки.');
	    return $this;
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
		
		$srcW = $this->_imageWidth;
		$srcH = $this->_imageHeight;
		
		//only adjust if larger than reduction size
		if(($this->modeThumb == 'both') AND (($srcW >$max_size) OR ($srcH > $max_size)))
		{
			$reduction = $this->calculateReduction($max_size);
		}
		else if(($this->modeThumb == 'height') AND ($srcH > $max_size))
		{
			$reduction = $this->calculateReductionH($max_size);
		}			
		else if(($this->modeThumb == 'width') AND ($srcW > $max_size))
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
			if ($this->_imageType == IMAGETYPE_GIF)
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
   			     $this->_imageWidth  = $desW;
 			     $this->_imageHeight = $desH;

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
	protected function calculateReduction($thumbnailsize)
	{
		//adjust
		$srcW = $this->_imageWidth;
		$srcH = $this->_imageHeight;
		
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
	protected function calculateReductionW($thumbnailsize)
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
	protected function calculateReductionH($thumbnailsize)
	{
		//adjust
  		return $this->imageInfoObject->getHeight() / $thumbnailsize;
	}
	
}
//end class
////////////////////////////////////////////////////////