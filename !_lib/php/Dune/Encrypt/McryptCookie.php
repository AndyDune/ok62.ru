<?php
/**
 * Статичный Класс синхронного шифрования куки.
 * 
 * Необходима библиотека не ниже libmcrypt 2.4.x
 * Параметры шифрования задаются установкой статических переменных.
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: McryptCookie.php                            |
 * | В библиотеке: Dune/Encrypt/McryptCookie.php       |
 * | Автор: Андрей Рыжов (Dune) <dune@pochta.ru>       |
 * | Версия: 1.01                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * 
 * 
 * Аналогичен классу Dune_Encrypt_Mcrypt но применяется для кодирования с использованием с ситемными переменными из файла настроек
 * 
 * Необходимые ключи в файле настроек:
 *                                     cookie_mcript_cypher
 *                                     cookie_mcript_mode
 *                                     cookie_mcript_key
 * 
 * Если не заданы - используются значения статических переменных по умолчанию
 * 
 * 
 * 
 * История версий:
 * -----------------
 * 
 * Версия 1.00 -> 1.01
 * Параметры шифрования извлекаются не непосредственно из файла настроек а из спец. класса (статического)
 * 
 * 
 * 
 */

class Dune_Encrypt_McryptCookie
{
    static protected $initCryptVars = false;
    static $cypher     = 'blowfish';
    static $mode       = 'cfb';
    static $key;
    
    static private function setCryptVars()
    {
        self::$cypher = Dune_Parameters::$cookeiMcriptCypher;
        self::$mode = Dune_Parameters::$cookeiMcriptMode;
        self::$key = Dune_Parameters::$cookeiMcriptKey;
        self::$initCryptVars = true;
    }
    
    /**
     * Кодиреут принммаемую как параметр строку
     *
     * @param string $plaintext
     * @return string
     */
    static public function encrypt($plaintext)
    {
      if (!self::$initCryptVars)
         self::setCryptVars();
      $td = mcrypt_module_open(self::$cypher, '', self::$mode, '');
      $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
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
      if (!self::$initCryptVars)
         self::setCryptVars();
      $td = mcrypt_module_open(self::$cypher, '', self::$mode, '');
      
      // операция, приводящая к предупреждению в libmcrypt 2.4.x
      //$ivsize = mcrypt_get_iv_size($td);
      
      $ivsize = mcrypt_get_iv_size(self::$cypher,self::$mode);
      $iv = substr($crypttext, 0, $ivsize);
      $crypttext = substr($crypttext, $ivsize);
      @mcrypt_generic_init($td, self::$key, $iv);
      $plaintext = @mdecrypt_generic($td, $crypttext);
      mcrypt_generic_deinit ($td);
      return $plaintext;
    }    
}