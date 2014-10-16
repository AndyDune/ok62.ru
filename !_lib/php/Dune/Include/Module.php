<?php
 /**
 *  ����� ��� ����������� �������
 * 
 *  !!!!!!!!!!!  ����������, � ������������� �� �������������   !!!!!!!!!!!!!
 *
 * ������ ������ ������������ ��������� ������� ��� ��������� �������� ������
 *    $massage_code = array() - ���� ���������
 *    $massage_text = array() - ������ ����� ���������
 *    $text = array() - ����������
 * 
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Module.php                                  |
 * | � ����������: Dune/Include/Module.php             |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 1.13                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * ������� ������:
 * -----------------
 * 
 * 1.13 (2008 ������� 24)
 * ��� ����� ������������ �������� ��� ������� - ��������� ����������.
 * 
 * 1.11 -> 1.12
 * �������� ���������� ����� __tostring() ����� �� ������ ����������.
 * 
 * 
 * 1.10 -> 1.11
 * ����� ������������� ������ ����������� � �������� ������� getOutput � getResult ��� ���������� ������������� ���������.
 * 
 * 1.00 -> 1.10
 * ��� ���������� ���� � ������ ������������ ����������� ����������� ����������.
 * ������ �� �������� ��� ��� ������ ������������ - ������������ ����� make.
 * ����� ������ ���������� � ����� ������ make � ���������� ���������� ������ $this-><���-��>
 * ���������� � ������ $this->results
 * 
 * 0.99 -> 1.00
 * ��������� ����������� ����� ���� �������� ������� ����������
 * 
 */

class Dune_Include_Module
{
    /**
     * �������������� �� ���������� ��� ���������� ���������� ������
     * True - �������� (�� ���������)
     *
     * @var boolean
     */
    public static $isExeption = true;
    
    /**
     * ��� �������� ����� ������ � �����������
     * �� ��������� main.php
     * 
     * @var string
     */
    public static $modulFileName = 'index.php';

    /**
     * ��� ����� ������ ��� ����������� ������
     * �� ��������� .help.php
     * 
     * @var string
     */
    public static $modulHelpFileName = '.help.php';

    /**
     * ��� ����� �������� ������� ������ ��� ������
     * 
     * @var string
     */
    public static $modulControlFileName = '.control.php';
    
    public static $modulsPath = '';
    public static $modulsSpace = 'default';
    
    
    /**
     * ���� ������������� ������
     *
     * @var boolean
     * @access private
     */
    protected $moduleExistence = false;
    
    /**
     * ���� � ������ � �������� ����� �������
     *
     * @var string
     * @access private
     */
    protected $moduleLocalPath = '';
    
    /**
     * ������ ���� � ������
     *
     * @var string
     * @access private
     */
    protected $moduleFullPath = '';
    
    /**
     * ������ ���� � ����� ������
     *
     * @var string
     * @access private
     */
    protected $moduleHelpFullPath = '';

    
    /**
     * ������ ���� � ����� �������� ������� ������
     *
     * @var string
     * @access private
     */
    protected $moduleControlFullPath = '';
    /**
     * ������ ����� ���������
     *
     * @var array
     * @access private
     */
    protected $messageCode = array();
    
    /**
     * ������ ����������� ����� ���������
     *
     * @var array
     * @access private
     */
    protected $messageText = array();
    
    /**
     * ������ ��������������� �������
     *
     * @var array
     * @access private
     */
    protected $text = array();
    
    /**
     * ������ ����������� ������ ������
     *
     * @var array
     * @access private
     */
    protected $results = array();

