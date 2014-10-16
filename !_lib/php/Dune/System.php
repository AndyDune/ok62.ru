<?php
/**
 * Класс содержащий в себе системные переменные
 * Поное имя файла передаётся конструктору
 * Файл системных настроек есть ini-файл
 * Красс реализует Singletone - создаётся только раз и созданием передеётся модулям, др. объектам
 * 
 * Доступ к параметрам осуществляется интерфейсами Iteratir и ArrayAccess
 * Доступ к несуществующим переменным приводит к исключению Exception
 * 
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: System.php                                  |
 * | В библиотеке: Dune/System.php                     |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>        |
 * | Версия: 1.02                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------

 * Объект создаётся вызовом функции Dune_System::getInstance()
 * 
 * При повторном вызове функции возвращается указатель на уже созданный объект.
 * 
 * 
 * История версий:
 * -----------------
 * Версия 1.01 -> 1.02
 * Метод getInstance() больше не принимает параметра. Путь к файлу берётся из класса Dune_Parameters
 * 
 * История версий:
 * -----------------
 * Версия 1.00 -> 1.01
 * Исправлена ошибка при проверке существования ключа в массиве $arrayINI. Метод: offsetExists($key)
 *
 */
class Dune_System implements ArrayAccess,Iterator
{
    private $arrayINI = array();
    private $__currentKey;
    
   /**
    * Иниц. при первом вызове стат. метода и возвращается при последующих
    *
    * @var указатель на объект
    */
  static private $instance = NULL;

  /**
   * Создаёт реализацию класса при первом вызове
   * Возвращает сохранённый указатель объекта при последующих вызовах
   *
   * @param string $fileName
   * @return указатель на объект
   */
  static function getInstance()
  {
    if (self::$instance == NULL)
    {
      self::$instance = new Dune_System(Dune_Parameters::$configFilePath);
    }
    return self::$instance;
  }
  
  // Конструктор приватный - зызов извне невозможен
  private function __construct($fileName)
  {
      if (is_file($fileName))
      {
          $this->arrayINI = parse_ini_file($fileName);
      }
      else 
        throw new Exception('Файл настроек по указанному пути не существует: '.$fileName);
  }
  
////////////////////////////////////////////////////////////////
///////////////////////////////     Методы интерфейса ArrayAccess
    public function offsetExists($key)
    {
        return key_exists($key,$this->arrayINI);
    }
    public function offsetGet($key)
    {
        if (!key_exists($key,$this->arrayINI))
            //throw new Exception('Ошибка чтения системной переменной: ключа '.$key.' не существует');
            return false;
        return $this->arrayINI[$key];
    }
    
    public function offsetSet($key, $value)
    {
        throw new Exception('Зарещено менять значение системных переменных');
    }
    public function offsetUnset($key)
    {
        throw new Exception('Зарещено менять значение системных переменных');
    }

/////////////////////////////
////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////
///////////////////////////////     Методы интерфейса Iterator
  // устанавливает итеретор на первый элемент
  public function rewind()
  {
    reset($this->arrayINI);
  }
  // возвращает текущий элемент
  public function current()
  {
    return current($this->arrayINI);
  }
  // возвращает ключ текущего элемента
  public function key()
  {
    return key($this->arrayINI);
  }
  // переходит к следующему элементу
  public function next()
  {
    next($this->arrayINI);
  }
  // проверяет, существует ли текущий элемент после выполнения мотода rewind или next
  public function valid()
  {
    if (isset($this->arrayINI[key($this->arrayINI)]))
        return true;
    else 
        return false;
  }    
/////////////////////////////
////////////////////////////////////////////////////////////////
  
}