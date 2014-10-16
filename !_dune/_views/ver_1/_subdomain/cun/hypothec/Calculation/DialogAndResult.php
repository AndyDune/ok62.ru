<?php echo $this->crumbs; ?>
<hr />
<style type="text/css">
<!--
#calc_main h3
{
    margin: 0 0 10px 0;
}
#calc_main #form_main_table table tr td
{
font-size: 13px;
}
#calc_main #form_main_table table tr td h3
{
font-size: 13px;
}
#calc_main #form_main_table table tr td input
{
padding: 2px;
font-size: 14px;
}
#calc_main #form_main_table table tr td select
{
padding: 2px;
font-size: 13px;
}

#form_main_table
{
width:800px;
margin: 0 auto 0 auto;
}

#form_main_table table
{
width:100%;
}
#form_main_table table td
{
text-align:center;
vertical-align:top;
width:50%;
margin: 0 auto 0 auto;
}
#form_ras
{
height: 400px;
text-align:left;
margin: 0 auto 0 auto;
width:400px;
background-color: E5E7E5;
padding: 10px;
}
#form_ras table tr td
{
text-align:left;
}

#form_dva
{
text-align:left;
margin: 0 auto 0 auto;
width:400px;
background-color: E5E7E5;
height: 400px;
padding: 10px;
}
#form_dva table tr td
{
text-align:left;
vertical-align: bottom;
}

