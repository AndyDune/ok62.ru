<?php
/**
 * Конструктор таблицы
 * 
 * Применять в пределах одной страницы с кодом.
 * 
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                    |
 * | Файл: Table.php                                     |
 * | В библиотеке: Dune/Display/Table.php                |
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
class Dune_Display_Table
{
    /**
     * Строка-накопитель открывающийся тег элемента
     *
     * @var string
     * @access private
     */
    protected $_string = '<table>';

    /**
     * Строка-накопитель содержимого таблицы
     *
     * @var string
     * @access private
     */
    protected $_text = '';

    
    /**
     * Индикатор отктытого ряда таблицы
     *
     * @var boolean
     * @access private
     */
    protected $openedTR = false;

    /**
     * Максимальное число ячеек в ряде из всей таблицы
     *
     * @var integer
     * @access private
     */
    protected $_countMaxTD = 0;

    
    /**
     * Число ячеек в текущем ряде
     *
     * @var unteger
     * @access private
     */
    protected $_countTD = 0;
    
    
    public static $isExeption = true;    
    
    /**
     * Конструктор 
     * 
     * @param string $id идентификатор таблицы
     */
    public function __construct($id = '')
    {
        if ($id)
        {
            $this->_string = str_replace('>', ' id="' . $id . '">', $this->_string);
        }
    }
    

    /**
     * Определяет класс для всей таблицы
     *
     * @param string $class
     */
    public function setClass($class)
    {
        $this->_string = str_replace('>', ' class="' . $class . '">', $this->_string);
    }

    public function addSummary($text)
    {
        $this->_string = str_replace('>', ' summary="' . $text . '">', $this->_string);        
    }
    
    /**
     * Начинает ряд таблицы.
     *
     * @return sting
     */
    public function beginTR($class = '')
    {
        $this->_checkTDinTR();
        if ($class)
            $class = ' class="' . $class . '"';
        $this->_text .= '<tr' . $class . '>';
        $this->openedTR = true;
    }
    
    /**
     * Явное окончание ряда таблицы.
     * Не обязательно приметять - ряд заканчивается автоамтичеки при начале нового или при выводе таблицы.
     *
     * @return sting
     */
    public function endTR()
    {
        $this->_checkTDinTR();
    }

    
    /**
     * Добавление ячейки в ряд таблицы.
     * Ряд должен быть открыт - иначе исключение.
     *
     * @param string $content содержимое ячейки
     * @param string $class класс ячейки, если установлен
     */
    public function addTD($content = '', $class = '')
    {
        if (!$this->openedTR)
            throw new Dune_Exception_Base('Перед добавлением ячейки ряда необходимо ряд открыть.');
        $this->_countTD += 1;
        if ($class)
            $class = ' class="' . $class . '"';
        $this->_text .= '<td' . $class . '>' . $content . '</td>';
    }

    /**
     * Добавление ячейки-заголовка в ряд таблицы.
     * Ряд должен быть открыт - иначе исключение.
     *
     * @param string $content содержимое ячейки
     * @param string $class класс ячейки, если установлен
     */
    public function addTH($content = '', $class = '')
    {
        if (!$this->openedTR)
            throw new Dune_Exception_Base('Перед добавлением ячейки ряда необходимо ряд открыть.');
        $this->_countTD += 1;
        if ($class)
            $class = ' class="' . $class . '"';
        $this->_text .= '<th' . $class . '>' . $content . '</th>';
    }
    
    /**
     * Возвращает весь блок с содержимым и ограничивающими тегами.
     *
     * @return sting
     */
    public function get()
    {
        $this->_checkTDinTR();        
        return $this->_string . $this->_text . '</table>';
    }

    
////////////////////////////////////////////////////////////////
///////////////////////////////     Магические методы
    
   
    public function __toString()
    {
        $this->_checkTDinTR();        
        return $this->_string . $this->_text . '</table>';
    }

    
////////////////////////////////////////////////////////////////
///////////////////////////////     Закрытые методы
    
    /**
     * Проверка соотношений.
     *
     * @access private
     * @return sting
     */
    protected function _checkTDinTR()
    {
        if ($this->openedTR)
        {
            if (($this->_countMaxTD) and ($this->_countMaxTD != $this->_countTD))
            {
                throw new Dune_Exception_Base('Число ячеек в текущем ряде не соответствует определённому ранее.');
            }
            else 
            {
                $this->_countMaxTD = $this->_countTD;
                $this->_countTD = 0;
                $this->_text .= '</tr>';
            }
            $this->openedTR = false;
        }
    }    
}