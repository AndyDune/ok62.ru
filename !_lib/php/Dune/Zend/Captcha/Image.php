<?php

 /**
 * Наследник Zend_Captcha_Image.
 * Пути к папкам картинок и шриштак указывается автосматически при создании объекта. Данные из класса Dune_Patameters.
 * Заблоктровал к чёрту использование объектов работы с сессиями в Zend.
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Image.php                                   |
 * | В библиотеке: Dune/Zend/Captcha/Image.php         |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.00                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * 
 * История версий:
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
     * Возврат ссылки на картинку.
     *
     * @return string
     */
    public function getImageLink()
    {
        return $this->imagePathDisplay . $this->getId() . $this->getSuffix();
    }

    /**
     * Set captcha word
     * Блокировка работы с сессиями из ZF.
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
     * Блокировка работы с сессиями из ZF.
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
