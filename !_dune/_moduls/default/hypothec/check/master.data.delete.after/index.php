<?php
    
    $this->results['result'] = true;
    //$this->sess->killZone();
    $x = 1; // ������� ��������
    foreach ($this->support as $key => $value) // ��������� ��������
    {
        if ($key < $this->page)
            continue;
        foreach ($value['form'] as $forms) // ���������� ������ ����� ����� ��� ��������
        {
            if ($forms == 'creditperiod')
            {
// ��� ���������� ������� ����������� 2 �����
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