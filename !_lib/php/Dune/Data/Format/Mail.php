<?
/**
*	����� ������� ������� ��������� ������ ����������� �����
* 
*	��������� ������ ����������� �����:
* 
* ----------------------------------------------------
* | ����������: Dune                                  |
* | ����: Mail.php                                    |
* | � ����������: Dune/Data/Format/Mail.php           |
* | �����: ������ ����� (Dune) <dune@rznw.ru>         |
* | ������: 1.03                                      |
* | ����: www.rznw.ru                                 |
* ----------------------------------------------------
* 
* ������� ������:
* ----------------
* 1.03 (2009 ���� 23)
* � ����������� ����� ����� ������������ ����
* 
* 1.02
* � ����������� ����� ����� ������������ �����
* 
* ������ 1.00 -> 1.01
* ���������� � ����������� ������ ��. ����� � ������ ��. �����
* 
*/

class Dune_Data_Format_Mail
{
    /**
     * ���� ����������� ������ ����������� �����
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
     * �����������. ��������� ������ - ����� ��. �����
     *
     * @param string $mail ����� e-mail
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
     * ���������� ��������� �������� ������ ��. �����
     *
     * @return boolean
     */
    public function check()
    {
        return $this->check;
    }

    /**
     * ������� ������ ��. �����
     *
     * @return string ����� ��. �����
     */
    public function getMail()
    {
        return $this->mail;
    }
    
    /**
     * ������� ������ ��. �����
     *
     * @return string ����� ��. �����
     */
    public function getDomain()
    {
        return $this->domain;
    }
}