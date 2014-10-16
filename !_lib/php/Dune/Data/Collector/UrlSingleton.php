<?php
/**
 * ����������� ������ �������. ���������.
 * �������� ���������� - ������ ������ �������� ��������� � ��������� ������.
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Url.php                                     |
 * | � ����������: Dune/Data/Colletor/UrlSingleton.php |
 * | �����: ������ ����� (Dune) <dune@rznlf.ru>        |
 * | ������: 1.00                                      |
 * | ����: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * ������� ������:
 *
 * ������ 1.00 -> 1.01
 * 
 */
class Dune_Data_Collector_UrlSingleton extends Dune_Data_Collector_Abstract_Url
{
   /**
    * ����. ��� ������ ������ ����. ������ � ������������ ��� �����������
    *
    * @var Dune_Session
    * @access private
    */
    static private $instance = NULL;
 
  
/////////////////////////////////////////////////////////////////////
//////////////////////////////      ��������� ������    
  /**
   * ������ ���������� ������ ��� ������ ������
   * ���������� ���������� ��������� ������� ��� ����������� �������
   *
   * �������� ��������� �� ������ � ���������� �����������
   * 
   * @return Dune_Data_Collector_UrlSingleton
   */
    static public function getInstance()
    {
        if (self::$instance == NULL)
        {
            self::$instance = new Dune_Data_Collector_UrlSingleton();
        }
        return self::$instance;
    }
    
    
}