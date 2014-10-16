<?php
/**
 * Класс включает таблицы стилей в текст html
 * Сканирует папку -> генерирует код
 * 
 * Определён метод __toStrihg() - печатает. !!! Может вызвать исключение.
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Styles.php                                  |
 * | В библиотеке: Dune/Build/Styles.php               |
 * | Автор: Андрей Рыжов (Dune) <dune@pochta.ru>       |
 * | Версия: 1.03                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * История версий:
 * -----------------
 * 
 *  Версия 1.02 -> 1.03
 *  Файл по имени ie6.css в директории присоединяется с фильтром только для ie версии менее 7
 * 
 * Версия 1.01 -> 1.02
 * Переименовал метод getStyles -> get
 * Исключение Dune_Exception_Base
 * 
 * Версия 1.00 -> 1.01
 * Убрано лишнее. Конструктор принимает путь к папке с файлами css в папке styles
 * Добавлена возможность изменять коренную папку
 * 
 */

class Dune_Build_Styles
{
    protected $dirName = '';
    protected $fullDirName = '';
    protected $stylesText = '';
    
    protected $stylesRootPath = 'styles';
    
    /**
     * Конструктор объекта
     * Принимает путь в папке styles к файлам css
     *
     * @param string $stylesPath
     */
    public function __construct($stylesPath = '', $stylesRootPath = 'styles')
    {
        if ($stylesPath != '')
        {
            $stylesPath = '/' . $stylesPath;
        }
        $this->stylesRootPath = $stylesRootPath;
        $this->dirName = $this->stylesRootPath . $stylesPath;
        $this->fullDirName = $_SERVER['DOCUMENT_ROOT'].'/'.$this->dirName;
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