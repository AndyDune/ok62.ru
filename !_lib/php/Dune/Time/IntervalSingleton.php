<?php
/**
 * Фиксирование времени от момента создания объекта
 * Класс - синглетон. (функционально идентичен классу Dune_Time_Interval)
 * 
 * Печать (echo) объекта приводит к возврату интервала
 * 
 * Реализует интерфейсы: ArrayAccess,Iterator
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: IntervalSingleton.php                       |
 * | В библиотеке: Dune/Time/IntervalSingleton.php     |
 * | Автор: Андрей Рыжов (Dune) <dune@pochta.ru>       |
 * | Версия: 1.01                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * История версий:
 * -----------------
 * 
 * Версия 1.00 -> 1.01
 * Введена возможность создавать несколько Singleton'ов в пределах класса.
 * 
 *
 */

class Dune_Time_IntervalSingleton implements ArrayAccess,Iterator
{
    protected $timeBegin;
    protected $timeMarker = array();
    protected $toRound = 3;
    
    
    /**
    * Иниц. при первом вызове стат. метода и возвращается при последующих
    *
    * @var указатель на объект
    */
  static private $instance = array();

  /**
   * Создаёт реализацию класса при первом вызове
   * Возвращает сохранённый указатель объекта при последующих вызовах
   *
   * @param integer $precision число знаков после запятой
   * @param string $name имя объекта во внутреннем реестре
   * @return Dune_Time_IntervalSingleton
   */
  
  public static function getInstance($precision = 3, $name = 'default')
  {
        if (!key_exists($name,self::$instance))
        {
            self::$instance[$name] = new Dune_Time_IntervalSingleton($precision);
        }
        return self::$instance[$name];
  }

  /**
   * @access private
   */
    private function __construct($precision = 3)
    {
        $this->toRound = $precision;
        $this->timeBegin = microtime(true);
    }

    /**
     * Возвращает интервал с сохранением в массиве с указанным ключём
     *
     * @param mixed $val
     * @return float
     */
    public function getTime($keyName = null)
    {
        if (empty($keyName))
            return $this->timeMarker[] = round(microtime(true) - $this->timeBegin,$this->toRound);
        else 
            return $this->timeMarker[$keyName] = round(microtime(true) - $this->timeBegin,$this->toRound);
    }
    
    
////////////////////////////////////////////////////////////////
///////////////////////////////     Методы интерфейса ArrayAccess
  /**
   * @access private
   */
    public function offsetExists($key)
    {
        return key_exists($key,$this->timeMarker);
    }
    
  /**
   * @access private
   */
    public function offsetGet($key)
    {
        if (!key_exists($key,$this->timeMarker))
            throw new Exception('Ошибка чтения временных меток: ключа '.$key.' не существует');
        return $this->timeMarker[$key];
    }
    
    public function offsetSet($key, $value)
    {
        throw new Exception('Зарещено менять значение временных меток');
    }
    public function offsetUnset($key)
    {
        throw new Exception('Зарещено менять значение временных меток');
    }

/////////////////////////////
////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////
///////////////////////////////     Методы интерфейса Iterator
  // устанавливает итеретор на первый элемент
  public function rewind()
  {
    reset($this->timeMarker);
  }
  // возвращает текущий элемент
  public function current()
  {
    return current($this->timeMarker);
  }
  // возвращает ключ текущего элемента
  public function key()
  {
    return key($this->timeMarker);
  }
  // переходит к следующему элементу
  public function next()
  {
    next($this->timeMarker);
  }
  // проверяет, существует ли текущий элемент после выполнения мотода rewind или next
  public function valid()
  {
    if (isset($this->timeMarker[key($this->timeMarker)]))
        return true;
    else 
        return false;
  }    
/////////////////////////////
////////////////////////////////////////////////////////////////    
    
    
    
//////////////////////////////////////////////////////////////////////
//////////////////  Волшебные методы
    public function __toString()
    {
        return (string)(round(microtime(true) - $this->timeBegin,$this->toRound));
    }    
    
    
}