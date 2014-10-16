<?php
/**
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: TextArea.php                                |
 * | В библиотеке: Dune/Form/TextArea.php              |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>        |
 * | Версия: 1.00                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * История версий:
 *
 * Версия 1.00 -> 1.01
 * 
 * 
 */
class Dune_Form_TextArea extends Dune_Form_Parent_InputSetClassId
{
    /**
     * Строка текстовой области
     *
     * @var string
     * @access private
     */
    protected $_string = '<textarea>';

    /**
     * Строка содержимого текстовой области
     *
     * @var string
     * @access private
     */
    protected $_value = '';
    
    /**
     * Флаг заполнения обязательных атрибутов формы
     *
     * @access private
     */
    protected $ready = false;

    const WRAP_OFF = 'off';
    const WRAP_VIRTUAL = 'virtual';
    const WRAP_PHYSICAL = 'physical';

    /**
     * Конструктор принимает имя текстовой области.
     *
     * @param string $name имя текстовой области
     */
    public function __construct($name)
    {
        $this->_string = str_replace('>', ' name="' . $name . '">', $this->_string);
    }
    
    /**
     * Определяет способ переноса слов в заполняемой данной заполняемой форме.
     * Рекомендую указывать только предопределённые константы класса
     *
     * @param string $wrap
     */
    public function setWrap($wrap = self::WRAP_VIRTUAL)
    {
        $this->_string = str_replace('>', ' wrap="' . $wrap . '">', $this->_string);
    }

    /**
     * Определяет количество строк текста, видимых на экране.
     *
     * @param integer $rows
     */
    public function setRows($rows)
    {
        $this->_string = str_replace('>', ' rows="' . $rows . '">', $this->_string);
    }
    
    /**
     * Определяет количество строк текста, видимых на экране.
     *
     * @param integer $cols
     */
    public function setCols($cols)
    {
        $this->_string = str_replace('>', ' cols="' . $cols . '">', $this->_string);
    }

    
    /**
     * Определяет содержимое текстовой области.
     * Заменяет символы < и > представлением их html.
     *
     * @param string $value
     */
    public function setValue($value = '')
    {
        $this->_value = str_replace(array('>','<'), array('&gt;','&lt;'), $value);
    }

    
    /**
     * Возвращает строку - текст текстовой области.
     *
     * @return sting
     */
    public function get()
    {
        return $this->_string . $this->_value . '</textarea>';
    }
}