<?php
/**
 * Статичный Класс синхронного шифрования.
 * 
 * Необходима библиотека не ниже libmcrypt 2.4.x
 * Параметры шифрования задаются установкой статических переменных.
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Mcrypt.php                                  |
 * | В библиотеке: Dune/Encrypt/Mcrypt.php             |
 * | Автор: Андрей Рыжов (Dune) <dune@pochta.ru>       |
 * | Версия: 1.00                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * Код полностью скопирован из книги "Профессиональное програмирование на PHP"
 * 
 */
class Dune_Encrypt_Mcrypt
{
    static $cypher     = 'blowfish';
    static $mode       = 'cfb';
    static $key = 'bi-bi-bi-pi-bi-pi-tu-ta-ri';
    
    /**
     * Кодиреут принммаемую как параметр строку
     *
     * @param string $plaintext
     * @return string
     */
    static public function encrypt($plaintext)
    {
      $td = mcrypt_module_open(self::$cypher, '', self::$mode, '');
      $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size ($td), MCRYPT_RAND);
      mcrypt_generic_init($td, self::$key, $iv);
      $crypttext = mcrypt_generic($td, $plaintext);
      mcrypt_generic_deinit ($td);
      return $iv.$crypttext;
    }
    /**
     * Декодирует принммаемую как параметр строку
     *
     * @param string $plaintext
     * @return string
     */
    static public function decrypt($crypttext) 
    {
      $td = mcrypt_module_open(self::$cypher, '', self::$mode, '');
      //$ivsize = mcrypt_get_iv_size($td);
      $ivsize = mcrypt_get_iv_size(self::$cypher,self::$mode);
      $iv = substr($crypttext, 0, $ivsize);
      $crypttext = substr($crypttext, $ivsize);
      mcrypt_generic_init($td, self::$key, $iv);
      $plaintext = mdecrypt_generic($td, $crypttext);
      mcrypt_generic_deinit($td);
      return $plaintext;
    }
}