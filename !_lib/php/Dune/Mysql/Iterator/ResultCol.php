<?php
/**
 * ��������� ���������� ������� (��������).
 * �������� � �������� �� ������ ������� � ���������� �������.
 * 
 * -------------------------------------------------------
 * | ����������: Dune                                     |
 * | ����: ResultCol.php                                  |
 * | � ����������: Dune/Mysql/Iterator/ResultCol.php     |
 * | �����: ������ ����� (Dune) <dune@rznlf.ru>           |
 * | ������: 1.00                                         |
 * | ����: www.rznlf.ru                                   |
 * -------------------------------------------------------
 *
 */

class Dune_Mysqli_Iterator_ResultCol extends Dune_Mysql_Iterator_Parent_Result
{
    protected function getEl()
    {
        $r = mysql_fetch_row($this->result);
        return $r[0];
    }
}
