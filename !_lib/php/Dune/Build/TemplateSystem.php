<?php
/**
 * ����� ��� ������ � ������-�������� ��������. ����������� � ������������ ����� ������������.
 * 
 * ������� � ������ �������� ������ ���� <!--%����%--> �������� ���� �� ������.
 * 
 * ���������� ������:
 * Dune_Exception_Base
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: TemplateSystem.php                          |
 * | � ����������: Dune/Build/TemplateSystem.php       |
 * | �����: ������ ����� (Dune) <dune@rznlf.ru>        |
 * | ������: 1.03                                      |
 * | ����: www.rznlf.ru                                |
 * ----------------------------------------------------
 * 
 * 
 * ������� ������:
 * -----------------
 * 
 * ������ 1.02 -> 1.03
 * Dune_Parameters::$templateSpace ������ Dune_Parameters::$templateRalization
 * 
 * ������ 1.01 -> 1.02
 * !! ��������� ��� ������ � ������: {����}
 * ������� ������� leaveKeys - ��������� �������� � ����� ����� � ����������� ������������. �� ��������� �������
 * !! � ������ ������ ������������ ���� {head} � {body}
 * 
 * ������ 1.00 -> 1.01
 * ������������� �������� ������ ������.
 * 
 */
class Dune_Build_TemplateSystem
{
    /**
     * ���� � �����-�������
     *
     * @var string
     */
    private $path;
    
    /**
     * �������������� ����� ��������
     *
     * @var string
     */
    private $template;


      /**
     * @var boolean
     */
    private $madeNot = true;

    
    /**
     * ������ � ������� ��� ������
     *
     * @var string
     */
    private $keysArray = array();
    private $valueArray = array();
    
    private $headText = '';
    private $headTextAdd = '';
    
    private $bodyText = '';
    
    
    private $_leaveKeys = false;

    /**
     * �����������.
     * $name - ��� �����-������� ��� ����������. ����� ������������ ��������: folder1/file (folder1/folder2/file)
     * $name - ���� �������. ��� ��� ���� �������� $like_string = true
     * 
     * ���������� ���� ����� �� ����������.
     *
     * @param string $name ��� �����-������� ���� ����� ��� ���������
     * @param boolean $like_string ��������� true ���� $name - �����
     */
    public function __construct($name = 'page', $like_string = false)
    {
        if ($like_string)
        {
            $this->template = $name;
        }
        else 
        {
            $this->path = Dune_Parameters::$templatesPath. '/' . Dune_Parameters::$templateSpace . '/' . $name . '.tpl';
            if (!is_file($this->path))
            {
                throw new Dune_Exception_Base('������ ���� � ��������������� �����-�������: '.$this->path);
            }
            $this->template = file_get_contents($this->path);
            if (!$this->template)
            {
                throw new Dune_Exception_Base('�� ������� ������� ����-������.');
            }
        }
    }
    
    
    /**
     * �������� ���� � ������� �� ���������� ��������.
     * 
     * � ������� ������ ������������ ����, ����� ����� ����������.
     * 
     * ���� � ������� ����� ���: {����}. ������� ���������.
     * ��� �������� ��������������� ��������� specialchars = true ����� �������������� �������� htmlspecialchars()
     *
     * @param string $key ���� ��� ������ � �������
     * @param string $value �������� ��� ������
     * @param boolean $specialchars �������� ����������� ����. ������� html
     */
    public function assign($key, $value, $specialchars = false)
    {
        $bool = true;
        if ($specialchars)
        {
            $value = htmlspecialchars($value);
        }
        $this->keysArray[$key] = $value;
        return true;
    }
    
    /**
     * ���������� ������ ���� ������
     *
     * @return array ������ ������ � �������
     */
    public function getKeys()
    {
        $array = array();
        preg_match_all('|\{([-_a-zA-Z0-9]+)\}|i', $this->template, $array);
        //unset($array[0]);
        return $array[1];
    }
    /**
     * ������������� ����� ��������� ��������.
     * ������� ������ � ������� �� ���������.
     * � ������ ����������� ������� htmlspecialchars()
     * ����-��� ����������� ��������������� ����� ��������� ����� head (</head>)
     *
     * @param string $value ����� title
     */
    public function setTitle($value)
    {
        $value = htmlspecialchars($value);
        $this->headText .= '<title>'.$value.'</title>';
    }
    
    /**
     * ������������� ����� �������� ���� ��������.
     * ������� ������ � ������� �� ���������.
     * � ������ ����������� ������� htmlspecialchars()
     * ����-��� ����������� ��������������� ����� ��������� ����� head (</head>)
     *
     * @param string $value ����� keywords
     */
    public function setKeywords($value)
    {
        $value = htmlspecialchars($value);
        $this->headText .= '<meta name="keywords" content="'.$value.'" />';
    }  

    /**
     * ������������� ����� �������� ��������.
     * ������� ������ � ������� �� ���������.
     * � ������ ����������� ������� htmlspecialchars()
     * ����-��� ����������� ��������������� ����� ��������� ����� head (</head>)
     *
     * @param string $value ����� description
     */
    public function setDescription($value)
    {
        $value = htmlspecialchars($value);
        $this->headText .= '<meta name="description" content="'.$value.'" />';
    }
    /**
     * ���������� ������ � ���� head(������ �� ������� css, ����� JS � ������)
     * � ������ �� ����������� ������� htmlspecialchars()
     *
     * @param string $value
     */
    public function addToHead($value)
    {
        $this->headTextAdd .= $value;
    }    

    
    /**
     * ���������� ������ � ���� body. ����� ����������� �����.
     * � ������ �� ����������� ������� htmlspecialchars()
     *
     * @param string $value
     */
    public function addToBody($value)
    {
        $this->bodyText .= $value;
    }    
    
    /**
     * ������ ��������
     *
     */
    public function display()
    {
        echo $this->make();
    }
    
    /**
     * ���������� ������� ����� ��������
     *
     */
    public function get()
    {
        return $this->make();
    }

    
    /**
     * ��������� �������� � ����� ����� � ����������� ������������.
     * �� ��������� �������
     *
     * @param boolean $bool 
     */
    public function leaveKeys($bool = true)
    {
        $this->_leaveKeys = $bool;
    }
    
////////////////////////////////////////////////////////////////
///////////////////////////////     ���������� ������

    public function __toString()
    {
        return $this->make();
    }
    
////////////////////////////////////////////////////////////////
///////////////////////////////     ���������� ������ ������

	protected function findMacro($sub)
	{
	    if ($this->_leaveKeys)
	       $key = '{' . $sub . '}';
	    else 
	       $key = '';
		return array_key_exists($sub, $this->keysArray) ? $this->keysArray[$sub] : $key;
	}
	
	
    protected function make()
    {
        if ($this->madeNot)
        {

           	$this->keysArray['head'] = $this->headText . $this->headTextAdd;
          
            $this->keysArray['body'] = $this->bodyText;
/*
            $count = 0;
            $this->template = str_ireplace(array_keys($this->keysArray),
                                           array_values($this->keysArray),
                                           $this->template,
                                           $count);
*/          
            $this->template = preg_replace("/\{([^}]+)\}/e", "\$this->findMacro('\\1')", $this->template);
            //$this->template = $text;
            
            $this->madeNot = false;
        }
        return $this->template;
    }
}