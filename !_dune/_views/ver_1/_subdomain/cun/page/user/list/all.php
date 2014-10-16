
<h3>Все пользователи</h3>
<ul id="ul-users-list-sort">
<li class="li-no-info"><span>Сортировка:</span></li>
<li<?php
if (!$this->order or $this->order == 'name')
{
    ?> class="current"<?php
}
?>><a href="/user/list/order_name/?page=0">По имени</a></li>
<li<?php
if ($this->order == 'time')
{
    ?> class="current"<?php
}
?>><a href="/user/list/order_time/?page=0">По времени последнего посещения</a></li>
</ul>
<?php if (count($this->list)) { ?>
<table id="users-list">
<?php foreach ($this->list as $value) {
    if ($this->user_id and $this->user_id == $value['id'] and false)
        continue;
    ?>
<tr>
<td class="td-avatara">
<a class="user-link" href="/user/info/<?php echo $value['id']; ?>/">
<img src="<?php
if (isset($value['photo_preview']) and $value['photo_preview'])
{
    echo $value['photo_preview'];
}
else 
{
    echo $this->view_folder; ?>/img/user/avatars/first-50.gif<?php
}
 ?>" width="50" height="50" />
</a>
</td>

<td class="td-text">
<?php
if ($value['contact_name'])
    $add_name = ' (' . $value['contact_name'] . ')';
else 
    $add_name = '';
?>
<p class="p-general-info"><a class="user-link" href="/user/info/<?php echo $value['id']; ?>/"><?php echo $value['name'], $add_name;  ?></a></p>
<p>Дата регистрации:
<?php echo (int)substr($value['time'], 8, 2);?>
<?php
switch ((int)substr($value['time'], 5, 2))
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

<?php echo substr($value['time'], 0, 4);?>



, последнее посещение: <?php echo $value['time_last_visit']?> </p>

</td>
</tr>
<?php } ?>

</table>
<hr />
<?php echo $this->navigator; ?>

<?php } else{?>
нет
<?php } ?>

