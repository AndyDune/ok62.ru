<?php
/**
 * ����� ������� ������ �������.
 * ��������.
 * 
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Url.php                                     |
 * | � ����������: Dune/Parsing/Parent/Url.php         |
 * | �����: ������ ����� (Dune) <dune@rznlf.ru>        |
 * | ������: 1.00                                      |
 * | ����: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * ������� ������:
 *
 * ������ 1.00 -> 1.01
 * 
 */
class Dune_Parsing_UrlSingleton extends Dune_Parsing_Parent_Url
{
    
    static private $instance = null;
    
    /**
     * ����� ���������.
     *
     * @return Dune_Parsing_UrlSingleton
     */
    static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new Dune_Parsing_UrlSingleton();
        }
        return self::$instance;
    }
}