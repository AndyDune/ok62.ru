<?php
/**
 * Генерация страницы rss
 * 
 * Используются магические методы __toString() для работы с блоком.
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                    |
 * | Файл: Rss.php                                       |
 * | В библиотеке: Dune/Display/Rss.php                  |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>           |
 * | Версия: 1.04                                        |
 * | Сайт: www.rznw.ru                                   |
 * ----------------------------------------------------
 *
 * История версий:
 * 
 * 1.04 (2009 январь 23)
 * Для set-методов реализована возможность построения "цепочек";
 * 
 * Версия 1.02 -> 1.03
 * Добавлена автоматическая подстановка слеша в начеле строки локальной ссылки
 * Добавлено указание таблицы стилей для канала.
 * Пример текста файла
 * rss {
 * display: block;
 * font-family: verdana, arial;
 * }
 * title {
 * display: block;
 * margin: 5px;
 * padding: 2px;
 * color: gray;
 * border-bottom: 1px solid silver;
 * }
 * link {
 * display: block;
 * font-size: small;
 * padding-left: 10px;
 * }
 * item {
 * display: block;
 * padding: 2px 30px 2px 30px;
 * }
 * docs {
 * display: block;
 * background-color: #ffffe6;
 * margin: 20px;
 * text-align: center;
 * padding: 5px;
 * color: #7f7f7f;
 * border: 1px solid silver;
 * }
 * /* all hidden elements /
 * language, lastBuildDate, ttl, guid, category, description, pubDate {
 * display: none;
 * }
 * 
 * Версия 1.01 -> 1.02
 * Устранены ошибки.
 *
 * Версия 1.00 -> 1.01
 * Внедрена возможность вставлять относительные ссылки.
 * Смена кодировки.
 * 
 */
class Dune_Display_Rss
{
    /**
     * Строка-накопитель открывающийся тег элемента
     *
     * @var string
     * @access private
     */
    protected $_string_1 = '<?xml version="1.0" encoding="';

    /**
     * Строка-накопитель открывающийся тег элемента
     *
     * @var string
     * @access private
     */
    protected $_string_2 = '"?>';

    /**
     * @access private
     */
    protected $_string_stylesheet = '<?xml-stylesheet type="text/css" href="';

    /**
     * @access private
     */
    protected $_string_stylesheet_end = '" ?>';

    /**
     * @access private
     */
    protected $_string_rss_begin = '<rss version="2.0"><channel>';

    /**
     * @access private
     */
    protected $_stylesheet_set = false;
    
    
    /**
     * Текст информационных блоков 
     *
     * @var string
     * @access private
     */
    protected $_items = '';

    /**
     * Текст заголовка
     *
     * @var string
     * @access private
     */
    protected $_channel = '';

    /**
     * Текст картинка заголовка
     *
     * @var string
     * @access private
     */
    protected $_channelImage = '';
    
    
    /**
     * Индикатор открытого item
     *
     * @var string
     * @access private
     */
    protected $_itemOpened = false;

    /**
     * Запоминает элементы item, которые были заполнены
     *
     * @var string
     * @access private
     */
    protected $_itemElements = array();
    
    
    /**
     * Кодировка текста - источника
     *
     * @var string
     * @access private
     */
    protected $_encodingSourse = 'windows-1251';
    
    /**
     * Кодировка текста - результата
     *
     * @var string
     * @access private
     */
    protected $_encoding = 'UTF-8';
    
    /**
     * @access private
     */
    protected $_domain = 'http://www.rznlf.ru';
    
    const ENC_WINDOWS1251 = 'windows-1251';
    const ENC_UTF8 = 'UTF-8';
    
    public static $isExeption = true;    
    
    /**
     * Конструктор 
     * 
     * При указании кодировок источника и результата используйте соответствующие константы класса.
     * 
     * @param string $encoding_source кодировка данных
     * @param string $encoding кодировка результирующего файла
     * @param string $timeZone временная зона
     */
    public function __construct($encoding_source = 'windows-1251', $encoding = 'windows-1251', $timeZone = 'Europe/Moscow')
    {
        $this->_encodingSourse = $encoding_source;
        $this->_encoding = $encoding;
        date_default_timezone_set($timeZone);
    }

    
     public function xmlStylesheet($file)
     {
         if (strcmp('/', $file[0]) != 0)
         {
             $file = '/' . $file;
         }
         $this->_string_stylesheet .= $this->_domain . $file;
         $this->_stylesheet_set = true;
     }
     
