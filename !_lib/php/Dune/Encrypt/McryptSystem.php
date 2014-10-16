<?php
/**
 * ��������� ����� ����������� ����������.
 * 
 * ���������� ���������� �� ���� libmcrypt 2.4.x
 * ��������� ���������� �������� ���������� ����������� ����������.
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: McryptSystem.php                            |
 * | � ����������: Dune/Encrypt/McryptSystem.php       |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 1.01                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * ���������� ������ Dune_Encrypt_Mcrypt �� ����������� ��� ����������� � �������������� � ��������� ����������� �� ����� ��������
 * 
 * ����������� ����� � ����� ��������:
 *                                     mcript_cypher
 *                                     mcript_mode
 *                                     mcript_key
 * 
 * ���� �� ������ - ������������ �������� ����������� ���������� �� ���������
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
     * �������� ����������� ��� �������� ������
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
     * ���������� ����������� ��� �������� ������
     *
     * @param string $plaintext
     * @return string
     */
    static public function decrypt($crypttext) 
    {
      if (!self::$initCryptVars)
         self::setCryptVars();
      $td = mcrypt_module_open(self::$cypher, '', self::$mode, '');
      
      // ��������, ���������� � �������������� � libmcrypt 2.4.x
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