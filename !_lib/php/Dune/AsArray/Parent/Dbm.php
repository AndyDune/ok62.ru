<?php
/**
 * Класс для работы с DBM как с массивом - подключение прячется
 * Родительский для ряда классов. Абстрактный
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Dbm.php                                     |
 * | В библиотеке: Dune/AsArray/Parent/Dbm.php         |
 * | Автор: Андрей Рыжов (Dune) <dune@pochta.ru>       |
 * | Версия: 1.04                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * 
 * История версий:
 * 
 * Версия 1.03 -> 1.04
 * Все исключения переведены на класс Dune_Exception_Base
 * 
 * Версия 1.02 -> 1.03
 * Изменены параметры для наследования.
 * Введена возможность переключения режимов работы 'r' > 'w' автоматически
 * Введена функция close() - принудительного закрытия соединения. Осуществляется контроль за функциями после закрытия.
 * 
 * Версия 1.01 -> 1.02
 * Добавлен контроль при записи. В режиме работы с dbm "r" генерится исключение.
 * 
 * Версия 1.00 -> 1.01
 * Изменена последовательность передачи параметров в конструктор
 * 
 */

abstract class Dune_AsArray_Parent_Dbm implements Iterator,ArrayAccess
{
    protected $__maxRandOtimize = 100;

    protected $__switchReadModeToWrite = true; // Возможность переключения режима 'r' > 'w' автоматически
                                               // Если отключено - ген. исключение
    protected $__DBA;
    protected $__DBA_path;
    protected $__DBA_mode;
    protected $__DBA_handler;
    protected $__defaultValue = '';
    protected $__getLastRecord = true;
    protected $__currentKey;
    protected $__currentValue = false;

    
    protected function connectDBA()
    {
        $this->__DBA = @dba_open($this->__DBA_path,$this->__DBA_mode,$this->__DBA_handler);
        if (!$this->__DBA)
            $this->__DBA = @dba_open($this->__DBA_path,'n',$this->__DBA_handler);
        if (!$this->__DBA)
            throw new Dune_Exception_Base('Не удалось открыть файл DBM. Указанный путь: <strong>'.$this->__DBA_path.'</strong>');
        
    }  
    protected function checkDBA()
    {
        if (!$this->__DBA)
        {
            throw new Dune_Exception_Base('Соединение с базой данных DBM было принудительно закрыто. Работа невозможна.');
        }
        
    }
    
    
/**
 * Конструктор - открывает файт dbm
 *
 * @param unknown_type $path путь к файлу
 * @param unknown_type $handler тип базы данных, по умолчанию flatfile
 * @param unknown_type $mode режим открытия файла, по умолчанию w
 */
    protected function __construct($path,$mode = 'r',$handler = 'flatfile')
    {
        $this->__DBA_path = $path;
        $this->__DBA_mode = $mode;
        $this->__DBA_handler = $handler;
        $this->connectDBA();
        
        if (rand(1,$this->__maxRandOtimize) == 1)
            $this->optimize();
    }
    
    
    public function __destruct()
    {
        if ($this->__DBA)
            dba_close($this->__DBA);
    }
    
   /**
    * Установка значения, выдаваемого приотсутствии ключа в базе
    *
    * @param mixed $value
    */
    public function setDefaultValue($value = '')
    {
        $this->__defaultValue = $value;
    }
    
