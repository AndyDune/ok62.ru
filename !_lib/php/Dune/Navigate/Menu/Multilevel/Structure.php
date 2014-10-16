<?
/**
*	�����, ����������� ��������� ����. � ��� ����� � ��������������.
* 
*	
* 
* ----------------------------------------------------
* | ����������: Dune                                  |
* | ����: Structure.php                               |
* | � ����������: Dune/Navigate/Menu/Structure.php    |
* | �����: ������ ����� (Dune) <dune@pochta.ru>       |
* | ������: 1.00                                      |
* | ����: www.rznlf.ru                                |
* ----------------------------------------------------
* 
*/

class Dune_Navigate_Menu_Structure
{
	protected $topLevel = array();
	protected $childrenMap = array();
	protected $children = array();
	
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
