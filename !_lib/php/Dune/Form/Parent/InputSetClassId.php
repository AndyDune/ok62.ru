<?php
/**
 * Родительский класс
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                    |
 * | Файл: InputsetClassId.php                           |
 * | В библиотеке: Dune/Form/Parent/InputsetClassId.php  |
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
abstract class Dune_Form_Parent_InputSetClassId
{
    /**
     * Строка текстовой области
     *
     * @var string
     * @access private
     */
    protected $_string = '<input>';

    
    /**
     * Определяет класс поля
     *
     * @param string $class
     */
    public function setClass($class)
    {
        $this->_string = str_replace('>', ' class="' . $class . '">', $this->_string);
    }

    /**
     * Определяет ID для поля
     *
     * @param string $id
     */
    public function setId($id)
    {
        $this->_string = str_replace('>', ' id="' . $id . '">', $this->_string);
    }
    
    /**
     * Возвращает строку - текст поля.
     *
     * @return sting
     */
    public function get()
    {
        return $this->_string;
    }
    /**
     * Возвращает строку - текст поля.
     *
     * @return sting
     */
    public function __toString()
    {
        return $this->_string;
    }
    
}