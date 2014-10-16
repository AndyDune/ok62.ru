<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title><?php echo $this->title;?></title>
<meta name="description" content="<?php echo htmlspecialchars($this->description); ?>" />
<meta name="keywords" content="<?php echo htmlspecialchars($this->keywords); ?>" />
<?php
echo $this->css;
echo $this->js;
?>
</head>
<body>

<!-- begin of Top100 code -->
<script id="top100Counter" type="text/javascript" src="http://counter.rambler.ru/top100.jcn?1633488"></script><noscript><img src="http://counter.rambler.ru/top100.cnt?1633488" alt="" width="1" height="1" border="0"></noscript>
<!-- end of Top100 code -->

<div id="mega-main">
<div id="main-no-footer">
<div id="header"> 



<a id="logo" href="/" title="Открытый Каталог Недвижимости Рязани"><img src="/viewfiles/default/<?php echo $this->view_realization; ?>/img/logo_4.jpg" alt="Открытый Каталог Недвижимости Рязани" /></a>
<?php echo $this->auth_field; ?>
<?php echo $this->header; ?>
</div>
<div id="mega-content">
<?php
echo $this->text
?>
</div>
</div><div id="footer">
<p id="generate_time"><?php
echo $this->time;
?></p>
<p id="bottom_link" align="right">
<A href="/catalogue/type/1/adress/1/1/1/0/0/0/"><b>квартиры Рязани</b></A> . 
<A href="/catalogue/type/2/adress/1/1/1/0/0/0/"><b>дома Рязани</b></A> . 
<A href="/catalogue/type/4/adress/1/1/1/0/0/0/"><b>коммерческая недвижимость Рязани</b></A> . 
<A href="/catalogue/adress/1/1/1/0/0/0/">вся <b>недвижимость Рязани</b></A> . <BR>
<A href="/modules.php?name=Hypothec"><b>Ипотека</b></A> . 
<A href="/modules.php?name=Hypothec&op=Calculation"><b>Ипотечный калькулятор</b></A> . 
<A href="/modules.php?name=Hypothec&op=ShowAllPrograms"><b>Ипотечные программы</b></A> . 
</p>

</div>
</div>

<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
var pageTracker = _gat._getTracker("UA-1677018-6");
pageTracker._trackPageview();
</script>

</body>
</html>
