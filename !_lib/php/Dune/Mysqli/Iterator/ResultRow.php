<?php
/**
 * ��������� ���������� ������� (��������).
 * �������� �� ��������� �������� ��������.
 * 
 * -------------------------------------------------------
 * | ����������: Dune                                     |
 * | ����: ResultRow.php                                  |
 * | � ����������: Dune/Mysqli/Iterator/ResultRow.php     |
 * | �����: ������ ����� (Dune) <dune@rznlf.ru>           |
 * | ������: 1.00                                         |
 * | ����: www.rznlf.ru                                   |
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