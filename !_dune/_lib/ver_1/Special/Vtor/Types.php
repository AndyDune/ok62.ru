<?php
/**
 * 
 * 
 */
abstract class Special_Vtor_Types
{
    
    static public $typesToRequest = array(
                                        1 => array('id' => 1,
                                                   'code'=>'room',
                                                   'name'   => 'квартира',
                                                   'nameTo' => 'квартиру',
                                                   'nameOf' => 'квартиры',
                                                   ),
                                        2 => array('id' => 2,
                                                   'code'=>'house',
                                                   'name'   => 'дом',
                                                   'nameTo' => 'дом',
                                                   'nameOf' => 'дома',
                                                   ),
                                                   
                                        3 => array('id' => 3,
                                                   'code'=>'garage',
                                                   'name'   => 'гараж',
                                                   'nameTo' => 'гараж',
                                                   'nameOf' => 'гаража',
                                                   ),
                                        4 => array('id' => 4,
                                                   'code'=>'nolife',
                                                   'name'   => 'коммерческая недвижимость',
                                                   'nameTo' => 'коммерческую недвижимость',
                                                   'nameOf' => 'коммерческой недвижимости',
                                                   ),
                                        5 => array('id' => 5,
                                                   'code'=>'pantry',
                                                   'name'   => 'кладовое помещение',
                                                   'nameTo' => 'кладовое помещение',
                                                   'nameOf' => 'кладового помещения',
                                                   ),
                                        6 => array('id' => 6,
                                                   'code'=>'land',
                                                   'name'   => 'земельный участок',
                                                   'nameTo' => 'земельный участок',
                                                   'nameOf' => 'земельного участка',
                                                   ),
                                        7 => array('id' => 7,
                                                   'code'=>'cottage',
                                                   'name'   => 'коттедж',
                                                   'nameTo' => 'коттедж',
                                                   'nameOf' => 'коттеджа',
                                                   ),
                                     );
    
    static public function getTypeCode($id)
    {
        if (isset(self::$typesToRequest[$id]))
            return self::$typesToRequest[$id]['code'];
        else 
            return null;
    }
                                     
}