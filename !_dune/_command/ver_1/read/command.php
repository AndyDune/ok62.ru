<?php

$vars = Dune_Variables::getInstance();

// Команда настроек пользователя

if (Dune_Variables::$userStatus > 0)
{
    $use_captcha = false;
}
else 
{
    $use_captcha = true;
}

$prem = false;

$script_path = $_SERVER['DOCUMENT_ROOT'] . '/scripts/';
$session_name = 'comments';


$table = 'unity_article_text';
$folder = '/data/read/';

    $this_command = '/read/';

    $view = Dune_Zend_View::getInstance();

    $text = '';
    $pagetitle = "";

try {    

    $URL = Dune_Parsing_UrlSingleton::getInstance();
    
//    $command = $URL->getCommandPart(2, 0, '', '-'); // Учет только последнего слова после дефиса
    $command = $URL->getCommand(2); // Учет всей команды
    
    if (!$command)
    {
        throw new Dune_Exception_Control_Goto('/');
    }
    
    // Сбор идентификатора из комманд
    $count = $URL->count();
    if ($count > 2)
    {
         
        for ($i = 3; $i <= $count; $i++)
        {
            $command .= '-' . $URL->getCommand($i);
        }
    }
    
    
    $one = new Dune_Mysqli_Table($table);
    
    
    $have_parent = false;
    $parents = array();
    
    
    $one->useKey('name_code', $command);
    if (!$data = $one->getData(true))
    {
        throw new Dune_Exception_Control_Goto('/');
    }
    
    // Сохранение комментрия
    $post = Dune_Filter_Post_Total::getInstance();
    $post->trim();
    $post->htmlSpecialChars();
    if ($data->can_comment and $post->com === 'comment')    
    {
        $module = new Module_Article_CommentSave();
        $module->use_captcha = $use_captcha;
        $module->session_name = $session_name;
        $module->id = $data->id;
        $module->text = $post->text;
        $module->prem = $prem;
        
        $module->name = $post->name;
        $module->mail = $post->mail;
        $module->site = $post->site;
        $module->captcha = $post->captcha;
        $module->make();
        throw new Dune_Exception_Control_Goto($module->getResult('goto'));
    }
    
    if ($data->parent or true)
    {
        $module = new Module_Article_Parents();
        $module->id = $data->id;
        $module->make();
        $have_parent = $module->getResult('have_parent');
        $parents = $module->getResult('data');
    }
    $text = $data->text;
    if ($data->script)
    {
        include($script_path . $data->script);
    }
    Dune_Variables::addTitle($data->title . ' ');
    Dune_Variables::$pageDescription = $data->description . Dune_Variables::$pageDescription;
    Dune_Variables::$pageKeywords = $data->keywords . Dune_Variables::$pageKeywords;

    
    
    $URL->cutCommands(1);
    $crumbs = Dune_Display_BreadCrumb::getInstance('1');
    $crumbs->addCrumb('Главная', '/');
    if ($have_parent)
    {
        $minus = '';
        $buffer = '';
        foreach ($parents as $value)
        {
            if ($value['name_crumb'])
                $name = $value['name_crumb'];
            else 
                $name = $value['name'];
            if ($value['name_code'])
                $name_code = $value['name_code'];
            else 
                $name_code = $value['id'];
//            $buffer .= $minus . $name_code;
            $buffer = str_replace('-', '/', $name_code);
            $crumbs->addCrumb($name, $URL->getCommandString() . $buffer . '/');
            $minus = '-';
        }
    }
    
    
    $view = Dune_Zend_View::getInstance();
    $view->prem = $prem;
    // Табло комментариев
    $comments = '';
    if ($data->can_comment)    
    {
        $view->use_captcha = $use_captcha;
        $session = Dune_Session::getInstance($session_name);
        
        $view->article_id = $data->id;
        $view->message = $session->message;
        $view->text = $session->text;
        $view->name = $session->name;
        $view->mail = $session->mail;
        $view->site = $session->site;
        $session->clearZone();

        
        $comm = new Special_Vtor_Article_Comment_List(0);
        $comm->setOrderInComment('time');
        $comm->setArticle($data->id);
        $comm->setActivity();
        $list = $comm->getList(0, 200);
        
        if ($use_captcha)
        {
            $captcha = new Dune_Zend_Captcha_Image();
            $captcha->setWordlen(rand(4, 5));
            $captcha->generate();
            $view->captcha_link = $captcha->getImageLink();
            $session->captcha = $captcha->getWord();
        }
        
        $view->list = $list;
        $comments = $view->render('bit/article/comments');
    }
    
	
    $crumbs_text = $crumbs->getString('<p id="breadcrumb">', '</p>');
    
    $text = $crumbs_text . $text . $comments;
    
    $view->assign('text', $text);
    
    Dune_Variables::addTitle($pagetitle. ' ');

if (!$vars->subdomainFocusUserId)
{
    $view->banners = $view->render('bit/banners/some');
}
    
    Dune_Static_StylesList::add('base');
    
    echo $view->render('bit/general/container_padding_for_banners');
    Dune_Static_StylesList::add('read');
    
    
}
catch (Dune_Exception_Control_Goto $e)
{
    if ($e->getCode())
    {
        Dune_Static_Message::setCode($e->getCode());
    }
    if ($e->getMessage())
    {
        $this->setStatus(Dune_Include_Command::STATUS_GOTO);
        $this->setResult('goto', $e->getMessage());
    }
    else 
    {
        $this->setStatus(Dune_Include_Command::STATUS_EXIT);
    }
}
catch (Dune_Exception_Control_NoAccess $e)
{
    if ($e->getCode())
    {
        Dune_Static_Message::setCode($e->getCode());
    }
    if ($e->getMessage())
    {
        Dune_Static_StylesList::add('user/info/message');
        $view = Dune_Zend_View::getInstance();
        echo $view->render($e->getMessage());
    }
    else 
    {
        $this->setResult('goto', '/');
        $this->setStatus(Dune_Include_Command::STATUS_EXIT);
    }
}        