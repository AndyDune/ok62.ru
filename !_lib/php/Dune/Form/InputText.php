<?php
/**
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: InputText.php                               |
 * | В библиотеке: Dune/Form/InputText.php             |
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
class Dune_Form_InputText extends Dune_Form_Parent_InputSetClassId
{
    /**
     * Строка текстовой области
     *
     * @var string
     * @access private
     */
    protected $_string = '<input type="text">';

    /**
     * Строка содержимого текстовой области
     *
     * @var string
     * @access private
     */
    protected $_value = '';

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
     * Определяет размер поля в символах.
     *
     * @param integer $size
     */
    public function setSize($size)
    {
        $this->_string = str_replace('>', ' size="' . $size . '">', $this->_string);
    }
    
    /**
     * Определяет максимальное количество символов, которые можно ввести в текстовом поле.
     * Оно может быть больше, чем количество символов, указанных в параметре SIZE, в этом случае поле будет прокручиваться (scroll).
     * По умолчанию количество символов не ограничено.
     *
     * @param integer $maxlength
     */
    public function setMaxLength($maxlength)
    {
        $this->_string = str_replace('>', ' maxlength="' . $maxlength . '">', $this->_string);
    }

    
    /**
     * Задает текстовый заголовок для поля.
     * Двойные кавычки заменяются на html представление.
     *
     * @param string $value
     */
    public function setValue($value = '')
    {
        $value = str_replace('"' , '&quot;', $value);
        $this->_string = str_replace('>', ' value="' . $value . '">', $this->_string);
    }
}