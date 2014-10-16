<?php
ini_set('always_populate_raw_post_data', 'On');

try {
//phpinfo(); die();
    $post = Dune_Filter_Post_Total::getInstance();
    $get = Dune_Filter_Get_Total::getInstance();
    
    $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
    $user_id = $session->user_id;
    
    $draw = new Special_Vtor_DrawPlan();
    
    
    $URL = Dune_Parsing_UrlSingleton::getInstance();
    
    
    if ($URL->getCommandPart(4) == 'do')
    {
/*        $files_array = Dune_AsArray_File_String::getInstance(Dune_Variables::$pathToArrayFiles);
        $files_array['1'] = 'Загрузили xml ' . time();
        Dune_BeforePageOut::registerObject($files_array);
*/
        switch ($URL->getCommandPart(4, 2))
        {
            case 'loadxml':
                //$files_array['loadxml'] = 'Загрузили xml ' . time();
                $draw = new Special_Vtor_DrawPlan();
                $draw->setUserId($user_id);
                $list = $draw->getOneOfUser();
                if ($list)
                    echo $list['xml'];
                else 
                    echo '<planning></planning>';
                throw new Dune_Exception_Control_Text();
                
            case 'savexml': 
            
                if (isset($GLOBALS["HTTP_RAW_POST_DATA"]))
                {
                    $draw = new Special_Vtor_DrawPlan();
                    $list = $draw->setUserId($user_id)->getOneOfUser();
                    if ($list)
                    {
                        $draw->setDrawId($list['id'])->saveXML($GLOBALS["HTTP_RAW_POST_DATA"]);
                    }
                    else 
                    {
                        $draw->addWithXML($GLOBALS["HTTP_RAW_POST_DATA"]);
                    }
                    
                }
                
                echo '<message>ok</message>';
                throw new Dune_Exception_Control_Text();

            case 'topublic': 
            
                    $draw = new Special_Vtor_DrawPlan();
                    $list = $draw->setUserId($user_id)->getOneOfUser();
                    if ($list)
                    {
                        $draw->setDrawId($list['id'])->savePublic(1);
                    }
                    
                throw new Dune_Exception_Control_Text();
            break;                
            case 'frompublic': 
                    
                    $draw = new Special_Vtor_DrawPlan();
                    $list = $draw->setUserId($user_id)->getOneOfUser();
                    if ($list)
                    {
                        $draw->setDrawId($list['id'])->savePublic(0);
                    }
                    
                throw new Dune_Exception_Control_Text();
            break;                
            
            
            case 'loadpng':            
                    $draw = new Special_Vtor_DrawPlan();
                    $draw->setUserId($user_id);
                    $list = $draw->getOneOfUser();
                    if ($list)
                    {
                        header("Content-type: image/png");
                        Dune_Static_Header::noCache();
                        echo $list['file'];
                    }
            throw new Dune_Exception_Control_Text();
            case 'savepng':
//                throw new Dune_Exception_Control_Text();
                
//                $image_data = $GLOBALS["HTTP_RAW_POST_DATA"] ;
                $image_data = file_get_contents('php://input');
                $file_name = uniqid('flash', true);
                $filename_to_save = $_SERVER['DOCUMENT_ROOT'] . '/_temp/input/draw_plan/' . $file_name;
                $filename_to_save_result = $_SERVER['DOCUMENT_ROOT'] . '/_temp/input/draw_plan_db';
                
//                $files_array['do'] = time();
                
                if(isset($image_data))
                {
                    $draw = new Special_Vtor_DrawPlan();
                    $draw->setUserId($user_id);
                    $list = $draw->getOneOfUser();
                    
                    if (!$list)
                    {
                        $id = $draw->addOne();
                    }
                    else 
                    {
                        $id = $list['id'];
                    }
                    
                    
                    
                	$png_file = fopen($filename_to_save, "wb") or die("File not opened!");
                	if($png_file)
                	{
                		  set_file_buffer($png_file, 20);
                		  fwrite($png_file, $image_data);
                		  fclose($png_file);
//                		  file_put_contents($filename_to_save, $image_data);

                            $good = false;
                	    	$o_file_info = new Dune_Image_Info($filename_to_save);
                	        if ($o_file_info->isCorrect())
                	        {
                	            $good = true;
                	        }
                          
                    	    if ($good)
                    	    {
                    	    	$tumb = new Dune_Image_Transform($o_file_info);
                    	        $tumb->setPathToResultImage($filename_to_save_result);
                    	        $tumb->setModeThumb('both');
                    	        $tumb->setProportions(10, 10);
                    	        $tumb->setModeProportion('add');
                    	        $tumb->setBackgroundColor(0xffffff);
                    	        if ($tumb->changeProportion())
                    	        	$good = $tumb->createThumb(800);
                    	        else 
                    	        	$good = false;
                    
                    			if ($tumb->save($file_name))
                    			{
                    	    			$good = true;     
                    			}
                    	    }
                    	    if ($good)
                    	    {
                    	        
                    	    $file = file_get_contents($filename_to_save_result . '/' . $file_name . '.png');
                    	       $draw->setDrawId($id);
                    	       $draw->saveFile($file);
                    	    }
                          
                		  unlink($filename_to_save);
                		  unlink($filename_to_save_result . '/' . $file_name . '.png');
                	}
                }
                
                echo '<message>ok</message>';
                throw new Dune_Exception_Control_Text();
                return;
            break;
        }
        
        throw new Dune_Exception_Control('Сделали');
    }
    
    
    $view  = Dune_Zend_View::getInstance();
    
    
    $view->session_id = $session->getId();
    
    
    $draw = new Special_Vtor_DrawPlan();
    $draw->setUserId($user_id);
    $list = $draw->getOneOfUser();
    if ($list and strlen($list['file']) > 50)
    {
        $view->look = $list['id'];
    }
    
    $view->data = $list;
    $view->text = $view->render('bit/draw_plan/flash');
    
    echo $view->render('bit/general/container_padding_for_auth');    
    
    Dune_Variables::addTitle($view->getResult('title'));
    
}
catch (Dune_Exception_Control_Text $e)
{
    $this->setStatus(Dune_Include_Command::STATUS_TEXT);
}