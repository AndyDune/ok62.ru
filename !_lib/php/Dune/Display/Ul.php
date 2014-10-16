<?php
/**
 * Конструктор списка
 * 
 * 
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                    |
 * | Файл: Ul.php                                        |
 * | В библиотеке: Dune/Display/Ul.php                   |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>          |
 * | Версия: 1.00                                        |
 * | Сайт: www.rznlf.ru                                  |
 * ----------------------------------------------------
 *
 * История версий:
 *
 * Версия 1.00 -> 1.01
 * 
 * 
 */
class Dune_Display_Ul
{
    /**
     * Строка-накопитель открывающийся тег элемента
     *
     * @var string
     * @access private
     */
    protected $_string = '<ul>';

    /**
     * Строка-накопитель содержимого таблицы
     *
     * @var string
     * @access private
     */
    protected $_text = '';

    
    public static $isExeption = true;    
    
    /**
     * Конструктор 
     * 
     * @param string $id идентификатор списка
     */
    public function __construct($id = '')
    {
        if ($id)
        {
            $this->_string = str_replace('>', ' id="' . $id . '">', $this->_string);
        }
    }
    

    /**
     * Определяет класс для всего списка
     *
     * @param string $class
     */
    public function setClass($class)
    {
        $this->_string = str_replace('>', ' class="' . $class . '">', $this->_string);
    }

    
    /**
     * Добавление элемента списка
     *
     * @param string $content содержимое элемента
     * @param string $class класс элемента, если установлен
     */
    public function addLi($content = '', $class = '')
    {
        if ($class)
            $class = ' class="' . $class . '"';
        $this->_text .= '<li' . $class . '>' . $content . '</li>';
    }

    
    /**
     * Возвращает весь блок с содержимым и ограничивающими тегами.
     *
     * @return sting
     */
    public function get()
    {
        return $this->_string . $this->_text . '</ul>';
    }

    
////////////////////////////////////////////////////////////////
///////////////////////////////     Магические методы
    
   
    public function __toString()
    {
        return $this->_string . $this->_text . '</ul>';
    }

    
////////////////////////////////////////////////////////////////
///////////////////////////////     Закрытые методы
    
}