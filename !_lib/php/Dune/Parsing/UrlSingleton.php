<?php
/**
 * Класс разбора строки запроса.
 * Синглтон.
 * 
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Url.php                                     |
 * | В библиотеке: Dune/Parsing/Parent/Url.php         |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>        |
 * | Версия: 1.00                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * История версий:
 *
 * Версия 1.00 -> 1.01
 * 
 */
class Dune_Parsing_UrlSingleton extends Dune_Parsing_Parent_Url
{
    
    static private $instance = null;
    
    /**
     * Метод сиглетона.
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