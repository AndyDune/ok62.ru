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
<a id="logo" href="/" title="Открытый Каталог Недвижимости Рязани"><img src="<?php echo $this->view_path; ?>/img/logo.gif" alt="Открытый Каталог Недвижимости Рязани" /></a>
<img id="logo-2" src="<?php echo $this->view_path; ?>/img/r.png" alt="" />
<a id="logo-3" target="_blank" href="http://www.edinstvo62.ru/" title='ЗАО "Группа компаний "ЕДИНСТВО"'>
<img src="<?php echo $this->view_path; ?>/img/logoed.gif" alt="ЕДИНСТВО" />
</a>
<p id="site-name">Раздел продавца</p>

</div>

<div id="mega-content">
<?php echo $this->text; ?>
</div> <!--/ mega-content -->

</div> <!--/ main-no-footer -->
<div id="footer">
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
</div>
</div>


</body>
</html>
