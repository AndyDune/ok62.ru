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

<a id="logo" href="/" title="Центр управления недвижимостью"><img src="<?php echo $this->view_path; ?>/img/logo.gif" alt="Центр управления недвижимостью" /></a>
<!--
<img id="logo-2" src="<?php echo $this->view_path; ?>/img/r.png" alt="" />
-->
<p id="site-name">Центр управления недвижимостью</p>
<a id="logo-3" target="_blank" href="http://www.edinstvo62.ru/" title='ЗАО "Группа компаний "ЕДИНСТВО"'>
<img src="<?php echo $this->view_path; ?>/img/logoed.gif" alt="ЕДИНСТВО" />
</a>

<?php if (!$this->no_tosell_link) { ?>
<!--
<p id="p-sell-buttom">
<a href="/public/sell/">Разместить объявление</a></p>
-->
<?php } ?>

<form method="post" action="/catalogue/">
<p id="p-object-go">
<!--
<input size="11" class="title-to-value" title="код объекта" type="text" name="object_code" value="<?php echo $this->object_code ?>" />

 
 <input type="image" src="<?php echo $this->view_path; ?>/img/find_object.png" style="position:relative; top: 6px; padding:0; margin:0;" title="Найти объект по коду." alt="Найти объект" />
  -->
</p>
</form>


<?php echo $this->top_menu; ?>
<?php echo $this->header; ?>
<?php echo $this->auth_field_v2; ?>
</div>
<div id="mega-content"><div id="auth-field-not-in-main">
<?php echo $this->auth_field; ?></div>
<?php
echo $this->text
?>
</div>
</div><div id="footer">
<?php if (Dune_Variables::$userStatus > 999) {?>
<p id="p-admin-panel"><a href="/<?php echo $this->admin;?>/">Панель администратора</a></p>
<?php }?>

<?php
if (Dune_Variables::$userStatus > 999)
{
  ?><p id="generate_time"><?php
    echo $this->time;
?></p>
<?php } ?>
<p style="overflow: hidden;width:1px;height:1px;" align="right" id="bottom_link">
<!--begin of Kvartirant.RU RATING-->
<a href="http://www.kvartirant.ru">
<img src="http://www.kvartirant.ru/counter.php?site=54856" alt="Аренда квартир" width=88 height=31 border=0></a>
<!--end of Kvartirant.RU RATING-->
</p>
<p id="bottom_link" align="right">
<A href="/catalogue/type/1/adress/1/1/1/0/0/0/"><b>квартиры Рязани</b></A> . 
<A href="/catalogue/type/2/adress/1/1/1/0/0/0/"><b>дома Рязани</b></A> . 
<A href="/catalogue/type/4/adress/1/1/1/0/0/0/"><b>коммерческая недвижимость Рязани</b></A> . 
<A href="/catalogue/adress/1/1/1/0/0/0/">вся <b>недвижимость Рязани</b></A> . <BR>
<A href="/modules.php?name=Hypothec"><b>Ипотека</b></A> . 
<A href="/modules.php?name=Hypothec&op=Calculation"><b>Ипотечный калькулятор</b></A> . 
<A href="/modules.php?name=Hypothec&op=ShowAllPrograms"><b>Ипотечные программы</b></A> . 
<A href="/modules.php?name=Hypothec&op=Privilege"><b>Льготная ипотека</b></A> . 
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
