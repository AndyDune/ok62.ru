<?php
    
    $this->results['result'] = true;
    //$this->sess->killZone();
    $x = 1; // Счётчик итераций
    foreach ($this->support as $key => $value) // Пребираем страницы
    {
        if ($key < $this->page)
            continue;
        foreach ($value['form'] as $forms) // Перебираем список полей формы для страницы
        {
            if ($forms == 'creditperiod')
            {
// Для кредитного периода учитывается 2 цифры
                if (key_exists('creditperiodmin', $this->array) or key_exists('creditperiodmax', $this->array))
                {
                    unset($this->array['creditperiodmin']);
                    unset($this->array['creditperiodmax']);
                    
                }
            }
            else if (key_exists($forms, $this->array))
            {
                unset($this->array[$forms]);
            }
        }
    }

        $this->results['array'] = $this->array;