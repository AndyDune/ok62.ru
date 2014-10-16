<?php
/**
 * Класс для генерации капчи с искажением.
 * Для генерации используется переработаный код KCAPTCHA PROJECT VERSION 1.2.6
 * 
 * Оригинальный код здесь: www.captcha.ru
 * 
 * !!! Используется переменная: Dune_Parameters::$fontsDirectory
 * 
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: MultiWave.php                               |
 * | В библиотеке: Dune/Form/MultiWave.php             |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 0.92                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * История версий:
 *
 * 0.92 (2009 май 5)
 * Используется для строк контейнер страндартных функций.
 * 
 * Версия 0.90 -> 0.91
 * Упорядочены приватные переменные
 * 
 * 
 */
class Dune_Captcha_MultiWave
{
    
    # show credits
    /**
     * @access private
     */
    protected $_showCredits = false; # set to false to remove credits line. Credits adds 12 pixels to image height
    
    /**
     * @access private
     */
    protected $_credits = 'www.rznw.ru'; # if empty, HTTP_HOST will be shown

    /**
     * @access private
     */
    protected $_stringLength;

    /**
     * @access private
     */
    protected $_colorForeground;
    
    /**
     * @access private
     */
    protected $_colorBackground;
    
    /**
     * @access private
     */
    protected $_captchaSizeX = 150;
    
    /**
     * @access private
     */
    protected $_captchaSizeY = 50;

    /**
     * @access private
     */
    protected $_image;

    /**
     * @access private
     */
    protected $keyString;

    /**
     * @access private
     */
    protected $_jpegQuality = 80;

    
        # symbols used to draw CAPTCHA
     //protected $_allowedSymbols = "0123456789"; #digits
     protected $_allowedSymbols = "23456789abcdeghkmnpqsuvxyz"; #alphabet without similar symbols (o=0, 1=l, i=j, t=f)
    

    /**
     * @access private
     */
    protected $_fontsFileArray = array();
    
    public function __construct()
    {
        $this->_stringLength = mt_rand(5,6); # random 5 or 6
        
        # CAPTCHA image colors (RGB, 0-255)
        //$foreground_color = array(0, 0, 0);
        //$background_color = array(220, 230, 255);
        $this->_colorForeground = array(mt_rand(0,100), mt_rand(0,100), mt_rand(0,100));
        $this->_colorBackground = array(mt_rand(200,255), mt_rand(200,255), mt_rand(200,255));
     
    }
    
    /**
     * Установка качетсва выводимой картинки jpg
     *
     * @param integer $quality
     */
    public function setJpegQuality($quality)
    {
        $this->_jpegQuality = $quality;
    }
    
    /**
     * Установка размера капчи
     * 
     * @param integer $x ширина
     * @param imteger $y высота
     */
    public function setSize($x = 150, $y = 50)
    {
        $this->_captchaSizeX = $x;
        $this->_captchaSizeY = $y;
    }

    /**
     * Установка подписи в картинку под капчёй
     *
     * @param string $credits имя домена
     */
    public function setCredits($credits = 'www.rznw.ru')
    {
        $this->_showCredits = true;
        $this->_credits = $credits;
    }
    
    
    /**
     * Узнать секретную стору для проверки капчи
     *
     * @return string
     */
    public function getKeyString()
    {
        return $this->keyString;
    }
    
    /**
     * Посыл заголовков браузеру
     *
     */
    public function getHeaders()
    {
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");  
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");  
        header("Cache-Control: no-store, no-cache, must-revalidate");  
        header("Cache-Control: post-check=0, pre-check=0", false); 
        header("Pragma: no-cache");  
        Header ('Content-type: image/jpeg');         
    }
    
    
    /**
     * Посыл картинки браузеру
     *
     */
    public function get()
    {
        $this->_setFontsFileArray();
        $this->_makeCaptcha();
        imagejpeg($this->_image, NULL, $this->_jpegQuality); 
        ImageDestroy($this->_image); 
    }
    
    
    /**
     * @access private
     */
    protected function _setFontsFileArray()
    {
		$fonts=array();

	    $array = scandir(Dune_Parameters::$fontsDirectory . '/multiwave');
		foreach ($array as $file) 
		{
			if (is_file(Dune_Parameters::$fontsDirectory . '/multiwave/' . $file))
			{
				$fonts[]= Dune_Parameters::$fontsDirectory . '/multiwave/' . $file;
			}
		}
        $this->_fontsFileArray = $fonts;
    }
    
    
    protected function _generateKeyString()
    {
			// generating random keystring
			$str = Dune_String_Factory::getStringContainer($this->_allowedSymbols);
			$len = $str->len() - 1;
			while(true)
			{
				$this->keyString = '';
				for($i=0; $i < $this->_stringLength; $i++){
					$this->keyString .= $this->_allowedSymbols[mt_rand(0, $len)];
				}
				if(!preg_match('/cp|cb|ck|c6|c9|rn|rm|mm|co|do|cl|db|qp|qb|dp|ww/', $this->keyString)) break;
			}
        
    }
    