    /**
     * Установка Заголовка канала.
     * 
     * Основной элемент, по которому люди смогут идентифицировать Ваш канал.
     * Используйте заголовки умеренной длинны, и максимально информативные.
     * Вначале заголовка можно упомянуть ваш сайт, если он популярен.
     * Отличной техникой является неизменный заголовок, ни в коем случая не указывайте в заголовке дат и тому подобного,
     *  для этого есть другие элементы. Избегайте СПАМА в заголовках, поисковиков по RSS всё-равно пока нет,
     *  а пользователю разобрать что-то будет нелегко.
     *
     * @param string $title заголовок
     */
    public function channelTitle($title)
    {
        $this->_channel .= '<title>' . $title . '</title>';
        return $this;
    }
    
    /**
     * Ссылка на Ваш сайт.
     * !!! Требование: запуск функции до заполнения items.
     * 
     * Ссылка должна вести на главную страницу вашего сайта. 
     * Или, как максимум, на соответствующий каналу раздел
     *
     * !!! Не допускается слеш к конце.
     * Можно не указыва протокол.
     * 
     * @param string $link домен сайт. Можно указывать так: www.domen.ru, или domen.ru
     */
    public function channelLink($link)
    {
        if (strpos($link, 'http:') !== 0)
        {
            $this->_domain = 'http://' . $link;        
            $link = 'http://' . $link . '/';
        }
        $this->_channel .= '<link>' . $link . '</link>';
        return $this;
    }
    
    /**
     * Описание канала. 
     * Описание не должно повторять заголовок, а должно его расшифровывать и дополнять.
     *
     * @param string $description описанеи
     */
    public function channelDescription($description)
    {
        $this->_channel .= '<description>' . $description . '</description>';
        return $this;
    }

    /**
     * Язык, на котором написан канал.
     * Несмотря на то, что этот элемент необязателен, УКАЗЫВАЙТЕ ЕГО ВСЕГДА.
     * Это поможет миновать целый список проблем. Есть 2 списка значений для этого элемента этот и этот. Оба допустимы.
     *
     * @param string $language
     */
    public function channelLanguage($language = 'ru-ru')
    {
        $this->_channel .= '<language>' . $language . '</language>';
        return $this;
    }
    
    /**
     * Дата публикации информации в канале.
     * 
     * Каждый раз, когда информация публикуется, необходимо обновлять этот элемент.
     * Это позволит многим агрегаторам ранжировать Ваш канал по актуальности представленной информации.
     * Формат нужно использовать только этот.
     * Единственное исключение, в том, что год можно указать 2-мя последними числами. Но никогда так не делайте.
     *
     * !!! Здесь примает число секунд. Формат timeStamp. Конвертирует в нужный формат.
     * 
     * @param integer $timeStamp секунды. Если не указывать - текущее время.
     */
    public function channelPubDate($timeStamp = 0)
    {
        if ($timeStamp)
            $pubDate = date('r', $timeStamp);
        else 
            $pubDate = date('r');
        $this->_channel .= '<pubDate>' . $pubDate . '</pubDate>';
        return $this;
    }

    /**
     * Время последнего изменения канала.
     * Отличие от предыдущего в том, что эта дата отражает последнее изменения контента, в то время,
     *  как pubDate - дата публикации, а не последнего редактирования.
     * Например, Ваш канал может быть опубликован год назад с информацией о курсах валют, которые обновляются каждый день.
     *
     * !!! Здесь примает число секунд. Формат timeStamp. Конвертирует в нужный формат.
     * 
     * @param integer $timeStamp секунды. Если не указывать - текущее время.
     */
    public function channelLastBuildDate($timeStamp = 0)
    {
        if ($timeStamp)
            $lastBuildDate = date('r', $timeStamp);
        else 
            $lastBuildDate = date('r');
        $this->_channel .= '<lastBuildDate>' . $lastBuildDate . '</lastBuildDate>';
        return $this;
    }

//////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////     Заполнение элемента image
/*
Путь к изображению в формате GIF, JPEG или PNG, отображаемому в заголовке канала.
Дочерние узлы:
<url> - URL изображения.
<title> ; - описание изображения, используется в атрибуте ALT HTML-тега IMG, если агрегатор конвертирует канал в HTML.
<link> - cсылка на Ваш сайт. Ссылка должна вести на главную страницу вашего сайта. Или, как максимум, на соответствующий каналу раздел. 
Элементы title и link лучше всего делать копией этих же элементов, указанных в channel.
<description> - описание картинки. Используется в элементе TITLE HTML-тега IMG.
<width> - ширина картинки в пикселях. Максимально допустимое значение - 400, по умолчанию - 88.
<height> - высота картинки в пикселях. Максимально допустимое значение - 144, по умолчанию - 31.    
*/    

