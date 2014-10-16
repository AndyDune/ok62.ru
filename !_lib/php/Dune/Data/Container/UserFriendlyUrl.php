<?
/**
 * Строка в урл имеет вид:
 * <любой разрещённый набор символов>-<код статьи>
 * т.е. после последнего дефиса - код(id)
 * если дефис не найден - значит вся строка является кодом
 * 
 * 
 * Класс контейнер данных.
 *  Инвертирование русских предложений в транслит для ЧПУ.
 *  Инвертирование транслита в индекс для поиска в индексе таблицы БД.
 *  
 *	 
 * ---------------------------------------------------------
 * | Библиотека: Dune                                       |
 * | Файл: UserFriendlyUrl.php                              |
 * | В библиотеке: Dune/Data/Container/UserFriendlyUrl.php  |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>             |
 * | Версия: 1.01                                           |
 * | Сайт: www.rznlf.ru                                     |
 * ---------------------------------------------------------
 * 
 * История версий:
 *
 * Версия 1.00 -> 1.01
 * Добавлено извлечение идентификатора из строки. 
 * Метод getId().
 * 
 */

class Dune_Data_Container_UserFriendlyUrl
{

    /**
     * Массив символов для замены
     *
     * @var array
     * @access privare
     */
    private $search = array("а","б","в","г","д","е","ё","ж","з","и",
                            "й","к","л","м","н","о","п","р","с","т",
                            "у","ф","х","ц","ч","ш","щ","ъ","ы","ь",
                            "э","ю","я"," ");
      

    /**
     * Массив символов для транслита
     *
     * @var array
     * @access privare
     */
    private $replace = array("a","b","v","g","d","e","jo","zh","z","i",
                            "j","k","l","m","n","o","p","r","s","t",
                            "u","f","h","c","ch","sh","shch","'","y","'",
                            "eh","yu","ya","-");

    /**
     * Русская фраза для трансформации
     *
     * @var string
     * @access privare
     */
    private $originalString = '';
    
    /**
     * Получившаясы фраза-транслитерация с русского
     *
     * @var string
     * @access privare
     */
    private $urlString = '';
    
    /**
     * Бинарная строка из 16 символов.
     * Использовать для индексов в таблице.
     *
     * @var string
     * @access privare
     */
    private $hash16String = '';
    
    /**
     * 32-значное шестнадцатеричное число.
     * Использовать для индексов в таблице.
     *
     * @var string
     * @access privare
     */
    private $hash32String = '';

    /**
     * Код статьи
     * 
     * @var integer
     * @access privare
     */
    private $id = 0;
    
    /**
     * При передаче непустой строки конвертирует её в транслит для использования в ЧПУ.
     * После чего можно тспользовать get методы
     *
     * @param string $string русская фраза
     */
    public function __construct($string = '')
    {
        if ($string)
        {
            $this->originalString = $string;
            $string = strtolower($string);
            $string = preg_replace('|[^- 0-9а-яa-z]|i', '', $string);
            $string = preg_replace('|[ ]{2,}|i', ' ', $string);
            $string = str_replace($this->search, $this->replace, $string);
            $this->urlString = $string;
        }
    }
  
    /**
     * Принимает строку из URL для прообразования в хэш.
     * Выборка из строки id статьи.
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
     * Возвращает хеш 16 байт от строки используемой в URL
     *
     * @return string бинареая строка
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
     * Возвращает хеш 32 байта от строки используемой в URL
     *
     * @return string строка 16-ое число
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
     * Возвращает транслитерную строку от переданной русской для вставки в URL.
     *
     * @return string строка, применяемая в URL
     */
    public function getUrl()
    {
        $this->urlString = preg_replace('|[^-0-9a-z]|', '', strtolower($this->urlString));
        return $this->urlString;
    }
    
    /**
     * Возвращает идентификатор статьи (id).
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

}