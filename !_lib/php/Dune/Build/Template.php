<?php
/**
 * Класс для работы с файлом-шаблоном страницы
 * 
 * Ключами к замене являются строки типа <!--%ключ%--> Пробелов быть не должно.
 * 
 * Использует классы:
 * Dune_Exception_Base
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Template.php                                |
 * | В библиотеке: Dune/Build/Template.php             |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>        |
 * | Версия: 1.02                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 * 
 * 
 * История версий:
 * -----------------
 * Версия 1.01 -> 1.02
 * Добавлен метод: addToBody($value) - добавляет текст к боди
 * 
 * Версия 1.00 -> 1.01
 * Добавлен метод: get() - возвращает текст страницы
 * Добавлен метод: getKeys() - возвращает массив ключей в шаблоне
 * 
 */
class Dune_Build_Template
{
    /**
     * Флаг генерации исключений
     *
     * @var boolean
     */
    private $exeption = false;
    
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
    
    public function __construct($path, $like_string = false)
    {
        if ($like_string)
        {
            $this->template = $path;
        }
        else 
        {
            if (!is_file($path))
            {
                throw new Dune_Exception_Base('Указан путь к несуществующему файлу-шаблону: '.$path);
            }
            $this->path = $path;
            $this->template = file_get_contents($path);
            if (!$this->template)
            {
                throw new Dune_Exception_Base('Не удалось открыть файл-шаблон.');
            }
        }
    }
    
    /**
     * Включает/выключает генерацию исключений при отсутсивии искомого ключа
     *
     * @param boolean $bool
     */
    public function setExeption($bool = true)
    {
        $this->exeption = $bool;
    }
    
    /**
     * Заменяет ключ в шаблоне на указаннное значение.
     * 
     * В шаболне должен существовать ключ, иначе будет прерывание.
     * 
     * Ключ в шаблоне имеет вид: <!--%ключ%-->. Пробелы запрещены.
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
        $count = 0;
        $this->template = str_ireplace('<!--%'.$key.'%-->',
                                       $value,
                                       $this->template,
                                       $count);
        if (!$count)
        {
            if ($this->exeption)
                throw new Dune_Exception_Base('Указанный ключ: '.$key.' не найден в шаблоне.');
            else
                return false;
        }
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
        preg_match_all('|<!--%([-_a-zA-Z0-9]+)%-->|i', $this->template, $array);
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
        $count = 0;
        $this->template = str_ireplace('</head>',
                                       '<title>'.$value.'</title></head>',
                                       $this->template,
                                       $count);
        if (!$count)
        {
            throw new Dune_Exception_Base('Ошибка добавления МЕТА-тега title.');
        }
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
        $count = 0;
        $this->template = str_ireplace('</head>',
                                       '<meta name="keywords" content="'.$value.'" /></head>',
                                       $this->template,
                                       $count);
        if (!$count)
        {
            throw new Dune_Exception_Base('Ошибка добавления МЕТА-тега keywords.');
        }
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
        $count = 0;
        $this->template = str_ireplace('</head>',
                                       '<meta name="description" content="'.$value.'" /></head>',
                                       $this->template,
                                       $count);
        if (!$count)
        {
            throw new Dune_Exception_Base('Ошибка добавления МЕТА-тега keywords.');
        }
    }
    /**
     * Добавления текста в блок head(ссылки на таблицы css, файлы JS и прочее)
     * К тексту не применяется функция htmlspecialchars()
     *
     * @param string $value
     */
    public function addToHead($value)
    {
        $count = 0;
        $this->template = str_ireplace('</head>',
                                       $value.'</head>',
                                       $this->template,
                                       $count);
        if (!$count)
        {
            throw new Dune_Exception_Base('Ошибка добавления текста в шапку страницы.');
        }
    }    

    
    /**
     * Добавления текста в блок body. Перед закрывающим тегом.
     * К тексту не применяется функция htmlspecialchars()
     *
     * @param string $value
     */
    public function addToBody($value)
    {
        $count = 0;
        $this->template = str_ireplace('</body>',
                                       $value.'</body>',
                                       $this->template,
                                       $count);
        if (!$count)
        {
            if ($this->exeption)
                throw new Dune_Exception_Base('Ошибка добавления текста в тело страницы.');
            else
                return false;
        }
    }    
    
    /**
     * Печать страницы
     *
     */
    public function display()
    {
        echo $this->template;
    }
    
    /**
     * Возвращает текущий текст страницы
     *
     */
    public function get()
    {
        return $this->template;
    }
    
////////////////////////////////////////////////////////////////
///////////////////////////////     Магические методы

    public function __toString()
    {
        return $this->template;
    }
}