<?php
/**
 * Абстрактный класс содержащий в себе системные объекты.
 * 
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Objects.php                                 |
 * | В библиотеке: Dune/Objects.php                    |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>        |
 * | Версия: 0.91                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 * 
 * История версий:
 * -----------------
 * 
 * Версия 0.90 -> 0.91
 * Добавлена переменная объекта Dune_Build_Template $pageTemplare
 * 
 */
abstract class Dune_Objects
{
    /**
     * Хранит указатель на экземпляр класса Dune_Data_Container_Command
     *
     * @var Dune_Data_Container_Command
     */
    static public $command;
    
    /**
     * Хранит указатель на экземпляр класса Dune_Build_Template
     *
     * @var Dune_Build_Template
     */
    static public $pageTemplate;
    
}