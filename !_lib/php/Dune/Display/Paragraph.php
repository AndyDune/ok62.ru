<?php
/**
 * Генерация блока p с проверкой колличества открытый и закрытых тегов.
 * 
 * Применять в пределах одной страницы с кодом.
 * Число открытый и закрытых тегов сохраняется в переменной класса.
 * 
 * Используются магические методы __set(), __get, __toString() для работы с блоком.
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                    |
 * | Файл: Paragraph.php                                 |
 * | В библиотеке: Dune/Display/Paragraph.php            |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>          |
 * | Версия: 1.00                                        |
 * | Сайт: www.rznlf.ru                                  |
 * ----------------------------------------------------
 *
 * История версий:
 *
 * Версия 1.00 -> 1.01
 * 
 */
class Dune_Display_Paragraph
{
    /**
     * Строка-накопитель открывающийся тег элемента
     *
     * @var string
     * @access private
     */
    protected $_string = '<p>';

    /**
     * Строка-накопитель содержимого блока
     *
     * @var string
     * @access private
     */
    protected $_text = '';

    
    /**
     * Соотношение открытых и закрытых тегов.
     * 10 - соотношение в норме.
     *
     * @var integer
     * @access private
     */
    protected $_count = 10;
    
    public static $isExeption = true;    
    
    /**
     * Конструктор 
     * 
     * @param string $id идентификатор блока
     */
    public function __construct($id = '')
    {
        if ($id)
        {
            $this->_string = str_replace('>', ' id="' . $id . '">', $this->_string);
        }
    }
    

    /**
     * Определяет класс блока
     *
     * @param string $class
     */
    public function setClass($class)
    {
        $this->_string = str_replace('>', ' class="' . $class . '">', $this->_string);
    }

    
    /**
     * Возвращает строку - открывающийся тег блока.
     *
     * @return sting
     */
    public function begin()
    {
        $this->_count += 1;
        return $this->_string;
    }
    
    /**
     * Возвращает строку - закрывающий тег блока.
     *
     * @return sting
     */
    public function end()
    {
        $this->_count -= 1;
        return '</p>';
    }

    
    /**
     * Устанавливает содержимое блока.
     * Может использоваться сколько угодно раз.
     *
     * @return sting
     */
    public function set($text)
    {
        $this->_text .= $text;
    }

    /**
     * Возвращает весь блок с содержимым и ограничивающими тегами.
     *
     * @return sting
     */
    public function get()
    {
        return $this->_string . $this->_text . '</p>';
    }

    
////////////////////////////////////////////////////////////////
///////////////////////////////     Магические методы
    
    public function __set($name, $value)
    {
        $this->_text .= $value;
    }
    public function __get($name)
    {
        return $this->_string . $this->_text . '</p>';
    }
    
    public function __toString()
    {
        return $this->_string . $this->_text . '</p>';
    }

    
////////////////////////////////////////////////////////////////
///////////////////////////////     Закрытые методы
    
    /**
     * Проверка соотношений.
     *
     * @return sting
     */
    public function check()
    {
        if ($this->_count == 10)
            $bool = true;
        else 
        {
            if (self::$isExeption)
                throw new Dune_Exception_Base('Не закрыт блок p.');
            $bool = false;
        }
        return $bool;
    }
    
}