<?php echo $this->crumbs; ?>
<hr />
<div id="hypotec-info">
<h1>����� ��������� ���������</h1>


<div style="margin:  0 0 15px 3px;">


<?php 
$o_array = new Dune_Array_IsSet($this->data);


////////////// ����������� ����
/////////////////////////////////////////////////////////////

$f = new Dune_Form_Form();

$f->setMethod(Dune_Form_Form::METHOD_POST);
echo $f->getBegin();

//?name=Hypothec&op=ShowAllPrograms
$ff = new Dune_Form_InputHidden('name');
$ff->setValue('Hypothec');
echo $ff->get();
$ff = new Dune_Form_InputHidden('op');
$ff->setValue('SearchPrograms');
echo $ff->get();
$ff = new Dune_Form_InputHidden('_do_');
$ff->setValue('do');
echo $ff->get();


$banks = new Dune_Form_Select('bank_id');
$banks->setOption(0, '���');
foreach ($this->banks as $value)
{
    if ($value['id'] == $o_array->bank_id)
    {
        $banks->setOption($value['id'], $value['name'], true);
    }
    else 
        $banks->setOption($value['id'], $value['name']);
}

// ������
$currencyid = new Dune_Form_Select('currencyid');
foreach ($this->data_specify_array['currencyid_rus'] as $key => $value)
{
    if ($key == $o_array->currencyid)
    {
        $currencyid->setOption($key, $value, true);
    }
    else 
        $currencyid->setOption($key, $value);
}

// ������������� ������
$incconfirmid = new Dune_Form_Select('incconfirmid');
foreach ($this->data_specify_array['incconfirmid'] as $key => $value)
{
    if ($key == $o_array->incconfirmid)
    {
        $incconfirmid->setOption($key, $value, true);
    }
    else 
        $incconfirmid->setOption($key, $value);
}

// ���� ����������� ������
$approveperiod = new Dune_Form_InputText('approveperiod');
$approveperiod->setSize(5);
$approveperiod->setValue($o_array->approveperiod);

// ������ �������
$rate = new Dune_Form_InputText('rate');
$rate->setSize(5);
$rate->setValue($o_array->rate);

// ����������� �������
$loansecurityid = new Dune_Form_Select('loansecurityid');
foreach ($this->data_specify_array['loansecurityid'] as $key => $value)
{
    if ($key == $o_array->loansecurityid)
    {
        $loansecurityid->setOption($key, $value, true);
    }
    else 
        $loansecurityid->setOption($key, $value);
}

//���� �������
$creditperiodmin = new Dune_Form_InputText('creditperiodmin');
$creditperiodmin->setSize(3);
$creditperiodmin->setValue($o_array->creditperiodmin);
$creditperiodmax = new Dune_Form_InputText('creditperiodmax');
$creditperiodmax->setSize(3);
$creditperiodmax->setValue($o_array->creditperiodmax);

// ������ �������
$sumcredit = new Dune_Form_InputText('sumcredit');
$sumcredit->setSize(8);
$sumcredit->setValue($o_array->sumcredit);
// ��������������� ����
$firstpayment = new Dune_Form_InputText('firstpayment');
$firstpayment->setSize(4);
$firstpayment->setValue($o_array->firstpayment);
// ������� ��������
$age = new Dune_Form_InputText('age');
$age->setSize(3);
$age->setValue($o_array->age);

// ����������� �� ����� ��������� �������
$registration = new Dune_Form_Select('registration');
foreach ($this->data_specify_array['registration'] as $key => $value)
{
    if ($key == $o_array->registration)
    {
        $registration->setOption($key, $value, true);
    }
    else 
        $registration->setOption($key, $value);
}
// ����������� ��
$nationality = new Dune_Form_Select('nationality');
foreach ($this->data_specify_array['nationality'] as $key => $value)
{
    if ($key == $o_array->nationality)
    {
        $nationality->setOption($key, $value, true);
    }
    else 
        $nationality->setOption($key, $value);
}

