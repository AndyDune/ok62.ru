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
<a id="logo-3" target="_blank" href="http://www.edinstvo62.ru/" title='ЗАО "Группа компаний "ЕДИНСТВО"'>
<img src="<?php echo $this->view_path; ?>/img/logoed.gif" alt="ЕДИНСТВО" />
</a>
<p id="site-name">Центр управления недвижимостью</p>

<form method="post" action="/catalogue/">
<p id="p-object-go">
<!--
<input  size="11" class="title-to-value" title="код объекта" type="text" name="object_code" value="" />


 <input type="image" src="<?php echo $this->view_path; ?>/img/find_object.png" style="position:relative; top: 6px; padding:0; margin:0;" title="Найти объект по коду." alt="Найти объект" />
 -->
</p>
</form>

<!--
<p id="p-sell-buttom">
<a href="/public/sell/">Разместить объявление</a></p>
-->
<?php echo $this->top_menu; ?>
<?php echo $this->header; ?>
<?php echo $this->auth_field_v2; ?>
</div>
<div id="mega-content">
<?php echo $this->run_string; ?>

<div id="auth-form-and-new-last"><div class="line"><!-- Колонки сверху -->

<div class="item" id="auth-form-col"><div class="sap-content">
<?php echo $this->auth_field; ?>
</div></div>


<div class="item" id="new-last-col"><div class="sap-content"><!--  Новое последнее в системе -->
<?php echo $this->objects_list_new; ?>
<?php echo $this->objects_list_pop; ?>
</div></div><!--/ Новое последнее в системе -->

</div></div><!-- / Колонки сверху -->

<?php echo $this->objects_search; ?>

<div id="canvas-on-main"> <?php // Странное: при описаниии  casnvas - контент улетает выше блока ?>
<div class="line" id="line-canvas-on-main">
	  <div class="item" id="canvas-on-main-left"><div class="sap-content">
	  
<!-- !!!! ВРЕМЕННО -->	  
<div id="banners-left">

<?php if (!$this->subdomainFocusUserId) { ?>
<div><a href="http://www.edinstvo62.ru/modules.php?name=CleanWater"><img src="/data/banners/img/voda.gif" align="Чистая вода в каждый дом!" width="270" height="130" /></a></div>
<div><a href="/public/plan/draw/"><img src="/data/banners/left/1/img/1.gif" align="Нарисуйте планировку своей квартиры самостоятельно." width="270" height="130" /></a></div>
<div><a target="_blank" href="http://www.edinstvo62.ru/modules.php?name=Hypothec&op=ShowHypothecClub&c=vmeste"><img alt="Программа развития ипотечного кредитования Строим вместе" src="/data/banners/img/ipoteka.gif" width="270" height="130" /></a></div>
<div><a href="/modules.php?name=Hypothec&op=Calculation"><img align="Ипотечный калькуляьлр" src="/data/banners/img/kalk.gif" width="270" height="130" /></a></div>
<div><a title="Дисконтная карта «Единство» в подарок!" href="/read/clients-diskont/"><img src="/data/banners/img/diskont.gif" width="260" height="130" alt="Дисконтная карта «Единство» в подарок!" /></a></div>
<?php } ?>
</div>

	  </div></div>
	  
	  <div class="item" id="canvas-on-main-center"><div class="sap-content">
	  <?php
      echo $this->objects_list_elected;
	  echo $this->text; ?>
	  </div></div>
	  
	  <div class="item" id="canvas-on-main-right"><div class="sap-content">
	  </div></div>
</div>
</div>

</div>
</div><div id="footer">
<?php if (Dune_Variables::$userStatus > 999) {?>
<p id="p-admin-panel"><a href="/<?php echo $this->admin;?>/">Панель администратора</a></p>
<?php }?>

<?php
if (Dune_Variables::$userStatus > 999 and false)
{
  ?><p id="generate_time"><?php
    echo $this->time;
?></p>
<?php } ?>
<p id="bottom_link" align="right">
<A href="/catalogue/type/1/adress/1/1/1/0/0/0/"><b>квартиры Рязани</b></A> . 
<A href="/catalogue/type/2/adress/1/1/1/0/0/0/"><b>дома Рязани</b></A> . 
<A href="/catalogue/type/4/adress/1/1/1/0/0/0/"><b>коммерческая недвижимость Рязани</b></A> . 
<A href="/catalogue/type/4/adress/1/1/1/0/0/0/"><b>новостройки Рязани</b></A> . 
<A href="/catalogue/adress/1/1/1/0/0/0/">вся <b>недвижимость Рязани</b></A> . <BR>
<A href="/modules.php?name=Hypothec"><b>Ипотека</b></A> . 
<A href="/modules.php?name=Hypothec&op=Calculation"><b>Ипотечный калькулятор</b></A> . 
<A href="/modules.php?name=Hypothec&op=ShowAllPrograms"><b>Ипотечные программы</b></A> . 
<A href="/modules.php?name=Hypothec&op=Privilege"><b>Льготная ипотека</b></A> . 
</p>

<?php
if (Dune_Variables::$userStatus > 599)
{
    ?><p><a href="/seller/">Панель продавца</a></p><?php } ?>
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
