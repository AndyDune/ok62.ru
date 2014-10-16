<?php
/**
 * Анализ папки с картинками и создание уменьшенных копий картинок в подпапке.
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Preview.php                                 |
 * | В библиотеке: Dune/Image/Preview.php              |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>        |
 * | Версия: 0.93                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * 
 * Версия 0.92 -> 0.93 Бета-версия
 * Выбор формата результирующего массива.
 * На один вариант размера картинок и на несколько. По умолчанию на один.
 * 
 * 
 * Версия 0.91 -> 0.92 Бета-версия
 * Добавлены выборка ряда превью.
 * 
 */

class Dune_Image_Preview
{
    protected $_previewFolder = '_preview';
    protected $_previewFolderFull;
    protected $_previewFolderDisplay;
    
    protected $_previewSize = array(1 => 100);
    protected $_previewSizeCount = 1;
    
    protected $_sourseFolder;
    protected $_sourseFolderFull;
    protected $_sourseFolderDisplay;
    
    protected $_haveDir = false;
    
    protected $_sourseFilesList = array();
    protected $_sourseFilesCount = false;

    protected $_sourseFolderList = array();
    protected $_sourseFolderCount = false;
    
    protected $_notHaveSourse = true;
    
    protected $_resultArray = array();
    
    
    
    protected $_currentResultSize = 0;
    
    
    /**
     * Значение директивы на возврат массива в формате с одним превью размером.
     */
    const RESULT_SIZE_ONE = 0;
    
    /**
     * Значение директивы на возврат массива в формате с несколькими превью размерами.
     */
    const RESULT_SIZE_MULTI = 1;
    
    /**
     * Принимает путь к папке с группой картинок. Проверяет на существование.
     * Путь к папке указать от корня сайта. !!! Не от корня сервера.
     * Слеши в начале строки удаляются.
     *
     * @param string $path путь к папке от корня сайта.
     */
    public function __construct($path)
    {
        if (($path[0] == '/') or ($path[0] == '\\'))
        {
            $path = substr($path, 1);
        }
        $this->_sourseFolder = $path;
        $this->_sourseFolderFull = $_SERVER['DOCUMENT_ROOT'] . '/' . $path;
        $this->_sourseFolderDisplay = '/' . $path;
        if (is_dir($this->_sourseFolderFull))
        {
            $this->_haveDir = true;
            $this->_previewFolderFull = $this->_sourseFolderFull . '/' . $this->_previewFolder;
            $this->_previewFolderDisplay = $this->_sourseFolderDisplay . '/' . $this->_previewFolder;
            if (!is_dir($this->_previewFolderFull))
            {
                if (!mkdir($this->_previewFolderFull, 0777))
                    throw new Dune_Exception_Base('Не удалось создать папку превью, при существующей основной папки.');
            }
        }
    }

	/**
	 * Установить размер превью картинок для создания.
	 * Превью вариантов может быть несколько. Для этого вызвать функцию несколько раз, указав разные значения.
	 *
	 * @param integer $size размер картинок группы
	 */
    public function setPreviewSize($size)
    {
        $this->_previewSize[$this->_previewSizeCount] = $size;
        $this->_previewSizeCount++;
    }
	
    
    /**
     * Установка формата результирующего массива.
     * Используются константы класса:
     * RESULT_SIZE_ONE - только один размер, первый установленный. Установлен по умолчанию.
     * Формат:
     *  array = (
     * 			'sourse'  => путь к файлу-оригиналу. Готов для вставки на страницу.
     * 			'preview' => путь к картинке-превью размера, установленного первым
     *  		)
     * 
     * RESULT_SIZE_MULTI - несколько размеров. Все из установленного ряда.
     * Формат возвращаемого массива:
     * array = (
     * 			'sourse'  => путь к файлу-оригиналу. Готов для вставки на страницу.
     * 			'preview' => array(
     * 								<размер 1> => путь к картинке-превью размера, установленного первым
     *  							<размер 2> => путь к картинке-превью размера, установленного вторым
     * 								...
     * 							  )
     * 		   )

     * 
     * @param integer $format
     */
    
    public function setResultFormat($format)
    {
        $this->_currentResultSize = (int)$format;
    }
    
    /**
     * Очистить папку превью картинок (удалить все файлы). Структура папок сохраняется 
     *
     */
    public function clear()
    {
        $dir = new Dune_Directory_Delete($this->_previewFolderFull);
        $dir->deleteFiles();
    }
    
    /**
     * Удвалить папку превью-катинок полностью.
     *
     */
    public function delete()
    {
        $dir = new Dune_Directory_Delete($this->_previewFolderFull);
        $dir->deleteContent();
    }
    
    
    /**
     * Возвращает число файлов в рассматриваемой папке.
     *
     * @return integer число файлов в пакпке
     */
    public function sourseCount()
    {
    	$this->_getSourse();
        return $this->_sourseFilesCount;
    }
    
    /**
     * Выборка ряда превью для одной картинки.
     * Формат возвращаемого массива:
     * array = (
     * 			'sourse'  => путь к файлу-оригиналу. Готов для вставки на страницу.
     * 			'preview' => array(
     * 								<размер 1> => путь к картинке-превью размера, установленного первым
     *  							<размер 2> => путь к картинке-превью размера, установленного вторым
     * 								...
     * 							  )
     * 		   )
     *
     * @param integer $number номер картинки в папке,начиная с 0(нуля) отсортировано по алфавиту.
     * @return array массив спец. формата
     */
    public function getOne($number = 0)
    {
        $array = array();
        $this->_getSourse();
        if ($this->_sourseFilesCount)
        {
            if (!isset($this->_sourseFilesList[$number]))
                $number = 0;
            if ($this->_makeOnePreview($number))
                $array = $this->_resultArray[$number];
        }
        return $array;
    }
    
    
    
