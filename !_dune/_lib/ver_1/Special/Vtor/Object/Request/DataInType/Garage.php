<?php
class Special_Vtor_Object_Request_DataInType_Garage extends Dune_Data_Collector_Abstract_ArrayAllow
{
    /**
     * Массив разрешённых полей для использования и форматы.
     *
     * Формат:
     * <имя поля> => array(<ключ>, <длина>)
     * <имя поля> => array(<ключ>, <длина>)
     * ...
     * 
     * Расшифровка:
     * <ключ> : 'i' - целое число
     *          's' - строка
     *          'f' - число с плавающей точкой
     * <длина> : для строки - число символов, для числа - масимальное значение
     * 
     * @var array
     * @access private
     */
    protected $allowFields = array(
//                                  'text' => array('s', 3000)
                                  );

}