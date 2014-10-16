<?php
/**
 * Класс включает таблицы стилей в текст html
 * Используется в комплексе.
 * Сканирует папку -> генерирует код
 * 
 * Определён метод __toStrihg() - печатает. !!! Может вызвать исключение.
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: StylesSystem.php                            |
 * | В библиотеке: Dune/Build/StylesSystem.php         |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>        |
 * | Версия: 1.00                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * История версий:
 * -----------------
 * 
 * Версия 1.00 -> 1.01
 * 
 */

class Dune_Build_StylesSystem
{
    protected $dirName = '';
    protected $fullDirName = '';
    protected $stylesText = '';
    
    
    /**
     * Конструктор объекта
     * Принимает путь в папке styles к файлам css
     *
     * @param string $stylesPath
     */
    public function __construct($stylesRootPath = 'styles')
    {
        
        $this->dirName = $stylesRootPath . '/' . Dune_Parameters::$templateSpace . '/' . Dune_Parameters::$templateRealization;
        $this->fullDirName = $_SERVER['DOCUMENT_ROOT'] . '/' . $this->dirName;
    }
    /**
     * Возвращает строку для включения в текст html для включения таблиц стилей
     *
     * @return string
     */
    public function get()
    {
        $this->checkDirectory();
        $this->scanDirectory();
        return $this->stylesText;
    }
    
    
/////////////////////////////////////////////////////////////////////
//////////////////////////////      Приватные методы    

    // Проверяет существует ли директория с фалами стилей
    protected function checkDirectory()
    {
        if (!is_dir($this->fullDirName))
        {
            throw new Dune_Exception_Base('Указана неверная директория для подключения таблиц стилей: '.$this->dirName);
        }
    }
    // Сканирует указанную папку на наличие файлов
    // Возвращает строку с текстом для вставки в страницу html для включения css
    protected function scanDirectory()
    {
        $find_ie6 = false;
        $this->stylesText = '';
        $arr = scandir($this->fullDirName);
        foreach ($arr as $runArr)
        { 
            if (is_file($this->fullDirName.'/'.$runArr))
            {
                if (basename($runArr, '.css') == 'ie6')
                    $find_ie6 = true;
                else 
                    $this->stylesText .= '<link href="/'.$this->dirName.'/'.$runArr.'" rel="stylesheet" type="text/css" />';
            }
        }
        if ($find_ie6)
            $this->stylesText .= '<!--[if lt IE 7]><link href="/'.$this->dirName.'/ie6.css" rel="stylesheet" type="text/css" /><![endif]-->';
        return $this->stylesText;
    }
////////// Конец описания приватных методов
///////////////////////////////////////////////////////////////

    
    
//////////////////////////////////////////////////////////////////
///////////     Волшебные методы

    public function __toString()
    {
        $this->checkDirectory();
        $this->scanDirectory();
        return $this->stylesText;
    }

////////// Конец описания волшебных методов
///////////////////////////////////////////////////////////////
}