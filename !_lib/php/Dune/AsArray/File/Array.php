<?php

/**
 *  !!!! Вообще не сдалан - функционал дублирует на Dune_AsArray_File_Array
 * 
 * Работа с файлами в папке как с ячейками массива.
 * Файлы - сериализованные массивы.
 * 
 * Синглетон. Новый объект для каждой папки.
 * Реализует интерфейс Dune_Interface_BeforePageOut.
 * 
 * Dune Framework
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Array.php                                   |
 * | В библиотеке: Dune/AsArray/File/Array.php         |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 0.91                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * История версий:
 * 
 * Версия 0.91 (2009 апрель 24)
 * -------------------
 * Строковые функции в обертку.
 * 
 * Версия 0.90 (2009 январь 22)
 * -------------------
 * Начальная версия. Прошло ограниченное тестирование.
 * Итератор не реализован.
 * 
 */

class Dune_AsArray_File_Array implements Iterator, ArrayAccess, Dune_Interface_BeforePageOut
{
    protected $_data    = array();
    protected $_isWrite = array();
    protected $_isFile = array();
    
    protected $_path = '';
    protected $_tempFolder = '/tmp';
    
    protected $_doneBeforePageOut = false;
    
    protected $_iteratorCurrentPointer = 0;
    protected $_iteratorCurrentKey = null;
    
    static private $instance = array();
    
    /**
     * Вызов объекта.
     * Версия объекта определяется парметром $path
     *
     * @param string $path путь к папке с файлами. От корня сайта.
     * @return Dune_AsArray_File_Array
     */
    static function getInstance($path)
    {
        if (!key_exists($path,self::$instance))
        {
            self::$instance[$path] = new Dune_AsArray_File_Array($path);
        }
        return self::$instance[$path];
    }
    
    /**
     * Сохранение измененных данных в файла.
     *
     * @return boolean Возвращает false если не удалось создать временную папку.
     */
    public function commit()
    {
        if (!count($this->_isWrite))
            return true;
        $temp = $this->_path . $this->_tempFolder;
        if (!is_dir($temp))
        {
            if (!mkdir($temp))
                return false;
        }
        foreach ($this->_isWrite as $key => $value)
        {                 
            $file_name_full_info = $this->_path . '/' . $key;            
            if (empty($this->_data[$key]))
            {
                if ($this->_isFile[$key])
                    unlink($file_name_full_info);
                continue;
            }
            $data = (string)$this->_data[$key];
            $data_o = Dune_String_Factory::getStringContainer($data);
            if ($data_o->len() < 1)
                continue;
            $file = uniqid('tmp', true) . '.txt';
            $file_name_full_temp = $temp . '/' . $file;
            file_put_contents($file_name_full_temp, $data);
            if (is_file($file_name_full_info))
                unlink($file_name_full_info);
            rename($file_name_full_temp, $file_name_full_info);
            unset($this->_isWrite[$key]);
        }
        return true;
    }
    
    
    
    /**
     * Реализация метода интерфейса Dune_Interface_BeforePageOut.
     * 
     * Действие после работы скрипта, перед выводом страницы.
     *
     */
    public function doBeforePageOut()
    {
        // Если массив есть и выполнение происходит 1-й раз
        if (!$this->_doneBeforePageOut)
        {
            $this->commit();
            $this->_doneBeforePageOut = true;
        }
    }
    
    /**
     * Конструктр. Закрыт, вызов тлько из статичной переменной
     *
     * @param string $path
     */
    protected function __construct($path)
    {
        $path = trim($path, '/ ');
        $this->_path = $_SERVER['DOCUMENT_ROOT'] . '/' . $path;
        if (!is_dir($this->_path))
            throw new Dune_Exception_Base('Нет нужной папки: ' . $this->_path);
    }
    
    
    /**
     * Возврат данных файла или из сохраненой переменной.
     *
     * @param string $name
     * @return mixed Значения: null - нет данных, false - ошибка чтения данных.
     * @access private
     */
    protected function _getData($name)
    {
        $result = $this->_checkData($name);
        if (!is_null($result))
        {
            return $result;
        }
        $this->_getFileContent($name);
        return $this->_checkData($name);
    }
    
    protected function _checkData($name)
    {
        $result = null;
        if (isset($this->_data[$name]))
        {
            $result = $this->_data[$name];
        }
        else if (isset($this->_isFile[$name]))
        {
            $result = false;
        }
        return $result;
    }

    protected function _setData($name, $value)
    {
        $this->_data[$name] = $value;
        $this->_isWrite[$name] = true;
    }
    
    
    protected function _getFileContent($name)
    {
        $result = null;
        $file = $this->_path . '/' . $name;
        if (is_file($file))
        {
            $this->_data[$name] = file_get_contents($file);
            $this->_isFile[$name] = true;
            $result = $this->_data[$name];
        }
        else 
        {
            $this->_isFile[$name] = false;
        }
        return $result;
    }
    
    
      ////////////////////////////////////////////////////////////////
///////////////////////////////     Методы интерфейса ArrayAccess
    /**
     * @param mixed $key
     * @return mixed
     * @access private
     */
    public function offsetExists($key)
    {
        $data = $this->_getData($key);
        if (is_null($data) or $data === false)
        {
            return false;
        }
        return true;
    }
    public function offsetGet($key)
    {
        return $this->_getData($key);
    }
    
    public function offsetSet($key, $value)
    {
        return $this->_setData($key, $value);
    }
    public function offsetUnset($key)
    {
        unset($this->_data[$key]);
    }    
    ////////////////////////////////////////////////////////////////
///////////////////////////////     Методы интерфейса Iterator
  // устанавливает итеретор на первый элемент
  public function rewind()
  {
        return $this->_iteratorCurrentPointer = 0;
  }
  // возвращает текущий элемент
  public function current()
  {
      return 1;
  }
  // возвращает ключ текущего элемента
  public function key()
  {
    return $this->_iteratorCurrentKey;
  }
  
  // переходит к следующему элементу
  public function next()
  {
    return $this->_iteratorCurrentPointer++;
  }
  // проверяет, существует ли текущий элемент после выполнения мотода rewind или next
  public function valid()
  {
    return 1;
  }    
/////////////////////////////
////////////////////////////////////////////////////////////////   
    
    
}