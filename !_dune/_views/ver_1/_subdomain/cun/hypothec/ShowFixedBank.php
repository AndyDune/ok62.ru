<?php echo $this->crumbs; ?>
<hr />
<h1 style="font-size: 22px; text-align:center;"><?php echo $this->bank['NAME'];?></h1>
<table border="0" cellspacing="5">
<tr>
<td align="left" colspan="2" style="vertical-align: top;">

	<table border="0" cellspacing="5">
		<tr> 

		<td>
		<?php if ($this->bank['BANK_URL']) { ?>
		  <a href="<?php echo $this->bank['BANK_URL'];?>" target="_blank" alt="Логотип банка"><img src="<?php echo $this->IMG_PATH . $this->bank['LOGO_URL'];?>"></a>
		<?php  } else { ?>
		  <img src="<?php echo $this->IMG_PATH . $this->bank['LOGO_URL'];?>">
		<?php  } ?>
		<br / >
		
		<?php if ($this->bank['BANK_URL']) { ?>
		  <p style="text-align:center;"><a href="<?php echo $this->bank['BANK_URL'];?>" target="_blank"><?php echo $this->bank['BANK_URL_SHOW'];?></a></p>
		<?php  }?>
		</td> 
			<td style="padding: 10px;">
			
<?php echo $this->bank['DISCRIPTION'];?><br><br>

     		</td>
		</tr>	
    </table>

</td>
</tr>

<tr>
	<td style="font-size: 14px; font-family: Times New Roman;" align="justify" colspan="2">
	 	<?php //echo $this->bank['DISCRIPTION'];?><br><br>
	</td>
</tr>



<?php if ($this->SHOW_PROGRAM) { ?>
<tr>

<th colspan="2" style="border-bottom: solid red 2px;">Ипотечные программы:</th></tr>
<tr><td colspan="2">





<div>
<table class="expenses-table" width="100%">
<tr class="table-header-tr">
<th>Программа</th>
<?php
//<th class="<? php echo $this->kinds_pp_class;? >"><a href="/modules.php?name=Hypothec&op=ShowAllPrograms&_do_=order&col_name=kinds_pp" title="Сортировать по колонке.">Вид кредитования</a></th>
?>
<th>Валюта</th>
<th>Первый взнос</th>
<th>Ставка</th>
<th>Срок кредита</th>

<th>Размер кредита (мин.)</th>
<th>Размер кредита (макс.)</th>

<th></th>
</tr>

<?php foreach ($this->array as $program) {?>
    <tr>
    <td class="first">
    <strong class="p-name-in-shot-table">    
	<a href="modules.php?name=Hypothec&op=ShowFixedPProgram&programID=<?php echo $program['pprogram_id'];?>" title="Подробное описание варианта программы кредитования"><?php echo $program['name_pp'];?></a>
	</strong>
	<a class="b-name-in-shot-table" href="/modules.php?name=Hypothec&op=ShowFixedBank&bankID=<?php echo $program['bank_id'];?>" title="Описаниебанка"><?php echo $program['name'];?></a>
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
	от <?php echo $program['firstpayment_pp'];?> %
	</td>

	<td>
	<?php if ($program['rate_pp']) echo number_format($program['rate_pp'], 2) . '&nbsp;%';
	       else echo 'Не определено';
	?>
	</td>
	<td>
	<?php if ($program['creditperiod_pp']) echo $program['creditperiod_pp'];
	       //else echo $program['creditperiodmin'] . '&nbsp;-&nbsp;' . $program['creditperiodmax'];
	?> лет
	</td>
	
	
	<td>
	<?php echo number_format($program['sumcreditmin_pp'],0,'.',' ');?>
	</td>
	
	<td>
	<?php echo number_format($program['sumcreditmax_pp'],0,'.',' ');?>
	</td>
	

	<td>
	<?php if (isset($this->elected_id_array[$program['pprogram_id']])) {?>
	<a class="add-to-com-a" href="http://edinstvo62.host/modules.php?name=Hypothec&op=ShowProgramsToCompare" title="Добавлено к сравнению">!</a>
	<?php } else {?>
	<a class="add-to-com-a" href="/modules.php?name=Hypothec&op=todo&it=add_to_compare&pprogram_id=<?php echo $program['pprogram_id'];?>" title="Добавить к сравнению">+</a>
	<?php }?>
	</td>
	
    </tr>	
    		
	
<?php } ?>
</table>
</div>
<?php echo $this->navigation; ?>


<!--
<table class="expenses-table" width="100%">
<tr class="table-header-tr">
<th>Программа</th>
<th>Валюта</th>
<th>Ставка</th>
<th>Срок&nbsp;кредита</th>
<th>Первый&nbsp;взнос</th>
</tr>

<?php foreach ($this->bank['programs'] as $program) {?>
    <tr>
    <td class="first">
	<a href="modules.php?name=Hypothec&op=ShowFixedProgram&programID=<?php echo $program['ID'];?>"><?php echo $program['NAME'];?></a>
	</td>
	<td>
	<?php echo $this->data_specify_array['currencyid'][$program['currencyid']]?>
	</td>
	<td>
	<?php if ($program['ratemin'] == $program['ratemax']) echo $program['ratemin'];
	       else echo number_format($program['ratemin'], 2) . '&nbsp;-&nbsp;' . number_format($program['ratemax'], 2);
	?>&nbsp;%
	</td>
	<td>
	<?php if ($program['creditperiodmin'] == $program['creditperiodmax']) echo $program['creditperiodmin'];
	       else echo $program['creditperiodmin'] . '&nbsp;-&nbsp;' . $program['creditperiodmax'];
	?> лет
	</td>
	<td>
	от <?php echo $program['firstpayment'];?> %
	</td>

	
    </tr>	
     		
     		<!--<td align="justify"><?php echo $program['BONUS'];?></td>

		<?php } ?>
</table>
-->

</td></tr>
	
<?php } ?>
<!--
<tr>
 <th colspan="2" style="border-bottom: solid red 2px;">Условия кредитования:</th>
</tr>
     		<?php foreach ($this->bank['conditions'] as $condition) {?>
     		<tr bgcolor="">
     			<td align="center"><?php echo $condition['NAME'];?></td>
     			<td align="justify"><?php echo $condition['VALUE'];?></td>
     		</tr>
     		<?php } ?>
-->   
</td>
</tr>

</table>