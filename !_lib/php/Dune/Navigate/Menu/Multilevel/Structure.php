<?
/**
*	Класс, описывающий структуру меню. В том числе и многоуровневую.
* 
*	
* 
* ----------------------------------------------------
* | Библиотека: Dune                                  |
* | Файл: Structure.php                               |
* | В библиотеке: Dune/Navigate/Menu/Structure.php    |
* | Автор: Андрей Рыжов (Dune) <dune@pochta.ru>       |
* | Версия: 1.00                                      |
* | Сайт: www.rznlf.ru                                |
* ----------------------------------------------------
* 
*/

class Dune_Navigate_Menu_Structure
{
	protected $topLevel = array();
	protected $childrenMap = array();
	protected $children = array();
	
//////////////////////////////////////////////////////////////////
///////////     Волшебные методы

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

////////// Конец описания волшебных методов
///////////////////////////////////////////////////////////////
    
}
