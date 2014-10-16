<?php
/**
 * 
 * ���� ����������� ������������ ��������� ���� � ������� �����.
 * 
 * �������� ������������� ��������� � ���������� ACCEPT.
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: InputFile.php                               |
 * | � ����������: Dune/Form/InputFile.php             |
 * | �����: ������ ����� (Dune) <dune@rznlf.ru>        |
 * | ������: 1.00                                      |
 * | ����: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * ������� ������:
 *
 * ������ 1.00 -> 1.01
 * 
 * 
 */
class Dune_Form_InputFile extends Dune_Form_Parent_InputSetClassId
{
    /**
     * ������ ��������� �������
     *
     * @var string
     * @access private
     */
    protected $_string = '<input type="file">';

    /**
     * ������ ����������� ��������� �������
     *
     * @var string
     * @access private
     */
    protected $_value = '';

    const MINE_JPEG = 'image/jpeg';
    const MINE_GIF = 'image/gif';
    const MINE_PNG = 'image/png';
    const MINE_TXT = 'text/plain';
    
    /**
     * ����������� ��������� ��� ��������� �������.
     *
     * @param string $name ��� ��������� �������
     */
    public function __construct($name)
    {
        $this->_string = str_replace('>', ' name="' . $name . '">', $this->_string);
    }
    

    /**
     * ���������� ������ ���� � ��������.
     *
     * @param integer $size
     */
    public function setSize($size)
    {
        $this->_string = str_replace('>', ' size="' . $size . '">', $this->_string);
    }
    
    
    /**
     * �������������� ��� �����.
     * ���������� ��������� ������ ��������������� ��������� ������
     *
     * @param string $accept
     */
    public function setAccept($accept = self::MINE_JPEG)
    {
        $this->_string = str_replace('>', ' accept="' . $accept . '">', $this->_string);
    }

}