<?php
/**
 * ����������� �����. ������ - ������� ��� ������ �������.
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Autoload.php                                |
 * | � ����������: Dune/Autoload.php                   |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 1.00                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 */
class Dune_Autoload
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

  static public function unregister() 
  {
    if (!spl_autoload_unregister(__CLASS__ . '::load'))
    {
    	throw new Exception('Could not unregister class autoload function');
    }
  }
  
  static function load($className) 
  {
    echo self::$path . '/' . self::getFileByClass($className) . '<br />';
    $file = self::$path . '/' . self::getFileByClass($className);
  	if (is_file($file))
	{
        include_once($file);
	}
	return false;
  }

  protected static function getFileByClass($class)
  {
    return str_replace('_', '/', $class).'.php';
  }
}