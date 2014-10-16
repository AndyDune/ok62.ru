<div id="talk-mode-change">
<ul>
<li class="current"><p><span><em>Продавец</em></span></p></li>
</ul>
</div>
<div id="talk-list"><div style="position:relative; width:100%;">&nbsp;

<h2></h2>

<div style="padding: 10px;">

<?php if ($this->auth or true) { ?>

<table id="table-object-saler-info">

<tr>
<td class="td-saler-info-name">
Контактное имя:
</td><td class="td-saler-info-data">
<a href="/user/info/<?php echo $this->user_info->id; ?>/" title="Персональная страница">
<?php
if ($this->user_info->contact_name)
    echo $this->user_info->contact_name;
else 
    echo $this->user_info->name; 
  ?>
 </a>
</td>
<td class="td-saler-info-data-add">
<a href="/user/info/<?php echo $this->user_info->id; ?>/" title="Персональная страница">
Персональная страница
</a>
</td>
</tr>

<?php
// Показ фамилии
if ($this->user_info_allow->contact_surname)
{
?>

<?php echo $this->user_info->contact_surname;

} ?>



<?php
// Показ адреса электроной почты
if ($this->user_info_allow->mail_allow) {?>
<tr>
<td class="td-saler-info-name">
Эл.почта:
</td><td class="td-saler-info-data">
 <a href="mailto:<?php echo $this->user_info->mail; ?>"><?php echo $this->user_info->mail; ?></a>
</td>
<td class="td-saler-info-data-add">
</td>
</tr>
<?php } ?>



<?php
// Показ адреса электроной почты
if ($this->user_info_allow->phone_allow) {?>
<tr>
<td class="td-saler-info-name">
Телефон:
</td><td class="td-saler-info-data">
 <?php echo $this->user_info->phone; ?>
</td>
<td class="td-saler-info-data-add">
</td>
</tr>
<?php } ?>

<?php
// Показ аськи
if ($this->user_info_allow->icq_allow and $this->user_info->icq) {?>
<tr style="height: 30px;">
<td class="td-saler-info-name">
ICQ&nbsp; :
</td><td class="td-saler-info-data">
<img style="display:inline; line-height:12px; vertical-align:bottom; position:relative; bottom: 1px;" alt="статус" src="http://wwp.icq.com/scripts/online.dll?icq=<?php echo str_ireplace(array(' ', '-', '(', ')'), '',$this->user_info->icq); ?>&img=5&rnd=<?php echo rand(1000, 9999) ?>" />
<a href="#" onclick='clientWindow = window.open("http://www.icq.com/icq2go/flicq.html","ICQ2Go","left=20,top=20,width=176,height=441,toolbar=0,resizable=0");return false;'>
 <?php echo $this->user_info->icq; ?>
 </a>
</td>
<td class="td-saler-info-data-add">
</td>
</tr>
<?php } ?>


<?php
// Показ адреса электроной почты
if ($this->user_info->site) {?>
<tr>
<td class="td-saler-info-name">
Сайт:
</td><td class="td-saler-info-data">
 <?php
if (strpos($this->user_info->site, 'http://') !== false)
{
    $link = $this->user_info->site;
    $name = substr($this->user_info->site, 7);
}
else 
{
    $link = 'http://' . $this->user_info->site;
    $name = $this->user_info->site;
}
?>
<noindex>
<a target="_blank" rel="nofollow" href="<?php echo $link; ?>"><?php echo $name; ?></a>
</noindex>
</td>
<td class="td-saler-info-data-add">
</td>
</tr>
<?php } ?>



</table>
<?php } else { ?>

<p id="talk-no" style="color:red; text-align:center; font-size: 110%;"><a style="color:red; font-size: 120%;" href="/user/enter/">
Авторизуйтесь чтобы получить доступ к информции о продавце.
</a></p>

<?php } ?>

</div>
&nbsp;
<div class="ugol-left-top"></div>
<div class="ugol-left-bottom"></div>
<div class="ugol-right-top"></div>
<div class="ugol-right-bottom"></div></div></div>
