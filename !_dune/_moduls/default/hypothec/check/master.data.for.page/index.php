<?php

    
    $this->results['result'] = true;
    $x = 1; // ������� ��������
    foreach ($this->support as $value) // ��������� ��������
    {
        foreach ($value['form'] as $forms) // ���������� ������ ����� ����� ��� ��������
        {
            if ($forms == 'creditperiod')
            {
// ��� ���������� ������� ����������� 2 �����
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