    /**
     * Выборка всего ряда превью картинок вместе с оригиналом. 
     * Возвращается как массив элементы которого являются массивами формата:
     * array = (
     * 			'sourse'  => путь к файлу-оригиналу. Готов для вставки на страницу.
     * 			'preview' => array(
     * 								<размер 1> => путь к картинке-превью размера, установленного первым
     *  							<размер 2> => путь к картинке-превью размера, установленного вторым
     * 								...
     * 							  )
     * 		   )
     * 
     * @return array
     */
    public function getAll()
    {
    	$this->_getSourse();
    	foreach ($this->_sourseFilesList as $key => $value)
    	{
            $this->_makeOnePreview($key);
    	}
    	return $array = $this->_resultArray;
    }
    
    protected function _makeOnePreview($number)
    {
        $good = false;
        if ($this->_currentResultSize == 0)
            $result = $this->_makeOneOnly($number);
        else 
            $result = $this->_makeOneMulti($number);
        if ($result !== false)
        {
            $this->_resultArray[$number] = $result;
            $good = true;
        }
        return $good;
    }
    
   
   /**
    * Возвращает массив с сылками на превью-картинки одной, указанной картинки-источника.
    *
    * @param integer $number порядковый номер картинки в массиве-источнике.
    * @return mixed
    * 
    * @access private
    */
   
    protected function _makeOneMulti($number)
    {
        $good = true;
        $array['sourse'] =  $this->_sourseFolderDisplay . '/' . $this->_sourseFilesList[$number];
        $array['preview'] = array();
        foreach ($this->_previewSize as $key => $value)
        {
            $sizeFolder = $this->_previewFolderFull . '/' . $value;
            $pathDisplay = $this->_previewFolderDisplay . '/'  . $value . '/' . $this->_sourseFilesList[$number];
            if (!is_dir($sizeFolder))
                $good = mkdir($sizeFolder);
            if ($good)
            {
                $file = $sizeFolder . '/' . $this->_sourseFilesList[$number];
                if (is_file($file))
                {
                    $array['preview'][$value] = $pathDisplay;
                }
                else 
                {
    				$original_pic = new Dune_Image_Info($this->_sourseFolderFull . '/' . $this->_sourseFilesList[$number]);
    				if ($original_pic->isCorrect())
    				{
    					$thumbPic = new Dune_Image_Thumbnail($original_pic);
    					$thumbPic->setPathToResultImage($sizeFolder);
    					$thumbPic->createThumb($value);
    					if (!$thumbPic->save($original_pic->getFileName()))
    					{
    					    $good = false;
    					}
    					else 
    					{
    					    $array['preview'][$value] = $pathDisplay;
    					}
                        
                    }
                    else 
                        $good = false;
                }
            }
            if (!$good)
                break;                
        }
        if ($good)
            $good = $array;
        return $good;
    }
    
    

    
   /**
    * Возвращает массив, при успехе создания превью размера, указанного первым.
    *
    * @param integer $number порядковый номер картинки в массиве-источнике.
    * @return mixed
    * 
    * @access private
    */
    protected function _makeOneOnly($number)
    {
        $good = true;
        $array['sourse'] =  $this->_sourseFolderDisplay . '/' . $this->_sourseFilesList[$number];
        $array['preview'] = '';
        
        $value = $this->_previewSize[1];
            
        $sizeFolder = $this->_previewFolderFull . '/' . $value;
        $pathDisplay = $this->_previewFolderDisplay . '/'  . $value . '/' . $this->_sourseFilesList[$number];
        if (!is_dir($sizeFolder))
            $good = mkdir($sizeFolder);
        if ($good)
        {
            $file = $sizeFolder . '/' . $this->_sourseFilesList[$number];
            if (is_file($file))
            {
                $array['preview'] = $pathDisplay;
            }
            else 
            {
    		    $original_pic = new Dune_Image_Info($this->_sourseFolderFull . '/' . $this->_sourseFilesList[$number]);
    		    if ($original_pic->isCorrect())
    			{
    				$thumbPic = new Dune_Image_Thumbnail($original_pic);
    				$thumbPic->setPathToResultImage($sizeFolder);
    				$thumbPic->createThumb($value);
    				if (!$thumbPic->save($original_pic->getFileName()))
    				{
    				    $good = false;
    				}
    				else 
    				{
    				    $array['preview'] = $pathDisplay;
    				}
                       
                 }
                 else 
                     $good = false;
            }
        }
        if ($good)
            $good = $array;
        return $good;
    }
    
    protected function _getSourse()
    {
        if ($this->_notHaveSourse)
        {
            $dir = new Dune_Directory_List($this->_sourseFolderFull);
            $this->_sourseFilesList = $dir->getListFiles();
            $this->_sourseFilesCount = $dir->getCountFiles();
        
            $this->_sourseFolderList = $dir->getListDir();
            $this->_sourseFilesCount = count($this->_sourseFolderList);
            $this->_notHaveSourse = false;
        }
    }
}