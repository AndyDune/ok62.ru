<?php
/**
 * Результат выполнения запроса (итератор).
 * Итератор с ассоциатовным массивом.
 * 
 * Используется с устаревшими методиками. Библиотека mysql.
 * 
 * -------------------------------------------------------
 * | Библиотека: Dune                                     |
 * | Файл: ResultAssoc.php                                |
 * | В библиотеке: Dune/Mysql/Iterator/ResultAssoc.php    |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>           |
 * | Версия: 1.00                                         |
 * | Сайт: www.rznlf.ru                                   |
 * -------------------------------------------------------
 *
 */

class Dune_Mysql_Iterator_ResultAssoc extends Dune_Mysql_Iterator_Parent_Result
{
    protected function getEl()
    {
        return mysql_fetch_assoc($this->result);
    }
}


