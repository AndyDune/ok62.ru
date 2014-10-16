<?php
class Special_Vtor_Object_Request_DataInType_Room extends Dune_Data_Collector_Abstract_ArrayAllow
{
    /**
     * ������ ����������� ����� ��� ������������� � �������.
     *
     * ������:
     * <��� ����> => array(<����>, <�����>)
     * <��� ����> => array(<����>, <�����>)
     * ...
     * 
     * �����������:
     * <����> : 'i' - ����� �����
     *          's' - ������
     *          'f' - ����� � ��������� ������
     * <�����> : ��� ������ - ����� ��������, ��� ����� - ����������� ��������
     * 
     * @var array
     * @access private
     */
    protected $allowFields = array(
//                                  'text' => array('s', 3000)
                                  'rooms_count' => array('i', 100)
                                  );

}