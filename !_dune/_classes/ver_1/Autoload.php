<?php
/**
 * Статический класс. Методы - фабрики для других классов.
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Autoload.php                                |
 * | В библиотеке: Dune/Autoload.php                   |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.00                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 */
class SiteAutoload extends Dune_Autoload
{
     static protected $path;

     static public function register()
      {
        self::$path = dirname(__FILE__);
        if (!spl_autoload_register(__CLASS__ . '::load'))
        {
        	throw new Exception('Could not register class autoload function');
        }
      }
  static function load($className) 
  {
    //echo self::$path . '/' . self::getFileByClass($className) . '<br />';
    $file = self::$path . '/' . self::getFileByClass($className);
  	if (is_file($file))
	{
        include_once($file);
	}
	return false;
  }
      

}