<?php
/**
*	����� ��� ������������� � ������������ ����������� ������� ����������
*	����������� ������� $_GET, $_POST, $_COOKIE
* 
* ----------------------------------------------------
* | ����������: Dune                                  |
* | ����: Request.php                                 |
* | � ����������: Dune/Request.php                    |
* | �����: ������ ����� (Dune) <dune@pochta.ru>       |
* | ������: 1.00                                      |
* | ����: www.rznlf.ru                                |
* ----------------------------------------------------
* 
*/

class Dune_Filter_Request extends Dune_Filter_Parent_Request
{

public function __construct($name,$def = 0,$filter = 'd',$prioritet = 'pg')
{
    parent::__construct($name,$def,$filter,$prioritet);
}

}