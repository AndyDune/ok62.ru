<?php
/**
 * Класс для работы с DBM как с массивом - подключение прячется
 * 
 * Использует классы:
 * Dune_Exception_Base
 * Dune_System
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Dbm.php                                     |
 * | В библиотеке: Dune/AsArray/Dbm.php                |
 * | Автор: Андрей Рыжов (Dune) <dune@pochta.ru>       |
 * | Версия: 1.15                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * 
 * История версий:
 * 
 * Версия 1.13 -> 1.14
 * -------------------
 * Тип базы данных описывается в конфигурационном файле.
 * 
 * Версия 1.03 -> 1.13
 * -------------------
 * Полностью наследует абстрактный класс. (Открывает конструктор)
 * 
 */

class Dune_AsArray_Dbm extends Dune_AsArray_Parent_Dbm implements Iterator,ArrayAccess
{
    
    
/**
 * Конструктор - открывает файт dbm
 *
 * @param unknown_type $path путь к файлу
 * @param unknown_type $handler тип базы данных, по умолчанию flatfile
 * @param unknown_type $mode режим открытия файла, по умолчанию w
 */
    public function __construct($path,$mode = 'w')
    {
        $SYS = Dune_System::getInstance();
        if (!isset($SYS['dbm_handler']))
        {
            throw new Dune_Exception_Base('В файле настроек не указан ключ: dbm_handler');
        }
        parent::__construct($path, $mode, $SYS['dbm_handler']);
    }
}