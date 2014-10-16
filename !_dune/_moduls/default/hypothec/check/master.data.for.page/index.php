<?php

    
    $this->results['result'] = true;
    $x = 1; // Счётчик итераций
    foreach ($this->support as $value) // Пребираем страницы
    {
        foreach ($value['form'] as $forms) // Перебираем список полей формы для страницы
        {
            if ($forms == 'creditperiod')
            {
// Для кредитного периода учитывается 2 цифры
                if (!key_exists('creditperiodmin', $this->array) or !key_exists('creditperiodmax', $this->array))
                {
                    $this->results['result'] = false;
                    break;
                }
            }
            else if (!key_exists($forms, $this->array))
            {
                $this->results['result'] = false;
                break;
            }
        }
        $x++;
        if ($this->page == $x)
            break;
    }