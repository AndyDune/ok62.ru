<?
/**
*  ��������� ��������������� � �������������
*
* � ������� ����� ��������������� � ������������� ����� ���� � ������������, ������������ � ������������� �����:
*  ���� �����, ��� ������, ���� ������� 
*  (������������ ����� � ��� ����� ����������� � ������� ����� �������������� �����������, ������������� ������ � ���� ������).
* 
* 
* ----------------------------------------------------
* | ����������: Dune                                  |
* | ����: PluralForm.php                              |
* | � ����������: Dune/Data/Generator/PluralForm.php  |
* | �����: ������ ����� (Dune) <dune@rznw.ru>         |
* | ������: 1.00                                      |
* | ����: www.rznw.ru                                 |
* ----------------------------------------------------
* 
* ������� ������:
* ----------------
* ������ 1.00
* 
*/

class Dune_Data_Generator_PluralForm
{
    /**
     * �����
     *
     * @var integer
     * @access private
     */
    protected $_number = null;
    
    /**
     * �����
     *
     * @var string
     * @access private
     */
    protected $_form1  = null;
    
    /**
     * �����
     *
     * @var string
     * @access private
     */
    protected $_form2  = null;
    
    /**
     * �����
     *
     * @var string
     * @access private
     */
    protected $_form3  = null;
    
    /**
     * �����������.
     *
     * @param integer $n
     * @param string $form1 ���� �����
     * @param string $form2 ��� ������
     * @param string $form3 ���� �������
     */
    public function __construct($n = null, $form1 = null, $form2 = null, $form3 = null)
    {
        $this->_number = $n;
        $this->_form1  = $form1;
        $this->_form2  = $form2;
        $this->_form3  = $form3;
    }
    
    /**
     * ��������� �������� �����.
     *
     * @param integer $n
     * @return Dune_Data_Generator_PluralForm
     */
    public function setNumber($n)
    {
        $this->_number = $n;
        return $this;
    }
    
    /**
     * ��������� �������������� � �������������.
     *
     * @param string $form1 ���� �����
     * @param string $form2 ��� ������
     * @param string $form3 ���� �������
     * @return Dune_Data_Generator_PluralForm
     */
    public function setForms($form1, $form2, $form3)
    {
        $this->_form1  = $form1;
        $this->_form2  = $form2;
        $this->_form3  = $form3;
        return $this;
    }
    
    /**
     * ������� ��������������� ������.
     *
     * @param integer $n
     * @return string
     */
    public function get($n = null)
    {
        if (is_null($n))
            $n = (int)$this->_number;
        $n = abs($n) % 100;
        $n1 = $n % 10;
        if ($n > 10 && $n < 20) return $this->_form3;
        if ($n1 > 1 && $n1 < 5) return $this->_form2;
        if ($n1 == 1) return $this->_form1;
        return $this->_form3;
    }
}