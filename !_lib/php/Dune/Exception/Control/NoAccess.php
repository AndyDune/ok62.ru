<?php
/**
 * Вызов при отказе в доступе.
 * При вызове:
 * message - шаблон Zend_View с сообщением. При пустом значении - редирект на главную.
 * code - код сообщения для сохранения в пироге.
 *
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: NoAccess.php                                |
 * | В библиотеке: Dune/Exception/Control/NoAccess.php |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.00                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * 
 * 
 */
class Dune_Exception_Control_NoAccess extends Dune_Exception_Control
{
}