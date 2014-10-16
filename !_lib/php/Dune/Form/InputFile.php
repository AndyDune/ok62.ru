<?php
/**
 * 
 * Дает возможность пользователю приобщить файл к текущей форме.
 * 
 * Возможно использование совместно с параметром ACCEPT.
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: InputFile.php                               |
 * | В библиотеке: Dune/Form/InputFile.php             |
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
class Dune_Form_InputFile extends Dune_Form_Parent_InputSetClassId
{
    /**
     * Строка текстовой области
     *
     * @var string
     * @access private
     */
    protected $_string = '<input type="file">';

    /**
     * Строка содержимого текстовой области
     *
     * @var string
     * @access private
     */
    protected $_value = '';

    const MINE_JPEG = 'image/jpeg';
    const MINE_GIF = 'image/gif';
    const MINE_PNG = 'image/png';
    const MINE_TXT = 'text/plain';
    
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
     * Конкретизирует тип файла.
     * Рекомендую указывать только предопределённые константы класса
     *
     * @param string $accept
     */
    public function setAccept($accept = self::MINE_JPEG)
    {
        $this->_string = str_replace('>', ' accept="' . $accept . '">', $this->_string);
    }

}