<?php
/**
 * Ôîğìèğîâàíèå íàçâàíèÿ ìåñÿöà îò åãî ïîğÿäêîâîãî íîìåğà.
 * 
 * ----------------------------------------------------
 * | Áèáëèîòåêà: Dune                                  |
 * | Ôàéë: MonthName.php                               |
 * | Â áèáëèîòåêå: Dune/Build/MonthName.php            |
 * | Àâòîğ: Àíäğåé Ğûæîâ (Dune) <dune@rznw.ru>         |
 * | Âåğñèÿ: 1.01                                      |
 * | Ñàéò: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * Èñòîğèÿ âåğñèé:
 * -----------------
 * 
 *  Âåğñèÿ 1.01
 *  Ôóåêöèÿ trim() èñïîëüçóåòñÿ åğåç ïîñğåäíèêà.
 * 
 */

class Dune_Date_MonthName
{
    
    protected $_number = null;
    protected $_arrayNames = array(
                                    1 => array(
                                                1 => 'ÿíâàğü',
                                                2 => 'ÿíâàğÿ',
                                               ),
                                    2 => array(
                                                1 => 'ôåâğàëü',
                                                2 => 'ôåâğàëÿ',
                                               ),
                                    3 => array(
                                                1 => 'ìàğò',
                                                2 => 'ìàğòà',
                                               ),
                                    4 => array(
                                                1 => 'àïğåëü',
                                                2 => 'àïğåëÿ',
                                               ),
                                    5 => array(
                                                1 => 'ìàé',
                                                2 => 'ìàÿ',
                                               ),
                                    6 => array(
                                                1 => 'èşíü',
                                                2 => 'èşíÿ',
                                               ),
                                    7 => array(
                                                1 => 'èşëü',
                                                2 => 'èşëÿ',
                                               ),
                                    8 => array(
                                                1 => 'àâãóñò',
                                                2 => 'àâãóñòà',
                                               ),
                                    9 => array(
                                                1 => 'ñåíòÿáğü',
                                                2 => 'ñåíòÿáğÿ',
                                               ),
                                    10 => array(
                                                1 => 'îêòÿáğü',
                                                2 => 'îêòÿáğÿ',
                                               ),
                                    11 => array(
                                                1 => 'íîÿáğü',
                                                2 => 'íîÿáğÿ',
                                               ),
                                    12 => array(
                                                1 => 'äåêàáğü',
                                                2 => 'äåêàáğÿ',
                                               ),
                                    13 => array(
                                                1 => false,
                                                2 => false,
                                               ),
                                               
                                  );
    /**
     * Êîíñòğóêòîğ.
     *
     * @param integer $number ïîğÿäêîâûé íîìåğ ìåñÿöà
     */
    public function __construct($number)
    {
        $str = Dune_String_Factory::getStringContainer($number);
        $this->_number = (int)$str->trim(' 0');
        if ($this->_number < 1 or $this->_number > 12)
            $this->_number = 13;
    }
    
    /**
     * Âîçâğàò èìåíè ìåñÿöà
     *
     * @return string
     */
    public function get()
    {
        return $this->_arrayNames[$this->_number][1];
    }
    
    /**
     * Âîçâğàò èìåíè ìåñÿöà â ğîäèòåëüíîì ïàäåæå.
     * Íàïğèìåğ: ÿíâàğÿ, ôåâğàëÿ
     *
     * @return string
     */
    public function getGenitive()
    {
        return $this->_arrayNames[$this->_number][2];
    }
    
}