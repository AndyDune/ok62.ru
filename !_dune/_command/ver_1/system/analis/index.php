<?php
// Модуль, отдающий поле аутентифокации если пользовательне опознан
// Либо поле информации о пользователе.

$get = Dune_Filter_Get_Total::getInstance();
if ($get->clear == 'yes')
{
    $db = Dune_MysqliSystem::getInstance();
    $q = 'UPDATE `unity_catalogue_object` SET have_panorama = NULL';
    $dbr = $db->query($q, null, Dune_MysqliSystem::RESULT_AR);
    echo 'Затронули:', $dbr;
    
    $db = Dune_MysqliSystem::getInstance();
    $q = 'UPDATE `unity_catalogue_object` SET pics = NULL WHERE pics = 0';
    $dbr = $db->query($q, null, Dune_MysqliSystem::RESULT_AR);
    echo '<br />Затронули при обнулении картинок:', $dbr;
    
    die();
}
$q = 'SELECT * FROM `unity_catalogue_object` WHERE `activity` = 1 and (have_panorama IS NULL or have_plan IS NULL) order by id LIMIT 50';

$db = Dune_MysqliSystem::getInstance();
$dbr = $db->query($q, null, Dune_MysqliSystem::RESULT_IASSOC);
if (!count($dbr))
{
    echo 'Все обработано';
    die();
}
$done_plan = 0;
$done_panorama = 0;
foreach ($dbr as $value)
{
    $object = new Special_Vtor_Object_Data($value['id']);
    $planer = new Special_Vtor_Catalogue_Info_Plan($object->id, $object->time_insert); // а есть ли планеровка (план)
    //$plan_situa = new Special_Vtor_Catalogue_Info_PlanSitua($object->id, $object->time_insert); // а есть ли ситуационный план
    //$plan_floor = new Special_Vtor_Catalogue_Info_PlanFloor($object->id, $object->time_insert); // а есть ли план этажа
    //$plan_platform = new Special_Vtor_Catalogue_Info_PlanPlatform($object->id, $object->time_insert); // а есть ли план этажа
    
        
    //$house = new Special_Vtor_Catalogue_Info_House($object->id, $object->time_insert); // а есть ли фото дома
    $panorama = new Special_Vtor_Catalogue_Info_Panorama($object->id, $object->time_insert); // а есть ли панораы
    
    if (!$panorama->count() and $object->panorama)
        $panorama = new Special_Vtor_Catalogue_Info_PanoramaCommon($object->panorama); // а есть ли панораы
    
    
    // Выяснение похожих объектов
    $have_group = 0;
        
    $have_modif = false;
    if (is_null($object->have_plan)) // Фиксируем наличие плана
    {
        $object->have_plan = $planer->count();
        $have_modif = true;
        if ($planer->count())
            $done_plan++;
    }
    if (is_null($object->have_panorama)) // Фиксируем наличие панорамы
    {
        $object->have_panorama = $panorama->count();
        $have_modif = true;
        if ($panorama->count())
            $done_panorama++;
    }
    if ($have_modif) // Сохраняем ченжи
    {
        $object->save();
    }
}

echo '<br /> Прилепили планов: ' . $done_plan;
echo '<br /> Прилепили панораf: ' . $done_panorama;
die();