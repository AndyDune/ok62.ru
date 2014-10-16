<?php
/**
 * Расширенный Класс mysqli до синглетона
 * 
 * Объект создаётся вызовом функции Dune_MysqliSystem::getInstance()
 * 
 * При повторном вызове функции возвращается указатель на уже созданный объект.
 * 
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: MysqliSystem.php                            |
 * | В библиотеке: Dune/MysqliSystem.php               |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.04                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * 
 * История версий:
 * -----------------
 * 
 * Версия 1.04
 * Наследует классу Dune_Mysqli
 *
 * Версия 1.02 -> 1.03
 * Убраны отложенные запросы при установке кодировок (ошибки)
 * 
 * Версия 1.01 -> 1.02
 * Изменена работа с файлом конфигурации. Посредник - класс Dune_Parameters
 * Изменена схема установки кодировки
 * 
 * Версия 1.00 -> 1.01
 * Добавлена возможность установки кодировки, если есть такие опции в конфиг файле
 * 
 *
 */

class Dune_MysqliSystem extends Dune_Mysqli_Abstract_Mysqli
{
   /**
    * Иниц. при первом вызове стат. метода и возвращается при последующих
    *
    * @var указатель на объект
    */
  static private $instance = NULL;

  
  /**
   * Создаёт реализацию класса при первом вызове
   * Возвращает сохранённый указатель объекта при последующих вызовах
   *
   * Вызывает указаталь на объект с системными параметрами
   * 
   * @return Dune_MysqliSystem
   */
  static function getInstance()
  {
    if (self::$instance == NULL)
    {
      self::$instance = new Dune_MysqliSystem(Dune_Parameters::$mysqlHost,
                                   Dune_Parameters::$mysqlUsername,
                                   Dune_Parameters::$mysqlPasswd,
                                   Dune_Parameters::$mysqlDbname);
      
      
      if (mysqli_connect_errno())
            throw new Dune_Exception_Mysqli("Ошибка подключения: ".mysqli_connect_error());

      $query = 'SET NAMES ' . Dune_Parameters::$mysqlCharsetName;
      self::$instance->query($query);
      
      $query = ' SET CHARACTER SET ' . Dune_Parameters::$mysqlCharsetName;
      self::$instance->query($query);
      
    }
    return self::$instance;
  }


}