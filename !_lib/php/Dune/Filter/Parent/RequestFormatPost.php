<?php
/**
*   ������������ ����������� ����� ��� ���� ������� ������ � �������� $_POST[]
*	����� ��� ������������� � ������������ ����������� ������� ����������
* 
* ---------------------------------------------------------
* | ����������: Dune                                         |
* | ����: RequestFormatPost.php                              |
* | � ����������: Dune/Filter/Parent/RequestFormatPost.php   |
* | �����: ������ ����� (Dune) <dune@pochta.ru>              |
* | ������: 1.02                                             |
* | ����: www.rznlf.ru                                       |
* ---------------------------------------------------------
* 
*
* ������ 1.01 -> 1.02
* ----------------------
* ��������� ����������� ����������� ������ �� ������.
* ��������� ������. �������� ������ = 0 ������������������ ��� ���������� ������
* 
* ������ 1.00 -> 1.01
* ----------------------
* ��������� ����������� ��������������� ���������.
* 
*/

abstract class Dune_Filter_Parent_RequestFormatPost
{

    protected $value = '';
    protected $have = false;
    
    /**
     * ������ �������� �� ���������
     *
     * @var mixed
     */
    protected $defaultValue = '';
    
    protected $charsetIn = 'windows-1251';
    protected $charsetOut = 'windows-1251';
    
    
    protected function __construct($name, $def, $maxLength = 0)
    {
    	$this->defaultValue = $def;
    	
//      	if (empty($_POST[$name]) or ($_POST[$name]) == 'undefined') // or ($_POST[$name] == '')
      	if (empty($_POST[$name])) // or ($_POST[$name] == '')      	
      	{
       		$this->value = $this->defaultValue;
      	}
       	else 
       	{
       	    $val = trim($_POST[$name]);
       	    if ($val)
       	    {
           	    if ($maxLength)
           	        substr($val, 0, $maxLength);
       	        
                $this->makeFilter($val);
                if ($this->value !== '')
                {
                    $this->have = true;
                }
                else 
                    $this->value = $this->defaultValue;
       	    }
       	    else 
       	    {
       	        $this->value = $this->defaultValue;
       	    }
       	}
    }
    
    // �������� �� ������������ ����� ������� �����������������
    protected function makeFilter($value)
    {
        $this->value = $value;
    }
    
    public function get()
    {
    	return $this->value;
    }
    
    public function have()
    {
    	return $this->have;
    }

    /**
     * 
     *
     * @param string $in_charset �������� ���������
     * @param string $out_charset ��������� ����������
     */
    
    public function iconv($in_charset, $out_charset)
    {
        if (($this->have) and ($in_charset != $out_charset))
        {
            $this->value = iconv($in_charset, $out_charset, $this->value);
        }
        
    }
    
    
}