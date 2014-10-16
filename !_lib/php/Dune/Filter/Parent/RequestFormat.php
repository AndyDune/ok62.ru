<?php
/**
*   ������������ ����������� ����� ��� ���� ������� ������ � ��������� request
*	����� ��� ������������� � ������������ ����������� ������� ����������
*	����������� ������� $_GET, $_POST, $_COOKIE
* 
* ----------------------------------------------------
* | ����������: Dune                                    |
* | ����: RequestFormat.php                             |
* | � ����������: Dune/Filter/Parent/RequestFormat.php  |
* | �����: ������ ����� (Dune) <dune@pochta.ru>         |
* | ������: 1.01                                        |
* | ����: www.rznlf.ru                                  |
* ----------------------------------------------------
* 
*
* ������ 1.00 -> 1.01
* ----------------------
* ���������� ������ � ������ makeFilter($value)
* 
*/

abstract class Dune_Filter_Parent_RequestFormat implements ArrayAccess
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




protected function __construct($name, $def = '', $prioritet = 'pg')
{
	$this->defaultValue = $def;
	
	
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
protected function makeFilter($value)
{
    $array['empty'] = false;
    $array['value'] = $value;
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