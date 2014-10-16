<?php
/**
 * ����� ��������� ��������� �������� gif, jpg, png �� ����������.
 * ������ ���������� ���� ����������� �������.
 * 
 * � ��� ��������� ������� ��������, ������� ������ Dune_Image_Thumbnail
 * 
 * ��������� ������ Dune_Image_Proportion
 *  
 * �������� ������ (��������) ����������� � ������� Dune_Image_Info
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Transform.php                               |
 * | � ����������: Dune/Image/Transform.php            |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 1.02                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 *  1.02 (2009 ������ 23)
 *  ����������� ������� �������
 * 
 *  1.01 (2008 ������ 29) ��� �������� ��������� ���� gif ������������ ��� ��������� ������� imagecopyresized()
 * 
 */



/* 
    $img = new Dune_Image_Info(dirname(__FILE__) . '/res.jpg');
    if ($img->isCorrect())
        echo '���� ����';
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
	protected $modeThumb = 'both'; // �������� ������� ��������
							// height - �� ������
							// width - �� ������
							
    /**
     * ��������� ������ ���������� ��������:
     * both - ����������� ������ � ������
     * width - ����������� ������ ������
     * height - ����������� ������ ������
     *
     * @param string $str ���� ��: both, height, width
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
			throw new Dune_Exception_Base('������� �������� �������� ��� ���������� ��������.');
	    return $this;
	}


	/**
	 * ���������� �������� �� ���������� ������� � ��������� ����� �������.
	 * ����� �� ��������� - both (�� ����� ��������).
	 * 
	 * @param integer $max_size ����������� ���������� ������
	 * @return boolean ���������� ��������
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
			
			// ������� �������� ������������ � ����������� �������� � ����� gif
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