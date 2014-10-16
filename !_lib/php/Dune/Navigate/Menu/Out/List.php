<?
/**
*	����� ������ �������������� ����.
* 
*   ��������� - ������. 
*   ��������� ��������� ����� __toString - ������ ���� �� ��������
*	
* 
* ----------------------------------------------------
* | ����������: Dune                                  |
* | ����: List.php                                    |
* | � ����������: Dune/Navigate/Menu/Out/List.php     |
* | �����: ������ ����� (Dune) <dune@pochta.ru>       |
* | ������: 1.00                                      |
* | ����: www.rznlf.ru                                |
* ----------------------------------------------------
* 
*/

class Dune_Navigate_Menu_Out_List
{
	protected $divIdName = 'menu';
	protected $activeNumber = 0;
	protected $stringBeforeCode = '';
	protected $stringAfterCode = '';
	protected $array = array();
	protected $activeClassName = '';
	protected $outString = '';
	
	/**
	 * ����������� - ��������� ������ ��� �����������
	 *
	 * @param array $array ������ ������� ����: ����� - ���� � ������, ���������� - �����
	 * @param string $stringUrl ����� � ������ ����� �����
	 * @param mixed $id ������� ���
	 * @param string $divName ��� id �����, ������. ������
	 * @param string $activeClassName ��� ������ ������� ������
	 * @param string $specIten ���������� � �������� ������, ����� ������, ���������
	 */
    public function __construct($array, $stringBeforeCode, $id = 0, $divName = 'menu', $activeClassName = 'focus', $specIten = '')
    {
    	$this->divIdName = $divName;
    	$this->array = $array;
    	$this->stringBeforeCode = $stringBeforeCode;
    	$this->activeNumber = $id;
    	$this->activeClassName = $activeClassName;
    	if ($specIten)
    	   $this->outString = '<div id="'.$this->divIdName.'"><ul><li>'.$specIten.'</li>';
    	else 
    	   $this->outString = '<div id="'.$this->divIdName.'"><ul>';
    }

    /**
     * ��������� �������� ����� ���� ������ ���� � Url
     *
     * @param string $str
     */
    public function setAfterCode($str = '')
    {
        $this->stringAfterCode = $str;
    }
    
    /**
     * ����� ����
     *
     * @return string
     */
    public function getMenu()
    {
    //	$out = '<div id="'.$this->divIdName.'"><ul>';
    	$str = ' class="'.$this->activeClassName.'"';
    	foreach ($this->array as $key => $val)
    	{
    		$this->outString.= '<li';
    		if ($key == $this->activeNumber)
    			$this->outString.= $str;
    		$this->outString.= '><a';    			
    		$this->outString.= ' href="' . $this->stringBeforeCode . $key . $this->stringAfterCode . '">' . $val . '</a></li>';
    	}
    	$this->outString.= '</ul></div>';
    	return $this->outString;
    }

//////////////////////////////////////////////////////////////////
///////////     ��������� ������

    public function __toString()
    {
    	$str = ' class="'.$this->activeClassName.'"';
    	foreach ($this->array as $key => $val)
    	{
    		$this->outString.= '<li';
    		if ($key == $this->activeNumber)
    			$this->outString.= $str;
    		$this->outString.= '><a';    			
    		$this->outString.= ' href="' . $this->stringBeforeCode . $key . $this->stringAfterCode . '">' . $val . '</a></li>';
    	}
    	$this->outString.= '</ul></div>';
    	return $this->outString;
    }

////////// ����� �������� ��������� �������
///////////////////////////////////////////////////////////////
    
}
