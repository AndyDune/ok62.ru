<?php
/**
 * Генерация блока div с проверкой колличества открытый и закрытых тегов.
 * 
 * Применять в пределах одной страницы с кодом.
 * Число открытый и закрытых тегов сохраняется в переменной класса.
 * 
 * Используются магические методы __set(), __get, __toString() для работы с блоком.
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                    |
 * | Файл: Div.php                                       |
 * | В библиотеке: Dune/Display/Div.php                  |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>          |
 * | Версия: 1.03                                        |
 * | Сайт: www.rznlf.ru                                  |
 * ----------------------------------------------------
 *
 * История версий:
 *
 * Версия 1.02 -> 1.03
 * Убрана статичная переменная
 * 
 * Версия 1.01 -> 1.02
 * Устранена ошибка вывода всего блока с содержимым.
 * 
 * Версия 1.00 -> 1.01
 * Добалена работа с содержимым блока div.
 * Объект может использоваться не только как генератор тегов начала и конца блока.
 * Но и как контейнер для содержимого блока. Смешивать методики не делательно.
 * 
 * 
 */
class Dune_Display_Div
{
    /**
     * Строка-накопитель открывающийся тег элемента
     *
     * @var string
     * @access private
     */
    protected $_string = '<div>';

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
        return '</div>';
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
        return $this->_string . $this->_text . '</div>';
    }

    
////////////////////////////////////////////////////////////////
///////////////////////////////     Магические методы
    
    public function __set($name, $value)
    {
        $this->_text .= $value;
    }
    public function __get($name)
    {
        return $this->_string . $this->_text . '</div>';
    }
    
    public function __toString()
    {
        return $this->_string . $this->_text . '</div>';
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
                throw new Dune_Exception_Base('Не закрыт блок div.');
            $bool = false;
        }
        return $bool;
    }
    
}