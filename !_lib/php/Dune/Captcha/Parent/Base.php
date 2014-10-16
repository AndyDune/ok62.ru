<?php
/**
 * Класс для генерации простой капчи с символами 2-х цветов.
 * Ввести нужно символы только одно цвета. ЧЕРНОГО.
 * 
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: TwoColors.php                               |
 * | В библиотеке: Dune/Form/TwoColors.php             |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>        |
 * | Версия: 1.00                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * История версий:
 *
 * Версия 1.00 -> 1.01
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