<?php
/**
 * 
 * �������
 * 
 */
abstract class Special_Vtor_Tables
{
    /**
     * ������� ������������������ �����
     *
     * @var string
     */
    static public $houses = 'unity_sub_house';
    
    
    static public $grid = 'unity_sub_grid';
    static public $gridPorch = 'unity_sub_grid_porch';

    
    public static $object          = 'unity_catalogue_object';
    public static $objectType      = 'unity_catalogue_object_type';
    public static $objectTypeAdd   = 'unity_catalogue_object_type_add';
    
    public static $objectCondition   = 'unity_catalogue_object_condition';
    public static $objectPlanning    = 'unity_catalogue_object_planning';
    
    /**
     * �������
     *
     * @var unknown_type
     */
    public static $adressRegion       = 'unity_catalogue_adress_region';
    
    /**
     * ������ �������
     *
     * @var string
     */
    public static $adressArea         = 'unity_catalogue_adress_area';
    
    /**
     * �������
     *
     * @var string
     */
    public static $adressSettlement   = 'unity_catalogue_adress_settlement';
    
    /**
     * ������ ������
     *
     * @var string
     */
    public static $adressDistrict     = 'unity_catalogue_adress_district';
    
    /**
     * ���������� ������
     *
     * @var string
     */
    public static $adressDistrictPlus = 'unity_catalogue_adress_district_plus';    
    
    /**
     * �����
     *
     * @var string
     */
    public static $adressStreet       = 'unity_catalogue_adress_street';
    
    /**
     * ��� ����������� ���������������
     *
     * @var string
     */
    public static $adressHouse       = 'unity_catalogue_adress_house';

    /**
     * ��� ������� �������������
     *
     * @var string
     */
    public static $user       = 'dune_auth_user_active';

    /**
     * ��� ������� ����� (����������)
     *
     * @var string
     */
    public static $group       = 'unity_catalogue_object_groups';
    
    
}