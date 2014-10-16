<?php echo $this->crumbs; ?>
<hr />
<style type="text/css">
<!--
#form_ras
{
text-align:left;
margin: 0 auto 0 auto;
width:400px;
background-color: E5E7E5;
padding: 10px;
}

#mess
{
color: red;
text-align:center;
}

#calc_main h3
{
    margin: 0 0 10px 0;
}
#calc_main #form_main_table table tr td
{
font-size: 13px;
padding: 4px 0 3px 3px;
}

#calc_main #form_main_table table
{
font-size: 15px;
border-collapse: collapse;
}


#calc_main #form_main_table table tr td h3
{
font-size: 14px;
}
#calc_main #form_main_table table tr td input
{
padding: 2px;
font-size: 13px;
}
#calc_main #form_main_table table tr td select
{
padding: 2px;
font-size: 13px;
}

.two-from-concerned-up td.left
{
border-style: solid;
border-width: 1px 0px 0px 1px;
border-color: #990000;
}
.two-from-concerned-up td.right
{
border-style: solid;
border-width: 1px 1px 0px 0px;
border-color: #990000;
}

.two-from-concerned-down td.left
{
border-style: solid;
border-width: 0px 0px 1px 1px;
border-color: #990000;
}
.two-from-concerned-down td.left p, .two-from-concerned-up td.left p
{
padding:0;
margin:0;
position: relative;
width:100%;
}
.two-from-concerned-down td.right
{
border-style: solid;
border-width: 0px 1px 1px 0px;
border-color: #990000;
}

.radion-right
{
position:absolute;
right:0px;
top: 0px;
}

.radion-right-2
{
position:absolute;
right:0px;
top: 6px;
}
.focus
{
background-color: red;
}

#tr-firstpayment td 
{
vertical-align:top;
}

#tr-firstpayment td p
{
margin: 10px 0 0 0;
padding:0;
position: relative;
}

#tr-firstpayment td.left p
{
padding: 3px 0 0 0;
position: relative;
}

#tr-firstpayment td.right p input
{
width:100px;
}

#tr-firstpayment td p .radion-right-first
{
position:absolute;
right:0px;
top: 4px;
}

#tr-firstpayment td p .radion-right
{
position:absolute;
right:0px;
top: 6px;
}

-->
</style>

<script type="text/javascript">
<!--

$(document).ready(function() {

/*$('#monthpay').focus(function(){
    $('#creditperiod').attr('disabled', 'disabled');    
                                });    
$('#monthpay').blur(function(){
    if ($('#monthpay').val() == '')
    {
        $('#creditperiod').removeAttr('disabled', 'disabled');    
    }
                                });    
*/
$('#monthpay').focus(function(){
    $('#use_monthpay').attr('checked', 'checked');    
                                });    
$('#creditperiod').focus(function(){
    $('#use_creditperiod').attr('checked', 'checked');    
                                });    
                                
$('#firstpayment_per').focus(function(){
    $('#use_firstpayment_per').attr('checked', 'checked');    
                                });    
$('#firstpayment_money').focus(function(){
    $('#use_firstpayment_money').attr('checked', 'checked');    
                                });    
                    
$(".tt-extra").tooltip({
	track: true,
	delay: 0,
	showURL: false,
	fixPNG: true,
	showBody: " - ",
	extraClass: "pretty fancy",
	top: -15,
	left: 5
});                                
                                            
/*                                
$('#creditperiod').blur(function(){
    if ($('#creditperiod').val() == '')
    {
        $('#monthpay').removeAttr('disabled', 'disabled');    
    }
                                });    

    if ($('#monthpay').val() != '')
    {
        $('#creditperiod').attr('disabled', 'disabled');    
    }
    else if ($('#creditperiod').val() != '')
    {
        $('#monthpay').attr('disabled', 'disabled');    
    }
  */                              
                                     
    
});

// -->
</script>

<?php if ($this->object_info) { ?>
<h1>Ипотечный брокер</h1>
<?php echo $this->object_info; ?>
<?php } else { ?>
<h1>Ипотечный брокер</h1>
<?php } ?>

<div style="text-align:center;"  id="calc_main">
<div id="form_ras">
<?php
if ($this->message_id == 1 ) { 
?><p id="mess">Пожалуйста заполните  все обязательные поля</p><?php   } 

else if ($this->message_id == 2 ) { 
?><p id="mess">Нет кредитных программ с такими параметрами.</p><?php   } 

else if ($this->message_id == 3 ) { 
?><p id="mess">Введены недопустимые значения полей.</p><?php   } 

else if ($this->message_id == 4 ) { 
?><p id="mess">Сумма слишком велика.</p><?php   } 

else if ($this->message_id == 5 ) { 
?><p id="mess">Указан недопустимы возраст. Введит коррективы.</p><?php   } 

else if ($this->message_id == 6 ) { 
?><p id="mess">Не заполнены все обязательные поля.</p><?php   } 

else if ($this->message_id == 7 ) { 
?><p id="mess">Не указан вариант для выбора единицы измерения первоначального платежа.</p><?php   } 

else if ($this->message_id == 8 ) { 
?><p id="mess">Неверно введена сумма первого платежа.</p><?php   } 

?>

<form method="post" action="<?php echo $this->action;?>">
<input name="_do_" type="hidden" value="go" />
<div id="form_main_table">
<table style="width:100%">

