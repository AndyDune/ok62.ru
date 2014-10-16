<?php
/**
*   Родительский абстрактный класс для ряда классов работы с массивом $_POST[]
*	Класс для инициилизации и фильтрования управляющих входных параметров
* 
* ---------------------------------------------------------
* | Библиотека: Dune                                         |
* | Файл: RequestFormatPost.php                              |
* | В библиотеке: Dune/Filter/Parent/RequestFormatPost.php   |
* | Автор: Андрей Рыжов (Dune) <dune@pochta.ru>              |
* | Версия: 1.02                                             |
* | Сайт: www.rznlf.ru                                       |
* ---------------------------------------------------------
* 
*
* Версия 1.01 -> 1.02
* ----------------------
* Добавлена возможность ограничения строки по длинне.
* Устранена ошибка. Числовые данные = 0 интерпретировались как отсутствие данных
* 
* Версия 1.00 -> 1.01
* ----------------------
* Добавлена возможность конвертирования кодировки.
* 
*/

abstract class Dune_Filter_Parent_RequestFormatPost
{

    protected $value = '';
    protected $have = false;
    
    /**
     * Хранит значение по умолчанию
     *
     * @var mixed
     */
    protected $defaultValue = '';
    
    protected $charsetIn = 'windows-1251';
    protected $charsetOut = 'windows-1251';
    
    
    protected function __construct($name, $def, $maxLength = 0)
    {
    	$this->defaultValue = $def;
    	
//      	if (empty($_POST[$name]) or ($_POST[$name]) == 'undefined') // or ($_POST[$name] == '')
      	if (empty($_POST[$name])) // or ($_POST[$name] == '')      	
      	{
       		$this->value = $this->defaultValue;
      	}
       	else 
       	{
       	    $val = trim($_POST[$name]);
       	    if ($val)
       	    {
           	    if ($maxLength)
           	        substr($val, 0, $maxLength);
       	        
                $this->makeFilter($val);
                if ($this->value !== '')
                {
                    $this->have = true;
                }
                else 
                    $this->value = $this->defaultValue;
       	    }
       	    else 
       	    {
       	        $this->value = $this->defaultValue;
       	    }
       	}
    }
    
    // Проверка на соответствие ключа фильтра предустановленным
    protected function makeFilter($value)
    {
        $this->value = $value;
    }
    
    public function get()
    {
    	return $this->value;
    }
    
    public function have()
    {
    	return $this->have;
    }

    /**
     * 
     *
     * @param string $in_charset исходная кодировка
     * @param string $out_charset кодировка результата
     */
    
    public function iconv($in_charset, $out_charset)
    {
        if (($this->have) and ($in_charset != $out_charset))
        {
            $this->value = iconv($in_charset, $out_charset, $this->value);
        }
        
    }
    
    
}