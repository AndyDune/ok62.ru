<?php
/**
 * Создание директории с учетом родителей.
 * Создание родительской папки до указанного уровня.
 * 
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Make.php                                    |
 * | В библиотеке: Dune/Directory/Make.php             |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 0.91                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * История версий:
 *
 * Версия 0.91 (2009 май 15)
 * Внедрен trim через класс-контейнер.
 * 
 * Версия 0.90 Рабочая версия. Но требует доводки и комментариев.
 * 
 * 
 */


class Dune_Directory_Make
{

	protected $_directoryName = '';
	protected $_directoryNameArray = array();
	protected $_isDir = false;
	protected $_nesting = 0;
	
	/**
	 * Принимает имя директории от корня сайта.
	 *
	 * @param string $name имя директории от корня сайта !
	 */
	public function __construct($name)
	{
	    $str = Dune_String_Factory::getStringContainer($name);
	    $name = $str->trim('/\\');

	    $this->_directoryName = $name;
	    $this->_directoryNameArray = new Dune_String_Explode($name, '/', 1);
	    if (is_dir($_SERVER['DOCUMENT_ROOT'] . '/' . $name))
	       $this->_isDir = true;
	}
	
    public function make($from_level = 1, $mode = 0777)
    {
        $levels = count($this->_directoryNameArray);
        if ($levels < $from_level)
        {
            return $this->_isDir;
        }
        $cumul = '';
        foreach ($this->_directoryNameArray as $key => $value)
        {
            $cumul .= '/' . $value;
            if ($key < $from_level)
                continue;
            $temp = $_SERVER['DOCUMENT_ROOT'] . $cumul;
            if (is_dir($temp))
                continue;
            if (!mkdir($temp, $mode))
                return false;
        }
        return true;
    }
}