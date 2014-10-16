<?php
/**
 * Коллектор строки SET для сохранения данных в таблице.
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Set.php                                     |
 * | В библиотеке: Dune/Mysqli/Collector/Set.php       |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.01                                      |
 * | Сайт: www.dune.rznw.ru                            |
 * ----------------------------------------------------
 *
 *  Версии:
 * 
 * 1.01 (2009 июнь 17)
 * Обработка данный float
 * 
 */

class Dune_Mysqli_Collector_Set
{

    /**
     * Указатель на объект - соединения с базой данных.
     * 
     * @var string
     * @access private
     */
    protected $_DB = null;
    
    /**
     * Массив для сохранения в базе
     * 
     * @var array
     * @access private
     */
    protected $_arrayToSave = array();
    
    protected $_fieldsArrayAllow   = false;
    protected $_fieldsArrayrequire = false;

    /**
     * Строка SET для запроса
     * 
     * @var string
     * @access private
     */
    protected $_querySetString = '';
    

    /**
     * Формат данных. Целое число.
     */
    const FORMAT_INTEGER = 'i';

    /**
     * Формат данных. Плавающая точка.
     */
    const FORMAT_FLOAT = 'f';
    
    /**
     * Формат данных. Строка.
     */
    const FORMAT_STRING  = 's';
    
    /**
     * Формат данных. Время.
     */
    const FORMAT_TIME    = 't';
    
    /**
     * Формат данных. Строка. Может быть NUL При сохраняемом значении null или false.
     */
    const FORMAT_NULL    = 'n';
    
    /**
     * Конструктор. Принимает объект, производный от Dune_Mysqli_Abstract_Mysqli.
     *
     * @param Dune_Mysqli_Abstract_Mysqli $object
     */
    public function __construct($object)
    {
        $this->_DB = $object;
    }
    
    /**
     * Передача данных для сохранения.
     * Данные $data могут массивом в формате:
     * array(
     *       '<имя поля>' => array(<значение>, <формат>)
     *       )
     * Либо в формате (формат по умолчанию строка):
     * array(
     *       '<имя поля>' => <значение>
     *       )
     *  Формат может быть:
     *  s - строка (по умолчанию) спецсимволы экранируются
     *  i - целое число - привдится к нему (int)
     *  t - время. Если в значении есть установленное целое число (не ноль) - конвертируется в формат YYYY-MM-DD HH:MM:SS и сохраняется.
     *             Если не целое  - сохраняется NOW()
     * 
     * @param mixed $data имя поля таблицы либо массив с данными
     * @param mixed $value   [optional] Значение поля для сохранение
     * @param string $format [optional] Формат данных (i, s, n, t, f)
     */
    public function assign($data, $value = null, $format = 's')
    {
        if (is_array($data))
        {
            foreach ($data as $key => $value)
            {
                if (is_array($value))
                {
                    if (is_array($value[0])) // Сериализуем массив
                        $value[0] = serialize($value[0]);
                    $this->_arrayToSave[$key]['value']  = $value[0];
                    $this->_arrayToSave[$key]['format'] = $value[1];
                }
                else 
                {
                    $this->_arrayToSave[$key]['value']  = $value;
                    $this->_arrayToSave[$key]['format'] = 's';
                }
            }
        }
        else 
        {
            if ($this->_fieldsArrayAllow and in_array($data, $this->_fieldsArrayAllow))
                throw new Dune_Exception_Mysqli('Полученное поле не входит в список разрешенных для изменения');
            if (is_array($value))// Сериализуем массив
               $value = serialize($value);
            $this->_arrayToSave[$data]['value']  = $value;
            $this->_arrayToSave[$data]['format'] = $format;
        }
    }
    
    /**
     * Установка разрешённых полей для сохранения. По умолчанию - без ограничений.
     *
     * @param array $array
     */
    public function setFieldsAllow($array)
    {
        $this->_fieldsArrayAllow = $array;
    }
    
    /**
     * Установка обязательных полей для сохранения. По умолчанию - обязательных нет.
     *
     * @param array $array
     */
    public function setFieldsRequire($array)
    {
        $this->_fieldsArrayrequire = $array;
    }
    
    /**
     * Взять строку SET.
     *
     */
    public function get()
    {
        if ($this->_querySetString)
        {
            $result = $this->_querySetString;
        }
        else 
        {
            if (count($this->_arrayToSave))
            {
                $result = $this->_makeSetString();
            }
            else 
                $result = false;
        }
        return $result;
    }


////////////////////////////////////////////////////////////////////////////////////////
/////////////////       Волшебные методы    
///////////////////////////////////////////////////////////////////////////////////////

    /**
     * Тестовая печать полученной строки.
     */
    public function __toString()
    {
        return '<pre>' . $this->get() . '</pre>';
    }   

    
////////////////////////////////////////////////////////////////////////////////////////
/////////////////       Закрытые методы    
///////////////////////////////////////////////////////////////////////////////////////

    

    /**
     * Создание строки для сохранения в базе.
     * 
     * @access private
     */
    protected function _makeSetString()
    {
        
        // Проверка на наличие обязательных полей в списке сохраняемых
        if ($this->_fieldsArrayrequire)
        {
            foreach ($this->_fieldsArrayrequire as $run)
            {
                if (!key_exists($run, $this->_arrayToSave))
                {
                     throw new Dune_Exception_Base('В массиве для сохранение отcутствует необходимы ключ: ' . $run);
                }
            }
        }
        
       	// Создаём строку SET
       	$set_str = '';
       	$x = 0;
       	foreach ($this->_arrayToSave as $key => $value)
       	{
       	    switch ($value['format'])
       	    {
       	        // Целое число
       	        case 'i':
       	            $value['value'] = (int)$value['value'];
       	        break;
       	        // Целое число
       	        case 'f':
       	            $value['value'] = (float)$value['value'];
       	        break;
       	        
       	        // Время. Если передано значение (целое число, секунды от начала юникс) - перевдит в формат mysql и сохраняет.
       	        // Ноль игнорируется
       	        case 't':
       	            $value['value'] = (int)$value['value'];
       	            if ($value['value'])
       	                $value['value'] = 'FROM_UNIXTIME(' . (int)$value['value'] . ')';
       	            else 
       	                $value['value'] = 'NOW()';
       	        break;
       	        // Строковое, может быть null(или false) - тогда в базу отправляется NULL
       	        case 'n':
       	            if (is_null($value['value']) or $value['value'] === false)
       	                $value['value'] = 'NULL';
       	            else 
       	                $value['value'] = '"' . $this->_DB->real_escape_string($value['value']) . '"';
       	        break;
       	        // Строковое
       	        default:
       	            $value['value'] = '"' . $this->_DB->real_escape_string($value['value']) . '"';
       	    }
       		if ($x == 0)
       			$set_str.= ' SET `'.$key.'` = ' . $value['value'];
       		else
       			$set_str.= ', `'.$key.'` = ' . $value['value'];
       		$x++;
       	}
        return $this->_querySetString =  $set_str;
    }
    
}