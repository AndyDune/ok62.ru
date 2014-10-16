<?php
/**
 * ����� ��� ��������� ������� ����� � ��������� 2-� ������.
 * ������ ����� ������� ������ ���� �����. �������.
 * 
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: TwoColors.php                               |
 * | � ����������: Dune/Form/TwoColors.php             |
 * | �����: ������ ����� (Dune) <dune@rznlf.ru>        |
 * | ������: 1.00                                      |
 * | ����: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * ������� ������:
 *
 * ������ 1.00 -> 1.01
 * 
 * 
 */
abstract class Dune_Captcha_Parent_Base
{
   
    protected $_captchaSizeX = 60;
    protected $_captchaSizeY = 20;

    protected $_image;

    protected $keyString;
    
    protected $_jpegQuality = 80;
    
    

    public function setJpegQuality($quality)
    {
        $this->_jpegQuality = $quality;
    }
    
    public function setSize($x = 150, $y = 50)
    {
        $this->_captchaSizeX = $x;
        $this->_captchaSizeY = $y;
    }
    
    public function getKeyString()
    {
        return $this->keyString;
    }
    
    public function get()
    {
        $this->_makeCaptcha();
        imagejpeg($this->_image, NULL, $this->_jpegQuality); 
        ImageDestroy($this->_image); 
    }
    
    public function getHeaders()
    {
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");  
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");  
        header("Cache-Control: no-store, no-cache, must-revalidate");  
        header("Cache-Control: post-check=0, pre-check=0", false); 
        header("Pragma: no-cache");  
        Header ('Content-type: image/jpeg');         
    }
    
    protected function _makeCaptcha()
    {
    }

}