<?php

class Module_Catalogue_Mail_Saler_GetPublicTalkMassage extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        

        $text = '<h1>�������� ��������� � ���������� ���� ��� �������</h1>
        <dl>
        <dt>������������</dt>
        <dd><a href="http://' . Dune_Parameters::$siteDomain . '/user/info/' . $this->senderId . '/">' . $this->senderName . '</a></dd>
        <dt>����� ���������</dt>
        <dd><pre>' . $this->ttext . '</pre></dd>
        <dt>��������</dt>
        <dd><a href="http://' . Dune_Parameters::$siteDomain . '/catalogue/object/'
        . $this->objectId
        .'/">'
        . '�������� �������</a></dd>
        </dl>
        ';
         
        $view = Dune_Zend_View::getInstance();
        $view->domain = Dune_Parameters::$siteDomain;
        $view->senderId = $this->senderId;
        $view->senderName = $this->senderName;
        $view->ttext = $this->ttext;
        $view->objectId = $this->objectId;
        
        $user = new Dune_Auth_Mysqli_UserActive($this->salerId);
        
        $mail = new Module_Mail();
        echo $mail->body = $view->render('mail/talk/get_public_message_in_object');
        $mail->mail = $user->getUserMail();
        $mail->name = $user->getUserName();
        $mail->subject = '����� ��������� �� �����: ' . Dune_Parameters::$siteDomain;
        $mail->make();
        
        

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
}
    
    