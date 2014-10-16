<?php
/**
 * Dune Framework
 * 
 * Абстрактный класс.
 * Функция мниициилизации ссылки на объект misqli
 * 
 * --------------------------------------------------------
 * | Библиотека: Dune                                      |
 * | Файл: Connect.php                                     |
 * | В библиотеке: Dune/Mysqli/Abstract/Connect.php        |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>             |
 * | Версия: 0.91                                          |
 * | Сайт: www.rznw.ru                                     |
 * --------------------------------------------------------
 *
 * История версий:
 * 
 * Версия 0.91 (2008 апрель 08)
 *  Местами протестировано.
 * 
 */
abstract class Dune_Mysqli_Abstract_Connect
{
    /**
     * Указатель на класс
     *
     * @var Dune_MysqliSystem
     * @access private
     */
    protected $_DB = null;
    
    /**
     * Инициилизация указателя на объект mysqli
     *
     * @access private
     * @return Dune_MysqliSystem
     */
    final protected function _initDB()
    {
        if ($this->_DB == null)
            $this->_DB = Dune_MysqliSystem::getInstance();
        return $this;
    }
    


}