<?php
/**
 * 
 * ������ � ����������� �������.
 * 
 */
class Special_Vtor_Object_Request_DataSingleton extends Special_Vtor_Object_Request_Abstract_Data
{
    
   /**
    * ����. ��� ������ ������ ����. ������ � ������������ ��� �����������
    *
    * @var Special_Vtor_Object_Request_DataSingleton
    * @access private
    */
    static private $instance = NULL;
    
  /**
   * ������ ���������� ������ ��� ������ ������
   * ���������� ���������� ��������� ������� ��� ����������� �������
   *
   * �������� ��������� �� ������ � ���������� �����������
   * 
   * @return Special_Vtor_Object_Request_DataSingleton
   */
    static public function getInstance($id = 0)
    {
        if (self::$instance == NULL)
        {
            self::$instance = new Special_Vtor_Object_Request_DataSingleton($id);
        }
        return self::$instance;
    }

}