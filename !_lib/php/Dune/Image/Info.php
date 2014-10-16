<?php
/**
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Info.php                                    |
 * | В библиотеке: Dune/Image/Info.php                 |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.00                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * 1.00 (2008 декабрь 05)
 * Отсечение имени файла правильно (имя может содержать точки)
 * 
 * Версия 0.99 -> 0.99a
 * Поставлена заглушка для выборки свойства:
 * $this->fileArray['filename'] = substr($this->fileArray['basename'], 0, strpos($this->fileArray['basename'], '.') + 1) ;
 * Для php ниже 5.20
 * 
 * Версия 0.98 -> 0.99
 * Введена переменная $extensionNoDot - расширение без точки.
 * Была ошибка с выводом расширения временного файла - устранено.
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
     * расширение с точкой
     *
     * @var string
     * @access private
     */
    protected $extension;
    
    /**
     * расширение без точки
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
     * Mine-Type файла
     *
     * Возможные значения
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
		    ///			Для php ниже 5.20
		    if (phpversion() < '5.2')
		    {
		    	$this->fileArray['filename'] = substr($this->fileArray['basename'], 0, strrpos($this->fileArray['basename'], '.')) ;
		    }
		    
    		$this->fileSize = filesize($file);
/*Возвращает массив из 4 элементов.
Индекс 0 содержит ширину/width изображения в пикселах.
Индекс 1 содержит высоту/height.
Индекс 2 это флаг, указывающий тип изображения.1 = GIF, 2 = JPG, 3 = PNG, 4 = SWF, 5 = PSD, 6 = BMP, 7 = TIFF(байтовый порядок intel), 8 = TIFF(байтовый порядок motorola), 9 = JPC, 10 = JP2, 11 = JPX.
Индекс 3 это текстовая строка с корректной строкой height="yyy" width="xxx", которая может использоваться непосредственно в тэге IMG.    		
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
     * Возвращает флаг существования файла
     *
     * @return boolean
     */
    public function isExist()
    {
        return $this->existence;
    }
    
    /**
     * Возвращает флаг клрректности файла
     * Файл корректен, если является картинкой
     * 
     * @return boolean
     */
    public function isCorrect()
    {
        return $this->correctness;
    }
    
    /**
     * Возвращает ширину картинки
     *
     * @return integer
     */
    public function getWidth()
    {
        return $this->imageProperties[0];
    }
    
    /**
     * Возвращает высоту картинки
     *
     * @return integer
     */
    public function getHeight()
    {
        return $this->imageProperties[1];
    }
    
    /**
     * Возвращает размер файла
     *
     * @return integer
     */
    public function getFileSize()
    {
        return $this->fileSize;
    }
    
    /**
     * Возвращает mine-type картики
     *
     * @return string
     */
    public function getMimeType()
    {
        return $this->imageProperties['mime'];
    }
    
    /**
     * Возвращает расширение файла картики. C точкой по умолчанию.
     * Если передать $dot = false - без точки
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
     * Возвращает имя файла без разширения
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
     * Возвращает имя файла с разширением
     *
     * @return string
     */
    public function getBaseName()
    {
        return $this->fileArray['basename'];
    }
    
    /**
     * Возвращает имя директории
     *
     * @return string
     */
    public function getDirName()
    {
        return $this->fileArray['dirname'];
    }
    
    /**
     * Возвращает тип картинки
     *
     * @return string
     */
    public function getType()
    {
        return $this->imageProperties[2];
    }
    
    /**
     * Возвращает полный путь к файлу
     *
     * @return string
     */
    public function getPath()
    {
        return $this->fullPath;
    }
    
}