<?php
/**
 * ����������� ����� mysqli �� ����������
 * 
 * ������ �������� ������� ������� Dune_MysqliSystem::getInstance()
 * 
 * ��� ��������� ������ ������� ������������ ��������� �� ��� ��������� ������.
 * 
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: MysqliSystem.php                            |
 * | � ����������: Dune/MysqliSystem.php               |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 1.04                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * 
 * ������� ������:
 * -----------------
 * 
 * ������ 1.04
 * ��������� ������ Dune_Mysqli
 *
 * ������ 1.02 -> 1.03
 * ������ ���������� ������� ��� ��������� ��������� (������)
 * 
 * ������ 1.01 -> 1.02
 * �������� ������ � ������ ������������. ��������� - ����� Dune_Parameters
 * �������� ����� ��������� ���������
 * 
 * ������ 1.00 -> 1.01
 * ��������� ����������� ��������� ���������, ���� ���� ����� ����� � ������ �����
 * 
 *
 */

class Dune_MysqliSystem extends Dune_Mysqli_Abstract_Mysqli
{
   /**
    * ����. ��� ������ ������ ����. ������ � ������������ ��� �����������
    *
    * @var ��������� �� ������
    */
  static private $instance = NULL;

  
  /**
   * ������ ���������� ������ ��� ������ ������
   * ���������� ���������� ��������� ������� ��� ����������� �������
   *
   * �������� ��������� �� ������ � ���������� �����������
   * 
   * @return Dune_MysqliSystem
   */
  static function getInstance()
  {
    if (self::$instance == NULL)
    {
      self::$instance = new Dune_MysqliSystem(Dune_Parameters::$mysqlHost,
                                   Dune_Parameters::$mysqlUsername,
                                   Dune_Parameters::$mysqlPasswd,
                                   Dune_Parameters::$mysqlDbname);
      
      
      if (mysqli_connect_errno())
            throw new Dune_Exception_Mysqli("������ �����������: ".mysqli_connect_error());

      $query = 'SET NAMES ' . Dune_Parameters::$mysqlCharsetName;
      self::$instance->query($query);
      
      $query = ' SET CHARACTER SET ' . Dune_Parameters::$mysqlCharsetName;
      self::$instance->query($query);
      
    }
    return self::$instance;
  }


}