    public function channelImageTitle($title)
    {
        $this->_openChannelImage();
        $this->_channelImage .= '<title>' . $title . '</title>';
        return $this;
    }

    public function channelImageWidth($width)
    {
        $this->_openChannelImage();
        $this->_channelImage .= '<width>' . $width . '</width>';
        return $this;
    }
    
    public function channelImageHeight($height)
    {
        $this->_openChannelImage();
        $this->_channelImage .= '<height>' . $height . '</height>';
        return $this;
    }
    
    public function channelImageLink($link = '')
    {
        $this->_openChannelImage();
        if ($link)
            $this->_channelImage .= '<link>' . $link . '</link>';
        else 
            $this->_channelImage .= '<link>' . $this->_domain . '</link>';
        return $this;
    }
    
    public function channelImageUrl($url, $local = true)
    {
        $this->_openChannelImage();
        $url = $this->_checkSleshBegin($url);
        if ($local)
            $this->_channelImage .= '<url>' . $this->_domain . $url . '</url>';
        else 
            $this->_channelImage .= '<url>' . $url . '</url>';
        return $this;
    }
   
//////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////     Заполнение элемента item
    
    /**
     * Начало юлока item.
     * Использовать необязательно - закрытие и открытие происходит автоматически при использовании соответствубщих элементов.
     *
     */
    public function newItem()
    {
        $this->_closeItem();
        $this->_itemOpened = true;
        $this->_items .= '<item>';
        return $this;
    }

    /**
     * Заголовок статьи.
     *
     * @param string $title
     */
    public function itemTitle($title)
    {
        $this->_checkOpenedItem('title');
        $this->_items .= '<title>' . $title . '</title>';
        return $this;
    }
    
    /**
     * Ссылка на полный текст статьи.
     *
     * @param string $link может быть относительным (слеш в начале можно не указывать)
     * @param boolean $local индикатор относительной ссылки
     */
    public function itemLink($link, $local = true)
    {
        $this->_checkOpenedItem('link');
        if ($local)
        {
            $link = $this->_checkSleshBegin($link);
            $link = $this->_domain . $link;
        }
        $this->_items .= '<link>' . $link . '</link>';
        return $this;
    }
    
    /**
     * Полный текст статьи, либо аннотация.
     *
     * @param string $description
     * @param boolean $CDATA индикатор установки контейнера <![CDATA[]]>
     */
    public function itemDescription($description, $CDATA = false)
    {
        $this->_checkOpenedItem('desc');
        if ($CDATA)
            $this->_items .= '<description><![CDATA[' . $description . ']]></description>';
        else 
            $this->_items .= '<description>' . $description . '</description>';
        return $this;
    }
    
    /**
     * Адрес электронной почты автора статьи.
     *
     * @param string $author
     */
    public function itemAuthor($author)
    {
        $this->_checkOpenedItem('au');
        $this->_items .= '<author>' . $author . '</author>';
        return $this;
    }
    
    /**
     * То же самое, что и category в channel.
     *
     * @param string $category
     */
    public function itemCategory($category)
    {
        $this->_checkOpenedItem('cat');
        $this->_items .= '<category>' . $category . '</category>';
        return $this;
    }
    
    /**
     * Ссылка на страницу с комментариями к статье.
     *
     * @param string $comments может быть относительным (слеш в начале можно не указывать)
     * @param boolean $local индикатор относительной ссылки
     */
    public function itemComments($comments, $local = true)
    {
        $this->_checkOpenedItem('com');
        if ($local)
        {
            $comments = $this->_checkSleshBegin($comments);
            $comments = $this->_domain . $comments;
        }
        else if (strpos($comments, 'http:') !== 0)
            $comments = 'http://' . $comments;
            
        $this->_items .= '<comments>' . $comments . '</comments>';
        return $this;
    }
    
    /**
     * Вложение.
     * К статье можно присоединить любой файл, ссылка на него будет отображена агрегатором.
     *
     * @param string $url может быть относительным (слеш в начале можно не указывать)
     * @param string $length размер файла в байтах
     * @param string $type mime-тип файла
     * @param boolean $local индикатор относительной ссылки
     */
    public function itemEnclosure($url, $length = '', $type = 'image/jpeg', $local = true)
    {
        $this->_checkOpenedItem('enc');
        if ($local)
        {
            $url = $this->_checkSleshBegin($url);            
            $url = $this->_domain . $url;
        }
        else if (strpos($url, 'http:') !== 0)
            $url = 'http://' . $url;
            
        if ($lengt)
            $this->_items .= '<enclosure url="' . $url . '" length="' . $length . '" type="' . $type . '" />';
        else 
            $this->_items .= '<enclosure url="' . $url . '" type="' . $type . '" />';  
        return $this;      
    }
    
