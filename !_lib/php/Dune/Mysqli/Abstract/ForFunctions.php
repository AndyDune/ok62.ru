<?php
/**
 * Родительский класс для репозиториев функций для работы с таблицами  БД
 *  
 * Используются классы:
 *    Dune_MysqliSystem
 * 
 */

abstract class Dune_Mysqli_Abstract_ForFunctions
{
    

    /**
     * Указатель на объект - соединения с базой данных.
     * 
     * @var string
     * @access private
     */
    protected static $_DB = null;
    
    /**
     * Массив для сохранения в базе
     * 
     * @var array
     * @access private
     */
    protected static $_arrayToSave = array();

    /**
     * Строка SET для запроса
     * 
     * @var string
     * @access private
     */
    protected static $_querySetString = '';
    
    protected static $unserializationInfo = false;
    protected static $unserializationNotice = false;
    protected static $unserializationBody = false;
    
    protected static $ID = 'id';
    

    
    public static function setUnserializeInfo($bool = true)
    {
        self::$unserializationInfo =  $bool;
    }
    
    public function setUnserializeBody($bool = true)
    {
        self::$unserializationBody = $bool;
    }
    
    public function setUnserializeNotice($bool = true)
    {
        self::$unserializationNotice = $bool;
    }
    
    public function alterID($name)
    {
        $this->ID = $name;
    }
    
////////////////////////////////////////////////////////////////////////////////////////
/////////////////       Закрытые методы    
///////////////////////////////////////////////////////////////////////////////////////


    /**
     * Создание строки для сохранения в базе.
     * Сериализует подмассив.
     * 
     * @access private
     */
    protected static function _makeSetString($alloyArray = false, $arrays = 0, $requireFields = false)
    {
        // Основной ключ - здесь не нужен
        unset(self::$_arrayToSave[self::$ID]);
        
        if ($requireFields)
        {
            foreach ($requireFields as $run)
            {
                if (!key_exists($run, self::$_arrayToSave))
                {
                     throw new Dune_Exception_Base('В массиве для сохранение отсутствует необходимый ключ: ' . $run);
                }
            }
        }
        
        
       	$find_one = 0;
       	// Два элемента в переданном массиве может быть массивом - их сериализуем
       	// Подмассивов может быт только 2 - иначе исключение
       	foreach (self::$_arrayToSave as $r_rey => $contents)
       	{
       	    if (is_array($alloyArray) and !in_array($r_rey, $alloyArray))
       	    {
                throw new Dune_Exception_Base('Недопустимый ключ в массиве для сохранения в базе: ' . $r_rey);
       	        
       	    }
       	        
       	    if (is_array($contents))
       	    {
       	        if ($find_one == $arrays)
       	        {
       	            throw new Dune_Exception_Base('В массиве для сохранения значений ряда таблицы ' . self::$tableNameArticle . ' может быть только ' . $arrays . ' массив(ов).');
       	        }
       	        self::$_arrayToSave[$r_rey] = serialize(self::$_arrayToSave[$r_rey]);
       	        $find_one += 1;
       	    }
       	}       
       	// Создаём строку SET
       	// Здесь url есть в любом случае	
       	$set_str = '';
       	$x = 0;
       	foreach (self::$_arrayToSave as $r_rey => $contents)
       	{
       		if ($x == 0)
       			$set_str.= ' SET `'.$r_rey.'`="' . self::$_DB->real_escape_string($contents) . '"';
       		else
       			$set_str.= ', `'.$r_rey.'`="' . self::$_DB->real_escape_string($contents) . '"';
       		$x++;
       	}
        self::$_querySetString =  $set_str;
    }




    /**
     * Получаем указатель на объект - соединения с базой данных.
     * 
     * @access private
     */
    protected static function _getDB()
    {
        if (self::$_DB == null)
        {
            self::$_DB = Dune_MysqliSystem::getInstance();
        }
    }
    
}