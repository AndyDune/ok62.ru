<?php
/**
 * ����� ��� ������ � ������-�������� ��������
 * 
 * ������� � ������ �������� ������ ���� <!--%����%--> �������� ���� �� ������.
 * 
 * ���������� ������:
 * Dune_Exception_Base
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Template.php                                |
 * | � ����������: Dune/Build/Template.php             |
 * | �����: ������ ����� (Dune) <dune@rznlf.ru>        |
 * | ������: 1.02                                      |
 * | ����: www.rznlf.ru                                |
 * ----------------------------------------------------
 * 
 * 
 * ������� ������:
 * -----------------
 * ������ 1.01 -> 1.02
 * �������� �����: addToBody($value) - ��������� ����� � ����
 * 
 * ������ 1.00 -> 1.01
 * �������� �����: get() - ���������� ����� ��������
 * �������� �����: getKeys() - ���������� ������ ������ � �������
 * 
 */
class Dune_Build_Template
{
    /**
     * ���� ��������� ����������
     *
     * @var boolean
     */
    private $exeption = false;
    
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
    
    public function __construct($path, $like_string = false)
    {
        if ($like_string)
        {
            $this->template = $path;
        }
        else 
        {
            if (!is_file($path))
            {
                throw new Dune_Exception_Base('������ ���� � ��������������� �����-�������: '.$path);
            }
            $this->path = $path;
            $this->template = file_get_contents($path);
            if (!$this->template)
            {
                throw new Dune_Exception_Base('�� ������� ������� ����-������.');
            }
        }
    }
    
    /**
     * ��������/��������� ��������� ���������� ��� ���������� �������� �����
     *
     * @param boolean $bool
     */
    public function setExeption($bool = true)
    {
        $this->exeption = $bool;
    }
    
    /**
     * �������� ���� � ������� �� ���������� ��������.
     * 
     * � ������� ������ ������������ ����, ����� ����� ����������.
     * 
     * ���� � ������� ����� ���: <!--%����%-->. ������� ���������.
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
        $count = 0;
        $this->template = str_ireplace('<!--%'.$key.'%-->',
                                       $value,
                                       $this->template,
                                       $count);
        if (!$count)
        {
            if ($this->exeption)
                throw new Dune_Exception_Base('��������� ����: '.$key.' �� ������ � �������.');
            else
                return false;
        }
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
        preg_match_all('|<!--%([-_a-zA-Z0-9]+)%-->|i', $this->template, $array);
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
        $count = 0;
        $this->template = str_ireplace('</head>',
                                       '<title>'.$value.'</title></head>',
                                       $this->template,
                                       $count);
        if (!$count)
        {
            throw new Dune_Exception_Base('������ ���������� ����-���� title.');
        }
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
        $count = 0;
        $this->template = str_ireplace('</head>',
                                       '<meta name="keywords" content="'.$value.'" /></head>',
                                       $this->template,
                                       $count);
        if (!$count)
        {
            throw new Dune_Exception_Base('������ ���������� ����-���� keywords.');
        }
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
        $count = 0;
        $this->template = str_ireplace('</head>',
                                       '<meta name="description" content="'.$value.'" /></head>',
                                       $this->template,
                                       $count);
        if (!$count)
        {
            throw new Dune_Exception_Base('������ ���������� ����-���� keywords.');
        }
    }
    /**
     * ���������� ������ � ���� head(������ �� ������� css, ����� JS � ������)
     * � ������ �� ����������� ������� htmlspecialchars()
     *
     * @param string $value
     */
    public function addToHead($value)
    {
        $count = 0;
        $this->template = str_ireplace('</head>',
                                       $value.'</head>',
                                       $this->template,
                                       $count);
        if (!$count)
        {
            throw new Dune_Exception_Base('������ ���������� ������ � ����� ��������.');
        }
    }    

    
    /**
     * ���������� ������ � ���� body. ����� ����������� �����.
     * � ������ �� ����������� ������� htmlspecialchars()
     *
     * @param string $value
     */
    public function addToBody($value)
    {
        $count = 0;
        $this->template = str_ireplace('</body>',
                                       $value.'</body>',
                                       $this->template,
                                       $count);
        if (!$count)
        {
            if ($this->exeption)
                throw new Dune_Exception_Base('������ ���������� ������ � ���� ��������.');
            else
                return false;
        }
    }    
    
    /**
     * ������ ��������
     *
     */
    public function display()
    {
        echo $this->template;
    }
    
    /**
     * ���������� ������� ����� ��������
     *
     */
    public function get()
    {
        return $this->template;
    }
    
////////////////////////////////////////////////////////////////
///////////////////////////////     ���������� ������

    public function __toString()
    {
        return $this->template;
    }
}