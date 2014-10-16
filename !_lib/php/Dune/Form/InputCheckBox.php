<?php
/**
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: InputCheckBox.php                           |
 * | В библиотеке: Dune/Form/InputCheckBox.php         |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.00                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * История версий:
 *
 * Версия 1.00 -> 1.01
 * 
 * 
 */
class Dune_Form_InputCheckBox extends Dune_Form_Parent_InputSetClassId
{
    /**
     * Строка текстовой области
     *
     * @var string
     * @access private
     */
    protected $_string = '<input type="checkbox">';


    /**
     * Флаг заполнения обязательных атрибутов формы
     *
     * @access private
     */
    protected $ready = false;
    
    
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
     * Задает текстовый заголовок для поля.
     * Двойные кавычки заменяются на html представление.
     *
     * @param string $value
     */
    public function setValue($value = '')
    {
        $this->ready = true;
        $value = str_replace('"' , '&quot;', $value);
        $this->_string = str_replace('>', ' value="' . $value . '">', $this->_string);
    }

    /**
     * Определяет необязательный атрибут CHECKED, который указывает на то, что поле активизировано
     *
     */
    public function setChecked()
    {
        $this->_string = str_replace('>', ' checked="checked">', $this->_string);
    }
    
    
    /**
     * Возвращает строку - текст текстовой области.
     *
     * @return sting
     */
    public function get()
    {
        if (!$this->ready)
            throw new Dune_Exception_Base('Не определен обязательный параметр для поля формы checkbox');
        return $this->_string;
    }
}