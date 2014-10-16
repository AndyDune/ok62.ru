<?php

    $GET = Dune_Filter_Get_Total::getInstance();
    
Dune_Static_StylesList::add('catalogue/info_one');
$view = Dune_Zend_View::getInstance();
$view->object = $this->object;
$planer = new Special_Vtor_Catalogue_Info_Plan($this->object->id, $this->object->time_insert); // � ���� �� ���������� (����)
$plan_situa = new Special_Vtor_Catalogue_Info_PlanSitua($this->object->id, $this->object->time_insert); // � ���� �� ������������ ����
$plan_floor = new Special_Vtor_Catalogue_Info_PlanFloor($this->object->id, $this->object->time_insert); // � ���� �� ���� �����
$plan_platform = new Special_Vtor_Catalogue_Info_PlanPlatform($this->object->id, $this->object->time_insert); // � ���� �� ���� �����


$house = new Special_Vtor_Catalogue_Info_House($this->object->id, $this->object->time_insert); // � ���� �� ���� ����
$panorama = new Special_Vtor_Catalogue_Info_Panorama($this->object->id, $this->object->time_insert); // � ���� �� �������
try
{
if ($view->object->pics and $this->mode == 'photo')
{
    throw new Dune_Exception_Control('�������� ���� �������', 1);
}

if ($planer->count() and $this->mode == 'plan')
{
    throw new Dune_Exception_Control('�������� ���� �������', 2);
}

if ($house->count() and $this->mode == 'house')
{
    throw new Dune_Exception_Control('�������� ���', 3);
}

if ($panorama->count() and $this->mode == 'panorama')
{
    throw new Dune_Exception_Control('�������� ��������', 4);
}

if ($plan_situa->count() and $this->mode == 'situa')
{
    throw new Dune_Exception_Control('�������� ������������ ����', 5);
}
if ($plan_floor->count() and $this->mode == 'floor')
{
    throw new Dune_Exception_Control('�������� ���� �����', 6);
}


switch ($this->object->type)
{
        case 1: // ��������
            $object_condition = new Special_Vtor_Object_Condition();
            $object_condition = $object_condition->getList(1);
            $object_planning = new Special_Vtor_Object_Planning();
            $object_planning = $object_planning->getList();
           
            $view->condition = $object_condition;
            $view->planning = $object_planning;
            
            $object_card = $view->render('bit/catalogue/object/info/type/room');
        break;
        case 3: // �����
            $object_condition = new Special_Vtor_Object_Condition();
            $object_condition = $object_condition->getList(1);
            $object_planning = new Special_Vtor_Object_Planning();
            $object_planning = $object_planning->getList();
           
            $view->condition = $object_condition;
            $view->planning = $object_planning;
            
            $object_card = $view->render('bit/catalogue/object/info/type/garage');
        break;

        case 4: // �������
            $object_condition = new Special_Vtor_Object_Condition();
            $object_condition = $object_condition->getList(1);
            $view->condition = $object_condition;
            $object_card = $view->render('bit/catalogue/object/info/type/nolife');
        break;
        
        case 5: // �������
            $object_condition = new Special_Vtor_Object_Condition();
            $object_condition = $object_condition->getList(1);
            $view->condition = $object_condition;
            $object_card = $view->render('bit/catalogue/object/info/type/pantry');
        break;
        
        default:
            $object_card = $view->render('bit/catalogue/object/info/type/common');
}
        $view->object_card = $object_card;
        Dune_Static_StylesList::add('catalogue/info_one');
}
catch (Dune_Exception_Control $e)
{
    switch ($e->getCode())
    {
        case 1:
            Dune_Static_StylesList::add('catalogue/info_one_photo');
            Dune_Static_StylesList::add('thickbox');
            $pics = new Special_Vtor_Catalogue_Info_Image($this->object->id, $this->object->time_insert);
            $view->data = $pics;
            $object_card = $view->render('bit/catalogue/object/info/photo');
        break;
        case 2:
            Dune_Static_StylesList::add('catalogue/info_one_plan');
            Dune_Static_StylesList::add('thickbox');
            $view->data = $planer;
            $object_card = $view->render('bit/catalogue/object/info/plan');
        break;
        case 3:
            Dune_Static_StylesList::add('catalogue/info_one_photo');
            Dune_Static_StylesList::add('thickbox');
            $view->data = $house;
            $object_card = $view->render('bit/catalogue/object/info/house');
        break;
        case 4:
            Dune_Static_StylesList::add('catalogue/info_panorama');
            $view->data = $panorama;
            $view->adress_object = $this->adress_object;
            $view->type = $this->type;
            $view->mode = $this->mode;
            $view->object_id = $this->object->id;
            $view->number = $GET->getDigit('number', 1, 2);
            $view->view_folder = Dune_Variables::$pathToViewFolder;
            
            // ������ ������ �� ������� ������
            $collect = new Special_Vtor_Catalogue_Url_Collector();
            $collect->setAdress($this->adress_object);
            $collect->setType($this->type);
            $collect->setMode($this->mode);
            $collect->setObject($this->object->id);
            $view->base_url = $collect->get();
            
            if (Dune_Parameters::$ajax)
                $object_card = $view->render('bit/catalogue/object/info/panorama_ajax');
            else 
                $object_card = $view->render('bit/catalogue/object/info/panorama');
        break;
        
        case 5:
            Dune_Static_StylesList::add('catalogue/info_one_plan');
            Dune_Static_StylesList::add('thickbox');
            $view->data = $plan_situa;
            $object_card = $view->render('bit/catalogue/object/info/plan');
        break;
        case 6:
            Dune_Static_StylesList::add('catalogue/info_one_plan');
            Dune_Static_StylesList::add('thickbox');
            $view->data = $plan_floor;
            $object_card = $view->render('bit/catalogue/object/info/plan');
        break;
        
        
    }
    $view->object_card = $object_card;
    
}


    $url = new Special_Vtor_Catalogue_Url_Collector();
    $url->setType($this->type);
    $url->setObject($this->object->id);
    $url->setAdress($this->adress_object);
    $bookmarks[1] = array('����������', 'info', $url->get(), false);
    if ($view->object->pics)
    {
        $url->setMode('photo');
        $bookmarks[2] = array('����', 'photo', $url->get(), false);
    }
    if ($planer->count())
    {
        $url->setMode('plan');
        $bookmarks[3] = array('����������', 'plan', $url->get(), false);
    }
    
    if ($house->count())
    {
        $url->setMode('house');
        $bookmarks[4] = array('���', 'house', $url->get(), false);
    }
    if ($panorama->count())
    {
        $url->setMode('panorama');
        $bookmarks[5] = array('��������', 'panorama', $url->get(), false);
    }
    if ($plan_situa->count())
    {
        $url->setMode('situa');
        $bookmarks[6] = array('������������ ����', 'situa', $url->get(), false);
    }
    if ($plan_floor->count())
    {
        $url->setMode('floor');
        $bookmarks[7] = array('���� �����', 'floor', $url->get(), false);
    }
    
    $default = true;
    foreach ($bookmarks as $key => $value)
    {
        if ($this->mode == $value[1])
        {
            $bookmarks[$key][3] = true;
            $default = false;
        }
    }
    if ($default)
    {
        $bookmarks[1][3] = true;
    }
    $view->bookmarks = $bookmarks;
    
    echo $view->render('bit/catalogue/object/info/index');
