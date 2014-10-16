<?php
/**
 * Расширенный Класс mysqli до синглетона
 * 
 * Объект создаётся вызовом функции Dune_Mysqli::getInstance($host,$username,$passwd,$dbname)
 * При повторном вызове функции возвращается указатель на уже созданный объект.
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Mysqli.php                                  |
 * | В библиотеке: Dune/Mysqli.php                     |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>        |
 * | Версия: 1.03                                      |
 * | Сайт: www.rzw.ru                                  |
 * ----------------------------------------------------
 * 
 * 
 * История версий:
 * -----------------
 * 
 * 1.03 (2009 апрель 30)
 * Псевдо синглетон
 * 
 * 
 * Версия 1.00 -> 1.02
 * Смена родителя.
 * 
 * Версия 1.00 -> 1.01
 * Может быть родителем.
 * !! Позаимствован функционал из класса goDB (http://pyha.ru/go/godb/)
 *
 */
class Dune_Mysqli extends Dune_Mysqli_Abstract_Mysqli
{
   /**
    * Иниц. при первом вызове стат. метода и возвращается при последующих
    *
    * @var указатель на объект
    */
   static private $instance = array();


  /**
   * Создаёт реализацию класса при первом вызове
   * Возвращает сохранённый указатель объекта при последующих вызовах
   *
   * @param string $host
   * @param string $username
   * @param string $passwd
   * @param string $dbname
   * @return Dune_Mysqli
   */
  static function getInstance($host = null, $username = null, $passwd = null,$dbname = null,$port = null, $socket = null)
  {
    $key = (string)$host . (string)$username . (string)$passwd . (string)$dbname . (string)$port . (string)$socket;
    if (!key_exists($key, self::$instance))
    {
      self::$instance[$key] = new Dune_Mysqli($host, $username, $passwd, $dbname, $port, $socket);
      if (mysqli_connect_errno())
            throw new Dune_Exception_Mysqli("Ошибка подключения: ".mysqli_connect_error());
    }
    return self::$instance[$key];
  }

}