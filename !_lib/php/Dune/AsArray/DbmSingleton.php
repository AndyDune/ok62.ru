<?php
/**
 * Класс для работы с DBM как с массивом - подключение прячется
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
 * | Версия: 1.06                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * 
 * История версий:
 * -----------------
 * 
 * Версия 1.04 -> 1.05
 * -------------------
 * Тип базы данных описывается в конфигурационном файле.
 * 
 * Версия 1.03 -> 1.04
 * Изменены наследуемые параметры. Увеличено их число.
 * Изменен ключ для массива объектов.
 * 
 * Версия 1.02 -> 1.03
 * Возможно создать несколько объектов. Помещаются в массив, ключи от которого - конкентинация всех входных параметров
 *
 * 
 * Версия 1.01 -> 1.02
 * Изменение название класса
 *
 * Версия 1.00 -> 1.01
 * Изменена последовательность передачи параметров в конструктор
 * 
 */

  /**
   * 
   * @return Dune_AsArray_DbmSingleton
   */

class Dune_AsArray_DbmSingleton  extends Dune_AsArray_Parent_Dbm
{

    static private $instance = array();
    
    static function getInstance($path,$mode = 'r')
    {
        $SYS = Dune_System::getInstance();
        if (!isset($SYS['dbm_handler']))
        {
            throw new Dune_Exception_Base('В файле настроек не указан ключ: dbm_handler');
        }
        $key = $path;
        if (!key_exists($key,self::$instance))
        {
            self::$instance[$key] = new Dune_AsArray_DbmSingleton($path, $mode, $SYS['dbm_handler']);
        }
        else 
        {
            if ((self::$instance[$key]->__DBA_mode != $mode) AND
                (self::$instance[$key]->__DBA_mode == 'r'))
            {
                self::$instance[$key]->__destruct();
                self::$instance[$key] = new Dune_AsArray_DbmSingleton($path, $mode, $SYS['dbm_handler']);
            }
        }
        return self::$instance[$key];
    }

}