    /**
     * ����� ������ ������ ���������� �� �������
     *
     * @var string
     * @access private
     */
    protected $buffer = '';
    
    
    /**
     * ������ ������� ����������� ������.
     *
     * @var array
     * @access private
     */
    protected $____parameters = array();
    
    
    public function __construct($module, $parameters = array())
    {
        $this->moduleLocalPath = str_replace(array(':', '/', '\\'), DIRECTORY_SEPARATOR, $module);
        $this->moduleFullPath = self::$modulsPath
        					  . DIRECTORY_SEPARATOR 
        					  . self::$modulsSpace 
        					  . DIRECTORY_SEPARATOR
        					  . $this->moduleLocalPath
        					  . DIRECTORY_SEPARATOR 
        					  . self::$modulFileName;
                                
        $this->moduleHelpFullPath = self::$modulsPath
        						  . DIRECTORY_SEPARATOR
        						  . self::$modulsSpace 
        						  . DIRECTORY_SEPARATOR
        						  .	$this->moduleLocalPath
        						  . DIRECTORY_SEPARATOR
        						  . self::$modulHelpFileName;

        $this->moduleControlFullPath = self::$modulsPath
        							 . DIRECTORY_SEPARATOR
        							 . self::$modulsSpace
        							 . DIRECTORY_SEPARATOR
        							 . $this->moduleLocalPath
        							 . DIRECTORY_SEPARATOR
        							 . self::$modulControlFileName;
                  
         if (!file_exists($this->moduleFullPath))
         { 
         	
             if (self::$isExeption)
                throw new Dune_Exception_Base('��� ���������� ������: ' . $this->moduleFullPath);
         }
         else 
         {
            $this->moduleExistence = true;
         }  
        
    	$this->____parameters = $parameters;
    }
    
    
    public function make()
    {
    	if ($this->moduleExistence)
    	{
	         // ���� ���������, ������������ �� ������
	         $message_code = array();
	         // ������ ��������� ������������ �� ������
	         $message_text = array();
	         // ������, ������������ �� ������
	         $text = array();
	         ob_start();
	         include($this->moduleFullPath);

//	         if (isset($DF_RESULTS)) // � ������� ������������ ��� �������� ����������� ����������� ���������� ������ ����� ������.
//	           $this->results = $DF_RESULTS;
	         
	         $this->buffer = ob_get_clean();
	         return true;
    	}
    	else 
    		return false;
    }
    
    /**
     * ���������� ���� ������������� ������.
     *
     * @return boolean
     */
    public function isModuleExist()
    {
        return $this->moduleExistence;
    }
    
    /**
     * ���������� ����������� ��������� ������
     *
     * @return integer
     */
    public function countMessage()
    {
        return count($this->messageCode);
    }
    
    /**
     * ���������� ��� ��������� � ��������� �������.
     * ������� ���������� ��� ���������� ������.
     *
     * @return integer
     */
    public function getMessageCode($num = 0)
    {         print_r($this->messageCode);
//        if (!key_exists($num, $this->messageCode))
//            throw new Dune_Exception_Base('��� ��������� � ����� �����.');
        return $this->messageCode[$num];
        
    }

     /**
     * ���������� ����� ��������� � ��������� �������.
     * ������� ���������� ��� ���������� ������.
     *
     * @return string
     */
    public function getMassageText($num = 0)
    {
        if (!key_exists($num, $this->messageText))
            throw new Dune_Exception_Base('��� ��������� ���������� � ����� �����.');
        return $this->messageText[$num];
    }

    /**
     * ������� ���������� ������ ����������� ������ �������
     *
     * @return string
     */
    public function getOutput()
    {
        return $this->buffer;
    }
   
     /**
     * ���������� ��������� � ��������� �������.
     * ������� ���������� ��� ���������� �����.
     *
     * @param mixed $key ���� ��� ��������, ��������������� � �����������. ���� �� ������ - ������� ������ �������.
     * @return string
     */
    public function getResult($key = 0)
    {
        
        if (!key_exists($key, $this->results))
            throw new Dune_Exception_Base('��� ���������� � ����� �����.');
        return $this->results[$key];
    }

     /**
     * ���������� ����� ������ �����������.
     *
     * @return string
     */
    public function getResults()
    {
        return $this->results;
    }
    
    
    /**
     * ���������� ����������� ��������� ������, ��������������� �������
     *
     * @return integer
     */
    public function countText()
    {
        return count($this->results);
    }
    
     /**
     * ���������� ��������� ���� � ��������� �������.
     * ������� ���������� ��� ���������� ������.
     *
     * @return string
     */
    public function getText($key = 'text')
    {
        if (!key_exists($key, $this->results))
        	return false;
            //throw new Dune_Exception_Base('��� ��������� � ����� �����.');
        return $this->results[$key];
    }

     /**
     * ���������� ��������� ���� ������.
     * ��� false ���� ����� ������ ���.
     *
     * @return string
     */
    public function help()
    {
         if (!file_exists($this->moduleHelpFullPath))
         {
            ob_start();
            include($this->moduleHelpFullPath);
            $result = ob_get_clean();
         }
         else 
            $result = false;
         return $result;
    }
    
////////////////////////////////////////////////////////////////
///////////////////////////////     ���������� ������
    public function __set($name, $value)
    {
    	$this->____parameters[$name] = $value;
    }
    public function __get($name)
    {
    	if (isset($this->____parameters[$name]))
    		return $this->____parameters[$name];
    	else 
    		return false;
    }
    
    public function __toString()
    {
        return $this->buffer;
    }
    
    
/////////////////////////////
////////////////////////////////////////////////////////////////
    
    
}