    /**
     * Уникальная строка, однозначно идентифицирующая статью в рамках данного канала.
     * Особых требований нет, однако, стало традицией использовать полный интернет адрес, по которому доступен оргинал статьи.
     * Установка атрибута isPermaLink в true, будет означать, что именно такой идентификатор и используется.
     *
     * @param string $guid ссылка на статю. (слеш в начале можно не указывать)
     * @param boolean $isPermaLink
     * @param string $local url относительно домена сайта
     */
    public function itemGuid($guid, $isPermaLink = true, $local = true)
    {
        $this->_checkOpenedItem('gui');
        if ($local)
        {
            $quid = $this->_checkSleshBegin($guid);
            $guid = $this->_domain . $guid;
        }
        else if (strpos($guid, 'http:') !== 0)
            $guid = 'http://' . $guid;
        
        if ($isPermaLink)
           $this->_items .= '<guid isPermaLink="true">' . $guid . '</guid>';
        else 
           $this->_items .= '<guid>' . $guid . '</guid>';
        return $this;
    }
    
    /**
     * Дата публикации статьи.
     * Некоторые агрегаторы не будут отображать статью, если указанная дата еще не настала.
     * Но далеко не все.
     *
     * @param integer $timeStamp число секунд
     */
    public function itemPubDate($timeStamp = 0)
    {
        if ($timeStamp)
            $pubDate = date('r', $timeStamp);
        else 
            $pubDate = date('r');
        
        $this->_checkOpenedItem('pud');
        $this->_items .= '<pubDate>' . $pubDate. '</pubDate>';
        return $this;
    }
    
    /**
     * Для каждого <item> cодержит адрес канала и копию его атрибута title.
     *
     * @param string $url может быть относительным к домену  (слеш в начале можно не указывать)
     * @param string $text
     * @param boolean $local
     */
    public function itemSource($url, $text, $local = true)
    {
        $this->_checkOpenedItem('sour');
        if ($local)
        {
            $url = $this->_checkSleshBegin($url);
            $url = $this->_domain . $url;
        }
        else if (strpos($url, 'http:') !== 0)
            $url = 'http://' . $url;
        
        $this->_items .= '<source url="' . $url . '">' . $text . '</source>';
        return $this;
    }
    
    
    /**
     * Возвращает весь блок с содержимым и ограничивающими тегами.
     *
     * @return sting
     */
    public function get()
    {
        $this->_closeChannelImage();
        $this->_setChannelGenerator();
        $this->_closeItem();
        $str =  $this->_string_1 . $this->_encoding . $this->_string_2;
        if ($this->_stylesheet_set)
            $str .=  $this->_string_stylesheet . $this->_string_stylesheet_end;
        $str .= $this->_string_rss_begin . 
                $this->_channel . $this->_channelImage . $this->_items .'</channel></rss>';
        if ($this->_encodingSourse != $this->_encoding)        
        {
            $str_new = iconv($this->_encodingSourse, $this->_encoding, $str);
            $str = $str_new;
        }
        return $str;
    }

    
////////////////////////////////////////////////////////////////
///////////////////////////////     Магические методы

    public function __toString()
    {
        return $this->get();
    }

    
////////////////////////////////////////////////////////////////
///////////////////////////////     Закрытые методы


    /**
     * @access private
     */
    protected function _checkSleshBegin($text)
    {
         if (strcmp('/', $text[0]) != 0)
         {
             $text = '/' . $text;
         }
         return $text;
    }

    /**
     * @access private
     */
    protected function _setChannelGenerator()
    {
        $this->_channel .= '<generator>Dune Code Complex (rznlf.ru)</generator>';
    }

    /**
     * @access private
     */
    protected function _closeChannelImage()
    {
        if ($this->_channelImage)
        {
            $this->_channelImage .= '</image>';
        }
    }

    /**
     * @access private
     */
    protected function _openChannelImage()
    {
        if (!$this->_channelImage)
        {
            $this->_channelImage .= '<image>';
        }
    }
    

    /**
     * @access private
     */
    protected function _checkOpenedItem($key)
    {
        if (!$this->_itemOpened)
        {
            $this->newItem();
        }
        else if (key_exists($key, $this->_itemElements))
        {
            $this->_items .= '</item><item>';
            $this->_itemElements = array();
        }
        $this->_itemElements[$key] = 1;
    }
    
    /**
     * @access private
     */
    protected function _closeItem()
    {
        if ($this->_itemOpened)
        {
            $this->_items .= '</item>';
            $this->_itemOpened = false;
        }
    }

}