    /**
     * @access private
     */
    protected function _makeCaptcha()
    {
        $alphabet = "0123456789abcdefghijklmnopqrstuvwxyz"; # do not change without changing font files!
        
        # symbols used to draw CAPTCHA
        //$allowed_symbols = "0123456789"; #digits
       // $allowed_symbols = "23456789abcdeghkmnpqsuvxyz"; #alphabet without similar symbols (o=0, 1=l, i=j, t=f)
        
        # CAPTCHA string length
        $length = $this->_stringLength;

        # CAPTCHA image size (you do not need to change it, whis parameters is optimal)
        $width  = $this->_captchaSizeX;
        $height = $this->_captchaSizeY;

        # show credits
        $show_credits   = $this->_showCredits;
        $credits        = $this->_credits;
        
        
        # symbol's vertical fluctuation amplitude divided by 2
        $fluctuation_amplitude = 5;
        
        # increase safety by prevention of spaces between symbols
        $no_spaces = true;
        
        $foreground_color = $this->_colorForeground;
        $background_color = $this->_colorBackground;
        
        
		$fonts = $this->_fontsFileArray;
	
		$str = Dune_String_Factory::getStringContainer($alphabet);
		$alphabet_length = $str->len();
		
    	$str = Dune_String_Factory::getStringContainer($this->_allowedSymbols);
		$len = $str->len() - 1;
		
		do{
			// generating random keystring
			while(true)
			{
				$this->keyString = '';
				for($i=0;$i<$length;$i++){
					$this->keyString .= $this->_allowedSymbols[mt_rand(0, $len)];
				}
				if(!preg_match('/cp|cb|ck|c6|c9|rn|rm|mm|co|do|cl|db|qp|qb|dp|ww/', $this->keyString)) break;
			}
		
			$font_file=$fonts[mt_rand(0, count($fonts)-1)];
			$font=imagecreatefrompng($font_file);
			imagealphablending($font, true);
			$fontfile_width=imagesx($font);
			$fontfile_height=imagesy($font)-1;
			$font_metrics=array();
			$symbol=0;
			$reading_symbol=false;

			// loading font
			for($i=0;$i<$fontfile_width && $symbol<$alphabet_length;$i++){
				$transparent = (imagecolorat($font, $i, 0) >> 24) == 127;

				if(!$reading_symbol && !$transparent){
					$font_metrics[$alphabet[$symbol]]=array('start'=>$i);
					$reading_symbol=true;
					continue;
				}

				if($reading_symbol && $transparent){
					$font_metrics[$alphabet[$symbol]]['end']=$i;
					$reading_symbol=false;
					$symbol++;
					continue;
				}
			}

			$img=imagecreatetruecolor($width, $height);
			imagealphablending($img, true);
			$white=imagecolorallocate($img, 255, 255, 255);
			$black=imagecolorallocate($img, 0, 0, 0);

			imagefilledrectangle($img, 0, 0, $width-1, $height-1, $white);

			// draw text
			$x=1;
			for($i=0;$i<$length;$i++){
				$m=$font_metrics[$this->keyString[$i]];

				$y=mt_rand(-$fluctuation_amplitude, $fluctuation_amplitude)+($height-$fontfile_height)/2+2;

				if($no_spaces){
					$shift=0;
					if($i>0){
						$shift=10000;
						for($sy=7;$sy<$fontfile_height-20;$sy+=1){
							for($sx=$m['start']-1;$sx<$m['end'];$sx+=1){
				        		$rgb=imagecolorat($font, $sx, $sy);
				        		$opacity=$rgb>>24;
								if($opacity<127){
									$left=$sx-$m['start']+$x;
									$py=$sy+$y;
									if($py>$height) break;
									for($px=min($left,$width-1);$px>$left-12 && $px>=0;$px-=1){
						        		$color=imagecolorat($img, $px, $py) & 0xff;
										if($color+$opacity<190){
											if($shift>$left-$px){
												$shift=$left-$px;
											}
											break;
										}
									}
									break;
								}
							}
						}
						if($shift==10000){
							$shift=mt_rand(4,6);
						}

					}
				}else{
					$shift=1;
				}
				imagecopy($img, $font, $x-$shift, $y, $m['start'], 1, $m['end']-$m['start'], $fontfile_height);
				$x+=$m['end']-$m['start']-$shift;
			}
		}while($x>=$width-10); // while not fit in canvas

		$center=$x/2;

		// credits. To remove, see configuration file
		$img2=imagecreatetruecolor($width, $height+($show_credits?12:0));
		$foreground=imagecolorallocate($img2, $foreground_color[0], $foreground_color[1], $foreground_color[2]);
		$background=imagecolorallocate($img2, $background_color[0], $background_color[1], $background_color[2]);
		imagefilledrectangle($img2, 0, 0, $width-1, $height-1, $background);		
		imagefilledrectangle($img2, 0, $height, $width-1, $height+12, $foreground);
		$credits=empty($credits)?$_SERVER['HTTP_HOST']:$credits;
		
		$str = Dune_String_Factory::getStringContainer($credits);
		imagestring($img2, 2, $width/2-imagefontwidth(2) * $str->len()/2, $height-2, $credits, $background);

		// periods
		$rand1=mt_rand(750000,1200000)/10000000;
		$rand2=mt_rand(750000,1200000)/10000000;
		$rand3=mt_rand(750000,1200000)/10000000;
		$rand4=mt_rand(750000,1200000)/10000000;
		// phases
		$rand5=mt_rand(0,31415926)/10000000;
		$rand6=mt_rand(0,31415926)/10000000;
		$rand7=mt_rand(0,31415926)/10000000;
		$rand8=mt_rand(0,31415926)/10000000;
		// amplitudes
		$rand9=mt_rand(330,420)/110;
		$rand10=mt_rand(330,450)/110;

		//wave distortion

		for($x=0;$x<$width;$x++){
			for($y=0;$y<$height;$y++){
				$sx=$x+(sin($x*$rand1+$rand5)+sin($y*$rand3+$rand6))*$rand9-$width/2+$center+1;
				$sy=$y+(sin($x*$rand2+$rand7)+sin($y*$rand4+$rand8))*$rand10;

				if($sx<0 || $sy<0 || $sx>=$width-1 || $sy>=$height-1){
					continue;
				}else{
					$color=imagecolorat($img, $sx, $sy) & 0xFF;
					$color_x=imagecolorat($img, $sx+1, $sy) & 0xFF;
					$color_y=imagecolorat($img, $sx, $sy+1) & 0xFF;
					$color_xy=imagecolorat($img, $sx+1, $sy+1) & 0xFF;
				}

				if($color==255 && $color_x==255 && $color_y==255 && $color_xy==255){
					continue;
				}else if($color==0 && $color_x==0 && $color_y==0 && $color_xy==0){
					$newred=$foreground_color[0];
					$newgreen=$foreground_color[1];
					$newblue=$foreground_color[2];
				}else{
					$frsx=$sx-floor($sx);
					$frsy=$sy-floor($sy);
					$frsx1=1-$frsx;
					$frsy1=1-$frsy;

					$newcolor=(
						$color*$frsx1*$frsy1+
						$color_x*$frsx*$frsy1+
						$color_y*$frsx1*$frsy+
						$color_xy*$frsx*$frsy);

					if($newcolor>255) $newcolor=255;
					$newcolor=$newcolor/255;
					$newcolor0=1-$newcolor;

					$newred=$newcolor0*$foreground_color[0]+$newcolor*$background_color[0];
					$newgreen=$newcolor0*$foreground_color[1]+$newcolor*$background_color[1];
					$newblue=$newcolor0*$foreground_color[2]+$newcolor*$background_color[2];
				}

				imagesetpixel($img2, $x, $y, imagecolorallocate($img2, $newred, $newgreen, $newblue));
			}
		}
        $this->_image = $img2;		
	}

}