<?php
/**
 * ������������ ����� ��� ������������ ������� ��� ������ � ���������  ��
 *  
 * ������������ ������:
 *    Dune_MysqliSystem
 * 
 */

abstract class Dune_Mysqli_Abstract_ForFunctions
{
    

    /**
     * ��������� �� ������ - ���������� � ����� ������.
     * 
     * @var string
     * @access private
     */
    protected static $_DB = null;
    
    /**
     * ������ ��� ���������� � ����
     * 
     * @var array
     * @access private
     */
    protected static $_arrayToSave = array();

    /**
     * ������ SET ��� �������
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
/////////////////       �������� ������    
///////////////////////////////////////////////////////////////////////////////////////


    /**
     * �������� ������ ��� ���������� � ����.
     * ����������� ���������.
     * 
     * @access private
     */
    protected static function _makeSetString($alloyArray = false, $arrays = 0, $requireFields = false)
    {
        // �������� ���� - ����� �� �����
        unset(self::$_arrayToSave[self::$ID]);
        
        if ($requireFields)
        {
            foreach ($requireFields as $run)
            {
                if (!key_exists($run, self::$_arrayToSave))
                {
                     throw new Dune_Exception_Base('� ������� ��� ���������� ����������� ����������� ����: ' . $run);
                }
            }
        }
        
        
       	$find_one = 0;
       	// ��� �������� � ���������� ������� ����� ���� �������� - �� �����������
       	// ����������� ����� ��� ������ 2 - ����� ����������
       	foreach (self::$_arrayToSave as $r_rey => $contents)
       	{
       	    if (is_array($alloyArray) and !in_array($r_rey, $alloyArray))
       	    {
                throw new Dune_Exception_Base('������������ ���� � ������� ��� ���������� � ����: ' . $r_rey);
       	        
       	    }
       	        
       	    if (is_array($contents))
       	    {
       	        if ($find_one == $arrays)
       	        {
       	            throw new Dune_Exception_Base('� ������� ��� ���������� �������� ���� ������� ' . self::$tableNameArticle . ' ����� ���� ������ ' . $arrays . ' ������(��).');
       	        }
       	        self::$_arrayToSave[$r_rey] = serialize(self::$_arrayToSave[$r_rey]);
       	        $find_one += 1;
       	    }
       	}       
       	// ������ ������ SET
       	// ����� url ���� � ����� ������	
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
     * �������� ��������� �� ������ - ���������� � ����� ������.
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