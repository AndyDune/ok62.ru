<?php
/**
 * Репозиторий функция для работы с кавычками
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Quotes.php                                  |
 * | В библиотеке: Dune/Static/Quotes.php              |
 * | Автор: Андрей Рыжов (Dune) <dune@pochta.ru>       |
 * | Версия: 1.00                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 */

abstract class Dune_Static_Quotes
{
    /**
     * Применяет функцию addslashes() ко всем элементам массива
     *
     * @param array $arr
     * @access private
     */
    
    static protected function addSlashesForArray(&$arr) 
    {
       foreach($arr as $k=>$v) 
       {
           if (is_array($v)) 
           {
               self::addSlashesForArray($v);
               $arr[$k] = $v;
           }
           else 
           {
               $arr[$k] = addslashes($v);
           }
       }
    }
    /**
     * Применяет функцию stripcslashes() ко всем элементам массива
     *
     * @param array $arr
     * @access private
     */
    static protected function deleteSlashesForArray(&$arr) 
    {
       foreach($arr as $k=>$v) 
       {
           if (is_array($v)) 
           {
               self::deleteSlashesForArray($v);
               $arr[$k] = $v;
           }
           else 
           {
               $arr[$k] = stripcslashes($v);
           }
       }
    }
    
    /**
     * Экранирует при необходииости строки в $_GET, $_POST, $_COOKIE
     *
     */
    static function addMagic() 
    {
       if (!get_magic_quotes_gpc()) 
       {
           self::addSlashesForArray($_POST);
           self::addSlashesForArray($_GET);
           self::addSlashesForArray($_COOKIE);
       }
    }
    
    /**
     * Снимает экранизацию при необходииости строки в $_GET, $_POST, $_COOKIE
     *
     */
    static function stripMagic() 
    {
       if (get_magic_quotes_gpc()) 
       {
           self::deleteSlashesForArray($_POST);
           self::deleteSlashesForArray($_GET);
           self::deleteSlashesForArray($_COOKIE);
       }
    }
}