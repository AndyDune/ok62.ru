<?php

class Module_Catalogue_Request_Save extends Dune_Include_Abstract_Code
{

    protected function code()
    {
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $this->setResult('success', false);
        $this->setResult('id', 0);
        $post = Dune_Filter_Post_Total::getInstance();
        $post->htmlSpecialChars();
        $post->setLength(3000);
        if ($post->getDigit('edit') > 0)
        {
            $current = Special_Vtor_Object_Request_DataSingleton::getInstance($post->getDigit('edit'));
            $current->useIdGetDataFromDb($post->getDigit('edit'));
            if (!$current->isFromBd())
            {
                throw new Dune_Exception_Control_Goto('Нет такой заявки.', 51);
            }
            if ($current->getUserId() != Special_Vtor_User_Auth::$id)
            {
                throw new Dune_Exception_Control_Goto('Редактировать чужое нельзя.', 53);
            }
//            $class_name = 'Special_Vtor_Object_Request_DataInType_' . ucfirst($this->type_code);
//            $data = new $class_name();

            $data = new Special_Vtor_Object_Request_DataInType_Common();
            foreach ($post as $key => $value)
            {
                $data[$key] = $value;
            }
            $current->loadData($data->getData(false, true)); // Все необходимые данные из post отфильтрованы. Отсутствующие установлены по умолчанию.
            $current->setText($post['text']);
            
            $current->setName($post['name']);
            $current->setPrice($post['price']);
            $current->setRent($post->getDigit('rent'));
            $current->setSale($post->getDigit('sale'));

            $good = $current->save();
            if ($good)
            {
                $this->setResult('success', true);
                $mail = new Module_Catalogue_Mail_GetRequest();
                $mail->id = $post->getDigit('edit');
                $current->useIdGetDataFromDb($post->getDigit('edit'));
                $mail->data = $current->getData(true);
                $mail->mode = 'edit';
                $mail->make();
            }
            $this->setResult('success', true);
            $this->setResult('id', $post->getDigit('edit'));
//            die();
        }
        else 
        {
            $session = Dune_Session::getInstance('request');
            $current = Special_Vtor_Object_Request_DataSingleton::getInstance();
            $current->setUserId(Special_Vtor_User_Auth::$id);
            $current->setTypeId($session->object_type_id);
            
//            $class_name = 'Special_Vtor_Object_Request_DataInType_' . ucfirst($this->type_code);
//            $data = new $class_name();
            $data = new Special_Vtor_Object_Request_DataInType_Common();
            foreach ($post as $key => $value)
            {
                $data[$key] = $value;
            }
            $current->loadData($data->getData());
            $current->setText($post['text']);
            
            $current->setName($post['name']);
            $current->setPrice($post->getDigit('price'));
            $current->setRent($post->getDigit('rent'));
            $current->setSale($post->getDigit('sale'));
            
            
            $id = $current->add();
            if ($id)
            {
                $mail = new Module_Catalogue_Mail_GetRequest();
                $mail->id = $id;
                
                $current->useIdGetDataFromDb($id);
                $mail->data = $current->getData(true);
                
                $mail->mode = 'add';
                $mail->make();
                
                $this->setResult('id', $id);
                $this->setResult('success', true);
            }
            
        } 
        
        
        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    