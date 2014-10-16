<?php
$type = 0;
$table = 'unity_article_sections';

$get = Dune_Filter_Get_Total::getInstance();
$post = Dune_Filter_Post_Total::getInstance();
$URL = Dune_Parsing_UrlSingleton::getInstance();

$one = new Dune_Mysqli_Table($table);
if ($post->com == 'save')
{
    if ($post->getDigit('id'))
    {
        $one->useId($post->id);
        $one->loadData($post);;
        $one->save();
        $id = $post->id;
    }
    else 
    {
        $one->loadData($post);
        $one->type = $type;        
        $id = $one->add();
    }
    throw new Dune_Exception_Control_Goto($URL->getCommandString() . '?id=' . $id);
}

if ($get->id)
{
    $one->useId($get->id);
    if (!$data = $one->getData(true))
    {
        $data = new Dune_Array_Container(array());
    }
}
else 
{
    $data = new Dune_Array_Container(array());
}

$view = Dune_Zend_View::getInstance();
$view->data = $data;
$URL->cutCommands(3);
$view->url_parent = $URL->getCommandString();

echo $view->render('page/article/editsection');