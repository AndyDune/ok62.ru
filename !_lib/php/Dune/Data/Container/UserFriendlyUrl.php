<?
/**
 * ������ � ��� ����� ���:
 * <����� ����������� ����� ��������>-<��� ������>
 * �.�. ����� ���������� ������ - ���(id)
 * ���� ����� �� ������ - ������ ��� ������ �������� �����
 * 
 * 
 * ����� ��������� ������.
 *  �������������� ������� ����������� � �������� ��� ���.
 *  �������������� ��������� � ������ ��� ������ � ������� ������� ��.
 *  
 *	 
 * ---------------------------------------------------------
 * | ����������: Dune                                       |
 * | ����: UserFriendlyUrl.php                              |
 * | � ����������: Dune/Data/Container/UserFriendlyUrl.php  |
 * | �����: ������ ����� (Dune) <dune@rznlf.ru>             |
 * | ������: 1.01                                           |
 * | ����: www.rznlf.ru                                     |
 * ---------------------------------------------------------
 * 
 * ������� ������:
 *
 * ������ 1.00 -> 1.01
 * ��������� ���������� �������������� �� ������. 
 * ����� getId().
 * 
 */

class Dune_Data_Container_UserFriendlyUrl
{

    /**
     * ������ �������� ��� ������
     *
     * @var array
     * @access privare
     */
    private $search = array("�","�","�","�","�","�","�","�","�","�",
                            "�","�","�","�","�","�","�","�","�","�",
                            "�","�","�","�","�","�","�","�","�","�",
                            "�","�","�"," ");
      

    /**
     * ������ �������� ��� ���������
     *
     * @var array
     * @access privare
     */
    private $replace = array("a","b","v","g","d","e","jo","zh","z","i",
                            "j","k","l","m","n","o","p","r","s","t",
                            "u","f","h","c","ch","sh","shch","'","y","'",
                            "eh","yu","ya","-");

    /**
     * ������� ����� ��� �������������
     *
     * @var string
     * @access privare
     */
    private $originalString = '';
    
    /**
     * ������������ �����-�������������� � ��������
     *
     * @var string
     * @access privare
     */
    private $urlString = '';
    
    /**
     * �������� ������ �� 16 ��������.
     * ������������ ��� �������� � �������.
     *
     * @var string
     * @access privare
     */
    private $hash16String = '';
    
    /**
     * 32-������� ����������������� �����.
     * ������������ ��� �������� � �������.
     *
     * @var string
     * @access privare
     */
    private $hash32String = '';

    /**
     * ��� ������
     * 
     * @var integer
     * @access privare
     */
    private $id = 0;
    
    /**
     * ��� �������� �������� ������ ������������ � � �������� ��� ������������� � ���.
     * ����� ���� ����� ������������ get ������
     *
     * @param string $string ������� �����
     */
    public function __construct($string = '')
    {
        if ($string)
        {
            $this->originalString = $string;
            $string = strtolower($string);
            $string = preg_replace('|[^- 0-9�-�a-z]|i', '', $string);
            $string = preg_replace('|[ ]{2,}|i', ' ', $string);
            $string = str_replace($this->search, $this->replace, $string);
            $this->urlString = $string;
        }
    }
  
    /**
     * ��������� ������ �� URL ��� �������������� � ���.
     * ������� �� ������ id ������.
     *
     * @param string $string
     */
    public function useUrl($string)
    {
        $pos = strrpos($string, '-');
        if ($pos !== false)
        {
            $this->id = (integer)substr($string, $pos + 1);
        }
        else 
        {
            $this->id = (integer)$string;
        }
        $this->urlString = $string;
        $this->hash16String = '';
        $this->hash32String = '';
    }

    /**
     * ���������� ��� 16 ���� �� ������ ������������ � URL
     *
     * @return string �������� ������
     */
    public function getHash16()
    {
        if (($this->urlString) and (!$this->hash16String))
        {
            $this->hash16String = md5($this->urlString, true);
        }
        return $this->hash16String;
    }
    
    /**
     * ���������� ��� 32 ����� �� ������ ������������ � URL
     *
     * @return string ������ 16-�� �����
     */
    public function getHash32()
    {
        if (($this->urlString) and (!$this->hash32String))
        {
            $this->hash32String = md5($this->urlString);
        }
        return $this->hash32String;
    }

    /**
     * ���������� ������������� ������ �� ���������� ������� ��� ������� � URL.
     *
     * @return string ������, ����������� � URL
     */
    public function getUrl()
    {
        $this->urlString = preg_replace('|[^-0-9a-z]|', '', strtolower($this->urlString));
        return $this->urlString;
    }
    
    /**
     * ���������� ������������� ������ (id).
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

}