<?php
/**
 * Dune Framework
 * 
 * Абстрактный класс.
 * 
 * ------------------------------------------------------------
 * | Библиотека: Dune                                          |
 * | Файл: ArrayAllow.php                                      |
 * | В библиотеке: Dune_Data_Collector_Abstract_ArrayAllow.php |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>                 |
 * | Версия: 0.99                                              |
 * | Сайт: www.rznw.ru                                         |
 * ------------------------------------------------------------
 *
 * История версий:
 * Версия 0.99 (2009 январь 13)
 *  Есть опциональная возможность устанавливать массив значениями по умолчанию.
 *  При отсутствии значения по умолчанию в массиве $allowFields устанавливается в null.
 * 
 * Версия 0.98 (2008 декабрь 27) Нет хороших комменетариев.
 * 
 * 
 */
abstract class Dune_Data_Collector_Abstract_ArrayAllow extends Dune_Array_Abstract_Interface
{
    
    /**
     * Массив разрешённых полей для использования и форматы.
     *
     * Формат:
     * <имя поля> => array(<ключ>, <длина>, <по умолчанию, может отсутствовать>)
     * <имя поля> => array(<ключ>, <длина>, <по умолчанию, может отсутствовать>)
     * ...
     * 
     * Расшифровка:
     * <ключ> : 'i' - целое число
     *          's' - строка
     *          'f' - число с плавающей точкой
     * <длина> : для строки - число стмволов, для числа - масимальное значение
     * 
     * @var array
     * @access private
     */
    protected $allowFields = array();
    
    /**
     * Ключ генерации прерывания при приеме незарегистрированного ключа.
     *
     * @var boolean
     */
    public static $useExeption = false;
    
   
    final public function __set($name, $value)
    {
        if (key_exists($name, $this->allowFields))
        {
            if ($this->allowFields[$name][0] == 'i')
            {
                $value = (int)str_replace(' ', '', $value);
                if ($value > $this->allowFields[$name][1])
                    $value = $this->allowFields[$name][1];
            }
            else if ($this->allowFields[$name][0] == 'f')
            {
                $value = (float)str_replace(array(' ',','), array('','.'), $value);
                if ($value > $this->allowFields[$name][1])
                    $value = $this->allowFields[$name][1];
            }
            
            else 
            {
                $value =  substr($value, 0, $this->allowFields[$name][1]);
            }
            $this->_array[$name] = $value;
        }
        else 
        {
            if (self::$useExeption)
                throw new Dune_Exception_Base('Установка несуществующего ключа в масссив данных объекта');
        }
    }
    
    /**
     * Пакетная загрузка массива для сохранения.
     *
     * @param array $array может быть объектом c интерфесами ArrayAccess и Countable
     */
    final public function loadData($array)
    {
        if (count($array))
        {
            foreach ($array as $key => $value)
            {
                $this->__set($key, $value);
            }
        }
    }
    
   
    /**
     * Возврат всего собранного массива.
     *
     * @param array $array может быть объектом c интерфесами ArrayAccess и Countable
     */
    final public function getData($is_container = false, $with_default = false)
    { 
        if ($with_default)
        {
            $this->_checkDeafult();
        }
        if ($is_container)
            return new Dune_Array_Container($this->_array);
        return $this->_array;
    }

    final public function setDefault()
    {
        $this->_checkDeafult();
    }
    
    
    final protected function _checkDeafult()
    {
        foreach ($this->allowFields as $key => $value)
        {
            if (isset($value[2]))
            {
                if (empty($this->_array[$key]))
                {
                    $this->_array[$key] = $value[2];
                }
            }
            else 
            {
                if (empty($this->_array[$key]))
                {
                    $this->_array[$key] = null;
                }
                
            }
        }
    }
    
    
}