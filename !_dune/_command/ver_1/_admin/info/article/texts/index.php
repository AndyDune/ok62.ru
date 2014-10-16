<?php
$type = 0;
$table = 'unity_article_text';
$page = 0;
$per_page = 20;

$get = Dune_Filter_Get_Total::getInstance();
$post = Dune_Filter_Post_Total::getInstance();
$URL = Dune_Parsing_UrlSingleton::getInstance();

if ($get->com == 'delete')
{
    $texts = new Special_Vtor_Article_Text_ListSectionsCorr($type);
    $texts->setSection($get->id);
    if (!$texts->getCoutText())
    {
        $one = new Dune_Mysqli_Table($table);
        $one->useId($get->id);
        $one->delete();
    }
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

/*$parents = array();
$curr = 100;
$have_parent = 0;
if ($run_id = $URL->getCommandPart(5, 2, 0) and false)
{
    $go = true;
    $one = new Dune_Mysqli_Table($table);
    while ($go)
    {
        $one->useId($run_id);
        if (!$data = $one->getData())
        {
            $go = false;
            break;
        }
        if (!$have_parent)
            $have_parent = $run_id;
        $parents[$curr] = $data;
        $curr--;
        if (!$data['parent'])
        {
            $go = false;
            break;
        }
        $run_id = $data['parent'];
    }
}
ksort($parents);
*/
//print_array($parents); //die();

$module = new Module_Article_Parents();
$module->id = $URL->getCommandPart(5, 2, 0);
$module->make();
$have_parent = $module->getResult('have_parent');
$parents = $module->getResult('data');

    $URL->cutCommands(4);
    $crumbs = Dune_Display_BreadCrumb::getInstance('1');
    $crumbs->addCrumb('Все сразу', $URL->getCommandString());
    if ($have_parent)
    {
        $URL->cutCommands(5);
        foreach ($parents as $value)
        {
            $crumbs->addCrumb($value['name'], $URL->getCommandString() .'parent_' . $value['id'] . '/');
        }
        $URL->clearModifications();
        $URL->cutCommands(5);
    }

//echo $crumbs;

$list_o = new Special_Vtor_Article_Text_List($type);
if ($have_parent)
{
    $list_o->setParent($have_parent);
//    $list_o->setParent(null);
}
$list_o->setOrder('parent', 'ASC');
$list_o->setOrder('time_insert', 'DESC');
$list = $list_o->getList($page * $per_page, $per_page);

$count = $list_o->getCount();



$view = Dune_Zend_View::getInstance();
if ($count > $per_page)
{
    $navigator = new Dune_Navigate_Page($URL->getCommandString() . '?page=', $count, $page, $per_page);
    $view->navigator = $navigator->getNavigator();
}

$view->data = $list;

$view->crumbs = $crumbs->getString();

$URL->cutCommands(4);
$view->url = $URL->getCommandString();
$URL->cutCommands(3);
$view->url_parent = $URL->getCommandString();


echo $view->render('page/article/listtext');
