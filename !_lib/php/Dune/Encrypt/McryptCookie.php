<?php
/**
 * ��������� ����� ����������� ���������� ����.
 * 
 * ���������� ���������� �� ���� libmcrypt 2.4.x
 * ��������� ���������� �������� ���������� ����������� ����������.
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: McryptCookie.php                            |
 * | � ����������: Dune/Encrypt/McryptCookie.php       |
 * | �����: ������ ����� (Dune) <dune@pochta.ru>       |
 * | ������: 1.01                                      |
 * | ����: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * 
 * 
 * ���������� ������ Dune_Encrypt_Mcrypt �� ����������� ��� ����������� � �������������� � ��������� ����������� �� ����� ��������
 * 
 * ����������� ����� � ����� ��������:
 *                                     cookie_mcript_cypher
 *                                     cookie_mcript_mode
 *                                     cookie_mcript_key
 * 
 * ���� �� ������ - ������������ �������� ����������� ���������� �� ���������
 * 
 * 
 * 
 * ������� ������:
 * -----------------
 * 
 * ������ 1.00 -> 1.01
 * ��������� ���������� ����������� �� ��������������� �� ����� �������� � �� ����. ������ (������������)
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
      mcrypt_generic_deinit ($td);
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
      mcrypt_generic_deinit ($td);
      return $plaintext;
    }    
}