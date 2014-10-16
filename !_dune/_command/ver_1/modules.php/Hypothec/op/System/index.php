<?php

	$pagetitle = $this->pagetitle;
	$module_name = $this->module_name;
	$bgcolor1 = $this->bgcolor1;
	$bgcolor2 = $this->bgcolor2;
	$bgcolor3 = $this->bgcolor3;
	
	$session = Dune_Session::getInstance();
	$session->openZone('to_db');
	
     $pagetitle = "Загрузка бызы по ипотеке";
	
	$dbConn = connectToDB();
	$post = Dune_Filter_Post_Total::getInstance();
    switch ($post->_do_)	
    {
	    case 'save':
	        $file_dl = new Dune_Upload_File('file');
	        if ($file_dl->isCorrect())
	        {
	            $session->message = '1. Файл загружен <br />';
	            $copy = new Dune_File_Copy($file_dl->getTmpName());
	            $copy->makeDirs();
	            $copy->setResultFileExtension('txt');
	            $copy->setResultFileName('text');
	            $copy->setResultFilePath('temp');
	            if ($copy->make())
	            {
// Парсинг файла и составление запроса в базу

                    $operation = new Dune_Include_Operation('make_hyp_db', dirname(__FILE__));
                    $operation->file = $_SERVER['DOCUMENT_ROOT'] . '/temp/text.txt';
                    $operation->make();

	                if ($operation->getResult('done'))
	                   $session->message .= '2. База загружена';
	                else 
	                   $session->message .= '2. Ошибка при парсинге: ' . $operation->getMassageText('result');
	            }
	            
	          // Dune_Static_Header::Location();
	        }
	    break;
	    case 'save_glossary':
	        $file_dl = new Dune_Upload_File('file');
	        if ($file_dl->isCorrect())
	        {
	            $session->message = '1. Файл загружен <br />';
	            $copy = new Dune_File_Copy($file_dl->getTmpName());
	            $copy->makeDirs();
	            $copy->setResultFileExtension('txt');
	            $copy->setResultFileName('glossary');
	            $copy->setResultFilePath('temp');
	            if ($copy->make())
	            {
// Парсинг файла и составление запроса в базу

                    $operation = new Dune_Include_Operation('make_hyp_db_glossary', dirname(__FILE__));
                    $operation->file = $_SERVER['DOCUMENT_ROOT'] . '/temp/glossary.txt';
                    $operation->make();

	                if ($operation->getResult('done'))
	                   $session->message .= '2. База загружена';
	                else 
	                   $session->message .= '2. Ошибка при парсинге: ' . $operation->getMassageText('result');
	            }
	            
	          // Dune_Static_Header::Location();
	        }
	    break;
	    
        default:
        	$form = new Dune_Form_Form();
        	$form->setMethod();
        	$form->setAction('/modules.php?name=Hypothec&op=System');
        	$form->setEnctype(Dune_Form_Form::ENCTYPE_MULTI);
        	
        	$file = new Dune_Form_InputFile('file');
        	$submit = new Dune_Form_InputSubmit('go');
        	$submit->setValue('Отправить');
        	$hidden = new Dune_Form_InputHidden('_do_');
        	$hidden->setValue('save');
        	
        	echo '<h1>Загрузка базы по ипотеке</h1>';
        	echo '<p style="text-align:center; color: red; font-size: 20px;">' . $session->message . '</p>';
        	$session->message = '';
        	
        	echo $form->getBegin();
        	echo $file;
        	echo $hidden;
        	echo '<br />';
        	echo $submit;
        	
        	echo $form->getEnd();

        	
        	$form = new Dune_Form_Form();
        	$form->setMethod();
        	$form->setAction('/modules.php?name=Hypothec&op=System');
        	$form->setEnctype(Dune_Form_Form::ENCTYPE_MULTI);
        	
        	$file = new Dune_Form_InputFile('file');
        	$submit = new Dune_Form_InputSubmit('go');
        	$submit->setValue('Отправить');
        	$hidden = new Dune_Form_InputHidden('_do_');
        	$hidden->setValue('save_glossary');
        	
        	echo '<h1>Загрузка базы Глоссария</h1>';
        	echo '<p style="text-align:center; color: red; font-size: 20px;">' . $session->message . '</p>';
        	$session->message = '';
        	
        	echo $form->getBegin();
        	echo $file;
        	echo $hidden;
        	echo '<br />';
        	echo $submit;
        	
        	echo $form->getEnd();
        	
        	
        	
        	$this->results['pagetitle'] = $pagetitle;
    }
    
    $session->closeZone();