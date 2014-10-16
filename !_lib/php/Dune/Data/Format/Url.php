<?
/**
*	�������� ������������� ����� URL
* 
*	���������� ���������:
*   #^(http://)?[-a-z0-9_\.]+([-a-z0-9_]+\.(htm|html|php|pl|cgi))?([-a-z0-9_:@&\?=+\.!/~*'%$]+)?$#
* 
* ----------------------------------------------------
* | ����������: Dune                                  |
* | ����: Url.php                                     |
* | � ����������: Dune/Data/Format/Url.php            |
* | �����: ������ ����� (Dune) <dune@rznlf.ru>        |
* | ������: 1.00                                      |
* | ����: www.rznlf.ru                                |
* ----------------------------------------------------
* 
*/

class Dune_Data_Format_Url
{
    /**
     * ���� ����������� URL
     *
     * @var boolean
     */
    protected $check = false;
    
    /**
     * URL ��� http://
     *
     * @var string
     */
    protected $onlyUrl;
    
    /**
     * �����������. ��������� ������ - URL
     *
     * @param string $mail URL
     */
    public function __construct($url)
    {
        $pattern = "#^(http://)?[-a-z0-9_\.]+([-a-z0-9_]+\.(htm|html|php|pl|cgi))?([-a-z0-9_:@&\?=+\.!/~*'%$]+)?$#i";
        if(preg_match($pattern, $url))
        {
            $this->onlyUrl = str_replace('http://', '', $url);
            $this->check = true;
        }
    }
    
    /**
     * ���������� URL ��� http://
     *
     * @return string
     */
    public function get()
    {
        return $this->onlyUrl;
    }
    /**
     * ���������� ��������� �������� URL
     *
     * @return boolean
     */
    public function check()
    {
        return $this->check;
    }
}