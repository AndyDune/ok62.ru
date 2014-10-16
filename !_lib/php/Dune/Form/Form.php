<?php
/**
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Form.php                                    |
 * | � ����������: Dune/Form/Form.php                  |
 * | �����: ������ ����� (Dune) <dune@rznlf.ru>        |
 * | ������: 1.01                                      |
 * | ����: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * ������� ������:
 *
 * ������ 1.00 -> 1.01
 * ��������� ENCTYPE_MULTI
 * �� �������� ����������.
 * 
 * 
 */
class Dune_Form_Form
{
    /**
     * ������ �����
     *
     * @var string
     * @access private
     */
    protected $formString = '<form>';
    
    /**
     * ���� ���������� ������������ ��������� �����
     *
     * @access private
     */
    protected $ready = false;
    
    const TARGET_SELF = '_self';
    const TARGET_PARENT = '_parent';
    const TARGET_TOP = '_top';
    const TARGET_BLANK = '_blank';
    
    const METHOD_GET = 'get';
    const METHOD_POST = 'post';
    
    const ENCTYPE_DEFAULT = 'application/x-www-form-urlencoded';
    const ENCTYPE_MULTI = 'multipart/form-data';

    /**
     * ����������� ��������� ��� �����.
     * ��� ����� �������� ���� ���� ���������.
     * ����� ����� �� �����������.
     *
     * @param string $name ��� �����, ����� �� �����������, ����� �� �����������
     */
    public function __construct($name = '')
    {
        if ($name)
            $this->formString = str_replace('>', ' name="' . $name . '">', $this->formString);
    }
    
    /**
     * ���������� ������ �������� ����������� �����.
     * ���������� ��������� ������ ��������������� ��������� ������
     *
     * @param string $method
     */
    public function setMethod($method = self::METHOD_POST)
    {
        $this->formString = str_replace('>', ' method="' . $method . '">', $this->formString);
    }
    
    /**
     * ������������ ��������. ���������� URL, �� �������� ����� ���������� ���������� �����.
     *
     * @param string $method
     */
    public function setAction($action)
    {
        $this->ready = true;
        $this->formString = str_replace('>', ' action="' . $action . '">', $this->formString);
    }
    
    /**
     * ���������� ��� ����, � ������� ������������ ��������� ��������� ������������ �����.
     * ���������� ��������� ������ ��������������� ��������� ������
     *
     * @param string $method
     */
    public function setTarget($target = self::TARGET_SELF)
    {
        $this->formString = str_replace('>', ' target="' . $target . '">', $this->formString);
    }
    
    /**
     * ���������� ������ ����������� ����������� ����� ��� ��������.
     * ���������� ��������� ������ ��������������� ��������� ������
     *
     * @param string $method
     */
    public function setEnctype($enctype = self::ENCTYPE_DEFAULT)
    {
        $this->formString = str_replace('>', ' enctype="' . $enctype . '">', $this->formString);
    }
    
    
    
    /**
     * ���������� ID ��� �����
     *
     * @param string $id
     */
    public function setId($id)
    {
        $this->formString = str_replace('>', ' id="' . $id . '">', $this->formString);
    }
    
    /**
     * ���������� ������ - ������ �����.
     *
     * @return sting
     */
    public function get()
    {
//        if (!$this->ready)
//            throw new Dune_Exception_Base('�� ��������� ������������ �������� �����');
        return $this->formString;
    }
    
    /**
     * ������ ������� get()
     *
     * @return sting
     */
    public function getBegin()
    {
//        if (!$this->ready)
//            throw new Dune_Exception_Base('�� ��������� ������������ �������� �����');
        return $this->formString;
    }
            
    /**
     * ���������� </form>
     *
     * @return sting
     */
    public function getEnd()
    {
        return '</form>';
    }
    
}