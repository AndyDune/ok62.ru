<?php
/**
 * ����������� ������� ��� ������ � ���������
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Quotes.php                                  |
 * | � ����������: Dune/Static/Quotes.php              |
 * | �����: ������ ����� (Dune) <dune@pochta.ru>       |
 * | ������: 1.00                                      |
 * | ����: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 */

abstract class Dune_Static_Quotes
{
    /**
     * ��������� ������� addslashes() �� ���� ��������� �������
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
     * ��������� ������� stripcslashes() �� ���� ��������� �������
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
     * ���������� ��� ������������� ������ � $_GET, $_POST, $_COOKIE
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
     * ������� ����������� ��� ������������� ������ � $_GET, $_POST, $_COOKIE
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