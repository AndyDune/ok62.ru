<?php
 /**
  *  Dune Framework
  * 
 *  ���������� ������� ����� ��� ������������ �������� ����������� ������� ������
 *
 * 
 * ������ ������ ������������ ��������� ������� ��� ��������� �������� ������
 *    $massage_code = array() - ���� ���������
 *    $massage_text = array() - ������ ����� ���������
 *    $text = array() - ����������
 * 
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Command.php                                 |
 * | � ����������: Dune/Include/Parent/Command.php     |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 1.11                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * ������� ������:
 * -----------------
 * 
 * 1.11 (2009 ���� 08)
 * � ������ setResult ��� �������� ������� ��������� ������� � ������������. �� ������, ��� ������.
 * 
 * 1.10 (2009 ��� 13)
 * �������� ������� ��������� � ������������ ����� ������� strcmp()
 * 
 * 1.09 (2009 ������ 23)
 * ��� set-������� ����������� ����������� ���������� "�������";
 * 
 * 
 * 1.08 (2008 ������� 18)
 * ���������� ������. ������� ��� ������ ��������.
 * 
 * 1.07 (2008 ������� 05)
 * !!!!!!!!  ������ � ������� ����������� � ���������� ������� ����� ������.
 * 
 * 
 * 1.06 (2008 ������� 24)
 * ��� ����� ������������ �������� ��� ������� - ��������� ����������.
 *
 * 1.04 -> 1.05
 * �������� ���������� ����� __tostring() ����� �� ������ ����������.
 * 
 * 1.03 -> 1.04 (2008 ������� 04)
 * � ������ make() - ���������� ����� ������ �� ������������� ����.
 * 
 * 1.02 -> 1.03 (2008 ������� 02)
 * ������ ���������� ������� �� ��������� - STATUS_PAGE
 * ���� ���� ����������� - STATUS_NO
 * 
 * 1.00 -> 1.02
 * �� ������ make() ������ ������������� ���������� $_folder
 * 
 * 1.00 -> 1.01
 * �������� ������ ���������� ������� make().
 * ��������� ���������� ������ ��� ������� � ���������� �������.
 * 
 */

abstract class Dune_Include_Parent_Command
{
    /**
     * �������������� �� ���������� ��� ���������� ���������� ������
     * True - �������� (�� ���������)
     *
     * @var boolean
     */
    public static $isExeption = false;

    /**
     * ������ ���� � ������������ �����
     *
     * @var string
     * @access private
     */
    protected $fullPath = '';
    
    
    /**
     * ���� ������������� ����� ������
     *
     * @var boolean
     * @access private
     */
    protected $existence = false;
    
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
    protected $results = array();


    /**
     * ������ ��������������� �������. �����.
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
    protected $buffer = '';
    
    /**
     * ������ ������� ����� ����������
     *
     * @var string
     * @access private
     */
//    protected $status = '_page';

    /**
     * ������ ������� ����� ����������. �����.
     *
     * @var string
     * @access private
     */
    protected $____status = '_page';
    
    
    protected $____parameters = array();    
    
//////////////////////////////////////////////////////////////////////////
///////////         �������� ��������
    const STATUS_EXIT = '_exit'; // ����������� ���������� ������� � ��������� �� ��������
    const STATUS_GOTO = '_goto'; // ��������� ������������� � ��������� � �������� ������ �����������
    const STATUS_PAGE = '_page'; // � ���������� ������ ��� ������ ��������
    const STATUS_ARRAY = '_array'; // � ���������� ������ ������
    const STATUS_TEXT = '_text'; // � ���������� ������ ������
    const STATUS_NOACCESS = '_noaccess'; // � ������� ��������
    const STATUS_AJAX = '_ajax'; // � ���������� ������ �����
    
    /**
     * ������� �� �����������
     * 
     * � ������� ������ ��-�� ���������� ����� �������
     *
     */
    const STATUS_NO = '_no';

/////////////////////////////////////////////////////////////////////////
    

