<?php
/**
 * ��������� ���������� ������� (��������).
 * �������� � ������������� ��������.
 * 
 * -------------------------------------------------------
 * | ����������: Dune                                     |
 * | ����: ResultAssoc.php                                |
 * | � ����������: Dune/Mysqli/Iterator/ResultAssoc.php   |
 * | �����: ������ ����� (Dune) <dune@rznlf.ru>           |
 * | ������: 1.00                                         |
 * | ����: www.rznlf.ru                                   |
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


