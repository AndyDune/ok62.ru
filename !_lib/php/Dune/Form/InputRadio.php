<?php
/**
  * Создает поле ввода для атрибутов, которые принимают одно значение из нескольких возможных. 
  * 
 * Все кнопки (radio buttons) в группе должны иметь одинаковые имена, но только выбранная кнопка в группе создает пару name/value, которая будет послана на сервер.
 *  Как и для полей CHECKBOX, атрибут CHECKED необязателен; он может быть использован для определения выделенной кнопки в группе кнопок (radio button).
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: InputRadio.php                              |
 * | В библиотеке: Dune/Form/InputRadio.php            |
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
class Dune_Form_InputRadio extends Dune_Form_Parent_InputSetClassId
{
    /**
     * Строка текстовой области
     *
     * @var string
     * @access private
     */
    protected $_string = '<input type="radio">';


    /**
     * Флаг заполнения обязательных атрибутов формы
     *
     * @access private
     */
    protected $ready = false;
    
    
    /**
     * Конструктор принимает имя поля Radio.
     *
     * @param string $name имя текстовой области
     */
    public function __construct($name)
    {
        $this->_string = str_replace('>', ' name="' . $name . '">', $this->_string);
    }
    
    
    /**
     * Задает текстовый заголовок для поля radio.
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
     * Возвращает строку - текст поля Radio.
     *
     * @return sting
     */
    public function get()
    {
        if (!$this->ready)
            throw new Dune_Exception_Base('Не определен обязательный параметр для поля формы radio');
        return $this->_string;
    }
}