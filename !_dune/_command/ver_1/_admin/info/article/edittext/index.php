<?php
$type = 0;
$table = 'unity_article_text';

$get = Dune_Filter_Get_Total::getInstance();
$post = Dune_Filter_Post_Total::getInstance();
$URL = Dune_Parsing_UrlSingleton::getInstance();

$one = new Dune_Mysqli_Table($table);
if ($post->com == 'save')
{
    
    $data = $post->get();
    
/*    $bb = new HTML_BBCodeParser();  // Тест bbcode
    $bb->addFilter('Quote');
    $bb->addFilter('Email');
    $data['text'] = $post->text . $bb->qparse($post->text);
*/
    $data['name']       = htmlspecialchars($post->name); 
    $data['name_crumb'] = htmlspecialchars($post->name_crumb); 
    
    $data['description']       = htmlspecialchars($post->description); 
    $data['keywords']       = htmlspecialchars($post->keywords); 
    $data['title']       = htmlspecialchars($post->title); 
    
    if ($post->quote)
    {
        $text_o = new Dune_String_Transform($post->text);
        $text_o->setQuoteRussian();
        $data['text'] = $text_o->getResult(); 
        
        $text_o = new Dune_String_Transform($post->annotation);
        $text_o->setQuoteRussian();
        $data['annotation'] = $text_o->getResult(); 
        
        $text_o = new Dune_String_Transform($post->name);
        $text_o->setQuoteRussian();
        $data['name'] = $text_o->getResult(); 
        
        $text_o = new Dune_String_Transform($post->name_crumb);
        $text_o->setQuoteRussian();
        $data['name_crumb'] = $text_o->getResult(); 

        $text_o = new Dune_String_Transform($post->title);
        $text_o->setQuoteRussian();
        $data['title'] = $text_o->getResult(); 
        
        
    }
    
/*    $text_o->linkNofollow();
    $data['text'] = $post->text . 
'
' . $text_o->getResult();
*/
    if ($post->getDigit('id'))
    {
        $one->useId($post->id);
        $one->loadData($data);
        $one->time_edit = time();
        if (!$post->can_comment)
            $one->can_comment = 0;
        if (!$post->activity)
            $one->activity = 0;
            
        $one->save();
        $id = $post->id;
    }
    else 
    { 
        $one->loadData($post);
        $one->type = $type;
        $one->time_insert = time();
//        echo $one;
//        die();
        $id = $one->add();
    }
    throw new Dune_Exception_Control_Goto($URL->getCommandString() . '?id=' . $id);
}


$parent = new Dune_Array_Container(array());
if ($get->id)
{
    $one->useId($get->id);
    if (!$data = $one->getData(true))
    {
        $data = new Dune_Array_Container(array());
        $data['activity'] = 1;
        $data['parent'] = $URL->getCommandPart(5, 2);
        $section_corr = new Dune_Array_Container(array());
    }
    else 
    {
        if ($data->parent)
        {
            $one1 = new Dune_Mysqli_Table($table);
            $one1->useId($data->parent);
            if (!$parent = $one1->getData(true))
            {
                $parent = new Dune_Array_Container(array());
            }
        }
        $section_corr = new Dune_Array_Container(array());
    }
}
else 
{
    $data = new Dune_Array_Container(array());
    $data['activity'] = 1;
    $data['parent'] = $URL->getCommandPart(5, 2);
    $section_corr = new Dune_Array_Container(array());
}

$list_o = new Special_Vtor_Article_Sections_List($type);
$list_s = $list_o->getList();


$view = Dune_Zend_View::getInstance();
$view->data = $data;
$view->parent = $parent;
$view->sections = $list_s;
$URL->cutCommands(3);
$view->url_parent = $URL->getCommandString();

echo $view->render('page/article/edittext');