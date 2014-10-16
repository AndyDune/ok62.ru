<?php
/**
 * Класс для работы с файлом-шаблоном страницы. Применяется в порстранстве общей конфигурации.
 * 
 * Ключами к замене являются строки типа <!--%ключ%--> Пробелов быть не должно.
 * 
 * Использует классы:
 * Dune_Exception_Base
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: TemplateSystem.php                          |
 * | В библиотеке: Dune/Build/TemplateSystem.php       |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>        |
 * | Версия: 1.03                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 * 
 * 
 * История версий:
 * -----------------
 * 
 * Версия 1.02 -> 1.03
 * Dune_Parameters::$templateSpace вместо Dune_Parameters::$templateRalization
 * 
 * Версия 1.01 -> 1.02
 * !! Изменился вид ключей в тексте: {ключ}
 * Введена функция leaveKeys - установка возврата в текст ключа с отсутствием соответствия. По умолчанию удаляет
 * !! В тексте должен присутсвоват ключ {head} и {body}
 * 
 * Версия 1.00 -> 1.01
 * Оптимизирован механизм замены ключей.
 * 
 */
class Dune_Build_TemplateSystem
{
    /**
     * Путь к файлу-шаблону
     *
     * @var string
     */
    private $path;
    
    /**
     * Обрабатываемый текст страницы
     *
     * @var string
     */
    private $template;


      /**
     * @var boolean
     */
    private $madeNot = true;

    
    /**
     * Массив с ключами для замены
     *
     * @var string
     */
    private $keysArray = array();
    private $valueArray = array();
    
    private $headText = '';
    private $headTextAdd = '';
    
    private $bodyText = '';
    
    
    private $_leaveKeys = false;

    /**
     * Конструктор.
     * $name - имя файла-шаблона без разширения. Можно использовать подпапки: folder1/file (folder1/folder2/file)
     * $name - тест шаблона. Это так если получено $like_string = true
     * 
     * Исключение если файла не существует.
     *
     * @param string $name имя файла-шаблона либо текст для обработки
     * @param boolean $like_string принимает true если $name - текст
     */
    public function __construct($name = 'page', $like_string = false)
    {
        if ($like_string)
        {
            $this->template = $name;
        }
        else 
        {
            $this->path = Dune_Parameters::$templatesPath. '/' . Dune_Parameters::$templateSpace . '/' . $name . '.tpl';
            if (!is_file($this->path))
            {
                throw new Dune_Exception_Base('Указан путь к несуществующему файлу-шаблону: '.$this->path);
            }
            $this->template = file_get_contents($this->path);
            if (!$this->template)
            {
                throw new Dune_Exception_Base('Не удалось открыть файл-шаблон.');
            }
        }
    }
    
    
    /**
     * Заменяет ключ в шаблоне на указаннное значение.
     * 
     * В шаболне должен существовать ключ, иначе будет прерывание.
     * 
     * Ключ в шаблоне имеет вид: {ключ}. Пробелы запрещены.
     * При указании необязательного параметра specialchars = true текст обрабатывается функцией htmlspecialchars()
     *
     * @param string $key ключ для поиска в шаблоне
     * @param string $value значение для замены
     * @param boolean $specialchars указание фильтровать спец. символы html
     */
    public function assign($key, $value, $specialchars = false)
    {
        $bool = true;
        if ($specialchars)
        {
            $value = htmlspecialchars($value);
        }
        $this->keysArray[$key] = $value;
        return true;
    }
    
    /**
     * Возвращает массив всех ключей
     *
     * @return array массив ключей в шаблоне
     */
    public function getKeys()
    {
        $array = array();
        preg_match_all('|\{([-_a-zA-Z0-9]+)\}|i', $this->template, $array);
        //unset($array[0]);
        return $array[1];
    }
    /**
     * Устанавливает текст заголовка страницы.
     * Никаких ключей в шаблоне не требуется.
     * К тексту применяется функция htmlspecialchars()
     * МЕТА-тег добавляется непоследственно перед закрытием блока head (</head>)
     *
     * @param string $value Текст title
     */
    public function setTitle($value)
    {
        $value = htmlspecialchars($value);
        $this->headText .= '<title>'.$value.'</title>';
    }
    
    /**
     * Устанавливает текст ключевых слов страницы.
     * Никаких ключей в шаблоне не требуется.
     * К тексту применяется функция htmlspecialchars()
     * МЕТА-тег добавляется непоследственно перед закрытием блока head (</head>)
     *
     * @param string $value Текст keywords
     */
    public function setKeywords($value)
    {
        $value = htmlspecialchars($value);
        $this->headText .= '<meta name="keywords" content="'.$value.'" />';
    }  

    /**
     * Устанавливает текст описания страницы.
     * Никаких ключей в шаблоне не требуется.
     * К тексту применяется функция htmlspecialchars()
     * МЕТА-тег добавляется непоследственно перед закрытием блока head (</head>)
     *
     * @param string $value Текст description
     */
    public function setDescription($value)
    {
        $value = htmlspecialchars($value);
        $this->headText .= '<meta name="description" content="'.$value.'" />';
    }
    /**
     * Добавления текста в блок head(ссылки на таблицы css, файлы JS и прочее)
     * К тексту не применяется функция htmlspecialchars()
     *
     * @param string $value
     */
    public function addToHead($value)
    {
        $this->headTextAdd .= $value;
    }    

    
    /**
     * Добавления текста в блок body. Перед закрывающим тегом.
     * К тексту не применяется функция htmlspecialchars()
     *
     * @param string $value
     */
    public function addToBody($value)
    {
        $this->bodyText .= $value;
    }    
    
    /**
     * Печать страницы
     *
     */
    public function display()
    {
        echo $this->make();
    }
    
    /**
     * Возвращает текущий текст страницы
     *
     */
    public function get()
    {
        return $this->make();
    }

    
    /**
     * Установка возврата в текст ключа с отсутствием соответствия.
     * По умолчанию удаляет
     *
     * @param boolean $bool 
     */
    public function leaveKeys($bool = true)
    {
        $this->_leaveKeys = $bool;
    }
    
////////////////////////////////////////////////////////////////
///////////////////////////////     Магические методы

    public function __toString()
    {
        return $this->make();
    }
    
////////////////////////////////////////////////////////////////
///////////////////////////////     Защищённые методы методы

	protected function findMacro($sub)
	{
	    if ($this->_leaveKeys)
	       $key = '{' . $sub . '}';
	    else 
	       $key = '';
		return array_key_exists($sub, $this->keysArray) ? $this->keysArray[$sub] : $key;
	}
	
	
    protected function make()
    {
        if ($this->madeNot)
        {

           	$this->keysArray['head'] = $this->headText . $this->headTextAdd;
          
            $this->keysArray['body'] = $this->bodyText;
/*
            $count = 0;
            $this->template = str_ireplace(array_keys($this->keysArray),
                                           array_values($this->keysArray),
                                           $this->template,
                                           $count);
*/          
            $this->template = preg_replace("/\{([^}]+)\}/e", "\$this->findMacro('\\1')", $this->template);
            //$this->template = $text;
            
            $this->madeNot = false;
        }
        return $this->template;
    }
}