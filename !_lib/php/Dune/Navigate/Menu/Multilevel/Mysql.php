<?php
/**
 * Класс многоуровневого меню
 * Число уровней неограничено
 * Результат обработки кешируется в файлы или бызы данных DBM(flatfile)
 * 
 * Структура необходимой ьаблицы:
 * ------------------------------------------------------
 * CREATE TABLE `menu` (
 * `id` int(10) unsigned NOT NULL auto_increment,
 * `name` varchar(100) NOT NULL default '',
 * `href` varchar(100) NOT NULL default '',
 * `title` varchar(200) NOT NULL default '',
 * `parent` int(10) unsigned NOT NULL default '0',
 * `order` int(10) unsigned NOT NULL default '0',
 * `code` int(10) unsigned NOT NULL default '0',
 * PRIMARY KEY  (`id`),
 * KEY `parent` (`parent`,`order`)
 * ) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
 * 
 * Здесь:
 * id - уникальный ключ - имеет занчение при редактировании
 * name - отображаемое имя ссылки (что может вставляться между тегами <a></a>)
 * link - текст ссылки (значение для href)
 * title - соответственно tite ссылки
 * parent - id родителя
 * code - на всякий случай
 * 
 * Класс анализирует таблицу и возвращает массив со структурой меню
 */
class Dune_Navigate_MultileveledMenuMysql
{
    
}