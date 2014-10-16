<?php if ($this->sections_array and count($this->sections_array))
{
    ?><select name="section">
    <option value="0">---</option>
    <?php
    foreach ($this->sections_array as $value)
    {
        if ($this->section_current == $value['data']['id'])
            $select = ' selected="selected"';
        else 
            $select = '';
        $str_pred = '';
        if ($value['level'] > 0)
            $str_pred = '&nbsp;&nbsp;&nbsp;';
        ?><option value="<? echo $value['data']['id'] ?>"<? echo $select ?>><? echo $str_pred, $value['data']['name'] ?></option><?php
    }
    ?></select><?php
    
}