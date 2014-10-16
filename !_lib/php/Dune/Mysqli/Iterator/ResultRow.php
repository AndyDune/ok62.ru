<?php
/**
 * Результат выполнения запроса (итератор).
 * Итератор со скалярным массивом массивом.
 * 
 * -------------------------------------------------------
 * | Библиотека: Dune                                     |
 * | Файл: ResultRow.php                                  |
 * | В библиотеке: Dune/Mysqli/Iterator/ResultRow.php     |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>           |
 * | Версия: 1.00                                         |
 * | Сайт: www.rznlf.ru                                   |
 * -------------------------------------------------------
 *
 */

class Dune_Mysqli_Iterator_ResultRow extends Dune_Mysqli_Iterator_Parent_Result
{
    protected function getEl()
    {
        return $this->result->fetch_row();
    }
}