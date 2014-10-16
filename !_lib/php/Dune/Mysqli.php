<?php
/**
 * ����������� ����� mysqli �� ����������
 * 
 * ������ �������� ������� ������� Dune_Mysqli::getInstance($host,$username,$passwd,$dbname)
 * ��� ��������� ������ ������� ������������ ��������� �� ��� ��������� ������.
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Mysqli.php                                  |
 * | � ����������: Dune/Mysqli.php                     |
 * | �����: ������ ����� (Dune) <dune@rznlf.ru>        |
 * | ������: 1.03                                      |
 * | ����: www.rzw.ru                                  |
 * ----------------------------------------------------
 * 
 * 
 * ������� ������:
 * -----------------
 * 
 * 1.03 (2009 ������ 30)
 * ������ ���������
 * 
 * 
 * ������ 1.00 -> 1.02
 * ����� ��������.
 * 
 * ������ 1.00 -> 1.01
 * ����� ���� ���������.
 * !! ������������� ���������� �� ������ goDB (http://pyha.ru/go/godb/)
 *
 */
class Dune_Mysqli extends Dune_Mysqli_Abstract_Mysqli
{
   /**
    * ����. ��� ������ ������ ����. ������ � ������������ ��� �����������
    *
    * @var ��������� �� ������
    */
   static private $instance = array();


  /**
   * ������ ���������� ������ ��� ������ ������
   * ���������� ���������� ��������� ������� ��� ����������� �������
   *
   * @param string $host
   * @param string $username
   * @param string $passwd
   * @param string $dbname
   * @return Dune_Mysqli
   */
  static function getInstance($host = null, $username = null, $passwd = null,$dbname = null,$port = null, $socket = null)
  {
    $key = (string)$host . (string)$username . (string)$passwd . (string)$dbname . (string)$port . (string)$socket;
    if (!key_exists($key, self::$instance))
    {
      self::$instance[$key] = new Dune_Mysqli($host, $username, $passwd, $dbname, $port, $socket);
      if (mysqli_connect_errno())
            throw new Dune_Exception_Mysqli("������ �����������: ".mysqli_connect_error());
    }
    return self::$instance[$key];
  }

}