<?php
ini_set('always_populate_raw_post_data', 'On');


//phpinfo(); die();
    $post = Dune_Filter_Post_Total::getInstance();
    $get = Dune_Filter_Get_Total::getInstance();
    
    $session = Dune_Session::getInstance('control');
    $current_object = Special_Vtor_Object_Query_DataSingleton::getInstance($session->edit);        
    
    $URL = Dune_Parsing_UrlSingleton::getInstance();
    
    if ($URL->getCommandPart(5) == 'do')
    {
        $plan = new Special_Vtor_Object_Query_Plan($current_object->getId(), $current_object->getTime(), true);    
        
        $files_array = Dune_AsArray_File_String::getInstance(Dune_Variables::$pathToArrayFiles);
        Dune_BeforePageOut::registerObject($files_array);

        switch ($URL->getCommandPart(5,2))
        {
            
            case 'loadxml':
                //$files_array['loadxml'] = 'Загрузили xml ' . time();
                
                $session = Dune_Session::getInstance('flash');
                
                if ($session->image_data and strlen($session->image_data) > 10)
                    echo $session->image_data;
                else 
                    echo '<planning></planning>';
//                echo $session->image_data;
//                echo $files_array['xml'];
                throw new Dune_Exception_Control_Text();
                
            case 'loadpng':            
            echo '<message>ok</message>';
            throw new Dune_Exception_Control_Text();
                
                
            case 'savexml': 
                if (isset($GLOBALS["HTTP_RAW_POST_DATA"]))
                {
                    $session = Dune_Session::getInstance('flash');
                    $session->image_data = $GLOBALS["HTTP_RAW_POST_DATA"];
                }
                echo '<message>ok</message>';
//                $files_array['xml'] = $session->image_data;
                throw new Dune_Exception_Control_Text();
                
            case 'savepng':
//                $image_data = $GLOBALS["HTTP_RAW_POST_DATA"] ;
                $image_data = file_get_contents('php://input');
                $filename_to_save = $_SERVER['DOCUMENT_ROOT'] . '/_temp/input/draw_plan/' . uniqid('flash', true);
                
//                $files_array['do'] = time();
                
                if(isset($image_data))
                {
                	$png_file = fopen($filename_to_save, "wb") or die("File not opened!");
                	if($png_file)
                	{
                		  set_file_buffer($png_file, 20);
                		  fwrite($png_file, $image_data);
                		  fclose($png_file);
//                		  file_put_contents($filename_to_save, $image_data);
                		  
                          $plan = new Special_Vtor_Object_Query_Plan($current_object->getId(), $current_object->getTime(), true);                    		  
                          $current_object->setStatus(0);
                          $current_object->save();
                		  
                            $good = false;
                	    	$o_file_info = new Dune_Image_Info($filename_to_save);
                	        if ($o_file_info->isCorrect())
                	        {
                	            $good = true;
                	        }
                          
                          
                    	    if ($good)
                    	    {
                    	        $plan->deletePreviewFolder();
                    	        $plan->clearFolder();
                    	    	$tumb = new Dune_Image_Transform($o_file_info);
                    	        $tumb->setPathToResultImage($plan->getSystemUrl());
                    	        $tumb->setModeThumb('both');
                    	        $tumb->setProportions(10, 10);
                    	        $tumb->setModeProportion('add');
                    	        $tumb->setBackgroundColor(0xffffff);
                    	        if ($tumb->changeProportion())
                    	        	$good = $tumb->createThumb(1000);
                    	        else 
                    	        	$good = false;
                    
                    			if ($tumb->save(uniqid('pic', true)))
                    			{
                    	    			$good = true;     
                    			}
                    	    }
                          
                		  unlink($filename_to_save);
                	}
                }
                
                echo '<message>ok</message>';
                throw new Dune_Exception_Control_Text();
                return;
            break;
        }
        
        throw new Dune_Exception_Control('Сделали');
    }
    
    
    $view    = Dune_Zend_View::getInstance();
    
    
    $view->session_id = $session->getId();
    
    $view->url = '/public/sell/' . $object_type_code . '/step_31/';
    
    $view->type = $object_type;
//    $session = Dune_Session::getInstance();    
//    $view->message_code = $session->message_code;
//    unset($session->message_code);
    
    
    $text = $view->render('bit/sell/' . $object_type_code . '/auth/step_31');
    
    $session = Dune_Session::getInstance('data');
    
/*    ob_start();
    echo $session;
    $text .= ob_get_clean();
*/        
    $session = Dune_Session::getInstance('control');
    $session->step = 31;