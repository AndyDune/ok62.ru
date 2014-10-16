<?php
/**
 * Разбор значения временного интервала с выделением временных единиц.
 * 
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: IntervalParse.php                           |
 * | В библиотеке: Dune/Time/IntervalParse.php         |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 0.90                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * 
 */

class Dune_Time_IntervalParse
{
    protected $_timeBegin = 0;
    protected $_timeBeginArray = array();
    protected $_timeBeginIsUnix = true;
    protected $_timeEnd;
    protected $_timeEndArray = array();
    protected $_timeEndIsUnix = true;
    
    protected $_timeIntervalArray = array(
                                          'seconds' => 0,
                                          'minutes' => 0,
                                          'hours' => 0,
                                          'mday' => 0,
                                          'mon' => 0,
                                          'year' => 0
                                          );
    
    public function __construct($timeBegin, $timeEnd)
    {
        if (strpos($timeBegin, '-'))
        {
            $this->_timeBeginIsUnix = false;
            $this->_timeBegin = $timeBegin;
        }
        else 
        {
            $this->_timeBegin = (int)$timeBegin;
        }
        
        if (strpos($timeEnd, '-'))
        {
            $this->_timeEndIsUnix = false;
            $this->_timeEnd = $timeEnd;
        }
        else 
        {
            $this->_timeEnd = (int)$timeEnd;
        }
        $this->_calculate();
    }


    public function getSeconds()
    {
        return $this->_timeIntervalArray['seconds'];
    }
    public function getMinutes()
    {
        return $this->_timeIntervalArray['minutes'];
    }
    public function getHours()
    {
        return $this->_timeIntervalArray['hours'];
    }
    public function getMday()
    {
        return $this->_timeIntervalArray['mday'];
    }
    public function getMonth()
    {
        return $this->_timeIntervalArray['mon'];
    }
    public function getYear()
    {
        return $this->_timeIntervalArray['year'];
    }
    
    public function getResultArray()
    {
        return $this->_timeIntervalArray;
    }
    
//////////////////////////////////////////////////////////////////////
//////////////////  Волшебные методы
    private function _calculate()
    {
        $time = $this->_timeEnd - $this->_timeBegin;
        if ($time < 0 )
            return false;
            
        $this->_timeIntervalArray['seconds'] = $time % 60;
        $current_time = (int)($time / 60);
        if (!$current_time)
            return;
        $this->_timeIntervalArray['minutes'] = $current_time % 60;
        $current_time = (int)($current_time / 60);
        if (!$current_time)
            return;
        
        $this->_timeIntervalArray['hours'] = $current_time % 24;
        $current_time = (int)($current_time / 24);
        if (!$current_time)
            return;
        
        $this->_timeIntervalArray['mday'] = $current_time % 30;
        $current_time = (int)($current_time / 30);
        if (!$current_time)
            return;
            
        $this->_timeIntervalArray['mon'] = $current_time % 12;
        $this->_timeIntervalArray['year'] = (int)($current_time / 12);
        
    }

    private function __toString()
    {
        return '';
    }

}