<?php
// ������, �������� ���� �������������� ���� �������������� �������
// ���� ���� ���������� � ������������.

$get = Dune_Filter_Get_Total::getInstance();
if ($get->clear == 'yes')
{
    $db = Dune_MysqliSystem::getInstance();
    $q = 'UPDATE `unity_catalogue_object` SET have_panorama = NULL';
    $dbr = $db->query($q, null, Dune_MysqliSystem::RESULT_AR);
    echo '���������:', $dbr;
    
    $db = Dune_MysqliSystem::getInstance();
    $q = 'UPDATE `unity_catalogue_object` SET pics = NULL WHERE pics = 0';
    $dbr = $db->query($q, null, Dune_MysqliSystem::RESULT_AR);
    echo '<br />��������� ��� ��������� ��������:', $dbr;
    
    die();
}
$q = 'SELECT * FROM `unity_catalogue_object` WHERE `activity` = 1 and (have_panorama IS NULL or have_plan IS NULL) order by id LIMIT 50';

$db = Dune_MysqliSystem::getInstance();
$dbr = $db->query($q, null, Dune_MysqliSystem::RESULT_IASSOC);
if (!count($dbr))
{
    echo '��� ����������';
    die();
}
$done_plan = 0;
$done_panorama = 0;
foreach ($dbr as $value)
{
    $object = new Special_Vtor_Object_Data($value['id']);
    $planer = new Special_Vtor_Catalogue_Info_Plan($object->id, $object->time_insert); // � ���� �� ���������� (����)
    //$plan_situa = new Special_Vtor_Catalogue_Info_PlanSitua($object->id, $object->time_insert); // � ���� �� ������������ ����
    //$plan_floor = new Special_Vtor_Catalogue_Info_PlanFloor($object->id, $object->time_insert); // � ���� �� ���� �����
    //$plan_platform = new Special_Vtor_Catalogue_Info_PlanPlatform($object->id, $object->time_insert); // � ���� �� ���� �����
    
        
    //$house = new Special_Vtor_Catalogue_Info_House($object->id, $object->time_insert); // � ���� �� ���� ����
    $panorama = new Special_Vtor_Catalogue_Info_Panorama($object->id, $object->time_insert); // � ���� �� �������
    
    if (!$panorama->count() and $object->panorama)
        $panorama = new Special_Vtor_Catalogue_Info_PanoramaCommon($object->panorama); // � ���� �� �������
    
    
    // ��������� ������� ��������
    $have_group = 0;
        
    $have_modif = false;
    if (is_null($object->have_plan)) // ��������� ������� �����
    {
        $object->have_plan = $planer->count();
        $have_modif = true;
        if ($planer->count())
            $done_plan++;
    }
    if (is_null($object->have_panorama)) // ��������� ������� ��������
    {
        $object->have_panorama = $panorama->count();
        $have_modif = true;
        if ($panorama->count())
            $done_panorama++;
    }
    if ($have_modif) // ��������� �����
    {
        $object->save();
    }
}

echo '<br /> ��������� ������: ' . $done_plan;
echo '<br /> ��������� ������f: ' . $done_panorama;
die();