<?php
/**
 * ������� ����� ��� ���� ������� ��� ������ � cookie.
 * 
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Base.php                                    |
 * | � ����������: Dune/Cookie/Parent/Base.php         |
 * | �����: ������ ����� (Dune) <dune@pochta.ru>       |
 * | ������: 1.01                                      |
 * | ����: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * ������� ������:
 * -----------------
 * 
 * ������ 1.00 -> 1.01
 * ������������� ������ ���������� �������� $expires
 * 
 */

class Dune_Cookie_Parent_Base
{
    // ������ �� �������
    // key - ��� cookie
    // value - �������� cookie
    protected $cookieArray = array();
    protected $cookieCount = 0;
    
// [expires] - ���� ��������� �������� cookie (�� ��������� - �� ����� ������)
    protected $expires = 0;
// [path] - ����, ��� �������� cookie ������������� (�� ��������� - ��������, � ������� �������� ���� �����������)
    protected $path = "/";
// [domain] - �����, ��� �������� cookie ������������� (�� ��������� - �����, � ������� �������� ���� �����������)
    protected $domain = ".rznlf.ru";
// [secure] - ���������� ��������, ������������ ��������� �� ���������� �������� �������� cookie    
    protected $secure = 0;
    
// ����� ����� ���� � ��������
    protected $lifeTime = 3600;
    
    protected function __construct($hours = 1, $domain = ".rznlf.ru", $path = "/", $secure = 0)
    {
        $this->expires = time() + $this->lifeTime * $hours;
        $this->path = $path;
        $this->domain = $domain;
        $this->secure = $secure;
        $this->cookieCount = count($_COOKIE);     
    }
   
    /**
     * ���������� ����� ����� ������� ����
     *
     * @param string $name
     */
    public function getCookieCount()
    {
        return $this->cookieCount;
    }
    
    /**
     * ���������� �������� �����
     *
     * @param string $name
     */
    public function setTestCookie($name = 'check')
    {
        setcookie($name,'checked',0, $this->path, $this->domain, $secure = 0);
    }
    
    /**
     * ���������, ����������� �� �������� �����
     *
     * @param string $name
     * @return boolean
     */
    public function checkTestCookie($name = 'check')
    {
        if (key_exists($name,$_COOKIE))
            return true;
         else 
            return false;
            
    }
}