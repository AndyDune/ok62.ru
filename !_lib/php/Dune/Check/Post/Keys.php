<?php
/**
* �������� ������� ������ � ������� $_POST.
* ��� ���������.
* 
* 
* ----------------------------------------------------------
* | ����������: Dune                                        |
* | ����: Keys.php                                          |
* | � ����������: Dune/Check/Post/Keys.php                  |
* | �����: ������ ����� (Dune) <dune@rznw.ru>               |
* | ������: 1.01                                            |
* | ����: www.rznw.ru                                       |
* ----------------------------------------------------------
* 
* 
* ������
* ----------------------------------------------------------
* 
* 1.01 (2009 ������ 23)
* ��� set-������� ����������� ����������� ���������� "�������";
* 
* 1.00 (2008 ������� 16)
* 
*/

class Dune_Check_Post_Keys
{
    protected $_keys = array();
    protected $_keysNo = array();
    protected $_keysYes = array();
    
    /**
     * �������� ������ ������ ��� ��������.
     *
     * @param array $keys 
     */
    public function __construct($keys = array())
    {
        $this->_keys = $keys;
    }
    
    /**
     * �������� ���� ��� �������� �������.
     *
     * @param string $key
     */
    public function add($key)
    {
        $this->_keys[] = $key;
        return $this;
    }
    
    /**
     * �������� ������������� ����������� ������ � ������� $_POST.
     * trim �� ������������
     *
     * @return boolean true - ���� ��� ����
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