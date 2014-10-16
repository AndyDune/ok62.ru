<h1 id="h1-for-auth-forms">экспорт</h1>

<?php switch ($this->message_code) { 
case 1: ?>
<p id="system-message">Экспорт случился удачно.</p>
<?php break; ?> 

<?php case 2: ?>
<p id="system-message">Нет указанной папки.</p>
<?php break; ?> 

<?php case 3: ?>
<p id="system-message">Нет файла с данными.</p>
<?php break; ?> 

<?php case 4: ?>
<p id="system-message">Ошибка парсинга файла.</p>
<?php break; ?> 


<?php case 5: ?>
<p id="system-message">Данные  экспортированы.</p>
<?php break; ?> 


<?php case 10: ?>
<p id="system-message">Ошибка.</p>
<?php break; ?> 

<?php } ?>



<div id="user-enter-form-page">
<form method="post">
<input name="_do_" type="hidden" value="export" />
<dl id="user-logo-dl">
<dt>Папка</dt>
<dd><input name="folder" type="text" value="" size="50" maxlength="50" /></dd>
</dl>
<p id="user-enter-page-submit"><input name="go" type="submit" value="Вперед!" /></p>
</form>
</div>

<div style="width:1000px;">
<?php echo $this->text; ?>
</div>