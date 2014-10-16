
<div id="info-part">

<h3>Информация о пользователе «<?php echo $this->user->name;?>»</h3>
<div id="user-main-info">
      <?php
      if ($this->array_photo)
      {
          ?><a class="thickbox user-pic" href="<?php echo $this->array_photo[1] ?>"><img src="<?php
        echo $this->array_photo[2];
        ?>" width="100" height="100" /></a><?php
      }
      else 
      {
        ?><img class="user-pic" src="<?php echo $this->view_folder;?>/img/user/avatars/first.gif" width="100" height="100" /><?
      }
      ?>

<div class="user-main-info-table"><div>
<table>

<tr>
<th class="prompting"></th>
<th>
</th>
</tr>

<tr>
<td class="prompting"><strong>Псевдоним в системе</strong></td>
<td>
<?php echo $this->user->name;?>
</td>
</tr>

<?php
if ($this->user->contact_name)
{
?>
<tr>
<td class="prompting"><strong>Контактное имя</strong></td>
<td>
<?php echo $this->user->contact_name;?>
</td>
</tr>
<?php
}
?>


<?php
if (false) { 
if (($this->user_info_allow->contact_surname_allow or $this->system_user_status > 499) and $this->user->contact_surname)
{
?>
<tr>
<td class="prompting"><strong>Полное имя (Ф.И.О.)</strong></td>
<td>
<?php echo $this->user->contact_surname;?>
</td>
</tr>
<?php
} }
?>

<?php
if ($this->user_info_allow->mail_allow or $this->system_user_status > 499)
{
?>
<tr>
<td class="prompting"><strong>e-mail</strong></td>
<td><a href="mailto:<?php echo $this->user->mail;?>">
<?php echo $this->user->mail;?>
</a></td>
</tr>
<?php
}
?>


<?php
if (($this->user_info_allow->phone_allow or $this->system_user_status > 499) and $this->user->phone )
{
?>
<tr>
<td class="prompting"><strong>Телефон</strong></td>
<td>
<?php echo $this->user->phone;?>
</td>
</tr>
<?php
}
?>



<?php
// Показ аськи
if (($this->user_info_allow->icq_allow  or $this->system_user_status > 499) and $this->user->icq) {?>
<tr style="height: 30px;">
<td>
<strong>ICQ&nbsp; :</strong>
</td><td class="td-saler-info-data">
<img style="display:inline; line-height:12px; vertical-align:bottom; position:relative; bottom: 1px;" alt="статус" src="http://wwp.icq.com/scripts/online.dll?icq=<?php echo str_ireplace(array(' ', '-', '(', ')'), '',$this->user_info->icq); ?>&img=5&rnd=<?php echo rand(1000, 9999) ?>" />
<a href="#" onclick='clientWindow = window.open("http://www.icq.com/icq2go/flicq.html","ICQ2Go","left=20,top=20,width=176,height=441,toolbar=0,resizable=0");return false;'>
 <?php echo $this->user->icq; ?>
 </a>
</td>
</tr>
<?php } ?>


<?php if ($this->user->getUserArrayCell('about_me')) { ?>
<tr><td  style="vertical-align:top;">
<strong>О себе</strong></td>
<td>

<?php
$str = new Dune_String_Transform($this->user->getUserArrayCell('about_me'));
echo $str->deleteLineFeed(2)->setLineFeedToBreak()->getResult();
//echo $this->user->getUserArrayCell('about_me');
?>

</td></tr>
<?php } ?>


</table>

</div>


<h3></h3>
<table>

<tr>
<th class="prompting"></th>
<th>

</th>
<th></th>
</tr>

<tr>
<td class="prompting">Дата регистрации</td>
<td>
<?php echo (int)substr($this->user->time, 8, 2);?>
<?php
switch ((int)substr($this->user->time, 5, 2))
{
    case 1:
        ?> января <?php
    break;
    case 2:
        ?> февраля <?php
    break;
    case 3:
        ?> марта <?php
    break;
    case 4:
        ?> апреля <?php
    break;
    case 5:
        ?> мая <?php
    break;
    case 6:
        ?> июня <?php
    break;
    case 7:
        ?> июля <?php
    break;
    case 8:
        ?> августа <?php
    break;
    case 9:
        ?> сентября <?php
    break;
    case 10:
        ?> октября <?php
    break;
    case 11:
        ?> ноября <?php
    break;
    case 12:
        ?> декабря <?php
    break;
    
}
?>

<?php echo substr($this->user->time, 0, 4);?>
</td>
<td>
</td>
</tr>

<?php if (true)  { ?>
<tr>
<td class="prompting">Последнее посещение</td>
<td>
<?php echo $this->time_last_visit;?>
</td>
<td>
</td>
</tr>

<?php } ?>

</table>

<?php if (false) {?>
<ul>
<li><a href="/user/">Действие</a></li>
</ul>
<?php } ?>


</div>
<?php if ($this->request and Dune_Variables::$userStatus > 499) { ?>
<h3>Заявки пользователя на приобретение недвижимости</h3>
<?php
echo $this->request;
} ?>
<?php if ($this->no_auth) { ?>
<p><a href="/user/regorenter/">Авторизуйтесь</a>, чтобы общаться с пользователем  «<?php echo $this->user->name;?>»</p>
<?php } ?>
</div>
</div>
