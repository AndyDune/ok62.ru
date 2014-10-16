<?php

class Module_Article_CommentSave extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        

    $table_text = 'unity_article_text';
    $table_comment = 'unity_article_comments';

    $session_name = $this->session_name;
//    $session = Dune_Session::getInstance($session_name);
    
$url = Dune_Parsing_UrlSingleton::getInstance();
    $one = new Dune_Mysqli_Table($table_comment);
    $good = false;
    if (strlen($this->text) < 1)
    {
        $session = Dune_Session::getInstance($session_name);
        $session->message = 'no_1'; // Получена пустая строка
        throw new Dune_Exception_Control_Goto($url->getCommandString() . '#article-comment-do');
//        throw new Dune_Exception_Control_Goto();
    }
    
    if (Dune_Variables::$userStatus > 0)    
    {
        $one->article_id = $this->id;
        $one->time = time();
        $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
        $one->user_id = $session->user_id;
        
        $text = new Dune_String_Transform($this->text);
        $text->deleteLineFeed(2);
        $text->setLineFeedToBreak();
        $text->setQuoteRussian();
        $one->text = $text->getResult();
        $one->activity = 1;
        $one->add();
        
    $topic = 'Добавлен новый комментарий от зарегистрированного пользователя. Ok62.ru.';
    $text =
'
<h1>Новый комментарий</h1>
<p>Кто: <a href="http://' . Dune_Parameters::$siteDomain . '/user/info/' . $session->user_id . '/">пользователь</a></p>
<dl><dt>Текст</dt><dd>' . $text->getResult() . '</dd></dl>
';
    
        $mail = new Module_Mail();
        $mail->body = $text;
        $mail->mail = Special_Vtor_Mail::$getComment;
        $mail->name = '';
        $mail->subject = $topic;
        $mail->make();
        
        $good = true;
    }
    else 
    {
        $session = Dune_Session::getInstance($session_name);
        $good = true;
        if ($this->captcha !== $session->captcha)
        {
            $session->message = 'no_2'; // Не введена капча
            $good = false;
        }
        else if (strlen($this->name) < 1)
        {
            $session->message = 'no_3'; // не введены имя и пароль
            $good = false;
            
        }
        
/*        else if (strpos($this->name, '"') !== false or strpos($this->site, '"') !== false)
        {
            $session->message = 'no_5'; // двойные кавычки в имени и сайте
            $good = false;
            
        }
*/
        if ($good and false)
        {
            $mail = new Dune_Data_Format_Mail($this->mail);
            if (!$mail->check())
            {
                $session->message = 'no_4'; // неверный адрес мейла.
                $good = false;
            }
        }        
        if (!$good)
        {
            $session->text = $this->text;
            $session->name = $this->name;
            $session->site = $this->site;
            $session->mail = $this->mail;
            throw new Dune_Exception_Control_Goto($url->getCommandString() . '#article-comment-do');            
//            throw new Dune_Exception_Control_Goto('#article-comment-do');
        }
//        $session->clearZone();
        $one->article_id = $this->id;
        $one->time = time();
        $one->user_name = $this->name;
        $one->user_site = $this->site;
        $one->user_mail = $this->mail;

        
        $text = new Dune_String_Transform($this->text);
        $text->deleteLineFeed(2);
        $text->setLineFeedToBreak();
        $text->setQuoteRussian();
        $one->text = $text->getResult();
        if (!$this->prem)
        {
            $one->activity = 1;
        }
        $one->add();
        
        
    $topic = 'Добавлен новый комментарий от гостя. Ok62.ru.';
    $text =
'
<h1>Новый комментарий</h1>
<p>Кто: ' . $this->name . '</p>
<p>Почта: ' . $this->mail . '</p>
<dl><dt>Текст</dt><dd>' . $text->getResult() . '</dd></dl>
';
    
        $mail = new Module_Mail();
        $mail->body = $text;
        $mail->mail = Special_Vtor_Mail::$getComment;
        $mail->name = '';
        $mail->subject = $topic;
        $mail->make();
        
        
        $good = true;
        
    }
    
    
    if ($good)
    {
        $session = Dune_Session::getInstance($session_name);
        $session->clearZone();
        $session->message = 'yes_1'; // Сохранили
        throw new Dune_Exception_Control_Goto($url->getCommandString() . '#article-comment-do');        
//        throw new Dune_Exception_Control_Goto('#article-comment-do');

    }

    $session->text = $this->text;

    $this->setResult('goto', '');
    

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
