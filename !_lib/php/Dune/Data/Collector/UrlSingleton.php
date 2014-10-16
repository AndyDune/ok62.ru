<?php
/**
 * Составитель строки запроса. Синглетон.
 * Основное назначение - сборка строки текущего положения и возможная правка.
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Url.php                                     |
 * | В библиотеке: Dune/Data/Colletor/UrlSingleton.php |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>        |
 * | Версия: 1.00                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * История версий:
 *
 * Версия 1.00 -> 1.01
 * 
 */
class Dune_Data_Collector_UrlSingleton extends Dune_Data_Collector_Abstract_Url
{
   /**
    * Иниц. при первом вызове стат. метода и возвращается при последующих
    *
    * @var Dune_Session
    * @access private
    */
    static private $instance = NULL;
 
  
/////////////////////////////////////////////////////////////////////
//////////////////////////////      Статичные методы    
  /**
   * Создаёт реализацию класса при первом вызове
   * Возвращает сохранённый указатель объекта при последующих вызовах
   *
   * Вызывает указаталь на объект с системными параметрами
   * 
   * @return Dune_Data_Collector_UrlSingleton
   */
    static public function getInstance()
    {
        if (self::$instance == NULL)
        {
            self::$instance = new Dune_Data_Collector_UrlSingleton();
        }
        return self::$instance;
    }
    
    
}