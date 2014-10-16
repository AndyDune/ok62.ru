<?php
/**
 * Результат выполнения запроса (итератор).
 * Итератор со скалярным массивом массивом.
 * 
 * Используется с устаревшими методиками. Библиотека mysql.
 * 
 * -------------------------------------------------------
 * | Библиотека: Dune                                     |
 * | Файл: ResultRow.php                                  |
 * | В библиотеке: Dune/Mysql/Iterator/ResultRow.php      |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>           |
 * | Версия: 1.00                                         |
 * | Сайт: www.rznlf.ru                                   |
 * -------------------------------------------------------
 *
 */

class Dune_Mysql_Iterator_ResultRow extends Dune_Mysql_Iterator_Parent_Result
{
    protected function getEl()
    {
        return mysql_fetch_row($this->result);
    }
}