<?php
/**
*   ������������ ����������� ����� ��� ���� ������� ������ � ��������� request
*	����� ��� ������������� � ������������ ����������� ������� ����������
*	����������� ������� $_GET, $_POST, $_COOKIE
* 
* ----------------------------------------------------
* | ����������: Dune                                  |
* | ����: Request.php                                 |
* | � ����������: Dune/Filter/Parent/Request.php      |
* | �����: ������ ����� (Dune) <dune@pochta.ru>       |
* | ������: 1.03                                      |
* | ����: www.rznlf.ru                                |
* ----------------------------------------------------
* 
* 
* ������ 1.02 -> 1.03
* ----------------------
* ��������� ���������� ����������� ��������.
* 
* ������ 1.01 -> 1.02
* ----------------------
*  ��������� ������ �������� ������������� ������������� ���������� ��� ������� ArrayAccess
* 
* ������ 1.00 -> 1.01
* ----------------------
* �������� ������ ArrayAccess � ����������� �������� � ������������
* � ������ �������� ��� ������� ������� '-'
* 
*/

abstract class Dune_Filter_Parent_Request implements ArrayAccess
{

/**
 * 	������� �������� �� 3-� ������� �������� $_GET, $_POST, $_COOKIE
 * ���������:
 *            $get"    => array ("value" => <��������>,
 *                               "empty" => <true, ���� �� ���� �������� ��������, ����������� �� ���������>
 *                              )
 */
protected $get = array("empty"=>true);
 /**
 *             $post   => array ("value" => <��������>,
 *                               "empty" => <true, ���� �� ���� �������� ��������, ����������� �� ���������>
 *                              )
 */
protected $post = array("empty"=>true);  
 /**
 *             $cookie => array ("value" => <��������>,
 *                               "empty" => <true, ���� �� ���� �������� ��������, ����������� �� ���������>
 *                              )
 */
protected $cookie = array("empty"=>true);    
 /**
 *             $prioritet => array ("value" => <��������>,
 *                                  "empty" => <true, ���� �� ���� �������� ��������, ����������� �� ���������>
 *                                 )
 */
protected $prioritet = array("empty"=>true);
/**
 * ���� �������
 * ����������� ��������
 *  d  - �����
 *  pd - ������������� �����
 *  aw - ��������� ������� � "_"
 *  awd - ��������� �������  ����� � "_"
 * @var string
 */
protected $filter;
/**
 * ������ �������� �� ���������
 *
 * @var mixed
 */
protected $defaultValue;

protected function __construct($name,$def = 0,$filter = 'd',$prioritet = 'pg')
{
	$this->filter = $filter;
	$this->defaultValue = $def;
	
	if (!$this->checkFilter()) throw new Exception('����������������� ������ � ����� ��� �������', 2);
	
	$strLen = strlen($prioritet);
	if (!$strLen)
	{
        $this->get['value'] = $def;
        $this->post['value'] = $def;
        $this->cookie['value'] = $def;
        $this->prioritet['value'] = $def;        
	}
	else 
	{
    	for ($pri = 0; $pri < $strLen; $pri++)
    	{
    		if (false === stripos('pgc',$prioritet[$pri])) throw new Exception('����������������� ������ � ������ ����������� ���������� ��������� �������� _GET, _POST, _COOKIE', 1);
            switch ($prioritet[$pri])
            {
                case 'p':
                	if (empty($_POST[$name]))
                		$this->post = array('empty' => true, 'value' => $this->defaultValue);
                	else 
                	{
                    	$this->post = $this->makeFilter(trim($_POST[$name]));
                        $this->prioritet = $this->post;
                	}
                    break;
                case 'g':
                	if (empty($_GET[$name]))
                		$this->get = array('empty' => true, 'value' => $this->defaultValue);
                	else 
                	{
    	                $this->get = $this->makeFilter(trim($_GET[$name]));
                        $this->prioritet = $this->get;
                	}
                break;
                case 'c':
                	if (empty($_COOKIE[$name]))
                		$this->cookie = array('empty' => true, 'value' => $this->defaultValue);
                	else 
                	{
    	                $this->cookie = $this->makeFilter($_COOKIE[$name]);
    				    $this->prioritet = $this->cookie;
                	}
            }
        }
        if (empty($this->prioritet['value']))
            $this->prioritet['value'] = $this->defaultValue;
	}		
}

// �������� �� ������������ ����� ������� �����������������
protected function checkFilter()
{
	$keyArray = array('d','pd','aw','awd','no');
	return in_array($this->filter, $keyArray);
}
// �������� �� ������������ ����� ������� �����������������
protected function makeFilter($value)
{
    switch ($this->filter)
    {
        case 'no':
        	$array['empty'] = false;
        	$array['value'] = $value;
        break;
        
        case 'd':
        	$array['empty'] = false;
        	$array['value'] = (int)$value;
        break;
        case 'pd':
        	$array['empty'] = false;
        	$array['value'] = (int)$value;
        	if ($array['value'] < 0)
        		$array['value'] = 0;
        break;
        case 'aw':
            return $this->checkSymbols($value);
        break;
        case 'awd':
            return $this->checkSymbolsDigits($value);
        break;
        
    }
    return $array;
}
protected function checkSymbols($value)
{
    $res = preg_replace('|[^a-zA-Z_-]|i','',$value);
    if(($res == ''))
    {
         $array['value'] = $this->defaultValue;
         $array['empty'] = true;
    }
    else
    {
        $array['value'] = $res;
        $array['empty'] = false;        
    }
	return $array;
}
protected function checkSymbolsDigits($value)
{
    $res = preg_replace('|[^a-zA-Z0-9_-]|i','',$value);
    if(($res == ''))
    {
         $array['value'] = $this->defaultValue;
         $array['empty'] = true;
    }
    else
    {
        $array['value'] = $res;
        $array['empty'] = false;        
    }
	return $array;
}

public function getValue()
{
	return $this->prioritet['value'];
}
public function haveValue()
{
	return !$this->prioritet['empty'];
}
public function getPost()
{
	return $this->post['value'];
}
public function havePost()
{
	return !$this->post['empty'];
}
public function getGet()
{
	return $this->get['value'];
}
public function haveGet()
{
	return !$this->get['empty'];
}

////////////////////////////////////////////////////////////////
///////////////////////////////     ������ ���������� ArrayAccess
    public function offsetExists($key)
    {
        switch ($key)
        {
            case 'get' :
                return !$this->get['empty'];
            break;
            case 'post' :
                return !$this->post['empty'];
            break;
            case 'cookie' :
                return !$this->cookie['empty'];
            break;
            default :
                return !$this->prioritet['empty'];
            break;
            
        }
    }
    public function offsetGet($key)
    {
        switch ($key)
        {
            case 'get' :
                return $this->get['value'];
            break;
            case 'post' :
                return $this->post['value'];
            break;
            case 'cookie' :
                return $this->post['value'];
            break;
            default:
                return $this->prioritet['value'];
            break;
        }
    }
    public function offsetSet($key, $value)
    {
        throw new Exception('��������� ������ �������� ����� ������������� ����������');
/*        switch ($key)
        {
            case 'get' :
                $this->get['value'] = $value;
            break;
            case 'post' :
                $this->post['value'] = $value;
            break;
            case 'cookie' :
                $this->post['value'] = $value;
            break;
            default :
                $this->prioritet['value'] = $value;
            break;
        }
*/ 
    }
    public function offsetUnset($key)
    {
        switch ($key)
        {
            case 'get' :
                $this->get['value'] = $this->defaultValue;
            break;
            case 'post' :
                $this->post['value'] = $this->defaultValue;
            break;
            case 'cookie' :
                $this->post['value'] = $this->defaultValue;
            break;
            default :
                $this->prioritet['value'] = $this->defaultValue;
            break;
        }
    }

/////////////////////////////
////////////////////////////////////////////////////////////////

}