<?php
/**
 * Результат выполнения запроса (итератор).
 * Итератор с ассоциатовным массивом.
 * 
 * -------------------------------------------------------
 * | Библиотека: Dune                                     |
 * | Файл: ResultAssoc.php                                |
 * | В библиотеке: Dune/Mysqli/Iterator/ResultAssoc.php   |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>           |
 * | Версия: 1.00                                         |
 * | Сайт: www.rznlf.ru                                   |
 * -------------------------------------------------------
 *
 */

class Dune_Mysqli_Iterator_ResultAssoc extends Dune_Mysqli_Iterator_Parent_Result
{
    protected function getEl()
    {
        return $this->result->fetch_assoc();
    }
}


