<?php
/**
 * ��������� ���������� ������� (��������).
 * �������� � �������� �� ������ ������� � ���������� �������.
 * 
 * -------------------------------------------------------
 * | ����������: Dune                                     |
 * | ����: ResultCol.php                                  |
 * | � ����������: Dune/Mysqli/Iterator/ResultCol.php     |
 * | �����: ������ ����� (Dune) <dune@rznlf.ru>           |
 * | ������: 1.00                                         |
 * | ����: www.rznlf.ru                                   |
 * -------------------------------------------------------
 *
 */

class Dune_Mysqli_Iterator_ResultCol extends Dune_Mysqli_Iterator_Parent_Result
{
    protected function getEl()
    {
        $r = $this->result->fetch_row();
        return $r[0];
    }
}
