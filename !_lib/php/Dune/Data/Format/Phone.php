<?
/**
*	Класс анализа формата введённого номера телефона
* 
*	Параметры номера телефона, для всех:
*   - не менее 6 цифр, не более 12 цифр;
*   - только цифры и служебные символы - разделители
*   - в начале может быть знак +
*   - цифры в номере телефона могут быть разбиты на группы знаками "-"(тире), " "(пробел)
*   - код города может быть помещён в скобки, перед скобками может стоять цифра или цифра со знаком +. В скобках только цифры.
* 
* ----------------------------------------------------
* | Библиотека: Dune                                  |
* | Файл: Phone.php                                   |
* | В библиотеке: Dune/Data/Format/Phone.php          |
* | Автор: Андрей Рыжов (Dune) <dune@pochta.ru>       |
* | Версия: 1.00                                      |
* | Сайт: www.rznlf.ru                                |
* ----------------------------------------------------
* 
*/

class Dune_Data_Format_Phone
{
    protected $numbersMin = 6;
    protected $numbersMax = 12;
    
    protected $haveBrackets = false;
    
    protected $phoneOriginal; // Номер телефона - источисточник
    protected $phoneFiltered; // Номер телефона - отфильтрованный
    protected $phoneNumbersOnly; // Номер телефона - только цифры (и знак + если есть)
    
    
    public function __construct($phone)
    {
        $this->phoneOriginal = trim($phone);
        $this->phoneNumbersOnly = preg_replace("/[^\d\+]/i",'',$phone);
        $this->filter();
    }
    
   
    /**
     * Возвращает отфильтрованный номер телефона
     * 
     * Возвращает номер телефона с одними цифрами и знаком "+" если есть
     *
     * @return string номер телефона
     */
    public function getFiltered()
    {
        return $this->phoneFiltered;
    }
    
    /**
     * Проверяет строку с номером телефона на допустимые символы
     *
     * Допустимые символы:
     * цифра, плюс, минус, пробел, скобки
     * 
     * @return boolean
     */
    public function checkAllowSymbols()
    {
        $bool = true;
        $reg = "/[^\d\+\- ()]/i";
        $array = array();
        preg_match_all($reg,$this->phoneOriginal,$array);
        if (count($array[0]))
        {
            $bool = false;
        }
        return $bool;
    }

    /**
     * Проверка корректного числа цифр в номере
     * 
     * Условие > 6 и < 12
     *
     * @return boolean
     */
    public function checkCountNumbers()
    {
        $bool = true;
        $count = strlen($this->phoneNumbersOnly);
        
        if (($count < 6) OR ($count >12))
        {
            $bool = false;
        }
        return $bool;
    }

    /**
     * Проверка на правильность использования знака "+"
     *
     * Условия:
     * "+" только один;
     * "+" только в начале;
     * "+" только перед цифрой;
     * 
     * @return boolean
     */
    public function checkPlus()
    {
        $bool = true;
        $pos = strpos($this->phoneFiltered,'+');
        if ($pos !== false)
        {     
            // Есть второй плюс       
            if (strpos($this->phoneFiltered,'+', $pos + 1) !== false)
            {
                $bool = false;
            }
            // Плюс не сначала строки
            else if ($pos != 0)
            {
                $bool = false;
            }
            // За плюсом стоит не цифра
            else if (!preg_match("/^\+[ ]*\d/i",$this->phoneFiltered))
            {
                $bool = false;
            }
            
        }
        return $bool;
    }
    
    /**
     * Проверка на правильность использования скобок
     *
     * Условия:
     * Должна быть парная;
     * Должна быть только одна одного вида;
     * Правильная поледовательность "(" после ")";
     * Цифр внутри скобок от 2 до 5
     * Знак "-" внутри скобок запрещён
     * 
     * @return boolean
     */
    public function checkBrackets()
    {
        $bool = true;
        $pos_first = strpos($this->phoneFiltered,'(');
        $pos_second = strpos($this->phoneFiltered,')');
        
        // Если найдена скобка
        if (($pos_first !== false) OR ($pos_second !== false))
        {  
            $this->haveBrackets = true;
            // Если нет пары для скобки   
            if (($pos_first !== false) XOR ($pos_second !== false))
            {
                $bool = false;
            }
            // если есть вторая, идентичная
            else if (strpos($this->phoneFiltered,'(', $pos_first + 1) !== false)
            {
                $bool = false;
            }
            // если есть вторая, идентичная
            else if (strpos($this->phoneFiltered,')', $pos_second + 1) !== false)
            {
                $bool = false;
            }
            // если несоблюдена последовательность
            else if ($pos_second < $pos_first)
            {
                $bool = false;
            }
            // если есть недостаток цифр, идущих подряд
            else if (!preg_match("/\([ ]*[\d]{2,5}[ ]*\)/i",$this->phoneFiltered))
            {
                $bool = false;
            }
            // если используется знак "-" в скобках
            else if (preg_match("/\([\d]+\-[\d]+\)/i",$this->phoneFiltered))
            {
                $bool = false;
            }
            
        }
        return $bool;
    }
    
    /**
     * Проверка на наличие необходимый цифр вне круглых скобок
     *
     * Условия: слева не более 1-ой, справа не менее 4-х
     * 
     * @return boolean
     */
    public function checkNumbersOutBrackets()
    {
        $bool = true;
        if ($this->haveBrackets)
        {
            $pos_first = strpos($this->phoneFiltered,'(');
            $line_first = substr($this->phoneFiltered,0,$pos_first);
            $pos_second = strpos($this->phoneFiltered,')');
            $line_second = substr($this->phoneFiltered,$pos_second,100);
            // Число цифр перед открывающейся круглой скобкой более 1
            if (strlen(preg_replace("/[^\d]/i",'',$line_first)) > 1)
            {
                $bool = false;
            }
            // Число цифр после закрывающейся круглой скобкой менее 5
            else if (strlen(preg_replace("/[^\d]/i",'',$line_second)) < 4)
            {
                $bool = false;
            }
            
        }
        return $bool;
    }

    /**
     * Фильтрация номера
     * 
     * Допустимость символов, повторяющиеся пробелы и тире удаляются
     *
     */
    protected function filter()
    {
        // Удаляем все неразрешённые символы
        $this->phoneFiltered = preg_replace("/[^\d\+\- ()]/i",'',$this->phoneOriginal);
        // Заменяем последовательность пробелов одним
        $this->phoneFiltered = preg_replace("/[ ]{2,}/i",' ',$this->phoneFiltered);
        // Заменяем последовательность "пробел тире" знаком тире
        $this->phoneFiltered = preg_replace("/ \-/i",'-',$this->phoneFiltered);
        // Заменяем последовательность "тире пробел" знаком тире
        $this->phoneFiltered = preg_replace("/\- /i",'-',$this->phoneFiltered);
        // Заменяем последовательность тире одним
        $this->phoneFiltered = preg_replace("/[-]{2,}/i",'-',$this->phoneFiltered);
    }
    
}