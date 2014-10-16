<?php
/**
 * Поля этого типа не отображаются на экране монитора, что позволяет разместить "секретную" информацию в рамках формы.
 * 
 * Содержание этого поля посылается на сервер в виде name/value вместе с остальной информацией формы.
 * Этот тип может быть использован для передачи информации о взаимодействии клиент/сервер.
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: InputHidden.php                             |
 * | В библиотеке: Dune/Form/InputHidden.php           |
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
class Dune_Form_InputHidden
{
    /**
     * Строка текстовой области
     *
     * @var string
     * @access private
     */
    protected $_string = '<input type="hidden">';


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
     * Возвращает строку - текст поля Radio.
     *
     * @return sting
     */
    public function get()
    {
        if (!$this->ready)
            throw new Dune_Exception_Base('Не определен обязательный параметр value для поля формы hidden');
        return $this->_string;
    }
    
    public function __toString()
    {
        return $this->_string;
    }
    
}