.under-line
{
border-bottom: 1px dashed #333333;
}
.under-line span
{
padding: 0 2px 0 0;
margin: 0;
float:left;
top: 3px;
left : -1px;
display: block;
position: relative;
height: 21px;
background-color: E5E7E5;
}
#list-progs
{
list-style-type:none;
margin: 15px 5px 0 5px;
padding: 0;
}
#list-progs li
{
    margin: 7px 0 0 0;
}
#list-progs a
{
text-decoration: underline;
}
.header-span
{
display: block;

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
.two-from-concerned-down td.right
{
border-style: solid;
border-width: 0px 1px 1px 0px;
border-color: #990000;
}

.two-from-concerned-down td.left p, .two-from-concerned-up td.left p
{
padding:0;
margin:0;
position: relative;
width:100%;
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

.info-group, .info-group dt, .info-group dd
{
padding:0;
margin:0;
}
.info-group dt
{
padding-top: 5px;
border-bottom: 2px solid #8B8789;
}

.info-group dd ul
{
padding: 0 0 0 20px;
margin: 0;
}

-->

.hypo-calc
{
font-size:13px;
}
.hypo-calc tr td
{
font-size:13px;
}
.hypo-calc tr td span
{
font-size:13px;
}

.hypo-calc tr td span li
{
font-size:13px;
}

</style>


<script type="text/javascript">
<!--

$(document).ready(function() {

   
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
                                
});

// -->
</script>

<?php if ($this->object_info) { ?>
<h1>Ипотечный брокер</h1>
<?php echo $this->object_info; ?>
<?php } else { ?>
<h1>Ипотечный брокер</h1>
<?php } ?>
<div style="text-align:center;" id="calc_main">
<div id="form_main_table">
<table><tr><td>
<div id="form_ras">
<h3>Данные для расчета</h3>
<?php
if ($this->message_id == 1) { 
?><p>Пожалуйста заполните  все обязательные поля</p><?php   } 

else if ($this->message_id == 5) { 
?><p id="mess">Указан недопустимы возраст. Введит коррективы.</p><?php   } 

else if ($this->message_id == 6) { 
?><p id="mess">Не заполнены все обязательные поля.</p><?php   } 

else if ($this->message_id == 7 ) { 
?><p id="mess">Не указан вариант для выбора единицы измерения первоначального платежа.</p><?php   } 

else if ($this->message_id == 8 ) { 
?><p id="mess">Неверно введена сумма первого платежа.</p><?php   } 


?>
<form method="post" action="<?php echo $this->action;?>">
<input name="_do_" type="hidden" value="go" />

<table style="width:100%" class="hypo-calc">

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
<td class="right"><input id="creditperiod" name="creditperiod" type="text" value="<?php echo $this->creditperiod; ?>" /> лет</td>
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
<td class="right"><input id="monthpay" name="monthpay" type="text" value="<?php echo number_format($this->monthpay, 0, ',', ' '); ?>" /></td>
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

/*
$f = new Dune_Form_Select('paymenttypeid');
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
<input type="hidden" name="object" value="<?php echo $this->object_id; ?>" />
<p><span class="star-mandatory" title="Обязательное поле для заполнения">*</span> - Поля, обязательные для заполнения.</p>
<p style="text-align:center;"><input name="go" type="submit" value="Расчитать" /></p>
</form>
</div></td>
<td>
<div id="form_dva">
<h3>Расчет оптимального кредита</h3>
<?php
switch ($this->currencyid)
{
    case 'USD':
         $currency = 'долларов';
    break;

    case 'EUR':
         $currency = 'евро';
    break;
    
    default:
         $currency = 'рублей';
}
$this->pay_month = round($this->pay_month, -1);
$this->pay_over = round($this->pay_over, -1);
?>
<table style="width:100%" class="hypo-calc">

<tr style="width:100%">
<td style="width:60%" class="under-line"><span>Ставка по кредиту</span></td>
<td style="width:40%"><?php echo $this->rate; ?> %</td>
</tr>

<tr>
<td class="under-line"><span>Стоимость объекта</span></td>
<td><?php echo number_format($this->sumcredit_d, 0, ',', ' '); ?> <?php echo $currency; ?></td>
</tr>

<tr>
<td class="under-line"><span>Сумма, кредитуемая банком</span></td>
<td><?php echo number_format($this->sumcredit_bank, 0, ',', ' '); ?> <?php echo $currency; ?></td>
</tr>


<tr>
<?php if (!strcmp($this->paymenttypeid, 'ANNUIT')) { ?>
<td class="under-line"><span>Ежемесячные платежи</span></td>
<?php } else { ?>
<td class="under-line"><span>Платеж в 1-й месяц</span></td>
<?php } ?>
<td><?php echo number_format($this->pay_month, 0, ',', ' '); ?> <?php echo $currency; ?></td>
</tr>

<?php if ($this->program->bank_id == 1 and $this->pay_month_dolg and $this->pay_month_dolg > 0)  { ?>

<tr>
<?php if (strcmp($this->paymenttypeid, 'ANNUIT')) { ?>
<td class="under-line"><span>Платеж в 1-й месяц (<a target="_blank" title="Программа развития ипотечного кредитования строящихся объектов Строим вместе" href="/modules.php?name=Hypothec&op=Privilege">льгота</a>)</span></td>
<?php } ?>
<td><strong style="color:red;"><?php echo number_format($this->pay_month_dolg + ($this->pay_month - $this->pay_month_dolg) / 2, 0, ',', ' '); ?> <?php echo $currency; ?> </strong></td>
</tr>


<?php } ?>
<tr>
<td class="under-line"><span>Срок кредита (года)</span></td>
<td><?php echo $this->creditperiod_fact ?> </td>
</tr>



<tr>
<td class="under-line"><span>Переплата по процентам</span></td>
<td><?php echo number_format($this->pay_over, 0, ',', ' '); ?> <?php echo $currency; ?></td>
</tr>

<!--<tr>
<td class="under-line"><span>Программ найдено</span></td>
<td><a href="/modules.php?name=Hypothec&op=CalculationList"><?php echo $this->count; ?></a></td>
</tr>
-->
</table>

<ul id="list-progs">
<li>
<span class="header-span">Расчёт выполнен относительно: </span>
 &nbsp; &nbsp; &nbsp;<a href="/modules.php?name=Hypothec&op=ShowFixedPProgram&programID=<?php
  echo $this->program->pprogram_id;
   ?>&version=<?php echo $this->version ?>" class="tt" title="<?php echo $this->program->name_pp; ?>">программы</a>
банка <a href="/modules.php?name=Hypothec&op=ShowFixedBank&bankID=<?php echo $this->program->bank_id; ?>&version=<?php echo $this->version ?>"><?php echo $this->program->name; ?></a>
<hr />
</li></ul>
<dl class="info-group">
<dt>Программы со сходными данными для расчета</dt>
<dd>
<ul>
<li><a href="/modules.php?name=Hypothec&op=CalculationListBegin&version=<?php echo $this->version ?>">все программы (<?php echo $this->count_all; ?>)</a></li>
<?php if ($this->count > 1)  {?>
<li><a href="/modules.php?name=Hypothec&op=CalculationList&version=<?php echo $this->version ?>">со ставкой по кредиту не более <?php echo ceil($this->rate); ?> % (<?php echo $this->count; ?>)</a></li>
<?php } ?>

</ul>
</dd>
</dl>
<?php if ($this->objects_count) { ?>
<dl class="info-group">
<dt>Недвижимость в ипотеку</dt>
<dd>
<ul>
<?php if (!$this->object) 
    {
        $type = 1;
    }else 
    {
        $type = $this->object->type;
    }

    ?>
<li><a href="/catalogue/type/<?php echo $type; ?>/?set=filter&version=<?php echo $this->version ?>&price=<?php echo str_replace(' ', '', $this->sumcredit); ?>&new_building_flag=<?php echo $this->status ?>"> <?php echo $this->objects_count ?> предложений</a></li>

</ul>
</dd>
</dl>

<?php } ?>

</div>
</td>
</tr>
</table>
</div></div>

<!-- Когнец -->

