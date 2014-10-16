<?
/**
*	Класс анализа формата введённого адреса электронной почты
* 
*	Параметры адреса электронной почты:
* 
* ----------------------------------------------------
* | Библиотека: Dune                                  |
* | Файл: Mail.php                                    |
* | В библиотеке: Dune/Data/Format/Mail.php           |
* | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
* | Версия: 1.03                                      |
* | Сайт: www.rznw.ru                                 |
* ----------------------------------------------------
* 
* История версий:
* ----------------
* 1.03 (2009 июнь 23)
* В электронной почте можно использовать тире
* 
* 1.02
* В электронной почте можно использовать точку
* 
* Версия 1.00 -> 1.01
* Сохранения и возвращение адреса эл. почты и домена эл. почты
* 
*/

class Dune_Data_Format_Mail
{
    /**
     * Флаг правильного адреса электронной почты
     *
     * @access private
     * @var boolean
     */
    protected $check = false;
    
    /**
     * Enter description here...
     *
     * @var string
     * @access private
     */
    protected $mail = '';
    
    /**
     * Enter description here...
     *
     * @var string
     * @access private
     */
    protected $domain = '';
    
    /**
     * Конструктор. Принимает строку - адрес эл. почты
     *
     * @param string $mail адрес e-mail
     */
    public function __construct($mail)
    {
        $mail = trim($mail);
        if(preg_match("|^[-0-9a-z_\.]+@[0-9a-z_^\.]+\.[a-z]{2,4}$|i", $mail))
        {
            $this->mail = $mail;
            $this->domain = substr($mail, strpos($mail, '@') + 1);
            $this->check = true;
        }
    }
    
    /**
     * Возвращает результат проверки адреса эл. почты
     *
     * @return boolean
     */
    public function check()
    {
        return $this->check;
    }

    /**
     * Возврат адреса эл. почты
     *
     * @return string адрес эл. почты
     */
    public function getMail()
    {
        return $this->mail;
    }
    
    /**
     * Возврат домена эл. почты
     *
     * @return string домен эл. почты
     */
    public function getDomain()
    {
        return $this->domain;
    }
}