<tr style="width:100%">
<td style="width:50%">Стоимость объекта<span class="star-mandatory" title="Обязательное поле для заполнения">*</span></td>
<td style="width:50%"><input name="sumcredit" type="text" value="<?php if ($this->sumcredit) echo number_format($this->sumcredit, 0, ',', ' '); ?>" /></td>
</tr>

<tr>
<td>Возраст заемщика<span class="star-mandatory" title="Обязательное поле для заполнения">*</span></td>
<td><input name="age" type="text" value="<?php echo $this->age; ?>" /> лет</td>
</tr>

<tr class="two-from-concerned-up">
<td class="left">
<p>
Срок кредита<span class="star-mandatory" title="Обязательное поле для заполнения">*</span>
<input class="radion-right<?php

if ($this->message_id == 6)
{ ?> focus<?php }

?>" type="radio" id="use_creditperiod" name="use_creditperiod_or_monthpay" value="creditperiod"<?php

if ($this->use_creditperiod_or_monthpay == 'creditperiod')
{ ?> checked="checked"<?php }

?> />
</p>
</td>
<td class="right"><input  id="creditperiod" name="creditperiod" type="text" value="<?php echo $this->creditperiod; ?>" /> лет</td>
</tr>

<tr class="two-from-concerned-down">
<td class="left">
<p>
Размер ежемесячных платежей<span class="star-mandatory" title="Обязательное поле для заполнения">*</span>
<input class="radion-right-2<?php

if ($this->message_id == 6)
{ ?> focus<?php }

?>" type="radio" id="use_monthpay" name="use_creditperiod_or_monthpay" value="monthpay"<?php
if ($this->use_creditperiod_or_monthpay == 'monthpay')
{ ?> checked="checked"<?php }
?> />
</p>
</td>
<td class="right"><input id="monthpay" name="monthpay" type="text" value="<?php echo $this->monthpay; ?>" /></td>
</tr>

<tr id="tr-firstpayment">
<td class="left">
<p>Первоначальный взнос<input class="radion-right-first<?php

if ($this->message_id == 6)
{ ?> focus<?php }

?>" type="radio" id="use_firstpayment_per" name="use_firstpayment" value="per"<?php

if ($this->use_firstpayment == 'per')
{ ?> checked="checked"<?php }

?> />
</p>
<p>&nbsp;<input class="radion-right<?php

if ($this->message_id == 6)
{ ?> focus<?php }

?>" type="radio" id="use_firstpayment_money" name="use_firstpayment" value="money"<?php

if ($this->use_firstpayment == 'money')
{ ?> checked="checked"<?php }

?> />
</p>
</td>
<td class="right">
<p>
<input id="firstpayment_per" name="firstpayment" type="text" value="<?php echo $this->firstpayment; ?>" /> %
</p><p>
<input id="firstpayment_money" name="firstpayment_money" type="text" value="<?php if ($this->firstpayment_money) echo number_format($this->firstpayment_money, 0, ',', ' '); ?>" /> деньги
</p>
</td>
</tr>

<tr>
<td>Валюта</td>
<td>
<?php
$f = new Dune_Form_Select('currencyid');
foreach ($this->currencyarray as $key => $value)
{
    if ($key == $this->currencyid)
        $boo = true;
    else 
        $boo = false;
    $f->setOption($key, $value, $boo);
}
echo $f;
?>

</td>
</tr>

<tr>
<td>Платежи</td>
<td>
<?php
$x = 0;
foreach ($this->paymenttypearray as $key => $value)
{
    $f = new Dune_Form_InputRadio('paymenttypeid');
    if (!$x)
        $f->setChecked();
    else if ($key == $this->paymenttypeid)
        $f->setChecked();
    $f->setId('pla_' . $x);;
    $f->setValue($key);
    echo $f, ' <label for="pla_' . $x . '" style="cursor:pointer;">', $value, '</label><br />';
    $x++;
}

/*$f = new Dune_Form_Select('paymenttypeid');
foreach ($this->paymenttypearray as $key => $value)
{
    if ($key == $this->paymenttypeid)
        $boo = true;
    else 
        $boo = false;
    $f->setOption($key, $value, $boo);
}
echo $f;
*/
?>
</td>
</tr>


<tr>
<td>Подтверждение дохода</td>
<td>
<?php
$f = new Dune_Form_Select('incconfirmid');
foreach ($this->incconfirmarray as $key => $value)
{
    if ($key == $this->incconfirmid)
        $boo = true;
    else 
        $boo = false;
    $f->setOption($key, $value, $boo);
}
echo $f;
?>
</td>
</tr>

<tr>
<td>Статус объекта</td>
<td>
<?php
$f = new Dune_Form_Select('status');
foreach ($this->statusarray as $key => $value)
{
    if ($key == $this->status)
        $boo = true;
    else 
        $boo = false;
    $f->setOption($key, $value, $boo);
}
echo $f;
?>
</td>
</tr>


</table>
</div>
<input type="hidden" name="object" value="<?php echo $this->object_id; ?>" />
<p><span class="star-mandatory" title="Обязательное поле для заполнения">*</span> - Поля, обязательные для заполнения.</p>
<p style="text-align:center;"><input name="go" type="submit" value="Расчитать" /></p>
</form>
</div></div>
<!-- Когнец -->

