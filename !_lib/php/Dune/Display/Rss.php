<?php
/**
 * ��������� �������� rss
 * 
 * ������������ ���������� ������ __toString() ��� ������ � ������.
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                    |
 * | ����: Rss.php                                       |
 * | � ����������: Dune/Display/Rss.php                  |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>           |
 * | ������: 1.04                                        |
 * | ����: www.rznw.ru                                   |
 * ----------------------------------------------------
 *
 * ������� ������:
 * 
 * 1.04 (2009 ������ 23)
 * ��� set-������� ����������� ����������� ���������� "�������";
 * 
 * ������ 1.02 -> 1.03
 * ��������� �������������� ����������� ����� � ������ ������ ��������� ������
 * ��������� �������� ������� ������ ��� ������.
 * ������ ������ �����
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
 * ������ 1.01 -> 1.02
 * ��������� ������.
 *
 * ������ 1.00 -> 1.01
 * �������� ����������� ��������� ������������� ������.
 * ����� ���������.
 * 
 */
class Dune_Display_Rss
{
    /**
     * ������-���������� ������������� ��� ��������
     *
     * @var string
     * @access private
     */
    protected $_string_1 = '<?xml version="1.0" encoding="';

    /**
     * ������-���������� ������������� ��� ��������
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
     * ����� �������������� ������ 
     *
     * @var string
     * @access private
     */
    protected $_items = '';

    /**
     * ����� ���������
     *
     * @var string
     * @access private
     */
    protected $_channel = '';

    /**
     * ����� �������� ���������
     *
     * @var string
     * @access private
     */
    protected $_channelImage = '';
    
    
    /**
     * ��������� ��������� item
     *
     * @var string
     * @access private
     */
    protected $_itemOpened = false;

    /**
     * ���������� �������� item, ������� ���� ���������
     *
     * @var string
     * @access private
     */
    protected $_itemElements = array();
    
    
    /**
     * ��������� ������ - ���������
     *
     * @var string
     * @access private
     */
    protected $_encodingSourse = 'windows-1251';
    
    /**
     * ��������� ������ - ����������
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
     * ����������� 
     * 
     * ��� �������� ��������� ��������� � ���������� ����������� ��������������� ��������� ������.
     * 
     * @param string $encoding_source ��������� ������
     * @param string $encoding ��������� ��������������� �����
     * @param string $timeZone ��������� ����
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
     * ��������� ��������� ������.
     * 
     * �������� �������, �� �������� ���� ������ ���������������� ��� �����.
     * ����������� ��������� ��������� ������, � ����������� �������������.
     * ������� ��������� ����� ��������� ��� ����, ���� �� ���������.
     * �������� �������� �������� ���������� ���������, �� � ���� ������ �� ���������� � ��������� ��� � ���� ���������,
     *  ��� ����� ���� ������ ��������. ��������� ����� � ����������, ����������� �� RSS ��-����� ���� ���,
     *  � ������������ ��������� ���-�� ����� �������.
     *
     * @param string $title ���������
     */
    public function channelTitle($title)
    {
        $this->_channel .= '<title>' . $title . '</title>';
        return $this;
    }
    
    /**
     * ������ �� ��� ����.
     * !!! ����������: ������ ������� �� ���������� items.
     * 
     * ������ ������ ����� �� ������� �������� ������ �����. 
     * ���, ��� ��������, �� ��������������� ������ ������
     *
     * !!! �� ����������� ���� � �����.
     * ����� �� ������� ��������.
     * 
     * @param string $link ����� ����. ����� ��������� ���: www.domen.ru, ��� domen.ru
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
     * �������� ������. 
     * �������� �� ������ ��������� ���������, � ������ ��� �������������� � ���������.
     *
     * @param string $description ��������
     */
    public function channelDescription($description)
    {
        $this->_channel .= '<description>' . $description . '</description>';
        return $this;
    }

    /**
     * ����, �� ������� ������� �����.
     * �������� �� ��, ��� ���� ������� ������������, ���������� ��� ������.
     * ��� ������� �������� ����� ������ �������. ���� 2 ������ �������� ��� ����� �������� ���� � ����. ��� ���������.
     *
     * @param string $language
     */
    public function channelLanguage($language = 'ru-ru')
    {
        $this->_channel .= '<language>' . $language . '</language>';
        return $this;
    }
    
