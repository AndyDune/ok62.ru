<?php
class Special_Vtor_Object_Request_DataInType_Common extends Dune_Data_Collector_Abstract_ArrayAllow
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
                                  'contact'         => array('s', 300),
                                  'adress'          => array('s', 300),
                                  'price_to'        => array('s', 300),
//                                  'rooms_count'     => array('s', 250),
                                  
                                  'rooms_count_1'   => array('i', 5, 0),
                                  'rooms_count_2'   => array('i', 5, 0),
                                  'rooms_count_3'   => array('i', 5, 0),
                                  'rooms_count_4'   => array('i', 5, 0),
                                  'rooms_count_text' => array('s', 250),
                                  
                                  'variant_text' => array('s', 250),
                                  'variant_date' => array('s', 250)
                                  
                                  );

}