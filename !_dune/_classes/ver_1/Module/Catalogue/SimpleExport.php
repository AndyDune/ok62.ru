<?php

class Module_Catalogue_SimpleExport extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        

ini_set('max_execution_time', 360);
//phpinfo(); die();


    $this->setResult('success', false);

    $time_year = date('Y');
    $path_object = $_SERVER['DOCUMENT_ROOT'] . '/catalogue/objects';
    $path_object_time = $_SERVER['DOCUMENT_ROOT'] . '/catalogue/objects/' . $time_year;
    $path_object_time_local = 'catalogue/objects/' . $time_year;
    
    $need_folder = $_SERVER['DOCUMENT_ROOT'] . '/' . trim($this->folder_main, ' \\/') . '/' . $this->folder;
    //$need_folder = $_SERVER['DOCUMENT_ROOT'] . '/' . $this->folder_main . '/' . $this->folder;
    if (!is_dir($need_folder))
        throw new Dune_Exception_Control_Goto('', 2);
    $need_file = $need_folder . '/data.xml';
    $need_done = $need_folder . '/lock';
    if (!is_file($need_file))
        throw new Dune_Exception_Control_Goto('', 3);

    if (is_file($need_done))
        throw new Dune_Exception_Control_Goto('', 5);
        
        
    $xml = simplexml_load_file($need_file);
    if ($xml === false)
        throw new Dune_Exception_Control_Goto('', 4);
        
    $text = '';
    $array_to_db = array();
    foreach ($xml->object as $apartment)
    {
        
        $array_run = array();
        foreach ($apartment as $key => $value)
        {
            $array_run[$key] = iconv('UTF-8', 'windows-1251', $value);
            if ($array_run[$key] == 'on' or $array_run[$key] == 'On')
            {
                $array_run[$key] = 1;
            }
            if ($array_run[$key] == 'off' or $array_run[$key] == 'Off')
            {
                $array_run[$key] = 0;
            }
        }
        
//////////  Корректировка массива   <>     
            if (isset($array_run['room']) and strlen($array_run['room']) > 1 and (int)$array_run['room'] < 1)
            {
                $array_run['room'] = substr($array_run['room'], 1);
            }
            
//            $array_run['id'] = 1; // Временно
            
            
            switch ($array_run['type'])
            {
                case 'apartment':
                    $array_run['type'] = 1;
                    $array_run['type_name'] = 'apartment';
                break;
                case 'office':
                    $array_run['type'] = 4;
                    $array_run['type_name'] = 'office';
                break;
                case 'store':
                    $array_run['type'] = 5;
                    $array_run['type_name'] = 'store';
                break;
                case 'garage':
                    $array_run['type'] = 3;
                    $array_run['type_name'] = 'garage';
                    
                break;
                default: continue;
            }
            
            if (($array_run['type'] == 4 or $array_run['type'] == 5)  and $array_run['floor'] == 0)
                $array_run['floor'] = -1;
            
            $array_run['activity'] = 1;
            
//////////  Корректировка массива </>
        
        //$adress = new Special_Vtor_AdressLine($array_run['street']);
        $adress = new Special_Vtor_AdressLine($array_run['street']);
        $array_run['street_id'] = $array_run['street'];
        
        $array_run['region_id'] = $adress->getDataRegion();
        $array_run['region_id'] = $array_run['region_id']['id'];
        
        $array_run['area_id'] = $adress->getDataArea();
        $array_run['area_id'] = $array_run['area_id']['id'];

        $array_run['district_id'] = $adress->getDataDistrict();
        $array_run['district_id'] = $array_run['district_id']['id'];

        $array_run['settlement_id'] = $adress->getDataSettlement();
        $array_run['settlement_id'] = $array_run['settlement_id']['id'];
        
        if (is_dir($need_folder . '/' . $array_run['id'] . '/plan'))
        {
            $dir = new DirectoryIterator($need_folder . '/' . $array_run['id'] . '/plan');
            foreach ($dir as $file)
            {
                if ($file->isFile())
                {
                    $array_run['plan'] = $need_folder . '/' . $array_run['id'] . '/plan/' . $file;
                    break;
                }
            }
        }

        if (is_dir($need_folder . '/' . $array_run['id'] . '/situa'))
        {
            $dir = new DirectoryIterator($need_folder . '/' . $array_run['id'] . '/situa');
            foreach ($dir as $file)
            {
                if ($file->isFile())
                {
                    $array_run['situa'] = $need_folder . '/' . $array_run['id'] . '/situa/' . $file;
                    break;
                }
            }
        }

        if (is_dir($need_folder . '/' . $array_run['id'] . '/floor'))
        {
            $dir = new DirectoryIterator($need_folder . '/' . $array_run['id'] . '/floor');
            foreach ($dir as $file)
            {
                if ($file->isFile())
                {
                    $array_run['floor_i'] = $need_folder . '/' . $array_run['id'] . '/floor/' . $file;
                    break;
                }
            }
        }
        
        $array_to_db[] = $array_run;
    } // конец перебора xml
        ob_start();
        echo '<pre>';
        print_r($array_to_db);
        echo '</pre>';
        $text = ob_get_clean();
    
       $count = count($array_to_db);
       
 $session = Dune_Session::getInstance('export');
 $session->text = $text;
       
