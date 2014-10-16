<?php
/**
 * 
 * Изменение данных времени.
 * Как то, фиксация даты от сего мгновения до вычисляемого с прибавлением или вычитаением даты в формате unix.
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Change.php                                  |
 * | В библиотеке: Dune/Time/Change.php                |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.00                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * 
 */

class Dune_Time_Change
{
    protected $_timeStringCurrent = null;
    protected $_timeStringLook = null;

    protected $_timeNumberCurrent = null;
    protected $_timeNumberLook = null;
    
    protected $_formatAlloy = array('datetime', 'timestamp');
    
    protected $_timeBitsCurrent = array(
                                    'hours'   => 0,
                                    'minutes' => 0,
                                    'seconds' => 0,
                                    'mon'     => 0,
                                    'mday'    => 0,
                                    'year'    => 0    
                                  );
    /**
     * Число секунд на которое меняется время.
     *
     * @var integer
     * @access private
     */
    protected $_timeNumberChange = 0;
    
    public function __construct($time_current, $format = 'datetime')
    {
        if (!in_array($format, $this->_formatAlloy))
            throw new Dune_Exception_Base('Неразрешенный формат даты.');
        $result = false;
        switch ($time_current)
        {
            case 'datetime':
//                $str = preg_replace('/[^\d]/', '', $time_current);
                $this->_timeStringCurrent = $time_current;
                $this->_timeBitsCurrent = $this->_collectTimeBitsFromDatetime($this->_timeStringCurrent);
                $this->_timeNumberCurrent = $this->_makeTimestampFromTimeBits($this->_timeBitsCurrent);
            break;
            case 'unix':
                $this->_timeNumberCurrent = (int)$time_current;
                $this->_timeStringCurrent = date('Y-m-d H:i:s', $this->_timeNumberCurrent);
                $this->_timeBitsCurrent   = getdate($this->_timeNumberCurrent);
                $result = true;
            break;
        }
        $this->toRound = $precision;
        $this->timeBegin = microtime(true);
    }

    
    protected function _collectTimeBitsFromDatetime($string)
    {
        $str = Dune_String_Factory::getStringContainer($string);
        $array = array();
        $array['year']  = (int)$str->substr(0, 4);
        $array['mon']   = (int)$str->substr(5, 2);
        $array['mday']  = (int)$str->substr(8, 2);
        
        $array['hours']    = (int)$str->substr(11, 2);
        $array['minutes']  = (int)$str->substr(14, 2);
        $array['seconds']  = (int)$str->substr(17, 2);
        return $array;
    }

    protected function _makeTimestampFromTimeBits($array)
    {
        $result = mktime($array['hours'], 
                         $array['minutes'],
                         $array['seconds'],
                         $array['mon'],
                         $array['mday'],
                         $array['year']);
        return $result;
    }
    
}