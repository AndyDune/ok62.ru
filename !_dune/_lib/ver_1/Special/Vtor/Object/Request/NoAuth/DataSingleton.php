<?php
/**
 * 
 * ������ � ����������� �������.
 * 
 */
class Special_Vtor_Object_Request_NoAuth_DataSingleton extends Special_Vtor_Object_Request_Abstract_DataNoAuth
{
    
   /**
    * ����. ��� ������ ������ ����. ������ � ������������ ��� �����������
    *
    * @var Special_Vtor_Object_Request_NoAuth_DataSingleton
    * @access private
    */
    static private $instance = NULL;
    
  /**
   * ������ ���������� ������ ��� ������ ������
   * ���������� ���������� ��������� ������� ��� ����������� �������
   *
   * �������� ��������� �� ������ � ���������� �����������
   * 
   * @return Special_Vtor_Object_Request_NoAuth_DataSingleton
   */
    static public function getInstance($id = 0)
    {
        if (self::$instance == NULL)
        {
            self::$instance = new Special_Vtor_Object_Request_NoAuth_DataSingleton($id);
        }
        return self::$instance;
    }

}