if ($count > 0)
{
////////////////////////           Сохраняем в базе массив $array_to_db

$proportion_x = Special_Vtor_Settings::$pictureProportionX;
$proportion_y = Special_Vtor_Settings::$pictureProportionY;
$proportion_mode = Special_Vtor_Settings::$pictureProportionMode;
$proportion_color = Special_Vtor_Settings::$pictureProportionBGColor;

foreach ($array_to_db as $array_run)
{
        $object = new Special_Vtor_Object_Data();
        foreach ($array_run as $key => $value)
        {
            $object->$key = $value;
        }
       // $id =  0;
        $id = $object->add();
        if ($id)
        {
            $path_dir = $path_object_time_local . '/' . $id;
            
            $ndir = new Dune_Directory_Make($path_dir);
            if ($ndir->make(2))
            {
    ////////////////  Картинки сохраняем    <>
                if (isset($array_run['plan']) and $array_run['plan'])
                {
                    $path = $path_dir . '/plan';
                    $ndir = new Dune_Directory_Make($path);
                    $ndir->make(1);
                    
                    $separ_pos = strrpos($array_run['plan'], '/');
                    if ($separ_pos)
                    {
                            $fname = trim(substr($array_run['plan'], $separ_pos), ' /\\');
                        
                            $img = new Dune_Image_Info($array_run['plan']);
                	    	$tumb = new Dune_Image_Transform($img);
                	        $tumb->setPathToResultImage($_SERVER['DOCUMENT_ROOT'] . '/' . $path)
                	             ->setModeThumb('both')
                	             ->setProportions($proportion_x, $proportion_y)
                	             ->setModeProportion('add')
                	             ->setBackgroundColor($proportion_color);
                	        if ($tumb->changeProportion())
                	        	$good = $tumb->createThumb(900);
                	        else 
                	        	$good = false;
                	        	
                			if ($tumb->save('plan'))
                			{
                	    			$good = true;     
                			}
                        //copy($array_run['plan'], $path . '/' . $fname);
                    }
                }
    /////////////////   Картинки сохраняем    </>

    
    ////////////////  Ситуационный план сохраняем    <>
                if (isset($array_run['situa']) and $array_run['situa'])
                {
                    $path = $path_dir . '/situa';
                    $ndir = new Dune_Directory_Make($path);
                    $ndir->make(3);
                    
                    $separ_pos = strrpos($array_run['situa'], '/');
                    if ($separ_pos)
                    {
                        $img = new Dune_Image_Info($array_run['situa']);
                        $fname = '1' . $img->getExtension();
                        copy($array_run['situa'], $_SERVER['DOCUMENT_ROOT'] . '/' . $path . '/' . $fname);
                    }
                }
    /////////////////   Картинки сохраняем    </>

    ////////////////  План этажа сохраняем    <>
                if (isset($array_run['floor_i']) and $array_run['floor_i'])
                {
                    $path = $path_dir . '/floor';
                    $ndir = new Dune_Directory_Make($path);
                    $ndir->make(3);
                    
                    $separ_pos = strrpos($array_run['floor_i'], '/');
                    if ($separ_pos)
                    {
                        $img = new Dune_Image_Info($array_run['floor_i']);
                        $fname = 'plan' . $img->getExtension();

                        copy($array_run['floor_i'], $_SERVER['DOCUMENT_ROOT'] . '/' . $path . '/' . $fname);
                    }
                }
    /////////////////   Картинки сохраняем    </>
    
    
            }
        }
}


file_put_contents($need_done, 'Загружено');
///////////////////////
}
        
        
    
    $this->setResult('success', true);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    