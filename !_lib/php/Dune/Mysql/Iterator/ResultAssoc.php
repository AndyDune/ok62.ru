<?php
/**
 * ��������� ���������� ������� (��������).
 * �������� � ������������� ��������.
 * 
 * ������������ � ����������� ����������. ���������� mysql.
 * 
 * -------------------------------------------------------
 * | ����������: Dune                                     |
 * | ����: ResultAssoc.php                                |
 * | � ����������: Dune/Mysql/Iterator/ResultAssoc.php    |
 * | �����: ������ ����� (Dune) <dune@rznlf.ru>           |
 * | ������: 1.00                                         |
 * | ����: www.rznlf.ru                                   |
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


