<?php
/**
 * �������� ���������� ����������
 *
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Base.php                                    |
 * | � ����������: Dune/Exception/Base.php             |
 * | �����: ������ ����� (Dune) <dune@pochta.ru>       |
 * | ������: 1.01                                      |
 * | ����: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * 
 * 
 */
class Dune_Exception_Base extends Exception 
{
//    protected $trace;
    
//    public function getTrace()
//    {
//        return $this->trace;
//    }
    public function __construct($string = '', $code = 0)
    {
        parent::__construct($string, $code);
    }
}