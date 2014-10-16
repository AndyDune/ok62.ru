<?php
/**
 * Dune Framework
 * 
 * Обработка значений полей checkbox, пришедших с формы.
 * Создание массива из требумых обязательных значений.
 * 
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: InputCheckBox.php                           |
 * | В библиотеке: Dune/Form/Handle/InputCheckBox.php  |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 0.90                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * История версий:
 *
 * Версия 0.90 (2008 ноябрь 06)
 * Версия неполнофункциональна, но уже работает в проекте.
 * 
 * 
 */
class Dune_Form_Handle_CheckBox implements Iterator, Countable
{
    protected $_source = array();
    protected $_results = array();
    
    protected $_notAllowEmptyString = true;
    protected $_useTrim = false;
    
    public function __construct($array)
    {
        $this->_source = $array;
    }
    
    /**
     * При анализе значения ключа массива пустую строку считать как:
     * $value = false - не установленное значение
     * $value = true  - установленное значение
     * По умолчанию не установленое.
     * 
     * 
     * @param boolean $value
     */
    public function allowEmptyString($value = false)
    {
        $this->_notAllowEmptyString = !$value;
    }

    /**
     * Использовать функцию trim() перед анализом.
     * По умолчанию - не использовать.
     *
     * @param boolean $value
     */
    public function useTrim($value = false)
    {
        $this->_useTrim = $value;
    }
    
    public function assign($key, $value_if_not_set = 0, $value_if_set = null)
    {
        if (is_array($key))
        {
            
        }
        else 
        {
            if (isset($this->_source[$key]))
            {
                if ($this->_useTrim)
                    $value = trim($this->_source[$key]);
                else 
                    $value = $this->_source[$key];
                    
                if ($value == '' and $this->_notAllowEmptyString)
                    $this->_results[$key] = $value_if_not_set;
                else if (!is_null($value_if_set))
                    $this->_results[$key] = $value_if_set;
                else 
                {
                    $this->_results[$key] = $value;
                }
            }
            else 
            {
                $this->_results[$key] = $value_if_not_set;
            }
        }
    }
    
    public function getResults()
    {
        return $this->_results;
    }
    
    
	/**
	 * Возвращает колличество элементов массива
	 * Реализует интрефейс Countable
	 * 
	 * @return integer
	 */
	public function count()
	{
		return count($this->_array);
	}
    
	
    public function __toString()
    {
    	$string = '<pre>';
    	ob_start();
    	print_r($this->_results);
    	$string .= ob_get_clean();
    	return  '</pre>' . $string;
    }
	
    
    ////////////////////////////////////////////////////////////////
///////////////////////////////     Методы интерфейса Iterator
  // устанавливает итеретор на первый элемент
  public function rewind()
  {
        return reset($this->_results);
  }
  // возвращает текущий элемент
  public function current()
  {
      return current($this->_results);
  }
  // возвращает ключ текущего элемента
  public function key()
  {
    return key($this->_results);
  }
  
  // переходит к следующему элементу
  public function next()
  {
    return next($this->_results);
  }
  // проверяет, существует ли текущий элемент после выполнения мотода rewind или next
  public function valid()
  {
    return isset($this->_results[key($this->_results)]);
  }    
/////////////////////////////
////////////////////////////////////////////////////////////////   
    
    
}