<?php
/**
 * ����������� ������� ��� ������ � �����������
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Message.ph                                  |
 * | � ����������: Dune/Static/Message.php             |
 * | �����: ������ ����� (Dune) <dune@rznw.ru >        |
 * | ������: 1.02                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * ������� ������:
 * -----------------
 * 
 * ������ 1.02 (2008 ������� 16)
 * �������� ������ ��������� ���������� ���������.
 * 
 * ������ 1.00 -> 1.01
 * ���������� $text ������ ������ ����� ���������.
 * 
 */

abstract class Dune_Static_Message
{
    /**
     * ���� ������� ���������
     *
     * @var boolean
     */
    static public $have = false;

    /**
     * ��� ���������
     *
     * @var integer
     */
    static public $code = 0;
    
    /**
     * ������ ����� ���������
     *
     * @var string
     */
    static public $section = '';
    
    /**
     * ����� ���������
     *
     * @var string
     */
    static public $text = '';

    /**
     * ������ ���� � ����� ���������
     *
     * @var string
     */
    static public $messagesFile;
    
    
    /**
     * �������� ��������� � ������� Dune_Cookie_ArraySingleton 
     *
     * @param Dune_Cookie_ArraySingleton $array
     * @param string $key ���� � ������� � ��������-����������
     */
    static public function checkCookieArray(Dune_Cookie_ArraySingleton $array, $key = 'message')
    {
        if (isset($array[$key]))
//        if (isset($array[$key]) and is_array($array[$key]))        
        { 
            if (key_exists('text', $array[$key]))
            {
                self::$text = $array[$key]['text'];
                self::$have = true;
            }
            else 
            {
                self::$code = $array[$key]['code'];
                self::$section = $array[$key]['section'];
                if (is_file(self::$messagesFile))
                {
                    $arrayINI = parse_ini_file(self::$messagesFile, true);
                    if ((key_exists(self::$section, $arrayINI)) AND (key_exists(self::$code, $arrayINI[self::$section])))
                    {
                        self::$text = $arrayINI[self::$section][self::$code];
                        self::$have = true;
                    }
                }
                else 
                  throw new Dune_Exception_Base('���� ��������� �� ���������� ���� �� ����������: ' . self::$messagesFile);
            }
            unset($array[$key]);
        }
    }
    
    static public function setText($string = '')
    {
        $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);
        $cooc['message'] = array(
                                 'text' => $string
                                 );
        
    }
    
    static public function setCode($code, $section = 'common')
    {
        $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);
        $cooc['message'] = array(
                                 'code' => $code,
                                 'section' => $section
                                 );
    }
    
}