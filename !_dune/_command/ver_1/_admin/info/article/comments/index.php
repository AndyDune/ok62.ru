<?php
$type = 0;
$table = 'unity_article_comments';
$page = 0;
$per_page = 20;

$get = Dune_Filter_Get_Total::getInstance();
$post = Dune_Filter_Post_Total::getInstance();
$URL = Dune_Parsing_UrlSingleton::getInstance();

if ($get->com == 'delete')
{
    $one = new Dune_Mysqli_Table($table);
    $one->useId($get->id);
    $one->delete();
    throw new Dune_Exception_Control_Goto();
}
if ($get->com == 'activate')
{
    $one = new Dune_Mysqli_Table($table);
    $one->useId($get->id);
    $one->activity = 1;
    $one->save();
    throw new Dune_Exception_Control_Goto();
}
if ($get->com == 'deactivate')
{
    $one = new Dune_Mysqli_Table($table);
    $one->useId($get->id);
    $one->activity = 0;
    $one->save();
    throw new Dune_Exception_Control_Goto();
}

if ($post->com == 'add')
{
    $URL[4] = 'edittext';
    throw new Dune_Exception_Control_Goto($URL->getCommandString());
}
if ($get->com == 'edit' and $get->getDigit('id'))
{
    
    $URL[4] = 'edittext';
    throw new Dune_Exception_Control_Goto($URL->getCommandString() . '?id=' . $get->id);
}

$page = $get->getDigit('page');


$have_article = $URL->getCommandPart(5, 2, 0);

$list_o = new Special_Vtor_Article_Comment_List($type);
$for_article = false;
if ($have_article)
{
    $for_article = true;
    $list_o->setArticle($have_article);
}
$list_o->setOrderInComment('time', 'DESC');
$list = $list_o->getList($page * $per_page, $per_page);

$count = $list_o->getCount();


$view = Dune_Zend_View::getInstance();
if ($count > $per_page)
{
    $navigator = new Dune_Navigate_Page($URL->getCommandString() . '?page=', $count, $page, $per_page);
    $view->navigator = $navigator->getNavigator();
}

$view->data = $list;

$view->crumbs = '';

$view->for_article = $for_article;

$URL->cutCommands(4);
$view->url = $URL->getCommandString();
$URL->cutCommands(3);
$view->url_parent = $URL->getCommandString();


echo $view->render('page/article/listcomment');
