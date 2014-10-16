<?php
$type = 0;
$table = 'unity_article_sections';

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
    $URL[4] = 'editsection';
    throw new Dune_Exception_Control_Goto($URL->getCommandString());
}
if ($get->com == 'edit' and $get->getDigit('id'))
{
    
    $URL[4] = 'editsection';
    throw new Dune_Exception_Control_Goto($URL->getCommandString() . '?id=' . $get->id);
}

$list_o = new Special_Vtor_Article_Sections_List($type);
$list = $list_o->getList();

$view = Dune_Zend_View::getInstance();
$view->data = $list;

echo $view->render('page/article/listsection');