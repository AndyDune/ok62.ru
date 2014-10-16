<?php echo $this->crumbs; 
$vars = Dune_Variables::getInstance();
if (!$vars->pensia_age)
    $vars->pensia_age = 65;
?>
<hr />
<div id="hypotec-info">
<h1>������ �������� ���������� ��� ���������</h1>

<a id="to-compare-a" href="/modules.php?name=Hypothec&op=ShowAllPrograms">������ ���� ��������</a>
<a id="to-search" href="/modules.php?name=Hypothec&op=ShowProgramsToCompareFull">��������� ���������</a>
<?php if (count($this->array)) {?>

<div>
<table class="expenses-table" width="100%">
<tr class="table-header-tr">
<th class="<?php echo $this->name_pp_class;?>"><a href="/modules.php?name=Hypothec&op=ShowProgramsToCompare&_do_=order&col_name=name_pp" title="����������� �� �������.">���������</a></th>
<?php
//<th class="<? php echo $this->kinds_pp_class;? >"><a href="/modules.php?name=Hypothec&op=ShowAllPrograms&_do_=order&col_name=kinds_pp" title="����������� �� �������.">��� ������������</a></th>
?>
<th class="<?php echo $this->currencyid_pp_class;?>"><a href="/modules.php?name=Hypothec&op=ShowProgramsToCompare&_do_=order&col_name=currencyid_pp">������</a></th>
<th class="<?php echo $this->firstpayment_pp_class;?>"><a href="/modules.php?name=Hypothec&op=ShowProgramsToCompare&_do_=order&col_name=firstpayment_pp">������ �����</a></th>
<th class="<?php echo $this->rate_pp_class;?>"><a href="/modules.php?name=Hypothec&op=ShowProgramsToCompare&_do_=order&col_name=rate_pp">������</a></th>
<th class="<?php echo $this->creditperiod_pp_class;?>"><a href="/modules.php?name=Hypothec&op=ShowProgramsToCompare&_do_=order&col_name=creditperiod_pp">���� �������</a></th>

<th class="<?php echo $this->sumcreditmin_pp_class;?>"><a href="/modules.php?name=Hypothec&op=ShowProgramsToCompare&_do_=order&col_name=sumcreditmin_pp">������ ������� (���.)</a></th>
<th class="<?php echo $this->sumcreditmax_pp_class;?>"><a href="/modules.php?name=Hypothec&op=ShowProgramsToCompare&_do_=order&col_name=sumcreditmax_pp">������ ������� (����.)</a></th>
<th></th>
</tr>

<?php foreach ((array)$this->array as $program) {?>
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
	   if (!isset($program['creditperiod_pp']))
	       $program['creditperiod_pp'] = 15;
	   if ($this->age)
	   {
	       $to_p = $program['agemax'] - $this->age;
	       if ($to_p <= 0)
	       {
                echo '(<a class="tt" href="#pensia" title="' . $vars->text_more_then_age_max . '">*</a>)<br />';	           
	       }
	       else if ($to_p < $program['creditperiod_pp'])
	           echo '(<a class="tt" href="#pensia" title="' . $vars->text_age_to_pensia_near .'">' . $to_p . '*</a>)<br />';
	   }
	
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
	<a class="add-to-com-a" href="/modules.php?name=Hypothec&op=todo&it=delete_from_compare&pprogram_id=<?php echo $program['pprogram_id'];?>" title="������� �� ������"> &ndash; </a>
	</td>

	
    </tr>	
	
<?php } ?>
</table>
</div>

<?php } else { ?>
<p id="general-report">������ ����</p>
<?php }?>
</div>