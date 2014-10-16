
<div id="info-part">

<h3>Информация о пользователе «<?php echo $this->user->name;?>»</h3>
<div id="user-main-info">
      <?php
      if ($this->array_photo)
      {
          ?><a class="thickbox user-pic-i" href="<?php echo $this->array_photo[1] ?>"><img src="<?php
        echo $this->array_photo[2];
        ?>" width="100" height="100" /></a><?php
      }
      else 
      {
        ?><img class="user-pic-i" src="<?php echo $this->view_folder;?>/img/user/avatars/first.gif" width="100" height="100" /><?
      }
      ?>

<div class="user-main-info-table"><div>
<table>

<tr>
<th class="prompting"></th>
<th>
</th>
<th>Отображать на сайте</th>
</tr>

<tr>
<td class="prompting"><strong>Псевдоним в системе</strong></td>
<td>
<?php echo $this->user->name;?>
</td>
<td class="td-shot">-</td>
</tr>

<tr>
<td class="prompting"><strong>Контактное имя</strong></td>
<td>
<?php echo $this->user->contact_name;?>
</td>
<td class="td-shot">-</td>
</tr>

<?php if (false) { ?> 
<tr>
<td class="prompting"><strong>Поное имя (Ф.И.О.)</strong></td>
<td>
<?php echo $this->user->contact_surname;?>
</td>
<td class="td-shot">
<?php if ($this->user_info_allow->contact_surname_allow) { ?>ДА<?php } else { ?>НЕТ<?php }
?>
</td>
</tr>
<?php } ?>


<tr>
<td class="prompting"><strong>e-mail</strong></td>
<td><a href="mailto:<?php echo $this->user->mail;?>">
<?php echo $this->user->mail;?>
</a></td>
<td class="td-shot">
<?php if ($this->user_info_allow->mail_allow) { ?>ДА<?php } else { ?>НЕТ<?php }
?>
</td>
</tr>


<tr>
<td class="prompting"><strong>Телефон</strong></td>
<td>
<?php echo $this->user->phone;?>
</td>
<td class="td-shot">
<?php if ($this->user_info_allow->phone_allow) { ?>ДА<?php } else { ?>НЕТ<?php }
?>
</td>
</tr>

<tr>
<td class="prompting"><strong>Номер ICQ</strong></td>
<td>
<?php echo $this->user->icq;?>
</td>
<td class="td-shot">
<?php if ($this->user_info_allow->icq_allow) { ?>ДА<?php } else { ?>НЕТ<?php }
?>
</td>
</tr>


<?php if ($this->user->getUserArrayCell('about_me')) { ?>
<tr><td>
<strong>О себе</strong></td>
<td>
<?php
$str = new Dune_String_Transform($this->user->getUserArrayCell('about_me'));
echo $str->deleteLineFeed(2)->setLineFeedToBreak()->getResult();
//echo $this->user->getUserArrayCell('about_me');
?>
</td><td></td></tr>
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
<?php echo substr($this->user->time, 0, 10);?>
</td>
<td>
</td>
</tr>


</table>

</div>
</div>
</div>