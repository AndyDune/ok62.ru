<?php
/**
 * 
 */




/**
 * Concrete class for handling view scripts.
 *
 * @category   Zend
 * @package    Zend_View
 * @copyright  Copyright (c) 2005-2007 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */

class Dune_Zend_View extends Zend_View
{
    static private $instance = array();

    static $scriptPath = '';
    static $basePath = '';
    
    static $classToAssign = 'System_Site_ViewAssign';
    static $isClassToAssign = true;
    
    protected $_lockedKeys = array();
    
    /**
     * ������ ����������� ������ ������ �����
     *
     * @var array
     * @access private
     */
    protected $____results123321 = array();
    
    
    /**
     * ���������� ������ ������ Dune_Zend_View
     *
     * @param array $config ������ ������� ���������
     * @param string $key ���� ��� �������� ���������� ����������� ������
     * @return Dune_Zend_View
     */
    static function getInstance($key = 'default', $config = array())
    {
        if (!$key) $key = 'default';
        if (!key_exists($key, self::$instance))
        {
            self::$instance[$key] = new Dune_Zend_View($config);
            if (Dune_Parameters::$useClassToAssign)
            {
                $class = new self::$classToAssign();
                $class->view = self::$instance[$key];
                $class->make();
            }
            
            if (self::$scriptPath)
            {
            	self::$instance[$key]->addScriptPath(self::$scriptPath);
            }
            self::$instance[$key]->addHelperPath(dirname(__FILE__) . '/ViewHelper', 'Dune_Zend_ViewHelper');
        }
        return self::$instance[$key];
    }

    /**
     * Processes a view script and returns the output.
     *
     * @param string $name ��� �������-����. ���������� ����� �� ���������. /, \, : - ����������� ��� �������� �����.
     * @return string �����, ���������� � ���������� ������ �������.
     */
    public function render($name)
    {
    	$name = str_replace(array('/', '\\', ':'), DIRECTORY_SEPARATOR, $name) . '.php';
    	return parent::render($name);
    }
    
    
    public function assignOne($spec, $value = null)
    {
        if (key_exists($spec, $this->_lockedKeys))
        {
            throw new Dune_Exception_Base('��������� ������������� ���������� ��� ����.');
        }
        if (is_string($spec))
        {
                // assign by name and value
            if ('_' == substr($spec, 0, 1))
            {
                    throw new Dune_Exception_Base('Setting private or protected class members is not allowed', $this);
            }
//            $this->$spec = $value;
            $this->_lockedKeys[$spec] = $value;
        }
        else         
            throw new Dune_Exception_Base('����������-���� ����� ���� ������ �������.');
    }
    
    
    /**
     * Directly assigns a variable to the view script.
     *
     * Checks first to ensure that the caller is not attempting to set a
     * protected or private member (by checking for a prefixed underscore); if
     * not, the public member is set; otherwise, an exception is raised.
     *
     * @param string $key The variable name.
     * @param mixed $val The variable value.
     * @return void
     * @throws Zend_View_Exception if an attempt to set a private or protected
     * member is detected
     */
    public function __set($key, $val)
    {
        if (key_exists($key, $this->_lockedKeys))
        {
            throw new Dune_Exception_Base('��������� ������������� ���������� ��� ����: ' . $key);
        }
        if ('_' != substr($key, 0, 1)) {
            $this->$key = $val;
            return;
        }

        throw new Dune_Exception_Base('Setting private or protected class members is not allowed', $this);
    }
    
    
    /**
     * Prevent E_NOTICE for nonexistent values
     *
     * If {@link strictVars()} is on, raises a notice.
     *
     * @param  string $key
     * @return null
     */
    public function __get($key)
    {
        if (isset($this->_lockedKeys[$key]))
            return $this->_lockedKeys[$key];
        parent::__get($key);
    }
    
    /**
     * Enter description here...
     *
     * @param unknown_type $spec
     * @param unknown_type $value
     * @return Dune_Zend_View
     */
    public function assign($spec, $value = null)
    {
        if (is_string($spec) and key_exists($spec, $this->_lockedKeys))
        {
            throw new Dune_Exception_Base('��������� ������������� ���������� ��� ����: ' . $spec);
        }
        parent::assign($spec, $value);
        return $this;
    }
    

    
    /**
     * ������� ��� ��������� ����������� ������ ������.
     * !!! ����� ���������� ��������� ���� �����.
     * ������ ��������� �������.
     *
     * @param unknown_type $name
     * @param unknown_type $value
     */
    protected function setResult($name, $value)
    {
        $this->____results123321[$name] = $value;
        return $this;
    }
    
     /**
     * ���������� ��������� � ��������� �������.
     *
     * @param mixed $key ���� ��� ��������, ��������������� � �����������. ���� �� ������ - ������� ������ �������.
     * @return string
     */
    public function getResult($key = 0)
    {
        if (key_exists($key, $this->____results123321))
            return $this->____results123321[$key];
        else
            return null;
    }

     /**
     * ���������� ����� ������ �����������.
     *
     * @return string
     */
    public function getResults()
    {
        return $this->____results123321;
    }
    
    
    
}
