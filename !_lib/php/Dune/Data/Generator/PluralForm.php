<?
/**
*  Склонение существительных с числительными
*
* В русском языке существительные с числительными могут быть в единственном, двойственном и множественном числе:
*  один арбуз, два арбуза, пять арбузов 
*  (двойственное число — это почти исчезнувшая в русском языке грамматическая конструкция, встречающаяся только в этом случае).
* 
* 
* ----------------------------------------------------
* | Библиотека: Dune                                  |
* | Файл: PluralForm.php                              |
* | В библиотеке: Dune/Data/Generator/PluralForm.php  |
* | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
* | Версия: 1.00                                      |
* | Сайт: www.rznw.ru                                 |
* ----------------------------------------------------
* 
* История версий:
* ----------------
* Версия 1.00
* 
*/

class Dune_Data_Generator_PluralForm
{
    /**
     * Число
     *
     * @var integer
     * @access private
     */
    protected $_number = null;
    
    /**
     * Форма
     *
     * @var string
     * @access private
     */
    protected $_form1  = null;
    
    /**
     * Форма
     *
     * @var string
     * @access private
     */
    protected $_form2  = null;
    
    /**
     * Форма
     *
     * @var string
     * @access private
     */
    protected $_form3  = null;
    
    /**
     * Конструктор.
     *
     * @param integer $n
     * @param string $form1 один арбуз
     * @param string $form2 два арбуза
     * @param string $form3 пять арбузов
     */
    public function __construct($n = null, $form1 = null, $form2 = null, $form3 = null)
    {
        $this->_number = $n;
        $this->_form1  = $form1;
        $this->_form2  = $form2;
        $this->_form3  = $form3;
    }
    
    /**
     * Установка лпорного числа.
     *
     * @param integer $n
     * @return Dune_Data_Generator_PluralForm
     */
    public function setNumber($n)
    {
        $this->_number = $n;
        return $this;
    }
    
    /**
     * Установка уществительных с числительными.
     *
     * @param string $form1 один арбуз
     * @param string $form2 два арбуза
     * @param string $form3 пять арбузов
     * @return Dune_Data_Generator_PluralForm
     */
    public function setForms($form1, $form2, $form3)
    {
        $this->_form1  = $form1;
        $this->_form2  = $form2;
        $this->_form3  = $form3;
        return $this;
    }
    
    /**
     * Возврат соответствующей строки.
     *
     * @param integer $n
     * @return string
     */
    public function get($n = null)
    {
        if (is_null($n))
            $n = (int)$this->_number;
        $n = abs($n) % 100;
        $n1 = $n % 10;
        if ($n > 10 && $n < 20) return $this->_form3;
        if ($n1 > 1 && $n1 < 5) return $this->_form2;
        if ($n1 == 1) return $this->_form1;
        return $this->_form3;
    }
}