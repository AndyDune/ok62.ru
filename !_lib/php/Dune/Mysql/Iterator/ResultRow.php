<?php
/**
 * ��������� ���������� ������� (��������).
 * �������� �� ��������� �������� ��������.
 * 
 * ������������ � ����������� ����������. ���������� mysql.
 * 
 * -------------------------------------------------------
 * | ����������: Dune                                     |
 * | ����: ResultRow.php                                  |
 * | � ����������: Dune/Mysql/Iterator/ResultRow.php      |
 * | �����: ������ ����� (Dune) <dune@rznlf.ru>           |
 * | ������: 1.00                                         |
 * | ����: www.rznlf.ru                                   |
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