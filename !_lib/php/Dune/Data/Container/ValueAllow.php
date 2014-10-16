<?
/**
 * Класс-контейнер вхождения проверяемого значения в список разрешённых.
 * 
 * 
 *	 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: ValueAllow.php                              |
 * | В библиотеке: Dune/Data/Container/ValueAllow.php  |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.01                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 *  
 * История версий:
 * -----------------
 * 
 * 1.01 (2009 январь 29)
 *  Реализована цепочка методов.
 * 
 */

class Dune_Data_Container_ValueAllow
{
    /**
     * Значение по умолчанию.
     * Устанавливается если полученной нет в списке допустимых
     *
     * @var string
     * @access private
     */
    protected $_defaultValue;

    /**
     * Значение переменной.
     * Устанавливается если полученной нет в списке допустимых
     *
     * @var string
     * @access private
     */
    protected $_value;
    
    
    /**
     * Флаг регистрации значения по умолчанию
     * 
     * @var boolean
     * @access private
     */
    protected $_defaultRegistered = false;
    
    
    /**
     * Массив допустимых комманд
     *
     * @var array
     * @access private
     */
    protected $_allowValues = array();  

    
    /**
     * Флаг регистрации допустимых команд
     * 
     * @var boolean
     * @access private
     */
    protected $_allowValueRegistered = false;
    
    protected $_checked = false;
//////////////////////////////////////////////////////////////////////////
///////////         Описание констант
    
    
    /**
     * Конструктор.
     * Принимает начально значение.
     *
     * @param string $value начальное значение
     */
    public function __construct($value)
    {
        $this->_value = $value;
    }

    
    /**
     * Регистрация значения - добавление в массив разрешённых.
     *
     * @param mixed $value
     */
    public function register($value)
    {
        $this->_allowValueRegistered = true;
        if (is_array($value))
        {
            foreach ($value as $run)
            {
                $this->_allowValues[] = $run;
            }
        }
        else 
        {
            $this->_allowValues[] = $value;
        }
        return $this;
    }

    /**
     * Регистрация значения по умолчанию.
     * Необходимо при отсутствии переданного значения в массиве допустимых.
     *
     * @param mixed $value
     */
    public function registerDefault($value)
    {
        $this->_defaultRegistered = true;        
        $this->_defaultValue = $value;
        return $this;
    }

    
    /**
     * Проверяет значение на допустимость.
     * Должен вызываться только после методов:
     *      registerDefault($folder)
     *      register($folder)
     *      иначе прерывание.
     *
     * @return boolean флаг допустимости переданого значения - при 1-м вызове, иначе false
     */
    public function check()
    {
        if ($this->_checked)
            return false;
        $this->_checked = true;
        if (!$this->_defaultRegistered or !$this->_allowValueRegistered)
            throw new Dune_Exception_Base('Не зарегистированы значение по умолчанию и список допустимых значений.');
        $bool = true;
        $key = array_search($this->_value, $this->_allowValues);
        
        if ($key === false)
        {
            $this->_value = $this->_defaultValue;
            $bool = false;
        }
        return $bool;
    }
    
    /**
     * Возвращает значение.
     *
     * @return string
     */
    public function getValue()
    {
        $this->check();
        return $this->_value;
    }

}