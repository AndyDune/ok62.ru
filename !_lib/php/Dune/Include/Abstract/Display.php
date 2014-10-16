<?php
 /**
 * ����������� �����. ��������� ������ � ���������� ��� ������������ ��������� ����, ������������� � �������� ������.
 * � �������� ������ ������������ ������ ������� ��� � ������ code().
 *
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Display.php                                 |
 * | � ����������: Dune/Include/Abstract/Display.php   |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 1.02                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * ������� ������:
 * -----------------
 * 
 * 1.02 (2008 ���� 25)
 * ����� assign() ��������� �������.
 * ������������� ������ � ������� � �������� ����� ��������� �������.
 * ����������� ������� ��������� � ������� $______styles.
 *
 * 1.01 (2008 ���� 20)
 * ��������� ���������� self::$viewfiles - ���� � ����� � ������� �����.
 *
 * 1.00 (2008 ���� 18)
 * ��������.
 * ����� ���� render() - ������ make()
 * ����������� ������������ ������ ������ � ��������.
 * 
 * 0.99 (2008 ������ 29)
 * ���������. �� ���������.
 * 
 */

abstract class Dune_Include_Abstract_Display
{
    /**
     * �������������� �� ���������� ��� ���������� �������������� ����������.
     * True - �������� (�� ���������)
     *
     * @var boolean
     */
    public static $isExeption = true;
    
    public static $viewfiles = '';

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
     * ������ ����������� ������ ������ �����
     *
     * @var array
     * @access private
     */
    protected $____results = array();
    
    
    /**
     * ����� ������ ������ ���������� �� �������
     *
     * @var string
     * @access private
     */
    protected $____buffer = '';
    
    
    /**
     * ������ ������� ����������� ������.
     *
     * @var array
     * @access private
     */
    protected $____parameters = array();
    
    
    /**
     * ������ ���������� ��� ����. �����������.
     *
     * @var array
     * @access private
     */
    protected static $_____parametersSsSsS_ = array();
    
    /**
     * ���� � ������� ���������� ���������� �� ����.
     *
     * @var array
     * @access private
     */
    protected $_____useParametersSsSsS_ = false;
    
    
    
    /**
     * ������������ �����
     *
     * @var array
     * @access private
     */
    protected $______styles = array(
                                   );
    
                                   
    /**
     * ������������ �������
     *
     * @var array
     */
    protected $______scripts = array(
                                   );

    
    public function __construct($parameters = array())
    {
    	$this->____parameters = $parameters;
    }
    
    
    /**
     * ������������ ����������� ���������� ��� ����.
     *
     * @param string $spec
     * @param mixed $value
     */
    public function assignGlobal($spec, $value = null)
    {
        if (key_exists($spec, self::$______parametersSsSsS_))
        {
            throw new Dune_Exception_Base('��������� ������������� ���������� ����������');
        }
        self::$_____parametersSsSsS_[$spec] = $value;
    }
    
    /**
     * ����������/������ ������������� ����������(���������) ����������.
     *
     * @param unknown_type $value
     */
    protected function useGlobal($value = false)
    {
        $this->_____useParametersSsSsS_ = $value;
    }
    
    /**
     * ������� ���������� ����������.
     *
     * @return mixed
     */
    protected function getGlobal($key)
    {
        if (isset(self::$_parametersSsSsS_[$key]))
            return self::$_____parametersSsSsS_[$key];
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
        if ($this->_____useParametersSsSsS_)
        {
             if (isset(self::$_____parametersSsSsS_[$key]))
                return self::$_____parametersSsSsS_[$key];
            return null;
        }
        else
        {
        	if (isset($this->____parameters[$key]))
        		return $this->____parameters[$key];
            return null;
        }
    }
    
    /**
     * ���������������� ����������.
     *
     * @param string $spec
     * @param mixed $value
     * @return Dune_View
     */
    public function assign($spec, $value = null)
    {
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
     * ������ �������. ������� ����������. ������ render()
     *
     * @return string
     */
    public function make()
    {
      return $this->render();
    }

    /**
     * ������ �������. ������� ����������.
     *
     * @return string
     */
    public function render()
    {
      ob_start();
      
      if (!self::$viewfiles)
          self::$viewfiles = '/viewfiles/' . Dune_Parameters::$templateSpace . '/' . Dune_Parameters::$templateRealization . '/';

      foreach ($this->______styles as $value)
      {
          if (is_array($value))
          { 
              Dune_Static_StylesList::add($value[0], $value[1]);
          }
          else 
          { 
              Dune_Static_StylesList::add($value);
          }
      }
      foreach ($this->______scripts as $value)
      {
          Dune_Static_JavaScriptsList::add($value);
      }
      
      $this->code(); 
      return $this->____buffer = ob_get_clean();
    }
    
    
    protected function code()
    {
        // �������� ������� ��� ������. ������������ � ��������.
        
        
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
        $this->____results[$name] = $value;
        return $this;
    }
    

    /**
     * ������� ���������� ������ ����������� ������ �������
     *
     * @return string
     */
    public function getOutput()
    {
        return $this->____buffer;
    }
   
     /**
     * ���������� ��������� � ��������� �������.
     * ������� ���������� ��� ���������� �����.
     *
     * @param mixed $key ���� ��� ��������, ��������������� � �����������. ���� �� ������ - ������� ������ �������.
     * @return string
     */
    public function getResult($key)
    {
        if (key_exists($key, $this->____results))
            return $this->____results[$key];
        if (self::$isExeption)
           throw new Dune_Exception_Base('��� �������������� ����������.');
        return null;
    }

     /**
     * ���������� ����� ������ �����������.
     *
     * @return string
     */
    public function getResults()
    {
        return $this->____results;
    }
    
    
     /**
     * ���������� ��������� ���� ������.
     * ��� false ���� ����� ������ ���.
     *
     * @return string
     */
    public function help()
    {
         return true;
    }
    
////////////////////////////////////////////////////////////////
///////////////////////////////     ���������� ������
    public function __set($name, $value)
    {
    	$this->____parameters[$name] = $value;
    }
    
    public function __toString()
    {
        return $this->____buffer;
    }
    
    
/////////////////////////////
////////////////////////////////////////////////////////////////
    
    
}