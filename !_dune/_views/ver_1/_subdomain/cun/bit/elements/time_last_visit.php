<?php if ($this->time_inteval['year'] > 0)
{
    ?>����� ���� �����<?php
} else
{ 
    
    $have = false;
    if ($this->time_inteval['mon'])
    {
        $have = true;
        echo $this->time_inteval['mon'];
        switch ($this->time_inteval['mon'])
        {
            case 1:
                ?> �����<?php
            break;
            case 2:
            case 3:
            case 4:
                ?> ������<?php
            break;

            default:
                ?> �������<?php
        }
    }
    if ($this->time_inteval['mday'])
    {
        if ($have)
        {
            ?>, <?php
        }
        $have = true;
        echo $this->time_inteval['mday'];
        if ($this->time_inteval['mday'] > 19)
            $value = $this->time_inteval['mday'] % 10;
        else 
            $value = $this->time_inteval['mday'];
        switch ($value)
        {
            case 1:
                ?> ����<?php
            break;
            case 2:
            case 3:
            case 4:
                ?> ���<?php
            break;

            default:
                ?> ����<?php
        }
    }

    
    if ($this->time_inteval['hours'])
    {
        if ($have)
        {
            ?>, <?php
        }
        $have = true;
        echo $this->time_inteval['hours'];
        if ($this->time_inteval['hours'] > 19)
            $value = $this->time_inteval['hours'] % 10;
        else 
            $value = $this->time_inteval['hours'];
        switch ($value)
        {
            case 1:
                ?> ���<?php
            break;
            case 2:
            case 3:
            case 4:
                ?> ����<?php
            break;

            default:
                ?> �����<?php
        }
    }
    
    if ($this->time_inteval['minutes'])
    {
        if ($have)
        {
            ?>, <?php
        }
        $have = true;
        echo $this->time_inteval['minutes'];
        if ($this->time_inteval['minutes'] > 19)
            $value = $this->time_inteval['minutes'] % 10;
        else 
            $value = $this->time_inteval['minutes'];
        switch ($value)
        {
            case 1:
                ?> ������<?php
            break;
            case 2:
            case 3:
            case 4:
                ?> ������<?php
            break;

            default:
                ?> �����<?php
        }
    }

    if ($this->time_inteval['seconds'] and !$have)
    {
        $have = true;
        echo $this->time_inteval['seconds'];
        if ($this->time_inteval['seconds'] > 19)
            $value = $this->time_inteval['seconds'] % 10;
        else 
            $value = $this->time_inteval['seconds'];
        switch ($value)
        {
            case 1:
                ?> �������<?php
            break;
            case 2:
            case 3:
            case 4:
                ?> �������<?php
            break;

            default:
                ?> ������<?php
        }
    }
    
    if ($have)
    {
        ?> �����<?php
    }

    
}?>