    /**
     * ���� ���������� ���������� � ������.
     * 
     * ������ ���, ����� ���������� �����������, ���������� ��������� ���� �������.
     * ��� �������� ������ ����������� ����������� ��� ����� �� ������������ �������������� ����������.
     * ������ ����� ������������ ������ ����.
     * ������������ ����������, � ���, ��� ��� ����� ������� 2-�� ���������� �������. �� ������� ��� �� �������.
     *
     * !!! ����� ������� ����� ������. ������ timeStamp. ������������ � ������ ������.
     * 
     * @param integer $timeStamp �������. ���� �� ��������� - ������� �����.
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
     * ����� ���������� ��������� ������.
     * ������� �� ����������� � ���, ��� ��� ���� �������� ��������� ��������� ��������, � �� �����,
     *  ��� pubDate - ���� ����������, � �� ���������� ��������������.
     * ��������, ��� ����� ����� ���� ����������� ��� ����� � ����������� � ������ �����, ������� ����������� ������ ����.
     *
     * !!! ����� ������� ����� ������. ������ timeStamp. ������������ � ������ ������.
     * 
     * @param integer $timeStamp �������. ���� �� ��������� - ������� �����.
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
///////////////     ���������� �������� image
/*
���� � ����������� � ������� GIF, JPEG ��� PNG, ������������� � ��������� ������.
�������� ����:
<url> - URL �����������.
<title> ; - �������� �����������, ������������ � �������� ALT HTML-���� IMG, ���� ��������� ������������ ����� � HTML.
<link> - c����� �� ��� ����. ������ ������ ����� �� ������� �������� ������ �����. ���, ��� ��������, �� ��������������� ������ ������. 
�������� title � link ����� ����� ������ ������ ���� �� ���������, ��������� � channel.
<description> - �������� ��������. ������������ � �������� TITLE HTML-���� IMG.
<width> - ������ �������� � ��������. ����������� ���������� �������� - 400, �� ��������� - 88.
<height> - ������ �������� � ��������. ����������� ���������� �������� - 144, �� ��������� - 31.    
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
///////////////     ���������� �������� item
    
    /**
     * ������ ����� item.
     * ������������ ������������� - �������� � �������� ���������� ������������� ��� ������������� ��������������� ���������.
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
     * ��������� ������.
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
     * ������ �� ������ ����� ������.
     *
     * @param string $link ����� ���� ������������� (���� � ������ ����� �� ���������)
     * @param boolean $local ��������� ������������� ������
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
     * ������ ����� ������, ���� ���������.
     *
     * @param string $description
     * @param boolean $CDATA ��������� ��������� ���������� <![CDATA[]]>
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
     * ����� ����������� ����� ������ ������.
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
     * �� �� �����, ��� � category � channel.
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
     * ������ �� �������� � ������������� � ������.
     *
     * @param string $comments ����� ���� ������������� (���� � ������ ����� �� ���������)
     * @param boolean $local ��������� ������������� ������
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
     * ��������.
     * � ������ ����� ������������ ����� ����, ������ �� ���� ����� ���������� �����������.
     *
     * @param string $url ����� ���� ������������� (���� � ������ ����� �� ���������)
     * @param string $length ������ ����� � ������
     * @param string $type mime-��� �����
     * @param boolean $local ��������� ������������� ������
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
     * ���������� ������, ���������� ���������������� ������ � ������ ������� ������.
     * ������ ���������� ���, ������, ����� ��������� ������������ ������ �������� �����, �� �������� �������� ������� ������.
     * ��������� �������� isPermaLink � true, ����� ��������, ��� ������ ����� ������������� � ������������.
     *
     * @param string $guid ������ �� �����. (���� � ������ ����� �� ���������)
     * @param boolean $isPermaLink
     * @param string $local url ������������ ������ �����
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
     * ���� ���������� ������.
     * ��������� ���������� �� ����� ���������� ������, ���� ��������� ���� ��� �� �������.
     * �� ������ �� ���.
     *
     * @param integer $timeStamp ����� ������
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
     * ��� ������� <item> c������� ����� ������ � ����� ��� �������� title.
     *
     * @param string $url ����� ���� ������������� � ������  (���� � ������ ����� �� ���������)
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
     * ���������� ���� ���� � ���������� � ��������������� ������.
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
///////////////////////////////     ���������� ������

    public function __toString()
    {
        return $this->get();
    }

    
////////////////////////////////////////////////////////////////
///////////////////////////////     �������� ������


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