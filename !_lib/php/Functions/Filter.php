<?php
/**
 * Репозиторий функция для фильтрации входящих данных
 * 
 *
 *
 */

class Functions_Filter
{
    /**
     * Применяет функцию addslashes() ко всем элементам массива
     *
     * @param array $arr
     * @access private
     */
    
    static private function addSlashesForArray(&$arr) 
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
    static private function deleteSlashesForArray(&$arr) 
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
    static function addMagicQuotes() 
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
    static function stripMagicQuotes() 
    {
       if (get_magic_quotes_gpc()) 
       {
           self::deleteSlashesForArray($_POST);
           self::deleteSlashesForArray($_GET);
           self::deleteSlashesForArray($_COOKIE);
       }
    }
}