// �������
$paymenttypeid = new Dune_Form_Select('paymenttypeid');
foreach ($this->data_specify_array['paymenttypeid'] as $key => $value)
{
    if ($key == $o_array->paymenttypeid)
    {
        $paymenttypeid->setOption($key, $value, true);
    }
    else 
        $paymenttypeid->setOption($key, $value);
}

// ��������� ��������� ��� ������� �����
$advrepay = new Dune_Form_InputText('advrepay');
$advrepay->setSize(3);
$advrepay->setValue($o_array->advrepay);

// ��� ������������:
$kinds = new Dune_Form_Select('kinds');
foreach ($this->data_specify_array['kinds'] as $key => $value)
{
    if ($key == $o_array->kinds)
    {
        $kinds->setOption($key, $value, true);
    }
    else 
        $kinds->setOption($key, $value);
}


////////////// ��������� �����
/////////////////////////////////////////////////////////////

?>
<h2 class="search-h2">����� ������</h2>
<table>
<?php if (count($this->banks) > 0) {?>
<tr>
<td class="search-table-td-name">����: 
</td><td>
<?php echo $banks->get(); ?>
</td></tr>
<?php }?>

<tr><td>��� ������������: 
</td><td>
<?php echo $kinds->get(); ?> 
</td></tr>


<?php if (false)  {?>
<tr><td>����� ������������: 
</td><td>
<?php echo $banks->get(); ?> </td>
</tr>
<?php }?>
</table>

<h2 class="search-h2">������� �������</h2>
<table>
<tr><td class="search-table-td-name">������: 
</td><td>
<?php echo $currencyid->get(); ?>
</td></tr>


<tr><td class="search-table-td-name">������ �������: 
</td><td> ��
<?php echo $rate->get(); ?> %
</td></tr>



<tr><td class="search-table-td-name">����������� �������: 
</td><td>
<?php echo $loansecurityid->get(); ?>
</td></tr>


<tr><td class="search-table-td-name">���� �������: 
</td><td>
�� <?php echo $creditperiodmin->get(); ?> �� <?php echo $creditperiodmax->get(); ?> ���
</td></tr>

<tr><td class="search-table-td-name">������ �������: 
</td><td>
<?php echo $sumcredit->get(); ?>
</td></tr>


<tr><td class="search-table-td-name">�������������� �����: 
</td><td>�� 
<?php echo $firstpayment->get(); ?> %
</td></tr>

<tr><td class="search-table-td-name">������������� ������: 
</td><td>
<?php echo $incconfirmid->get(); ?>
</td></tr>

<tr><td class="search-table-td-name">���� ������������ ������: 
</td><td> ��
<?php echo $approveperiod->get(); ?> ����
</td></tr>

</table>

<h2 class="search-h2">���������� � ��������</h2>
<table>
<tr><td class="search-table-td-name">������� ��������: 
</td><td>
<?php echo $age->get(); ?> ���
</td></tr>
<tr><td class="search-table-td-name">����������� �� ����� ��������� �������: 
</td><td>
<?php echo $registration->get(); ?>
</td></tr>
<tr><td class="search-table-td-name">����������� ��: 
</td><td>
<?php echo $nationality->get(); ?>
</td></tr>

</table>

<h2 class="search-h2">������� ��������� �������</h2>
<table>
<tr><td class="search-table-td-name">�������: 
</td><td>
<?php echo $paymenttypeid->get(); ?>
</td></tr>
<tr><td class="search-table-td-name">��������� ��������� ���&nbsp;�������&nbsp;�����: 
</td><td>
<?php echo $advrepay->get(); ?> �������
</td></tr>

</table>


<?php
$ff = new Dune_Form_InputSubmit('������');
$ff->setValue('������');
$ff->setClass('hypo-submit');
?> <p style="margin:0; padding: 20px 0 0 0; text-align:center;"><?php
echo $ff->get();
?> </p> <?php
echo $f->getEnd();
?>

</div>
</div>