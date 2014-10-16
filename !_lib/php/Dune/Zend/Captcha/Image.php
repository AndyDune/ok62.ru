<?php

 /**
 * ��������� Zend_Captcha_Image.
 * ���� � ������ �������� � ������� ����������� �������������� ��� �������� �������. ������ �� ������ Dune_Patameters.
 * ������������ � ����� ������������� �������� ������ � �������� � Zend.
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Image.php                                   |
 * | � ����������: Dune/Zend/Captcha/Image.php         |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 1.00                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * 
 * ������� ������:
 * -----------------
 */


class Dune_Zend_Captcha_Image extends Zend_Captcha_Image
{

    protected $imagePathDisplay;
    
    public function __construct($array = null)
    {
        parent::__construct($array);
        $path = '/' . Dune_Parameters::$captchaPath . '/';
        $this->setFont(Dune_Parameters::$fontsDirectory . '/' . Dune_Parameters::$captchaFont);
        $this->setImgDir($_SERVER['DOCUMENT_ROOT'] . $path);
        $this->setImgUrl($path);
        $this->imagePathDisplay = $path;
    }
    
    /**
     * ������� ������ �� ��������.
     *
     * @return string
     */
    public function getImageLink()
    {
        return $this->imagePathDisplay . $this->getId() . $this->getSuffix();
    }

    /**
     * Set captcha word
     * ���������� ������ � �������� �� ZF.
     *
     * @param  string $word
     * @return Zend_Captcha_Word
     */
    protected function _setWord($word)
    {
        $this->_word   = $word;
        return $this;
    }

    /**
     * Get captcha word
     * ���������� ������ � �������� �� ZF.
     *
     * @return string
     */
    public function getWord()
    {
        if (empty($this->_word))
        {
            $this->_word = false;
        }
        return $this->_word;
    }
    
}
