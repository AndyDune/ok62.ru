<?php
/**
 * 
 * Контейнер адреса.
 * 
 */
abstract class Special_Vtor_Settings
{
    /**
     * Использовать ли районы человеческие.
     *
     * @var boolean
     */
    static public $districtPlus = true;
    
    /**
     * 
     *
     * @var string
     */
    static public $districtPlusPostFix = 'plus';
    
    /**
     * Разрешение на логирование.
     *
     * @var boolean
     */
    static public $log = true;
    
    static public $idOk62 = 3;
    
    static public $timeIntervalMessageToPublicTalk = 6;
    static public $timeIntervalMessageToPrivateTalk = 1;
    
    static public $timeIntervalObjectToAdd = 5;
    
    static public $pictureProportionX = 4;
    static public $pictureProportionY = 4;
    static public $pictureProportionMode = 'add';
    static public $pictureProportionBGColor = 0xffffff;
    
    static public $checkEnterAttemptCount = false;
    
    static public $maxLengthMessagePublic = 500;
    
    static public $maxObjectsInQueryToAdd = 1000;
    static public $maxRequestCount = 100;
    
    static public $maxCountPhotoLoad = 10;
    
    const CACHE_TAG_CATALOGUE = 'catalogue';
    
    /**
     * Ключ в пироговом массиве для уникального мегакода пользователя, который не зареген.
     */
    const NO_AUTH_USER_CODE_KEY = 'no_auth_user_code';
    
    static public $typeCodeToString = array(
                                        1 => 'room',
//                                        2 => 'house',
                                        3 => 'garage',
                                        4 => 'nolife'
                                     );
    static public $folderToSellKeep = 'input/tosell';
    
    static public $arrayEdinstvoSalers = array(1, 2, 12, 19, 3, 24, 25, 26, 27, 28, 29, 30, 31, 48, 52, 82, 83, 87, 88);
    
    /**
     * Использовать группировку по стояку.
     *
     * @var boolean
     */
    static public $useGroupInList = true;
    
    
    
                                
static public $windowsType = array(
                                   1 => 'ПВХ',
                                   2 => 'деревянные',
                                   3 => 'пластиковые'
                                    );
    
}