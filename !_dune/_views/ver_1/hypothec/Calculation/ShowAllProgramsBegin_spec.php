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

<th class="<?php echo $this->sumcreditmin_pp_class;?>"><a href="/modules.php?name=Hypothec&op=CalculationList&version=<?php echo $this->version; ?>&_do_=order&col_name=sumcreditmin_pp">������ �������</a></th>
<th class="<?php echo $this->sumcreditmin_pp_class;?>">��������� �� ���������</th>
<th class="<?php echo $this->sumcreditmin_pp_class;?>">������ � 1-� �����</th>
<th class="<?php echo $this->sumcreditmin_pp_class;?>">������ � 1-� ����� (<a target="_blank" title="��������� �������� ���������� ������������ ���������� �������� ������ ������" href="/modules.php?name=Hypothec&op=Privilege">������</a>)</th>

<th class="<?php echo $this->rate_pp_class;?>"><a href="/modules.php?name=Hypothec&op=CalculationList&version=<?php echo $this->version; ?>&_do_=order&col_name=rate_pp">������</a></th>
<th class="<?php echo $this->creditperiod_pp_class;?>"><a href="/modules.php?name=Hypothec&op=CalculationList&version=<?php echo $this->version; ?>&_do_=order&col_name=creditperiod_pp">���� ������� (����)</a></th>


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
	 <?php echo number_format($program['sum_first'], 0, ',', ' ');?> 
	</td>
	
	
	<td>
	<?php echo number_format($program['sum_bank'],0,'.',' ');?>
	</td>
	
	
	<td>
	<?php echo number_format($program['pay_over'],0,'.',' ');?>
	</td>
	
	<td>
	<?php echo number_format($program['pay_month'],0,'.',' ');?>
	</td>
	<td>
	<?php
	if ($program['pay_lgota'])
	   echo number_format($program['pay_lgota'],0,'.',' ');
	 else echo '-';
	 ?>
	</td>
	
	<td>
	<?php if ($program['rate_pp']) echo number_format($program['rate_pp'], 2) . '&nbsp;%';
	       else echo '�� ����������';
	?>
	</td>
	<td>
	
	<?php echo $program['creditperiod_fact'];
	       //else echo $program['creditperiodmin'] . '&nbsp;-&nbsp;' . $program['creditperiodmax'];
	?>
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