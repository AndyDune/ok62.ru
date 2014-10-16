<?php
$post = Dune_Filter_Post_Total::getInstance();
    
switch ($post->_do_) {
    

    case 'sub_house_to_edit':
        $mod = new Special_Vtor_Sub_List_House();
        $res = $mod->setToUpdate(); // выполнить модуль
        $sess = Dune_Session::getInstance('result');	    
        $sess->count = $res;
        
        $mod = new Special_Vtor_Sub_List_Complex();
        $mod->setToUpdate(); // выполнить модуль
        
    break;
    
    
    case 'object_remont':
        $mod = new Module_Catalogue_Object_OfficeChange();
        $mod->id = $post->id;
        $mod->mode = 'all';
        $mod->make(); // выполнить модуль
        $sess = Dune_Session::getInstance('result');	    
        if ($mod->getResult('success'))
	       $sess->count = 1;
        else 
            $sess->count = 0;
    break;
	case 'reset_have_situa_zero':
	    $bd = Dune_MysqliSystem::getInstance();
	    $q = 'UPDATE `unity_catalogue_object` SET have_situa = NULL WHERE have_situa = 0';
	    $count = $bd->query($q, null, Dune_MysqliSystem::RESULT_AR);
	    $sess = Dune_Session::getInstance('result');
	    $sess->count = $count;
	break;

	case 'reset_district_plus':	
	    $bd = Dune_MysqliSystem::getInstance();
	    $q = 'UPDATE `unity_catalogue_object` SET district_id_plus = 0 WHERE district_id_plus = 1';
	    $count = $bd->query($q, null, Dune_MysqliSystem::RESULT_AR);
	    $sess = Dune_Session::getInstance('result');
	    $sess->count = $count;
	break;
	
	case 'set_district_plus':
	    
	    $list = new Special_Vtor_Object_List();
	    
	    $list->setRegion(1);
	    $list->setArea(1);
	    $list->setSettlement(1);
	    $list->setDistrictPlusNo();
	    $object_list = $list->getListCumulate($post->getDigit('shift'), $post->getDigit('limit'));
	    $count = count($object_list);
	    
	    $count_success = 0;
	    if ($count) // Перебираем
	    {
	        $y = $x = 0;
	        foreach ($object_list as $value)
	        {
	            if ($value['gm_x'] > 10 and $value['gm_y'] > 10)
	            {
	                $y = $value['gm_y'];
	                $x = $value['gm_x'];
	            }
	            else if ($value['house_gm_x'] > 10 and $value['house_gm_y'] > 10)
	            {
	                $y = $value['house_gm_y'];
	                $x = $value['house_gm_x'];
	            }
	            else if ($value['group_gm_x'] > 10 and $value['group_gm_y'] > 10)
	            {
	                $y = $value['group_gm_y'];
	                $x = $value['group_gm_x'];
	            }
	            
	            if ($x)
	            {
                    // ТОчка в районе
                    $mod = new Module_Map_HitDistrictPlus();
                    $mod->x = $x;
                    $mod->y = $y;
                    $mod->make();
//                    echo $mod->getOutput() , '<br />';
//                    echo $mod->getResult('message'), '<br />';
                    if ($mod->getResult('success')) // Не нашли район
                    {
//                        die();
//                        echo 'Нашли: ' . Special_Vtor_Districts::$list[$mod->getResult('district')];
                        $object = new Special_Vtor_Object_Data($value['id']);
                        $object->district_id_plus = $mod->getResult('district');
                        $object->save();
                        $count_success++;
                    }
                    else 
                    {
                        $object = new Special_Vtor_Object_Data($value['id']);
                        $object->district_id_plus = 1;
                        $object->save();
                    }
	            }
                else  // Не указаны координаты
                {
                    $object = new Special_Vtor_Object_Data($value['id']);
                    $object->district_id_plus = 1;
                    $object->save();
                }
	        }
	    }
	    
	    $sess = Dune_Session::getInstance('result');	    
	    $sess->count = $count;
	    $sess->count_success = $count_success;
//	    die();
	break;
	
	default:
	break;
}
