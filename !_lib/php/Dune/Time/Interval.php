<?php
/**
 * Фиксирование времени от момента создания объекта
 * Печать (echo) объекта приводит к возврату интервала
 * 
 * Реализует интерфейсы: ArrayAccess,Iterator
 * Определены волшебные методы: __toString - снятие интервала и возвращение без сохранения значения
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Interval.php                                |
 * | В библиотеке: Dune/Time/Interval.php              |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.00                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * 
 */

class Dune_Time_Interval implements ArrayAccess, Iterator
{
    protected $timeBegin;
    protected $timeMarker = array();
    protected $toRound = 3;
    
    public function __construct($precision = 3)
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
    public function offsetExists($key)
    {
        return key_exists($key,$this->timeMarker);
    }
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
    private function __toString()
    {
        return (string)(round(microtime(true) - $this->timeBegin,$this->toRound));
    }

}