<?php
/**
 * Репозиторий функция для работы с сообщениями
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Message.ph                                  |
 * | В библиотеке: Dune/Static/Message.php             |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru >        |
 * | Версия: 1.02                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * История версий:
 * -----------------
 * 
 * Версия 1.02 (2008 декабрь 16)
 * Внедрены методы установки параметров сообщения.
 * 
 * Версия 1.00 -> 1.01
 * Переменная $text хранит только текст сообщения.
 * 
 */

abstract class Dune_Static_Message
{
    /**
     * Флаг наличия сообщения
     *
     * @var boolean
     */
    static public $have = false;

    /**
     * Код сллбщения
     *
     * @var integer
     */
    static public $code = 0;
    
    /**
     * Раздел кодов сообщений
     *
     * @var string
     */
    static public $section = '';
    
    /**
     * Текст сообщения
     *
     * @var string
     */
    static public $text = '';

    /**
     * Полный путь к файлк сообщений
     *
     * @var string
     */
    static public $messagesFile;
    
    
    /**
     * Проверка сообщений в объекте Dune_Cookie_ArraySingleton 
     *
     * @param Dune_Cookie_ArraySingleton $array
     * @param string $key ключ в объекты с массивом-сообщением
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
                  throw new Dune_Exception_Base('Файл сообщений по указанному пути не существует: ' . self::$messagesFile);
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