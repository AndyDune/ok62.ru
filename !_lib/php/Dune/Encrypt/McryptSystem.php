<?php
/**
 * Статичный Класс синхронного шифрования.
 * 
 * Необходима библиотека не ниже libmcrypt 2.4.x
 * Параметры шифрования задаются установкой статических переменных.
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: McryptSystem.php                            |
 * | В библиотеке: Dune/Encrypt/McryptSystem.php       |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.01                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * Аналогичен классу Dune_Encrypt_Mcrypt но применяется для кодирования с использованием с ситемными переменными из файла настроек
 * 
 * Необходимые ключи в файле настроек:
 *                                     mcript_cypher
 *                                     mcript_mode
 *                                     mcript_key
 * 
 * Если не заданы - используются значения статических переменных по умолчанию
 * 
 */

class Dune_Encrypt_McryptSystem
{
    static protected $initCryptVars = false;
    static $cypher     = 'blowfish';
    static $mode       = 'cfb';
    static $key = 'bi-bi-bi-pi-bi-pi-tu-ta-ri';


    static private function setCryptVars()
    {
        $SYS = Dune_System::getInstance();
        if (isset($SYS['mcript_cypher']))
            self::$cypher = $SYS['mcript_cypher'];
        if (isset($SYS['mcript_mode']))
            self::$mode = $SYS['mcript_mode'];
        if (isset($SYS['mcript_key']))
            self::$key = $SYS['mcript_key'];
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
      mcrypt_generic_deinit($td);
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
      mcrypt_generic_deinit($td);
      return $plaintext;
    }
}