<?php
/**
 * ����� ��������������� ����
 * ����� ������� ������������
 * ��������� ��������� ���������� � ����� ��� ���� ������ DBM(flatfile)
 * 
 * ��������� ����������� �������:
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
 * �����:
 * id - ���������� ���� - ����� �������� ��� ��������������
 * name - ������������ ��� ������ (��� ����� ����������� ����� ������ <a></a>)
 * link - ����� ������ (�������� ��� href)
 * title - �������������� tite ������
 * parent - id ��������
 * code - �� ������ ������
 * 
 * ����� ����������� ������� � ���������� ������ �� ���������� ����
 */
class Dune_Navigate_MultileveledMenuMysql
{
    
}