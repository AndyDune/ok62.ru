<?php
/**
 * Класс для работы с DBM как с массивом - подключение прячется.
 * Использует системные пераметры.
 * Расширяет класс Dune_AsArray_Parent_Dbm до синглетона
 * 
 * Использует классы:
 * Dune_Exception_Base
 * Dune_System
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: DbmSingleton.php                            |
 * | В библиотеке: Dune/AsArray/DbmSingleton.php       |
 * | Автор: Андрей Рыжов (Dune) <dune@pochta.ru>       |
 * | Версия: 1.00                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * 
 * История версий:
 * -----------------
 * 
 * Версия 1.00 -> 1.01
 * 
 */

  /**
   * 
   * @return Dune_AsArray_DbmSingleton
   */

class Dune_AsArray_DbmSingletonSystem  extends Dune_AsArray_Parent_Dbm
{

    static private $instance = false;
    
    static function getInstance($mode = 'r')
    {
        $SYS = Dune_System::getInstance();
        if (!isset($SYS['dbm_handler']))
        {
            throw new Dune_Exception_Base('В файле настроек не указан ключ: dbm_handler');
        }
        $key = Dune_Parameters::$systemDbmPath;
        if (!self::$instance)
        {
            self::$instance = new Dune_AsArray_DbmSingletonSystem($key, $mode, $SYS['dbm_handler']);
        }
        else 
        {
            if ((self::$instance->__DBA_mode != $mode) AND
                (self::$instance->__DBA_mode == 'r'))
            {
                self::$instance->__destruct();
                self::$instance = new Dune_AsArray_DbmSingletonSystem($key, $mode, $SYS['dbm_handler']);
            }
        }
        return self::$instance;
    }

}