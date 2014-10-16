<?php
/**
 * Cоздает кнопку, при нажатии которой заполненная форма посылается на сервер
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: InputSubmit.php                             |
 * | В библиотеке: Dune/Form/InputSubmit.php           |
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
class Dune_Form_InputSubmit extends Dune_Form_Parent_InputSetClassId
{
    /**
     * Строка текстовой области
     *
     * @var string
     * @access private
     */
    protected $_string = '<input type="submit">';

    
    /**
     * Конструктор принимает имя кнопки.
     * Что имеет значение если кнопка отсылает пару имя-значение
     * Здесь может не указываться.
     *
     * @param string $name имя кнопки
     */
    public function __construct($name = '')
    {
        if ($name)
        {
            $this->_string = str_replace('>', ' name="' . $name . '">', $this->_string);
        }
    }
    
    
    /**
     * Задает значение, отсылаемое кнопкой (отображаемое на ней в фомме).
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