    /**
     * Закрыть соединение с базой.
     *
     */
    public function close()
    {
        $this->checkDBA();
        dba_close($this->__DBA);
        $this->__DBA = null;
    }
    
    
/**
 * Метод оптимизации файла (очистка от удалённых записей)
 * 
 * Проверка на более совершенный движок
 * Если движок старый - оптимизируем файл "врукопашную"
 * 
 * Создаётся точная копия текущего файла без удалённых записей с уникальным именем.
 * Затем старый файл удаляется
 * Временный файл переименовывается - получает имя оптимизируемой таблицы
 * 
 * Если идёт работа с файлами db3,bd4 - оптимизируем стандартной функцией
 * 
 */
    public function optimize()
    {
        if (($this->__DBA_handler != 'db3') AND ($this->__DBA_handler != 'db4'))
        {
            $temp_name = dirname($this->__DBA_path).'/'.uniqid().'.dbt';
            $temp_dba = dba_open($temp_name,'c',$this->__DBA_handler);
            if (!$temp_dba)
                throw new Dune_Exception_Base('Не удалось создать временный файл при оптимизации DBM. Указанный путь:<strong>'.$temp_name).'</strong>';
            
            $key = dba_firstkey($this->__DBA);
            while ($key)
            {
                dba_insert($key,dba_fetch($key,$this->__DBA),$temp_dba);
                $key = dba_nextkey($this->__DBA);
            }
            dba_close($this->__DBA);
            dba_close($temp_dba);
            if (unlink($this->__DBA_path))
                rename($temp_name,$this->__DBA_path);
            else 
                throw new Dune_Exception_Base('Не удалось удалить файл dbm для замены оптимизированным. Указанный путь:<strong>'.$temp_name).'</strong>';
            $this->connectDBA();
        }
        else 
            dba_optimize($this->__DBA);
    }
    
    
////////////////////////////////////////////////////////////////
///////////////////////////////     Магические методы
/**
 * Enter description here...
 *
 * @access private
 * @param unknown_type $name
 * @param unknown_type $value
 * @return unknown
 */
    public function __set($name, $value)
    {
        $this->checkDBA();
        if ($this->__DBA_mode == 'r')
        {
            if ($this->__switchReadModeToWrite)
            {
                $this->__DBA_mode = 'w';
                $this->close();
                $this->connectDBA();
            }
            else 
                throw new Dune_Exception_Base('Попытка записи в базу данных dbm, открытой только для чтения.');
        }
        return dba_replace($key,$value,$this->__DBA);
    }
    /**
     * Enter description here...
     *
     * @access private
     * @param unknown_type $name
     * @return unknown
     */
    public function __get($name)
    {
        $this->checkDBA();
        if (dba_exists($name,$this->__DBA))
        {
            return dba_fetch($name, $this->__DBA);            
        }
        else 
            return $this->__defaultValue;
    }
/////////////////////////////
////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////
///////////////////////////////     Методы интерфейса Iterator
  // устанавливает итеретор на первый элемент
  public function rewind()
  {
    $this->checkDBA();
    return $this->__currentKey = dba_firstkey($this->__DBA);
  }
  // возвращает текущий элемент
  public function current()
  {
      $this->checkDBA();
      return dba_fetch($this->__currentKey, $this->__DBA);;
  }
  // возвращает ключ текущего элемента
  public function key()
  {
      $this->checkDBA();
      return key($this->__currentKey);
  }
  // переходит к следующему элементу
  public function next()
  {
      $this->checkDBA();
      return $this->__currentKey = dba_nextkey($this->__DBA);
  }
  // проверяет, существует ли текущий элемент после выполнения мотода rewind или next
  public function valid()
  {
      return $this->__currentKey;  
  }    
/////////////////////////////
////////////////////////////////////////////////////////////////    



////////////////////////////////////////////////////////////////
///////////////////////////////     Методы интерфейса ArrayAccess
    /**
     * @param mixed $key
     * @return mixed
     * @access private
     */
    public function offsetExists($key)
    {
        $this->checkDBA();
        return dba_exists($key,$this->__DBA);
    }
    public function offsetGet($key)
    {
        $this->checkDBA();
        if (dba_exists($key,$this->__DBA))
        {
            return dba_fetch($key, $this->__DBA);
        }
        else 
            return $this->__defaultValue;
    }
    
    public function offsetSet($key, $value)
    {
        $this->checkDBA();
        if ($this->__DBA_mode == 'r')
        {
            if ($this->__switchReadModeToWrite)
            {
                $this->__DBA_mode = 'w';
                $this->close();
                $this->connectDBA();
            }
            else 
                throw new Dune_Exception_Base('Попытка записи в базу данных dbm, открытой только для чтения.');
        }
        return dba_replace($key,$value,$this->__DBA);
    }
    public function offsetUnset($key)
    {
        $this->checkDBA();
        if ($this->__DBA_mode == 'r')
        {
            if ($this->__switchReadModeToWrite)
            {
                $this->__DBA_mode = 'w';
                $this->close();
                $this->connectDBA();
            }
            else 
                throw new Dune_Exception_Base('Попытка записи в базу данных dbm, открытой только для чтения.');
        }
        return dba_delete($key,$this->__DBA);
    }

/////////////////////////////
////////////////////////////////////////////////////////////////
}