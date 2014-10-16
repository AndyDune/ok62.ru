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
class Dune_Captcha_TwoColors extends Dune_Captcha_Parent_Base
{

    protected $_backGroundImage = "captcha.jpg";
    
    protected $_keyStringX = 0;
    protected $_keyStringY = 0;
    
    public function __construct()
    {
        
    }

    
    public function setKeyStringPosition($x = 0, $y = 0)
    {
        $this->_keyStringX = $x;
        $this->_keyStringY = $y;
    }

    
    public function setBackGroundImage($image)
    {
        $this->_backGroundImage = $image;
    }
    
    
    protected function _makeCaptcha()
    {
        $im = @imagecreatefromjpeg($this->_backGroundImage);  
        if (!$im)
        {
            /* проверить, удачно ли */
            $im= imagecreate ($this->_captchaSizeX, $this->_captchaSizeY); /* создать пустое изображение */        
            imagefill($im, 0, 0, 0);
        }
        $white = ImageColorAllocate ($im, 255, 255, 255);         
        
/*
        $black_a = array(mt_rand(0,100), mt_rand(0,100), mt_rand(0,100));
        $red_a = array(mt_rand(200,255), mt_rand(200,255), mt_rand(200,255));
        $black = ImageColorAllocate ($im, $black_a[0], $black_a[1], $black_a[2]); 
        $red = ImageColorAllocate ($im, $red_a[0], $red_a[1], $red_a[2]);
*/
        $black = ImageColorAllocate ($im, 0, 0, 0); 
        $red = ImageColorAllocate ($im, 255, 0, 0);
        
        $fomt = mt_rand(3, 5);
        
        $rand = $this->_generateRandom(3); 
        $this->keyString = $rand; 
        ImageString($im, $fomt, $this->_keyStringX, $this->_keyStringY, $rand[0]." ".$rand[1]." ".$rand[2]." ", $black); 
        $rand = $this->_generateRandom(3); 
        ImageString($im, $fomt, $this->_keyStringX, $this->_keyStringY, " ".$rand[0]." ".$rand[1]." ".$rand[2], $red); 
        
        $this->_image = $im;
    }
    
    
    protected function _generateRandom($length=6) 
    { 
        $_rand_src = array( 
            array(48,57) //digits 
            , array(97,122) //lowercase chars 
    //        , array(65,90) //appercase chars 
        ); 
        srand ((double) microtime() * 1000000); 
        $random_string = ""; 
        for($i=0;$i<$length;$i++){ 
            $i1=rand(0,sizeof($_rand_src)-1); 
            $random_string .= chr(rand($_rand_src[$i1][0],$_rand_src[$i1][1])); 
        } 
        return $random_string; 
    } 
}