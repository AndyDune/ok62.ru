<?php echo $this->crumbs; ?>

<center><span style="font-family: Arial; font-weight: bold;"><h1>Банки</h1><br></center></span>
   
     <table  bgcolor="#ffffff" width="100%" cellpadding="6" cellspacing="0" class="table-banks-list">
     		<tr >
				<th>&nbsp;</th>     		
     			<th>Банк</th>
     			<th>Новостройку в ипотеку</th>
     			<th>Готовое жилье в ипотеку</th>
     			<th>Количество ипотечных программ</th>
     		</tr>
     	<?php foreach($this->banks as $bank) { ?>
     		<tr>
     			<td align="center" border="0" bgcolor="#FFFFFF"><a href="/modules.php?name=Hypothec&op=ShowFixedBank&bankID=<?php echo $bank['ID'] ?>"><img height="120" width="120" src="<?php echo $this->IMG_PATH, $bank['LOGO_URL']; ?>" border="0"></a></td>
     			<td align="center" style="text-color: red;"><a href="/modules.php?name=Hypothec&op=ShowFixedBank&bankID=<?php echo $bank['ID'] ?>"><?php echo $bank['NAME'] ?></a></td>
     			<td align="center"><?php if ($bank['NOVOSTROI']) { ?><img src="<?php echo $this->IMG_PATH ?>accept2.gif"><?php } else {?> - <?php } ?></td>
     			<td align="center"><?php if ($bank['VTOR']) { ?><img src="<?php echo $this->IMG_PATH ?>accept2.gif"><?php } else {?> - <?php } ?></td>
     			<td align="center" class="table-tr-h-count">
     			<?php if ($bank['programs'] > 0) { ?>
     			<a href="/modules.php?name=Hypothec&op=ShowFixedBank&bankID=<?php echo $bank['ID'] ?>" title="Смотреть список программ банка"><?php echo $bank['programs'] ?><br /></a>
     			<?php } else { ?>
     			НЕТ
     			<?php } ?>
     			
     			</td>
     		</tr>
     	<?php } ?>
     </table>
