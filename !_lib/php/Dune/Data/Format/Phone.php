<?
/**
*	����� ������� ������� ��������� ������ ��������
* 
*	��������� ������ ��������, ��� ����:
*   - �� ����� 6 ����, �� ����� 12 ����;
*   - ������ ����� � ��������� ������� - �����������
*   - � ������ ����� ���� ���� +
*   - ����� � ������ �������� ����� ���� ������� �� ������ ������� "-"(����), " "(������)
*   - ��� ������ ����� ���� ������� � ������, ����� �������� ����� ������ ����� ��� ����� �� ������ +. � ������� ������ �����.
* 
* ----------------------------------------------------
* | ����������: Dune                                  |
* | ����: Phone.php                                   |
* | � ����������: Dune/Data/Format/Phone.php          |
* | �����: ������ ����� (Dune) <dune@pochta.ru>       |
* | ������: 1.00                                      |
* | ����: www.rznlf.ru                                |
* ----------------------------------------------------
* 
*/

class Dune_Data_Format_Phone
{
    protected $numbersMin = 6;
    protected $numbersMax = 12;
    
    protected $haveBrackets = false;
    
    protected $phoneOriginal; // ����� �������� - �������������
    protected $phoneFiltered; // ����� �������� - ���������������
    protected $phoneNumbersOnly; // ����� �������� - ������ ����� (� ���� + ���� ����)
    
    
    public function __construct($phone)
    {
        $this->phoneOriginal = trim($phone);
        $this->phoneNumbersOnly = preg_replace("/[^\d\+]/i",'',$phone);
        $this->filter();
    }
    
   
    /**
     * ���������� ��������������� ����� ��������
     * 
     * ���������� ����� �������� � ������ ������� � ������ "+" ���� ����
     *
     * @return string ����� ��������
     */
    public function getFiltered()
    {
        return $this->phoneFiltered;
    }
    
    /**
     * ��������� ������ � ������� �������� �� ���������� �������
     *
     * ���������� �������:
     * �����, ����, �����, ������, ������
     * 
     * @return boolean
     */
    public function checkAllowSymbols()
    {
        $bool = true;
        $reg = "/[^\d\+\- ()]/i";
        $array = array();
        preg_match_all($reg,$this->phoneOriginal,$array);
        if (count($array[0]))
        {
            $bool = false;
        }
        return $bool;
    }

    /**
     * �������� ����������� ����� ���� � ������
     * 
     * ������� > 6 � < 12
     *
     * @return boolean
     */
    public function checkCountNumbers()
    {
        $bool = true;
        $count = strlen($this->phoneNumbersOnly);
        
        if (($count < 6) OR ($count >12))
        {
            $bool = false;
        }
        return $bool;
    }

    /**
     * �������� �� ������������ ������������� ����� "+"
     *
     * �������:
     * "+" ������ ����;
     * "+" ������ � ������;
     * "+" ������ ����� ������;
     * 
     * @return boolean
     */
    public function checkPlus()
    {
        $bool = true;
        $pos = strpos($this->phoneFiltered,'+');
        if ($pos !== false)
        {     
            // ���� ������ ����       
            if (strpos($this->phoneFiltered,'+', $pos + 1) !== false)
            {
                $bool = false;
            }
            // ���� �� ������� ������
            else if ($pos != 0)
            {
                $bool = false;
            }
            // �� ������ ����� �� �����
            else if (!preg_match("/^\+[ ]*\d/i",$this->phoneFiltered))
            {
                $bool = false;
            }
            
        }
        return $bool;
    }
    
    /**
     * �������� �� ������������ ������������� ������
     *
     * �������:
     * ������ ���� ������;
     * ������ ���� ������ ���� ������ ����;
     * ���������� ����������������� "(" ����� ")";
     * ���� ������ ������ �� 2 �� 5
     * ���� "-" ������ ������ ��������
     * 
     * @return boolean
     */
    public function checkBrackets()
    {
        $bool = true;
        $pos_first = strpos($this->phoneFiltered,'(');
        $pos_second = strpos($this->phoneFiltered,')');
        
        // ���� ������� ������
        if (($pos_first !== false) OR ($pos_second !== false))
        {  
            $this->haveBrackets = true;
            // ���� ��� ���� ��� ������   
            if (($pos_first !== false) XOR ($pos_second !== false))
            {
                $bool = false;
            }
            // ���� ���� ������, ����������
            else if (strpos($this->phoneFiltered,'(', $pos_first + 1) !== false)
            {
                $bool = false;
            }
            // ���� ���� ������, ����������
            else if (strpos($this->phoneFiltered,')', $pos_second + 1) !== false)
            {
                $bool = false;
            }
            // ���� ����������� ������������������
            else if ($pos_second < $pos_first)
            {
                $bool = false;
            }
            // ���� ���� ���������� ����, ������ ������
            else if (!preg_match("/\([ ]*[\d]{2,5}[ ]*\)/i",$this->phoneFiltered))
            {
                $bool = false;
            }
            // ���� ������������ ���� "-" � �������
            else if (preg_match("/\([\d]+\-[\d]+\)/i",$this->phoneFiltered))
            {
                $bool = false;
            }
            
        }
        return $bool;
    }
    
    /**
     * �������� �� ������� ����������� ���� ��� ������� ������
     *
     * �������: ����� �� ����� 1-��, ������ �� ����� 4-�
     * 
     * @return boolean
     */
    public function checkNumbersOutBrackets()
    {
        $bool = true;
        if ($this->haveBrackets)
        {
            $pos_first = strpos($this->phoneFiltered,'(');
            $line_first = substr($this->phoneFiltered,0,$pos_first);
            $pos_second = strpos($this->phoneFiltered,')');
            $line_second = substr($this->phoneFiltered,$pos_second,100);
            // ����� ���� ����� ������������� ������� ������� ����� 1
            if (strlen(preg_replace("/[^\d]/i",'',$line_first)) > 1)
            {
                $bool = false;
            }
            // ����� ���� ����� ������������� ������� ������� ����� 5
            else if (strlen(preg_replace("/[^\d]/i",'',$line_second)) < 4)
            {
                $bool = false;
            }
            
        }
        return $bool;
    }

    /**
     * ���������� ������
     * 
     * ������������ ��������, ������������� ������� � ���� ���������
     *
     */
    protected function filter()
    {
        // ������� ��� ������������� �������
        $this->phoneFiltered = preg_replace("/[^\d\+\- ()]/i",'',$this->phoneOriginal);
        // �������� ������������������ �������� �����
        $this->phoneFiltered = preg_replace("/[ ]{2,}/i",' ',$this->phoneFiltered);
        // �������� ������������������ "������ ����" ������ ����
        $this->phoneFiltered = preg_replace("/ \-/i",'-',$this->phoneFiltered);
        // �������� ������������������ "���� ������" ������ ����
        $this->phoneFiltered = preg_replace("/\- /i",'-',$this->phoneFiltered);
        // �������� ������������������ ���� �����
        $this->phoneFiltered = preg_replace("/[-]{2,}/i",'-',$this->phoneFiltered);
    }
    
}