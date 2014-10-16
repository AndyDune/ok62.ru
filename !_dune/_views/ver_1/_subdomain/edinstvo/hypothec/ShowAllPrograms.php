<?php echo $this->crumbs; ?>
<hr />
<div id="hypotec-info">
<h1>������ ��������� ��������</h1>

<?php if ($this->show_compare_button) {?>
<a id="to-compare-a" href="/modules.php?name=Hypothec&op=ShowProgramsToCompare">������ ���������� ��� ��������� (<?php echo $this->show_compare_button;?>)</a>
<?php } ?>

<div style="margin:  0 0 15px 3px;">

<table>
<?php 
$f = new Dune_Form_Form();
//$f->setAction('/modules.php');
$f->setMethod();
echo $f->getBegin();

//?name=Hypothec&op=ShowAllPrograms
$ff = new Dune_Form_InputHidden('name');
$ff->setValue('Hypothec');
echo $ff->get();
$ff = new Dune_Form_InputHidden('op');
$ff->setValue('ShowAllPrograms');
echo $ff->get();
$ff = new Dune_Form_InputHidden('_do_');
$ff->setValue('do');
echo $ff->get();

if (count($this->banks) > 0) {?>
<tr>
<td>����: 
</td>
<td>
<?php $opt = new Dune_Form_Select('bank_id');
$opt->setOption(0, '���');
foreach ($this->banks as $value)
{
    if ($value['id'] == $this->bank_id)
    {
        $opt->setOption($value['id'], $value['name'], true);
    }
    else 
        $opt->setOption($value['id'], $value['name']);
}
echo $opt->get();
?>
</td>
</tr>
<?php }?>


<tr>
<td>������ (�� �����): 
</td>
<td>
<?php $ff = new Dune_Form_InputText('rate_pp');
if ($this->rate_pp == 0)
    $this->rate_pp = '';
$ff->setValue($this->rate_pp);
$ff->setMaxLength(5);
$ff->setSize(6);
echo $ff->get() . ' %';
?>
</td>
</tr>


<tr>
<td>������ ���� (�� �����): 
</td>
<td>
<?php $ff = new Dune_Form_InputText('firstpayment_pp');
if ($this->firstpayment_pp == 0)
    $this->firstpayment_pp = '';
$ff->setValue($this->firstpayment_pp);
$ff->setMaxLength(5);
$ff->setSize(6);
echo $ff->get() . ' %';
?>
</td>
</tr>

<tr>
<td>������: 
</td>
<td>
<?php $opt = new Dune_Form_Select('currencyid_pp');
foreach ($this->data_specify_array['currencyid_rus'] as $key => $value)
{
    if ($key == $this->currencyid_pp)
    {
        $opt->setOption($key, $value, true);
    }
    else 
        $opt->setOption($key, $value);
}
echo $opt->get();
?>
</td>
</tr>

</table>
<?php
$ff = new Dune_Form_InputSubmit('���������');
$ff->setValue('�����');
?> <p style="margin:0; padding: 0 0 0 330px;"><?php
echo $ff->get();
?> </p> <?php
echo $f->getEnd();
?>

</div>
<div>
<table class="expenses-table" width="100%">
<tr class="table-header-tr">
<th class="<?php echo $this->name_pp_class;?>"><a href="/modules.php?name=Hypothec&op=ShowAllPrograms&_do_=order&col_name=name_pp" title="����������� �� �������.">���������</a></th>
<?php
//<th class="<? php echo $this->kinds_pp_class;? >"><a href="/modules.php?name=Hypothec&op=ShowAllPrograms&_do_=order&col_name=kinds_pp" title="����������� �� �������.">��� ������������</a></th>
?>
<th class="<?php echo $this->currencyid_pp_class;?>"><a href="/modules.php?name=Hypothec&op=ShowAllPrograms&_do_=order&col_name=currencyid_pp">������</a></th>
<th class="<?php echo $this->firstpayment_pp_class;?>"><a href="/modules.php?name=Hypothec&op=ShowAllPrograms&_do_=order&col_name=firstpayment_pp">������ �����</a></th>
<th class="<?php echo $this->rate_pp_class;?>"><a href="/modules.php?name=Hypothec&op=ShowAllPrograms&_do_=order&col_name=rate_pp">������</a></th>
<th class="<?php echo $this->creditperiod_pp_class;?>"><a href="/modules.php?name=Hypothec&op=ShowAllPrograms&_do_=order&col_name=creditperiod_pp">���� �������</a></th>

<th class="<?php echo $this->sumcreditmin_pp_class;?>"><a href="/modules.php?name=Hypothec&op=ShowAllPrograms&_do_=order&col_name=sumcreditmin_pp">������ ������� (���.)</a></th>
<th class="<?php echo $this->sumcreditmax_pp_class;?>"><a href="/modules.php?name=Hypothec&op=ShowAllPrograms&_do_=order&col_name=sumcreditmax_pp">������ ������� (����.)</a></th>

<th></th>
</tr>

<?php foreach ($this->array as $program) {?>
    <tr>
    <td class="first">
    <strong class="p-name-in-shot-table">    
	<a href="modules.php?name=Hypothec&op=ShowFixedPProgram&programID=<?php echo $program['pprogram_id'];?>" title="��������� �������� �������� ��������� ������������"><?php echo $program['name_pp'];?></a>
	</strong>
	<a class="b-name-in-shot-table" href="/modules.php?name=Hypothec&op=ShowFixedBank&bankID=<?php echo $program['bank_id'];?>" title="�������������"><?php echo $program['name'];?></a>
	</td>
<?php 	
/*	<td>
	<? php echo $this->data_specify_array['kinds'][$program['kinds_pp']]; ? >
	</td>
*/?>	
	<td>
	<?php echo $this->data_specify_array['currencyid_rus'][$program['currencyid_pp']]?>
	</td>
	<td>
	�� <?php echo $program['firstpayment_pp'];?> %
	</td>

	<td>
	<?php if ($program['rate_pp']) echo number_format($program['rate_pp'], 2) . '&nbsp;%';
	       else echo '�� ����������';
	?>
	</td>
	<td>
	<?php if ($program['creditperiod_pp']) echo $program['creditperiod_pp'];
	       //else echo $program['creditperiodmin'] . '&nbsp;-&nbsp;' . $program['creditperiodmax'];
	?> ���
	</td>
	
	
	<td>
	<?php echo number_format($program['sumcreditmin_pp'],0,'.',' ');?>
	</td>
	
	<td>
	<?php echo number_format($program['sumcreditmax_pp'],0,'.',' ');?>
	</td>
	

	<td>
	<?php if (isset($this->elected_id_array[$program['pprogram_id']])) {?>
	<a class="add-to-com-a" href="http://edinstvo62.host/modules.php?name=Hypothec&op=ShowProgramsToCompare" title="��������� � ���������">!</a>
	<?php } else {?>
	<a class="add-to-com-a" href="/modules.php?name=Hypothec&op=todo&it=add_to_compare&pprogram_id=<?php echo $program['pprogram_id'];?>" title="�������� � ���������">+</a>
	<?php }?>
	</td>
	
    </tr>	
    		
	
<?php } ?>
</table>
</div>
<?php echo $this->navigation; ?>
</div>