<?php
 /**
 * ����������� �����. ��������� ������ � ���������� ��� ������������ ��������� ����, ������������� � �������� ������.
 * � �������� ������ ������������ ������ ������� ��� � ������ code().
 *
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Class.php                                   |
 * | � ����������: Dune/Include/Abstract/Code.php      |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 1.03                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * ������� ������:
 * -----------------
 * 
 * 1.03 (2009 ���� 19)
 *  ������� �������� ��� ��������� - null ������ false
 * 
 * 1.02 (2009 ������ 30)
 *  ������� ������ set-������.
 * 
 * 1.01 (2008 ������� 05)
 * !!! ��������� ����������� ����� �����.
 * ��������� ����� ���������� ���� ��������, �� ��������� �� ����� �������.
 * 
 */

abstract class Dune_Include_Abstract_Code
{
    /**
     * �������������� �� ���������� ��� ���������� ���������� ������
     * True - �������� (�� ���������)
     *
     * @var boolean
     */
    public static $isExeption = true;
    
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
    protected $___text121121278273= array();
    
    /**
     * ������ ����������� ������ ������
     *
     * @var array
     * @access private
     */
    protected $results = array();

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
    
    
    public function __construct($parameters = array())
    {
    	$this->____parameters = $parameters;
    }
    
    
    public function make()
    {
      // ���� ���������, ������������ �� ������
      $message_code = array();
      // ������ ��������� ������������ �� ������
      $message_text = array();
      // ������, ������������ �� ������
      $text = array();
      ob_start();
      $this->code();

      $this->____buffer = ob_get_clean();
      return true;
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
    {
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
        return $this->____buffer;
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
        if (key_exists($key, $this->____results))
            return $this->____results[$key];
        else if (!key_exists($key, $this->results))
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
        return $this->____results;
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
         return true;
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
    		return null;
    }
    
    public function __toString()
    {
        return $this->____buffer;
    }
    
    
/////////////////////////////
////////////////////////////////////////////////////////////////
    
    
}