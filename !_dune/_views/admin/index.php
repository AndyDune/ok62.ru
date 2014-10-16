<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>Панель управления</title>
<?php
echo Dune_Static_StylesList::get();
echo Dune_Static_JavaScriptsList::get();
?>
</head><body<?php if ($this->body_id) echo ' id="' . $this->body_id . '"'; ?>><div id="main">
<div id="header"> <!-- Заголовок пейджа. Начало.-->
<p id="head-word-main">DUNE</p>
<p id="head-word-about">Административная панель</p>
</div> <!-- Заголовок пейджа. Конец.-->
<div id="menu-top">
<ul>
<li><a href="/<?php echo $this->command_admin;?>/total/" class="main-menu-total"><span>Общее</span></a></li>
<li><a href="/<?php echo $this->command_admin;?>/catalogue/" class="main-menu-catalogue"><span>Управление каталогом</span></a></li>
<li><a href="/<?php echo $this->command_admin;?>/info/" class="main-menu-info"><span>Информация</span></a></li>
</ul>
</div>
<div id="middle" class="one two"> <!-- Средныы часть пейджа. Начало.-->

<div id="canvas"><div class="line"> <!-- имитация абсолютного позиционирования. Начало-->

<div class="item" id="item1"><div class="sap-content"><!-- Контейнер левого меню. Начало. -->
<?php echo $this->menu_left ?>
</div></div><!-- Контейнер левого меню. Конец. -->

<div class="item" id="item2"><div class="sap-content"><!-- Контейнер Основного содержания. Начало. -->
<div id="text"><?php echo $this->text;
?></div>
</div></div><!-- Контейнер Основного содержания. Конец. -->
<?php // echo $this->text;
?>

</div></div> <!-- имитация абсолютного позиционирования. Конец -->


</div> <!-- Средныы часть пейджа. Конец.-->
<div id="footer"></div>
</div></body></html>
