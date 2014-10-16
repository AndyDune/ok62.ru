<?php
/**
 * Dune Framework
 * 
 * ������������ Zend_View. ����������� � ������������ ��� ��� �����.
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: View.php                                    |
 * | � ����������: Dune/View.php                       |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 0.99.4                                    |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * 
 * 0.99.4 (2008 ���� 06)
 * ������ ���������� � ���������� �����.
 * 
 * 0.99.3 (2008 ���� 30)
 * ����� assign() ��������� �������.
 *
 * 0.99.2 (2009 ��� 27)
 * ������ � ����� ����������.
 * 
 * 0.99.1 (2009 ������ 30)
 * ������ ��������� � ����������.
 * 
 * 0.99 (2009 ������ 3)
 * �� ��������������. ��� ������������.
 * 
 * 
 */

class Dune_View
{
    /**
     * ���� � ����� � ������. ��� ������������ �����.
     *
     * @var string
     */
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
     * ������ ���������� ��� ����.
     *
     * @var array
     * @access private
     */
    protected $_parametersUuUuU_ = array();

    /**
     * ������ ���������� ��� ����. �����������.
     *
     * @var array
     * @access private
     */
    protected static $_parametersSsSsS_ = array();
    
    /**
     * ���� � ������� ���������� ���������� �� ����.
     *
     * @var array
     * @access private
     */
    protected $_useParametersSsSsS_ = false;

    /**
     *
     * @var string
     * @access private
     */
    protected $_fileFILEfile_ = '';
    

    /**
     * Processes a view script and returns the output.
     *
     * @param string $name ��� �������-����. ���������� ����� �� ���������. /, \, : - ����������� ��� �������� �����.
     * @return string �����, ���������� � ���������� ������ �������.
     */
    public function render($name, $absolute = false)
    {
        if ($absolute)
        {
            $this->_fileFILEfile_ = $name;
            if (!is_readable($this->_fileFILEfile_)) 
            {
                $message = "script '$name' not found";
                throw new Dune_Exception_Base($message);
            }
        }
        else 
        {
    	   $name = str_replace(array('/', '\\', ':'), DIRECTORY_SEPARATOR, $name) . '.php';
           $this->_fileFILEfile_ = $this->_script($name);
        }
        unset($name); // remove $name from local scope
        unset($absolute); // remove $name from local scope
        
        ob_start();
        include($this->_fileFILEfile_);
        return ob_get_clean();
    }
    
    
    /**
     * ������������ ����������� ���������� ��� ����.
     *
     * @param string $spec
     * @param mixed $value
     */
    public function assignGlobal($spec, $value = null)
    {
        if (key_exists($spec, self::$_parametersSsSsS_))
        {
            throw new Dune_Exception_Base('��������� ������������� ���������� ����������');
        }
        self::$_parametersSsSsS_[$spec] = $value;
    }
    
    /**
     * ����������/������ ������������� ����������(���������) ����������.
     *
     * @param unknown_type $value
     */
    protected function useGlobal($value = false)
    {
        $this->_useParametersSsSsS_ = $value;
    }
    
    
    /**
     * Finds a view script from the available directories.
     *
     * @param $name string The base name of the script.
     * @return void
     */
    protected function _script($name)
    {
        $fname = self::$scriptPath . '/' . $name;
        if (is_readable($fname)) 
        {
            return $fname;
        }

        $message = "script '$name' not found in path ("
                 . self::$scriptPath
                 . ")";
        throw new Dune_Exception_Base($message);
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
     * @throws Dune_Exception_Base if an attempt to set a private or protected
     * member is detected
     */
    public function __set($key, $val)
    {
        if ('_' != substr($key, 0, 1))
        {
            $this->_parametersUuUuU_[$key] = $val;
            return;
        }
        throw new Dune_Exception_Base('Setting private or protected class members is not allowed');
    }
    
    /**
     * ������� ���������� ����������.
     *
     * @return mixed
     */
    protected function getGlobal($key)
    {
        if (isset(self::$_parametersSsSsS_[$key]))
            return self::$_parametersSsSsS_[$key];
        return null;
    }
    
    /**
     * Prevent E_NOTICE for nonexistent values
     *
     * If {@link strictVars()} is on, raises a notice.
     *
     * @param  string $key
     * @return mixed
     */
    public function __get($key)
    {
/* ������������ ������ - ��������������� �������������.
        if (isset($this->_lockedKeys[$key]))
            return $this->_lockedKeys[$key];
*/
        if ($this->_useParametersSsSsS_)
        {
             if (isset(self::$_parametersSsSsS_[$key]))
                return self::$_parametersSsSsS_[$key];
            return null;
        }
        else
        {
             if (isset($this->_parametersUuUuU_[$key]))
                return $this->_parametersUuUuU_[$key];
            return null;
        }
    }
    
    /**
     * Enter description here...
     *
     * @param string $spec
     * @param mixed $value
     * @return Dune_View
     */
    public function assign($spec, $value = null)
    {
//        $this->__set($spec, $value);
        if (is_array($spec))
        {
            foreach ($spec as $key => $val)
            {
                $this->__set($key, $val);
            }
        }
        else 
            $this->__set($spec, $value);

        return $this;
    }
    

    
    /**
     * ������� ��� ��������� ����������� ������ ������.
     * !!! ����� ���������� ��������� ���� �����.
     * ������ ��������� �������.
     *
     * @param string $name
     * @param mixed $value
     * @return Dune_View
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
    
    public function __toString()
    {
    	$string = '';
    	ob_start();
    	
    	?>
���������� ������:
================================
<?php

    	print_r(self::$_parametersSsSsS_);
    	

    	?>
��������� ������:
================================
<?php
    	print_r($this->_parametersUuUuU_);

    	
    	?>
������:
================================
$this->getGlobal($key) - ���������� ���������� ����������
$this->useGlobal($value = false) - ��������� ����� �������� ���������� ���������� ����� ���������� ����� __get($key)
$this->setResult($name, $value) - ��������� ����������� ��� �������� �� ����.
<?php
    	
    	
    	$string = ob_get_clean();
    	return  '<pre>' . $string . '</pre>';
    }
    
    
}
