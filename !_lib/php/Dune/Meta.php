<?php
/**
 * Статический класс
 * Объединяет в себе методы для формирования строк мета-тегов
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Meta.php                                    |
 * | В библиотеке: Dune/Meta.php                       |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>        |
 * | Версия: 1.01                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 * 
 *  Можно использовать и как справочник
 * 
 * История версий:
 * -----------------
 * Версия 1.00 -> 1.01
 * Исправлено название метода: getrobotsArray() -> getRobotsArray()
 */

class Dune_Meta
{
//////////////////////////////////////////////////////////////////////////////////
////////////////////////////        Служебные переменные, методы - НАЧАЛО ОПИСАНИЯ
    /**
     * Массив допустимых значений мета тега control-cache
     * @var array
     */
    static private $cacheControlArray = array(1=>'public','private','no-cache','no-store','no-transform','must-revalidate','proxy-revalidate');
    
    /**
     * метод возвращает массив допустимых значений тега control-cache
     *
     * @return array
     */
    static public function getCacheControlArray()
    {
        return $cacheControlArray;
    }
    /**
     * Массив допустимых значений мета тега robots
     * @var array
     */
    static private $robotsArray = array(1=>'index','follow','all','noindex','nofollow','none');
    
    /**
     * метод возвращает массив допустимых значений тега robots
     *
     * @return array
     */
    static public function getRobotsArray()
    {
        return $robotsArray;
    }
    
////////////////////////////        Служебные переменные, методы - КОНЕЦ ОПИСАНИЯ    
/////////////////////////////////////////////////////////////////////////////////    

    /**
     * Возвращает строку c заголовком refresh
     * Праметры:
     *  $time - время в секундах, через которое браузер производит переадресацию страницы
     *  $url - адрес страницы к которой переадреауем, если не передано, переадресация на себя
     * 
     * @param integer $time
     * @param string $url
     * @return string
     */
    static public function refresh($time = 5,$url = '')
    {
        if ($url != '')
            $add = '; url='.$url;
        else 
            $add = '';
        return '<meta http-equiv="refresh" content="'.$time.$add.'">';
    }
    /**
     * Переадресация
     *
     * @param string $url
     * @return string
     */
    static public function location($url = '')
    {
        return '<meta http-equiv="location" content="'.$url.'">';
    }
    /**
     * Запрет кеширования по протокулу HTTP 1.0
     *
     * @return string
     */
    static public function pragma()
    {
        return '<meta http-equiv="pragma" content="no-cache">';
    }
    
    /**
     * Управление кэшированием в протоколе HTTP 1.1
     *
     * <meta http-equiv="cache-control" content="значение">
     * 
     * Значение заголовка:
     * 1. public   - разрешено кэширование во всех видах кэша
     * 2. private  - весь ответ, либо его часть может кэшироваться только только одним авторизованным пользователем. Для всех других кэширование запрещено
     * 3. no-cache - запрет кэширования, где бы то ни было;
     * 4. no-store - разрешается только временное кэширование
     * 5. no-transform - запрет трансформации передаваемых данных
     * 6. must-revalidate - при наличии данной директивы всегда должно следовать обращение к исходному серверу для сверки данных
     * 7. proxy-revalidate - тоже что и must-revalidate, но только для поркси-серверов
     * 8. max-age - управляет временем жизни данных в кэше
     * 
     * 
     * @param string $text значение заголовка
     * @return string строка мета тега
     */
    static public function cacheControl($text = 'public')
    {
        // если передаётся целое число - мета-тег формируется из предустановленных значений согласно их номерам в списке выше
        if (is_int($text))
        {
            // Если передана цифра больше 7 рна участвует в формированиее значения max-age
            if ($text > 7)
            {
                $text = 1;
                $text = $cacheControlArray[$text];
            }
            else 
            {
                $text = 'max-age='.$text;
            }
        }
        return '<meta http-equiv="cache-control" content="'.$text.'">';
    }
    
    
    /**
     * Возвращает строку метатега content-type
     * 
     * <meta http-equiv="content-type" content="MINE-тип; charset=кодовая страница">
     * 
     * @param string $charset кодировка, по умолчанию windows-1251
     * @param string $content MINE-тип,  по умолчанию text/html
     * @return string строка мета тега
     */
    static public function contentType($charset = 'windows-1251',$content = 'text/html')
    {
        return '<meta http-equiv="content-type" content="'.$content.'; charset='.$charset.'">';
    }

   /**
    * Возвращает строку метатега description
    * 
    * <meta name="description" content="Текст описания">
    * 
    * @param string $text описание
    * @return string
    */
    static public function description($text = '')
    {
        return '<meta name="description" content="'.$text.'">';
    }
    
   /**
    * Возвращает строку метатега keywords
    *
    * <meta name="keywords" content="ключевые слова">
    * 
    * @param string $text список ключевых слов через запятую
    * @return string
    */
    static public function keywords($text = '')
    {
        return '<meta name="keywords" content="'.$text.'">';
    }
    
    
/**
 * Возвращает строгу мета-тега Robots
 * Управление индексацией сайта
 * Принимаемые значения
 * 1. index - по умолчанию
 * 2. follow - следовать по ссылкам с данной странице
 * 3. all - идентично 2-м совместным опциям index и follow
 * 4. noindex - запретить инлексацию
 * 5. nofollow - запретить переход по ссылкам с данной страницы
 * 6. none - идентично 2-м совместным опциям noindex и nofollow
 *
 * <meta name="robots" content="одно из выше перечисленных слов">
 * 
 * @param mixed $text
 * @return string
 */
    static public function robots($text = 'none')
    {
        // если передаётся целое число - мета-тег формируется из предустановленных значений согласно их номерам в списке выше
        if (is_int($text))
        {
            // Если передана цифра больше 7 рна участвует в формированиее значения max-age
            if ($text > 6)
            {
                $text = 6;
                $text = $robotsArray[$text];
            }
        }
        
        return '<meta name="robots" content="'.$text.'">';
    }
}