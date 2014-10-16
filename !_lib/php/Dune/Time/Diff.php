<?php
/**
 * 
 * ��������� ������ �������.
 * ��� ��, �������� ���� �� ���� ��������� �� ������������ � ������������ ��� ����������� ���� � ������� unix.
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Diff.php                                    |
 * | � ����������: Dune/Time/Diff.php                  |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 0.90                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * 0.90 (2009 ��� 25)
 * ��� ������������. ������� ������������.
 * 
 */

class Dune_Time_Diff
{
    protected $_timeDatetimeCurrent = null;
    protected $_timeDatetimeRelative = null;

    protected $_timeTimestampCurrent = null;
    protected $_timeTimestampRelative = null;
    
    protected $_formatAlloy = array('datetime', 'timestamp');
    
    protected $_timeBitsCurrent = array(
                                    'hours'   => 0,
                                    'minutes' => 0,
                                    'seconds' => 0,
                                    'mon'     => 0,
                                    'mday'    => 0,
                                    'year'    => 0    
                                  );
    protected $_timeBitsRelative = array(
                                    'hours'   => 0,
                                    'minutes' => 0,
                                    'seconds' => 0,
                                    'mon'     => 0,
                                    'mday'    => 0,
                                    'year'    => 0    
                                  );

                                  
    const FORMAT_DATATIME  = 'datetime';
    const FORMAT_TIMESTAMP = 'timestamp';
    
    /**
     * ����� ������ �� ������� �������� �����.
     *
     * @var integer
     * @access private
     */
    protected $_timeNumberChange = 0;
    
    public function __construct($time_current, $format = 'datetime')
    {
        if (!in_array($format, $this->_formatAlloy))
            throw new Dune_Exception_Base('������������� ������ ����.');
        $result = false;
        switch ($time_current)
        {
            case 'datetime':
//                $str = preg_replace('/[^\d]/', '', $time_current);
                $this->_timeDatetimeCurrent = $time_current;
                $this->_timeBitsCurrent = $this->_collectTimeBitsFromDatetime($this->_timeDatetimeCurrent);
                $this->_timeTimestampCurrent = $this->_makeTimestampFromTimeBits($this->_timeBitsCurrent);
                $result = true;
            break;
            case 'timestamp':
                $this->_timeTimestampCurrent = (int)$time_current;
                $this->_timeDatetimeCurrent = $this->_makeDatetimeFromTimestamp($this->_timeTimestampCurrent);
                $this->_timeBitsCurrent   = getdate($this->_timeTimestampCurrent);
                $result = true;
            break;
        }
    }

    public function setRelativeTime($time_relative, $format = 'datetime')
    {
        if (!in_array($format, $this->_formatAlloy))
            throw new Dune_Exception_Base('������������� ������ ����.');
        $result = false;
        switch ($time_relative)
        {
            case 'datetime':
//                $str = preg_replace('/[^\d]/', '', $time_current);
                $this->_timeDatetimeRelative = $time_relative;
                $this->_timeBitsRelative = $this->_collectTimeBitsFromDatetime($this->_timeDatetimeRelative);
                $this->_timeTimestampRelative = $this->_makeTimestampFromTimeBits($this->_timeBitsRelative);
                $result = true;
            break;
            case 'timestamp':
                $this->_timeTimestampRelative = (int)$time_relative;
                $this->_timeDatetimeRelative = $this->_makeDatetimeFromTimestamp($this->_timeTimestampRelative);
                $this->_timeBitsRelative   = getdate($this->_timeTimestampRelative);
                $result = true;
            break;
        }
        return $result;
    }
    
    
    public function getDiff($bit = 'seconds', $mode = '<')
    {
        $znak = 1;
        $number = $this->_timeTimestampRelative - $this->_timeTimestampCurrent;
        if ($number < 0)
        {
            $znak = -1;
            $number = $number * $znak;
        }
        switch ($bit[0])
        {
            case 'd':
                $result = $number % 86400;
                $result_all = $number / 86400;
                if ($mode == '>' and $result != $result_all)
                {
                    $result = $result_mode + 1;
                }
            default:
                $result = $number;
        }
        return $result;
    }
    
    public function refreshTimeFromBits($mode = 'all')
    {
        switch ($mode)
        {
            case 'relative':
                $this->_timeTimestampRelative = $this->_makeTimestampFromTimeBits($this->_timeBitsRelative);
                $this->_timeDatetimeRelative = $this->_makeDatetimeFromTimestamp($this->_timeTimestampRelative);
            break;
            case 'current':
                $this->_timeTimestampCurrent = $this->_makeTimestampFromTimeBits($this->_timeBitsCurrent);
                $this->_timeDatetimeCurrent = $this->_makeDatetimeFromTimestamp($this->_timeTimestampCurrent);
            break;
            default:
                $this->_timeTimestampRelative = $this->_makeTimestampFromTimeBits($this->_timeBitsRelative);
                $this->_timeDatetimeRelative = $this->_makeDatetimeFromTimestamp($this->_timeTimestampRelative);
                
                $this->_timeTimestampCurrent = $this->_makeTimestampFromTimeBits($this->_timeBitsCurrent);
                $this->_timeDatetimeCurrent = $this->_makeDatetimeFromTimestamp($this->_timeTimestampCurrent);
        }
    }
    
    
    public function setCurrentTimeYear($value)
    {
        $this->_timeBitsCurrent['year'] = (int)$value;
    }
    public function setCurrentTimeMday($value)
    {
        $this->_timeBitsCurrent['mday'] = (int)$value;
    }
    public function setCurrentTimeMon($value)
    {
        $this->_timeBitsCurrent['mon'] = (int)$value;
    }
    public function setCurrentTimeSeconds($value)
    {
        $this->_timeBitsCurrent['seconds'] = (int)$value;
    }
    public function setCurrentTimeSeconds($value)
    {
        $this->_timeBitsCurrent['seconds'] = (int)$value;
    }
    public function setCurrentTimeMinutes($value)
    {
        $this->_timeBitsCurrent['minutes'] = (int)$value;
    }
    public function setCurrentTimeHours($value)
    {
        $this->_timeBitsCurrent['hours'] = (int)$value;
    }

    public function setRelativeTimeYear($value)
    {
        $this->_timeBitsRelative['year'] = (int)$value;
    }
    public function setRelativeTimeMday($value)
    {
        $this->_timeBitsRelative['mday'] = (int)$value;
    }
    public function setRelativeTimeMon($value)
    {
        $this->_timeBitsRelative['mon'] = (int)$value;
    }
    public function setRelativeTimeSeconds($value)
    {
        $this->_timeBitsRelative['seconds'] = (int)$value;
    }
    public function setRelativeTimeSeconds($value)
    {
        $this->_timeBitsRelative['seconds'] = (int)$value;
    }
    public function setRelativeTimeMinutes($value)
    {
        $this->_timeBitsRelative['minutes'] = (int)$value;
    }
    public function setRelativeTimeHours($value)
    {
        $this->_timeBitsRelative['hours'] = (int)$value;
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

    protected function _makeDatetimeFromTimestamp($timestamp)
    {
        $result = date('Y-m-d H:i:s', $timestamp);
        return $result;
    }
    
    
}