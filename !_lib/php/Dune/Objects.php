<?php
/**
 * ����������� ����� ���������� � ���� ��������� �������.
 * 
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Objects.php                                 |
 * | � ����������: Dune/Objects.php                    |
 * | �����: ������ ����� (Dune) <dune@rznlf.ru>        |
 * | ������: 0.91                                      |
 * | ����: www.rznlf.ru                                |
 * ----------------------------------------------------
 * 
 * ������� ������:
 * -----------------
 * 
 * ������ 0.90 -> 0.91
 * ��������� ���������� ������� Dune_Build_Template $pageTemplare
 * 
 */
abstract class Dune_Objects
{
    /**
     * ������ ��������� �� ��������� ������ Dune_Data_Container_Command
     *
     * @var Dune_Data_Container_Command
     */
    static public $command;
    
    /**
     * ������ ��������� �� ��������� ������ Dune_Build_Template
     *
     * @var Dune_Build_Template
     */
    static public $pageTemplate;
    
}