    /**
     * ������� ��� ��������� ����������� ������ ������.
     * !!! ����� ���������� ��������� ���� �����.
     * ������ ��������� �������.
     *
     * @param mixed $name_or_array
     * @param mixed $value
     */
    protected function setResult($name_or_array, $value = null)
    {
        if (is_array($name_or_array))
        {
            $this->____results += $name_or_array;
        }
        else 
            $this->____results[$name_or_array] = $value;
        return $this;
    }



	/**
	 * ��������� ����� ��� ����������, ���� �� ����������.
	 *
	 * @return boolean true - ���� ���� ����������, false - �����
	 */
    public function make()
    {
    	if ($this->existence = true)
    	{
    	    ob_start();
            include($this->fullPath);
            $this->buffer = ob_get_clean();     
			return true;    		
    	}
    	else 
    		return false;
    }


    /**
     * ���������� ���� ������������� ����� ������.
     *
     * @return boolean
     */
    public function isExist()
    {
        return $this->existence;
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
     * ���������� ����������� ��������� ���������� �������
     *
     * @return integer
     */
    public function countMessage()
    {
        return count($this->messageCode);
    }
    
    /**
     * ���������� ��� ��������� � ��������� �������.
     * ������� ���������� ��� ���������� �����.
     *
     * @return integer
     */
    public function getMessageCode($num = 0)
    {
        if (!key_exists($num, $this->messageCode))
            throw new Dune_Exception_Base('��� ��������� � ����� �����.');
        return $this->messageCode[$num];
    }

     /**
     * ���������� ����� ��������� � ��������� �������.
     * ������� ���������� ��� ���������� �����.
     *
     * @return string
     */
    public function getMassageText($num = 0)
    {
        if (!key_exists($num, $this->messageText))
            throw new Dune_Exception_Base('��� ��������� � ����� �����.');
        return $this->messageText[$num];
    }
    
    /**
     * ���������� ����������� ��������� ������, ��������������� ��������
     *
     * @return integer
     */
    public function countResults()
    {
        return count($this->____results);
    }
    
     /**
     * ���������� ��������� ���� � ��������� �������.
     * ������� ���������� ��� ���������� �����. ���� ���������� ����.
     * ����� ���������� false
     *
     * @param mixed $num ���� ��� ��������, ��������������� � �����������.
     * @return string
     */
    public function getResult($key = 0)
    {
        if (key_exists($key, $this->____results))
            return $this->____results[$key];
        else if (!key_exists($key, $this->results))
        {
            if ($this->isExeption)
                throw new Dune_Exception_Base('��� ���������� � ����� �����.');
            else 
                return false;
        }
        return $this->results[$key];
    }

     /**
     * ���������� ���� �������������� ������.
     *
     * @return string
     */
    public function getResults()
    {
        if (count($this->____results))
            return $this->____results;
        return $this->results;
    }
    
     /**
     * ���������� ������.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->____status;
    }
     /**
     * ������������� ������.
     *
     * @return string
     */
    public function setStatus($value)
    {
        $this->____status = $value;
        return $this;
    }
    
    
    /**
     * ��������� ������ ���������� ������� � ������������ ������� ��� ������.
     * ���� ��������� - ���������� true. ����� false.
     * 
     * ��������� ������� ��������� ��������� ������.
     *
     * @param string $status
     * @return boolean
     */
    public function checkStatus($status)
    {
        $bool = false;
        if (!strcmp($status, $this->____status))
        {
            $bool = true;
        }
        return $bool;
      }
      
      
    ////////////////////////////////////////////////////////////////
///////////////////////////////     ���������� ������
    public function __set($name, $value)
    {
        if ($name == 'status')     //     !!!!!!!!!!!!!!!       ��������� ��������.
            $this->____status = $value;
        else 
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