<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>������ ����������</title>
<?php
echo Dune_Static_StylesList::get();
echo Dune_Static_JavaScriptsList::get();
?>
</head><body<?php if ($this->body_id) echo ' id="' . $this->body_id . '"'; ?>><div id="main">
<div id="header"> <!-- ��������� ������. ������.-->
<p id="head-word-main">DUNE</p>
<p id="head-word-about">���������������� ������</p>
</div> <!-- ��������� ������. �����.-->
<div id="menu-top">
<ul>
<li><a href="/<?php echo $this->command_admin;?>/total/" class="main-menu-total"><span>�����</span></a></li>
<li><a href="/<?php echo $this->command_admin;?>/catalogue/" class="main-menu-catalogue"><span>���������� ���������</span></a></li>
<li><a href="/<?php echo $this->command_admin;?>/info/" class="main-menu-info"><span>����������</span></a></li>
</ul>
</div>
<div id="middle" class="one two"> <!-- ������� ����� ������. ������.-->

<div id="canvas"><div class="line"> <!-- �������� ����������� ����������������. ������-->

<div class="item" id="item1"><div class="sap-content"><!-- ��������� ������ ����. ������. -->
<?php echo $this->menu_left ?>
</div></div><!-- ��������� ������ ����. �����. -->

<div class="item" id="item2"><div class="sap-content"><!-- ��������� ��������� ����������. ������. -->
<div id="text"><?php echo $this->text;
?></div>
</div></div><!-- ��������� ��������� ����������. �����. -->
<?php // echo $this->text;
?>

</div></div> <!-- �������� ����������� ����������������. ����� -->


</div> <!-- ������� ����� ������. �����.-->
<div id="footer"></div>
</div></body></html>
