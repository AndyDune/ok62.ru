<?php
/**
 * Репозиторий функция для проверок, всяких проверок
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Generate.php                                |
 * | В библиотеке: Dune/Static/Generate.php            |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>        |
 * | Версия: 1.00                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 */

abstract class Dune_Static_Generate
{
    /**
     * Набор символов для генерации стлучайной строки
     *
     * @var string
     */
    static public $allowedSymbols = '23456789abcdeghkmnpqsuvxyz';
    
    static public function generateRandomString($length = 10)
    {
        $result = '';
        $allowedLength = strlen(self::$allowedSymbols) - 1;
        for ($x = 0; $x < $length; $x++)
        {
            $result .= self::$allowedSymbols[mt_rand(0, $allowedLength)];
        }
        return $result;
    }

}