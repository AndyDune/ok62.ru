<?php

class Module_Catalogue_Mail_Saler_GetPrivateTalkMassage extends Dune_Include_Abstract_Code
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
        .'/?talk_mode=private&user='
        . $this->senderId
        .'">'
        . '�������� �������</a></dd>
        </dl>
        ';
        $user = new Dune_Auth_Mysqli_UserActive($this->salerId);
        
/*        $zend_mail = new Zend_Mail('windows-1251');     
        $zend_mail->setBodyHtml($text);
        $zend_mail->setFrom(Dune_Parameters::$adminMail, Dune_Parameters::$siteDomain);
        $zend_mail->addTo($user->getUserMail(), '����� ������������ ' . $user->getUserName());
        $zend_mail->setSubject('����� ��������� �� �����: ' . Dune_Parameters::$siteDomain);
        $zend_mail->send();
        
*/        

        $mail = new Module_Mail();
        $mail->body = $text;
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
    
    