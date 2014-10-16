<?php
/**
 * Dune Framework
 * 
 * ��������� �������� ����� checkbox, ��������� � �����.
 * �������� ������� �� �������� ������������ ��������.
 * 
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: InputCheckBox.php                           |
 * | � ����������: Dune/Form/Handle/InputCheckBox.php  |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 0.90                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * ������� ������:
 *
 * ������ 0.90 (2008 ������ 06)
 * ������ ��������������������, �� ��� �������� � �������.
 * 
 * 
 */
class Dune_Form_Handle_CheckBox implements Iterator, Countable
{
    protected $_source = array();
    protected $_results = array();
    
    protected $_notAllowEmptyString = true;
    protected $_useTrim = false;
    
    public function __construct($array)
    {
        $this->_source = $array;
    }
    
    /**
     * ��� ������� �������� ����� ������� ������ ������ ������� ���:
     * $value = false - �� ������������� ��������
     * $value = true  - ������������� ��������
     * �� ��������� �� ������������.
     * 
     * 
     * @param boolean $value
     */
    public function allowEmptyString($value = false)
    {
        $this->_notAllowEmptyString = !$value;
    }

    /**
     * ������������ ������� trim() ����� ��������.
     * �� ��������� - �� ������������.
     *
     * @param boolean $value
     */
    public function useTrim($value = false)
    {
        $this->_useTrim = $value;
    }
    
    public function assign($key, $value_if_not_set = 0, $value_if_set = null)
    {
        if (is_array($key))
        {
            
        }
        else 
        {
            if (isset($this->_source[$key]))
            {
                if ($this->_useTrim)
                    $value = trim($this->_source[$key]);
                else 
                    $value = $this->_source[$key];
                    
                if ($value == '' and $this->_notAllowEmptyString)
                    $this->_results[$key] = $value_if_not_set;
                else if (!is_null($value_if_set))
                    $this->_results[$key] = $value_if_set;
                else 
                {
                    $this->_results[$key] = $value;
                }
            }
            else 
            {
                $this->_results[$key] = $value_if_not_set;
            }
        }
    }
    
    public function getResults()
    {
        return $this->_results;
    }
    
    
	/**
	 * ���������� ����������� ��������� �������
	 * ��������� ��������� Countable
	 * 
	 * @return integer
	 */
	public function count()
	{
		return count($this->_array);
	}
    
	
    public function __toString()
    {
    	$string = '<pre>';
    	ob_start();
    	print_r($this->_results);
    	$string .= ob_get_clean();
    	return  '</pre>' . $string;
    }
	
    
    ////////////////////////////////////////////////////////////////
///////////////////////////////     ������ ���������� Iterator
  // ������������� �������� �� ������ �������
  public function rewind()
  {
        return reset($this->_results);
  }
  // ���������� ������� �������
  public function current()
  {
      return current($this->_results);
  }
  // ���������� ���� �������� ��������
  public function key()
  {
    return key($this->_results);
  }
  
  // ��������� � ���������� ��������
  public function next()
  {
    return next($this->_results);
  }
  // ���������, ���������� �� ������� ������� ����� ���������� ������ rewind ��� next
  public function valid()
  {
    return isset($this->_results[key($this->_results)]);
  }    
/////////////////////////////
////////////////////////////////////////////////////////////////   
    
    
}