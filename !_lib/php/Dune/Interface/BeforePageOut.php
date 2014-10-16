<?php
/**
 * Интерфейс. Определение функции, для использования классом-регистратором классов.
 *
 */
interface Dune_Interface_BeforePageOut
{
    /**
     * Реализация метода интерфейса Dune_Interface_BeforePageOut.
     * 
     * Действие после работы скрипта, перед выводом страницы.
     *
     */
    function doBeforePageOut();
}