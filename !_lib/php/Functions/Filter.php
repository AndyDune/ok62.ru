<?php
/**
 * ����������� ������� ��� ���������� �������� ������
 * 
 *
 *
 */

class Functions_Filter
{
    /**
     * ��������� ������� addslashes() �� ���� ��������� �������
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
     * ��������� ������� stripcslashes() �� ���� ��������� �������
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
     * ���������� ��� ������������� ������ � $_GET, $_POST, $_COOKIE
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
     * ������� ����������� ��� ������������� ������ � $_GET, $_POST, $_COOKIE
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