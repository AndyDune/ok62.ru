<?
/**
*	Проверка корректрности ввода URL
* 
*	Регулятное выражение:
*   #^(http://)?[-a-z0-9_\.]+([-a-z0-9_]+\.(htm|html|php|pl|cgi))?([-a-z0-9_:@&\?=+\.!/~*'%$]+)?$#
* 
* ----------------------------------------------------
* | Библиотека: Dune                                  |
* | Файл: Url.php                                     |
* | В библиотеке: Dune/Data/Format/Url.php            |
* | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>        |
* | Версия: 1.00                                      |
* | Сайт: www.rznlf.ru                                |
* ----------------------------------------------------
* 
*/

class Dune_Data_Format_Url
{
    /**
     * Флаг правильного URL
     *
     * @var boolean
     */
    protected $check = false;
    
    /**
     * URL без http://
     *
     * @var string
     */
    protected $onlyUrl;
    
    /**
     * Конструктор. Принимает строку - URL
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
     * Возвращает URL без http://
     *
     * @return string
     */
    public function get()
    {
        return $this->onlyUrl;
    }
    /**
     * Возвращает результат проверки URL
     *
     * @return boolean
     */
    public function check()
    {
        return $this->check;
    }
}