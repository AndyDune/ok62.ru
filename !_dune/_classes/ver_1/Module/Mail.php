<?php

class Module_Mail extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        

//        if (false)
        if (true)
//        if (strpos($this->mail, 'gmail.com') or strpos($this->mail, 'edinstvo62.ru') or strpos($this->mail, 'ok62.ru'))
        {

            $mail = new Exterior_PHPMailer('windows-1251');  
            
            $mail->setSmtp("smtp.gmail.com", 465, 'ssl');
            
            $mail->setSmtpAuth("ok62@edinstvo62.ru", "Vmeste62");
            
            $mail->setFrom(Dune_Parameters::$adminMail, Dune_Parameters::$siteDomain);
            $mail->setSubject($this->subject);  
            $mail->setBodyHtml($this->body);
            
        $to =  $this->mail;
        if (is_array($to))
        {
            foreach ($to as $key => $value)
                $mail->addTo($key, $value);
        }
        else 
            $mail->addTo($this->mail, $this->name);
            
//            $mail->addTo($this->mail, $this->name);
            
                        
            $mail->setWordWrap();
              
            if(!$mail->send()) {  
              echo 'Message was not sent.';  
              echo 'Mailer error: ' . $mail->getErrorInfo();  
            } else {  
              echo 'Message has been sent.';  
            }  
//          die()   ;
        }
        else 
        {

        $zend_mail = new Exterior_PHPMailer('windows-1251');
        //$zend_mail = new Zend_Mail('windows-1251');
        
        $zend_mail->setBodyHtml($this->body);
        $zend_mail->setFrom(Dune_Parameters::$adminMail, Dune_Parameters::$siteDomain);
        
        $to =  $this->mail;
        if (is_array($to))
        {
            foreach ($to as $key => $value)
                $zend_mail->addTo($key, $value);
        }
        else 
            $zend_mail->addTo($this->mail, $this->name);
        
        
        $zend_mail->setSubject($this->subject);
        if(!$zend_mail->send()) {  
              echo 'Message was not sent.';  
              echo 'Mailer error: ' . $zend_mail->getErrorInfo();  
            } else {  
              echo 'Message has been sent.';  
            }  
        
        }
//        die();


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    