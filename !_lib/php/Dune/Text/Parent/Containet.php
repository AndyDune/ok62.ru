<?php
/**
*   –одительский абстрактный класс дл€ р€да классов работы с текстом
* 
* ---------------------------------------------------------
* | Ѕиблиотека: Dune                                       |
* | ‘айл: Containet.php                                    |
* | ¬ библиотеке: Dune/Text/Parent/Containet.php           |
* | јвтор: јндрей –ыжов (Dune) <dune@pochta.ru>            |
* | ¬ерси€: 1.00                                           |
* | —айт: www.rznlf.ru                                     |
* ---------------------------------------------------------
* 
*
* ¬ерси€ 1.00 -> 1.01
* ----------------------
* 
*/

abstract class Dune_Text_Parent_Containet
{
    /**
     * »сходный текст
     *
     * @var string
     * @access private
     */
    protected $_text = '';
    
    /**
     * –езультирующий текст
     *
     * @var string
     * @access private
     */
    protected $_textResult = '';
    
    /**
     * “екуща€ кодировка.
     *
     * @var string
     * @access private
     */
    protected $_coding = '';
    
    
    const ENC_UTF8 = 'utf-8';
    const ENC_WIN  = 'windows-1251';
    
    
    /**
     *  онструктор.
     *
     * @param string $text
     * @param string $coding кодировка, используйте константы класса
     */
    protected function __construct($text, $coding = 'windows-1251')
    {
    	$this->_text = $text;
    	$this->_coding = $coding;
    }
    

    /**
     * ”становка формата текста.
     * Ѕывает: text и html
     *
     * @return string
     */
    public function setFormat($format = 'text')
    {
    	return $this->_textFormat = $format;
    }
    
    
    /**
     * ¬озвращает обработанный текст.
     *
     * @return string
     */
    public function get()
    {
    	return $this->_textResult;
    }
    
	public function replaceWindowsCodes()
	{
		$after = array('&#167;', '&#169;', '&#174;', '&#8482;', '&#176;', '&#171;', '&#183;',
				       '&#187;', '&#133;', '&#8216;', '&#8217;', '&#8220;', '&#8221;', '&#164;', '&#166;',
				       '&#8222;', '&#8226;', '&#8211;', $this->plusmn, $this->tire, $this->number, '&#8240;',
				       '&#8364;', '&#182;', '&#172;');

		$before = array('І', '©',  'Ѓ', 'Щ',  '∞', 'Ђ', 'Ј',
			            'ї', 'Е', 'С', 'Т', 'У', 'Ф', '§', '¶',
			            'Д', 'Х', 'Ц', '±', 'Ч', 'є', 'Й',
			            'И', 'ґ', 'ђ');

		$this->_text = str_replace($before, $after, $this->_text);
	}
    
    
}