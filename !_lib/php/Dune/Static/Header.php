<?php
/**
 * Репозиторий функция для посыла заголовков
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Header.php                                  |
 * | В библиотеке: Dune/Static/Header.php              |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>        |
 * | Версия: 1.01                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * История версий:
 * -----------------
 * 
 * Версия 1.00 -> 1.01
 * Функция charset - отсыл Content-type: text/plain; charset=<кодировка>
 * 
 */

abstract class Dune_Static_Header
{
    static public function noCache()
    {
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
    	header("Cache-Control: post-check=0, pre-check=0", false);	
    	header("Pragma: no-cache");                          // HTTP/1.0
    }
    static public function location($destin = false)
    {
        if (!$destin)
            $destin = $_SERVER['HTTP_REFERER'];
        header("Location: " . $destin);
    }

    static public function charset($charset = 'windows-1251')
    {
        header("Content-type: text/plain; charset=" . $charset);
    }
	
}