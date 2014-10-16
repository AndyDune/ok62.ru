<?php
/**
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Form.php                                    |
 * | В библиотеке: Dune/Form/Form.php                  |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>        |
 * | Версия: 1.01                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * История версий:
 *
 * Версия 1.00 -> 1.01
 * Константа ENCTYPE_MULTI
 * Не вызывает прерываний.
 * 
 * 
 */
class Dune_Form_Form
{
    /**
     * Строка формы
     *
     * @var string
     * @access private
     */
    protected $formString = '<form>';
    
    /**
     * Флаг заполнения обязательных атрибутов формы
     *
     * @access private
     */
    protected $ready = false;
    
    const TARGET_SELF = '_self';
    const TARGET_PARENT = '_parent';
    const TARGET_TOP = '_top';
    const TARGET_BLANK = '_blank';
    
    const METHOD_GET = 'get';
    const METHOD_POST = 'post';
    
    const ENCTYPE_DEFAULT = 'application/x-www-form-urlencoded';
    const ENCTYPE_MULTI = 'multipart/form-data';

    /**
     * Конструктор принимает имя формы.
     * Что имеет значение если форм несколько.
     * Здесь может не указываться.
     *
     * @param string $name имя формы, может не указываться, тогда не учитывается
     */
    public function __construct($name = '')
    {
        if ($name)
            $this->formString = str_replace('>', ' name="' . $name . '">', $this->formString);
    }
    
    /**
     * Определяет способ отправки содержимого формы.
     * Рекомендую указывать только предопределённые константы класса
     *
     * @param string $method
     */
    public function setMethod($method = self::METHOD_POST)
    {
        $this->formString = str_replace('>', ' method="' . $method . '">', $this->formString);
    }
    
    /**
     * Обязательный параметр. Определяет URL, по которому будет отправлено содержимое формы.
     *
     * @param string $method
     */
    public function setAction($action)
    {
        $this->ready = true;
        $this->formString = str_replace('>', ' action="' . $action . '">', $this->formString);
    }
    
    /**
     * Определяет имя окна, в которое возвращается результат обработки отправленной формы.
     * Рекомендую указывать только предопределённые константы класса
     *
     * @param string $method
     */
    public function setTarget($target = self::TARGET_SELF)
    {
        $this->formString = str_replace('>', ' target="' . $target . '">', $this->formString);
    }
    
    /**
     * Определяет способ кодирования содержимого формы при отправке.
     * Рекомендую указывать только предопределённые константы класса
     *
     * @param string $method
     */
    public function setEnctype($enctype = self::ENCTYPE_DEFAULT)
    {
        $this->formString = str_replace('>', ' enctype="' . $enctype . '">', $this->formString);
    }
    
    
    
    /**
     * Определяет ID для формы
     *
     * @param string $id
     */
    public function setId($id)
    {
        $this->formString = str_replace('>', ' id="' . $id . '">', $this->formString);
    }
    
    /**
     * Возвращает строку - начало формы.
     *
     * @return sting
     */
    public function get()
    {
//        if (!$this->ready)
//            throw new Dune_Exception_Base('Не определен обязательный параметр формы');
        return $this->formString;
    }
    
    /**
     * Аналог функции get()
     *
     * @return sting
     */
    public function getBegin()
    {
//        if (!$this->ready)
//            throw new Dune_Exception_Base('Не определен обязательный параметр формы');
        return $this->formString;
    }
            
    /**
     * Возвращает </form>
     *
     * @return sting
     */
    public function getEnd()
    {
        return '</form>';
    }
    
}