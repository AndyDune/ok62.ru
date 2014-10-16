<?php
/**
* Проверка наличия ключей в массиве $_POST.
* Все указанных.
* 
* 
* ----------------------------------------------------------
* | Библиотека: Dune                                        |
* | Файл: Keys.php                                          |
* | В библиотеке: Dune/Check/Post/Keys.php                  |
* | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>               |
* | Версия: 1.01                                            |
* | Сайт: www.rznw.ru                                       |
* ----------------------------------------------------------
* 
* 
* Версии
* ----------------------------------------------------------
* 
* 1.01 (2009 январь 23)
* Для set-методов реализована возможность построения "цепочек";
* 
* 1.00 (2008 октябрь 16)
* 
*/

class Dune_Check_Post_Keys
{
    protected $_keys = array();
    protected $_keysNo = array();
    protected $_keysYes = array();
    
    /**
     * Принимет массив ключей для проверки.
     *
     * @param array $keys 
     */
    public function __construct($keys = array())
    {
        $this->_keys = $keys;
    }
    
    /**
     * Добавить ключ для проверки наличия.
     *
     * @param string $key
     */
    public function add($key)
    {
        $this->_keys[] = $key;
        return $this;
    }
    
    /**
     * Проверка существования добавленных ключей в массиве $_POST.
     * trim не используется
     *
     * @return boolean true - если все есть
     */
    public function check()
    {
        $result = true;
        foreach ($this->_keys as $value)
        {
            if (!isset($_POST[$value]) or ((string)$_POST[$value] == ''))
            {
                $result = false;
                $this->_keysNo[] = $value;
            }
            else 
                $this->_keysYes[] = $value;
        }
        return $result;
    }
    
    public function getAbsent()
    {
        return $this->_keysNo;
    }
    public function getAvailable()
    {
        return $this->_keysYes;
    }
    
}