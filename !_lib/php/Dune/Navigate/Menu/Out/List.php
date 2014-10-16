<?
/**
*	Класс вывода одноуровневого меню.
* 
*   Структура - список. 
*   Реализует волшебный метод __toString - печать меню на странице
*	
* 
* ----------------------------------------------------
* | Библиотека: Dune                                  |
* | Файл: List.php                                    |
* | В библиотеке: Dune/Navigate/Menu/Out/List.php     |
* | Автор: Андрей Рыжов (Dune) <dune@pochta.ru>       |
* | Версия: 1.00                                      |
* | Сайт: www.rznlf.ru                                |
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
	 * Конструктор - принимает данные для отображения
	 *
	 * @param array $array массив пунктов меню: ключи - коды в ссылке, содержание - текст
	 * @param string $stringUrl текст в ссылке перед кодом
	 * @param mixed $id текущий код
	 * @param string $divName имя id блока, содерж. список
	 * @param string $activeClassName имя класса текущей ссылки
	 * @param string $specIten содержимое в элементе списка, стоит первым, отдельное
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
     * Установка сомволов после кода пункта меню в Url
     *
     * @param string $str
     */
    public function setAfterCode($str = '')
    {
        $this->stringAfterCode = $str;
    }
    
    /**
     * Вывод меню
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
