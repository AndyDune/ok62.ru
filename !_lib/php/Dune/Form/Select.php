<?php
/**
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Select.php                                  |
 * | В библиотеке: Dune/Form/Select.php                |
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
class Dune_Form_Select extends Dune_Form_Parent_InputSetClassId
{
    /**
     * Строка начального тега select
     *
     * @var string
     * @access private
     */
    protected $_string = '<select>';
    
    /**
     * Строка содержимого select
     *
     * @var string
     * @access private
     */
    protected $_stringOption = '';


    /**
     * Индикатор начало группы
     *
     * @var boolean
     * @access private
     */
    protected $_optGroupOpened = false;
    
    
    /**
     * Конструктор принимает имя вцыпадающего списка.
     *
     * @param string $name имя текстовой области
     */
    public function __construct($name)
    {
        $this->_string = str_replace('>', ' name="' . $name . '">', $this->_string);
    }
    

    /**
     * Определяет размер поля в символах.
     *
     * @param integer $size
     */
    public function setSize($size)
    {
        $this->_string = str_replace('>', ' size="' . $size . '">', $this->_string);
    }


    /**
     * Открытие группы.
     * В явном закритии нет необходимости: при открятии новой нруппы и при выводе происходит авто-закрытие
     *
     * @param string $label название группы
     */
    public function beginOptGroup($label)
    {
        $this->_closeOptGroup();
        $this->_stringOption .= '<optgroup label="' . $label . '">';
        $this->_optGroupOpened = true;
    }

    /**
     * Установка класс для последней введённой группы.
     *
     * @param string $label название группы
     */
    public function setClassOptGroup($class)
    {
        if ($this->_optGroupOpened)
        {
            $pos = strrpos($this->_stringOption, 'label');
            $this->_stringOption = substr($this->_stringOption, 0, $pos) . 'class="' . $class . '" ' .
                                   substr($this->_stringOption, $pos);
        }
    }
    
    
    /**
     * Явное закрятие группы
     */
    public function endOptGroup()
    {
        $this->_closeOptGroup();
        $this->_optGroupOpened = false;
    }
    
    public function setOption($value, $text, $selected = false)
    {
        if ($selected)
            $sel = ' selected="selected"';
        else 
            $sel = '';
        $this->_stringOption .= '<option value="' . $value . '"' . $sel . '>'
                                                  . $text . '</option>';
    }
    
    /**
     * Возвращает строку - весь собраный текст .
     *
     * @return sting
     */
    public function get()
    {
        $this->_closeOptGroup();
        return $this->_string . $this->_stringOption . '</select>';
    }
    /**
     * Возвращает строку - текст поля.
     *
     * @return sting
     */
    public function __toString()
    {
        return $this->get();
    }
    
    /**
     * Неявное закрятие группы
     *
     * @access private
     */
    protected function _closeOptGroup()
    {
        if ($this->_optGroupOpened)
            $this->_stringOption .= '</optgroup>';
    }
    
}