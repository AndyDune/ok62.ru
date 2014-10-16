<?php echo $this->crumbs; ?>
<hr />
<div id="hypotec-info">
<h1>������ �������� ������������</h1>

<?php if ($this->show_compare_button) {?>
<a id="to-compare-a" href="/modules.php?name=Hypothec&op=ShowProgramsToCompare">������ ���������� ��� ��������� (<?php echo $this->show_compare_button;?>)</a>
<?php } ?>

<a id="to-search" href="/modules.php?name=Hypothec&op=Calculation&version=<?php echo $this->version; ?>">�������� ������ ��� �������</a>

<div>
<table class="expenses-table" width="100%">
<tr class="table-header-tr">
<th class="<?php echo $this->name_pp_class;?>"><a href="/modules.php?name=Hypothec&op=CalculationList&version=<?php echo $this->version; ?>&_do_=order&col_name=name_pp" title="����������� �� �������.">���������</a></th>
<?php
//<th class="<? php echo $this->kinds_pp_class;? >"><a href="/modules.php?name=Hypothec&op=ShowAllPrograms&_do_=order&col_name=kinds_pp" title="����������� �� �������.">��� ������������</a></th>
?>
<th class="<?php echo $this->currencyid_pp_class;?>"><a href="/modules.php?name=Hypothec&op=CalculationList&version=<?php echo $this->version; ?>&_do_=order&col_name=currencyid_pp">������</a></th>
<th class="<?php echo $this->firstpayment_pp_class;?>"><a href="/modules.php?name=Hypothec&op=CalculationList&version=<?php echo $this->version; ?>&_do_=order&col_name=firstpayment_pp">������ �����</a></th>
<th class="<?php echo $this->rate_pp_class;?>"><a href="/modules.php?name=Hypothec&op=CalculationList&version=<?php echo $this->version; ?>&_do_=order&col_name=rate_pp">������</a></th>
<th class="<?php echo $this->creditperiod_pp_class;?>"><a href="/modules.php?name=Hypothec&op=CalculationList&version=<?php echo $this->version; ?>&_do_=order&col_name=creditperiod_pp">���� �������</a></th>

<th class="<?php echo $this->sumcreditmin_pp_class;?>"><a href="/modules.php?name=Hypothec&op=CalculationList&version=<?php echo $this->version; ?>&_do_=order&col_name=sumcreditmin_pp">������ ������� (���.)</a></th>
<th class="<?php echo $this->sumcreditmax_pp_class;?>"><a href="/modules.php?name=Hypothec&op=CalculationList&version=<?php echo $this->version; ?>&_do_=order&col_name=sumcreditmax_pp">������ ������� (����.)</a></th>

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
	<?php 
	$print = $program['creditperiod_pp'];
	if ($this->age)
	{
	    $interv = $program['agemax'] - $this->age;
	    if ($interv < $program['creditperiod_pp'] and $interv > 0)
	       $print = $interv;
	    else 
	       $print = $program['creditperiod_pp'];
	}
	?>
	
	<?php if ($print) echo $print;
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