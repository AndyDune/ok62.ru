<?php
$okras = 1;
Dune_Static_StylesList::add('talk/base');
?>
<?php switch ($this->message_code) { 
case 3: ?>
<p id="system-message">В выбраной теме запрещено оставлять сообщения.</p>
<?php break; ?> 

<?php case 2: ?>
<p id="system-message">Слишком мало символов в сообщении. Рекомендуем от 3-х до 500 символов.</p>
<?php break; ?> 

<?php } ?>
<!--
<h3>Свободная тема для общения</h3>
-->
<table class="talk_topic_list">
<!--
<tr>
<th></th>
<th></th>
</tr>
-->

<?php 
$have_talk = false;
if (key_exists(1,  $this->topic_total_array_i))
{
    $params_i = $this->topic_total_array_i[1];
    $have_talk = true;
}
else 
    $params_i = array('read' => 1, 'count' => 0);

if (key_exists(1,  $this->topic_total_array_enemy))
{
    $params_enemy = $this->topic_total_array_enemy[1];
    $have_talk = true;
}
else 
    $params_enemy = array('read' => 1, 'count' => 0);
    
?>
<tr>
<td style="width:25px;">
<?php  
    $count = $params_enemy['count'] + $params_i['count'];
    if ($count > 5)
        $edge = '#edge';
    else 
        $edge = '';
    
if (!$params_enemy['read'])
{
    ?>
<a class="talk-status-message-new" href="<?php echo $this->url;?>topic_dif/<?php echo $edge?>" title="Новое сообщение"><span>новое</span></a>
<?php } else if ($count){?>    
<a class="talk-status-message-new-no" href="<?php echo $this->url;?>topic_dif/<?php echo $edge?>"  title="Нет новых сообщений"><span>нет новых</span></a>
<?php } else { ?>
<a class="talk-status-no-message-no" href="<?php echo $this->url;?>topic_dif/" title="Нет сообщений"><span>нет сообщений вообще</span></a>
<?php } ?>
    </td>
    
    <td class="text">
    <a href="<?php echo $this->url;?>topic_dif/<?php echo $edge?>" style="font-size:18px;">Общение</a>
    </td>
    
    </tr>

</table>



<?php if (count($this->list_sell_enemy)) { ?>


<?php
$array_i = array();
$array_enemy = array();
$array_no_one = array();
$current = 0;
foreach ($this->list_sell_enemy as $value)
{ 
$have_talk_enemy = false;
$have_talk_i = false;
if (key_exists($value['id'],  $this->topic_object_array_i))
{
    $params_i = $this->topic_object_array_i[$value['id']];
    unset($this->topic_object_array_i[$value['id']]);
    $have_talk_i = true;
}
else 
    $params_i = array('read' => 1, 'count' => 0);

if (key_exists($value['id'],  $this->topic_object_array_enemy))
{
    $params_enemy = $this->topic_object_array_enemy[$value['id']];
    unset($this->topic_object_array_enemy[$value['id']]);
    if (!($have_talk_i and $params_i['order'] > $params_enemy['order']))
        $have_talk_enemy = true;
}
else 
    $params_enemy = array('read' => -1, 'count' => 0);
    
if ($have_talk_enemy)
{
    $array_enemy[$params_enemy['order']] = $value;
    $array_enemy[$params_enemy['order']]['params_i'] = $params_i;
    $array_enemy[$params_enemy['order']]['params_enemy'] = $params_enemy;
}
else if ($have_talk_i)
{
    
/*    $array_i[$params_i['order']] = $value;
    $array_i[$params_i['order']]['params_i'] = $params_i;
    $array_i[$params_i['order']]['params_enemy'] = $params_enemy;
*/    
    $array_enemy[$params_i['order']] = $value;
    $array_enemy[$params_i['order']]['params_i'] = $params_i;
    $array_enemy[$params_i['order']]['params_enemy'] = $params_enemy;
    
}
else 
{
    $array_no_one[$current] = $value;
    $array_no_one[$current]['params_i'] = $params_i;
    $array_no_one[$current]['params_enemy'] = $params_enemy;
    $current++;
}
krsort($array_i);
krsort($array_enemy);
}

$count_in_float = 0;
?>

<h3>Объекты пользователя «<?php echo $this->user->name;?>»</h3>
<p>Всего объектов: <?php echo $this->count_result_array_sell_enemy ?></p>
<?php if (count($array_no_one) > 10 and !$this->show_all) { ?>
<p><a href="?show=all" >Показать все</a></p>
<?php } ?>

<?php foreach ($array_enemy as $value) {  ?>

<?php
$count_in_float++;
if ($count_in_float == 1)
{
  ?><div class="two-object-in-list"><?php  
}
?><div class="one-object-in-list">

<a href="/catalogue/type/<?php echo $value['type']; ?>/object/<?php echo $value['id']; ?>/" title="Подробная инфомация об объекте">
<?php
$module = new Module_File_Catalogue_PreviewOnly();
$module->size = 100;
$module->id = $value['id'];
$module->pics = $value['pics'];
$module->time = $value['time_insert'];
$module->make();
if ($module->getResult('preview')) {?>
<img src="<?php echo $module->getResult('preview');?>" height="100" width="100" />
<?php } else {?>
<img src="<?php echo $this->view_folder?>/img/house-100.png" height="100" width="100" />
<?php } ?>
</a>

<div class="one-object-in-list-text">

<?php 
    $count = $value['params_enemy']['count'] + $value['params_i']['count'];
    if ($count > 5)
        $edge = '#edge';
    else 
        $edge = '';
?>


<h4>
<a href="/catalogue/type/<?php echo $value['type']; ?>/object/<?php echo $value['id']; ?>/" title="Подробная инфомация об объекте">
<?php echo $value['name_type']; ?><br />
 <?php echo $value['name_settlement']; ?>
, <?php if ($value['street_adding']) { ?>улица <?php } echo $value['name_street']; ?>
<?php if ($value['house_number']) 
{ 
    ?>, дом&nbsp;<?php echo $value['house_number'];
}   ?>
<?php if ($value['building_number']) 
{ 
    ?>, корпус&nbsp;<?php echo $value['building_number'];
}   ?>
<?php if ($value['room'] and $value['type'] == 1) 
{ 
    ?>, квартира&nbsp;<?php echo $value['room'];
}  else if ($value['room']) { 
    ?>, номер&nbsp;<?php echo $value['room'];    
} ?>
</a>
</h4>

<p class="one-object-in-list-info">
<?php
if (!$value['params_enemy']['read'])
{ ?>
<a class="talk-status-message-new" href="/user/contact/user_<?php echo $this->interlocutor_id; ?>/topic_<?php echo $value['id']; ?>/<?php echo $edge?>" title="Новое сообщение"><span>новое</span></a>
<?php } else if ($count){?>    
<a class="talk-status-message-new-no" href="/user/contact/user_<?php echo $this->interlocutor_id; ?>/topic_<?php echo $value['id']; ?>/<?php echo $edge?>"  title="Нет новых сообщений"><span>нет новых</span></a>
<?php } else { ?>
<a class="talk-status-no-message-no" href="/user/contact/user_<?php echo $this->interlocutor_id; ?>/topic_<?php echo $value['id']; ?>/" title="Нет сообщений"><span>нет сообщений вообще</span></a>
<?php } ?>


<a href="/user/contact/user_<?php echo $this->interlocutor_id; ?>/topic_<?php echo $value['id']; ?>/<?php echo $edge?>"  class="one-object-in-list-more-info">
Обсуждение объекта
</a>
</p>


</div>
</div>
<?php
if ($count_in_float == 2)
{
  ?></div><?php  
  $count_in_float == 0;
}
else 
    $count_in_float++;

}
?>



<?php
// Блокируе слишком много на вывод
$count_max = 10;
$count_run = 0;
foreach ($array_no_one as $value) { 
    if ($count_run == $count_max and !$this->show_all)
    {
        break;
    }
    $count_run++;
     ?>

<?php
$count_in_float++;
if ($count_in_float == 1)
{
  ?><div class="two-object-in-list"><?php  
}
?><div class="one-object-in-list">

<a href="/catalogue/type/<?php echo $value['type']; ?>/object/<?php echo $value['id']; ?>/" title="Подробная инфомация об объекте">
<?php
$module = new Module_File_Catalogue_PreviewOnly();
$module->size = 100;
$module->id = $value['id'];
$module->pics = $value['pics'];
$module->time = $value['time_insert'];
$module->make();
if ($module->getResult('preview')) {?>
<img src="<?php echo $module->getResult('preview');?>" height="100" width="100" />
<?php } else {?>
<img src="<?php echo $this->view_folder?>/img/house-100.png" height="100" width="100" />
<?php } ?>
</a>

<div class="one-object-in-list-text">

<?php 
    $count = $value['params_enemy']['count'] + $value['params_i']['count'];
    if ($count > 5)
        $edge = '#edge';
    else 
        $edge = '';
?>


<h4>
<a href="/catalogue/type/<?php echo $value['type']; ?>/object/<?php echo $value['id']; ?>/" title="Подробная инфомация об объекте">
<?php echo $value['name_type']; ?><br />
 <?php echo $value['name_settlement']; ?>
, <?php if ($value['street_adding']) { ?>улица <?php } echo $value['name_street']; ?>
<?php if ($value['house_number']) 
{ 
    ?>, дом&nbsp;<?php echo $value['house_number'];
}   ?>
<?php if ($value['building_number']) 
{ 
    ?>, корпус&nbsp;<?php echo $value['building_number'];
}   ?>
<?php if ($value['room'] and $value['type'] == 1) 
{ 
    ?>, квартира&nbsp;<?php echo $value['room'];
}  else if ($value['room']) { 
    ?>, номер&nbsp;<?php echo $value['room'];    
} ?>
</a>
</h4>

<p class="one-object-in-list-info">
<?php
if (!$value['params_enemy']['read'])
{ ?>
<a class="talk-status-message-new" href="/user/contact/user_<?php echo $this->interlocutor_id; ?>/topic_<?php echo $value['id']; ?>/<?php echo $edge?>" title="Новое сообщение"><span>новое</span></a>
<?php } else if ($count){?>    
<a class="talk-status-message-new-no" href="/user/contact/user_<?php echo $this->interlocutor_id; ?>/topic_<?php echo $value['id']; ?>/<?php echo $edge?>"  title="Нет новых сообщений"><span>нет новых</span></a>
<?php } else { ?>
<a class="talk-status-no-message-no" href="/user/contact/user_<?php echo $this->interlocutor_id; ?>/topic_<?php echo $value['id']; ?>/" title="Нет сообщений"><span>нет сообщений вообще</span></a>
<?php } ?>


<a href="/user/contact/user_<?php echo $this->interlocutor_id; ?>/topic_<?php echo $value['id']; ?>/<?php echo $edge?>"  class="one-object-in-list-more-info">
Обсуждение объекта
</a>
</p>


</div>
</div>

<?php
if ($count_in_float == 2)
{
  ?></div><?php  
  $count_in_float == 0;
}
else 
    $count_in_float++;
    
}


if ($count_in_float)
{
  ?></div><?php  
}

?>


<?php } ?>




<?php if (count($this->list_sell_i)) { ?>
<?php
$array_i = array();
$array_enemy = array();
$array_no_one = array();
$current = 0;
foreach ($this->list_sell_i as $value)
{ 
$have_talk_enemy = false;
$have_talk_i = false;
if (key_exists($value['id'],  $this->topic_object_array_i))
{
    $params_i = $this->topic_object_array_i[$value['id']];
    unset($this->topic_object_array_i[$value['id']]);
    $have_talk_i = true;
}
else 
    $params_i = array('read' => 1, 'count' => 0);

if (key_exists($value['id'],  $this->topic_object_array_enemy))
{
    $params_enemy = $this->topic_object_array_enemy[$value['id']];
    unset($this->topic_object_array_enemy[$value['id']]);
    if (!($have_talk_i and $params_i['order'] > $params_enemy['order']))
        $have_talk_enemy = true;
}
else 
    $params_enemy = array('read' => -1, 'count' => 0);
    
if ($have_talk_enemy)
{
    $array_enemy[$params_enemy['order']] = $value;
    $array_enemy[$params_enemy['order']]['params_i'] = $params_i;
    $array_enemy[$params_enemy['order']]['params_enemy'] = $params_enemy;
}
else if ($have_talk_i)
{
    
/*    $array_i[$params_i['order']] = $value;
    $array_i[$params_i['order']]['params_i'] = $params_i;
    $array_i[$params_i['order']]['params_enemy'] = $params_enemy;
*/    
    $array_enemy[$params_i['order']] = $value;
    $array_enemy[$params_i['order']]['params_i'] = $params_i;
    $array_enemy[$params_i['order']]['params_enemy'] = $params_enemy;
    
}
else 
{
    $array_no_one[$current] = $value;
    $array_no_one[$current]['params_i'] = $params_i;
    $array_no_one[$current]['params_enemy'] = $params_enemy;
    $current++;
}
krsort($array_i);
krsort($array_enemy);
}
$count_in_float = 0;
?>



<h3>Мои объекты</h3>
<p>Всего объектов: <?php echo $this->count_result_array_sell_i ?></p>
<?php if (count($array_no_one) > 10 and !$this->show_all) { ?>
<p><a href="?show=all" >Показать все</a></p>
<?php } ?>



<?php foreach ($array_enemy as $value) {  ?>

<?php
$count_in_float++;
if ($count_in_float == 1)
{
  ?><div class="two-object-in-list"><?php  
}
?><div class="one-object-in-list">

<a href="/catalogue/type/<?php echo $value['type']; ?>/object/<?php echo $value['id']; ?>/" title="Подробная инфомация об объекте">
<?php
$module = new Module_File_Catalogue_PreviewOnly();
$module->size = 100;
$module->id = $value['id'];
$module->pics = $value['pics'];
$module->time = $value['time_insert'];
$module->make();
if ($module->getResult('preview')) {?>
<img src="<?php echo $module->getResult('preview');?>" height="100" width="100" />
<?php } else {?>
<img src="<?php echo $this->view_folder?>/img/house-100.png" height="100" width="100" />
<?php } ?>
</a>

<div class="one-object-in-list-text">

<?php 
    $count = $value['params_enemy']['count'] + $value['params_i']['count'];
    if ($count > 5)
        $edge = '#edge';
    else 
        $edge = '';
?>


<h4>
<a href="/catalogue/type/<?php echo $value['type']; ?>/object/<?php echo $value['id']; ?>/" title="Подробная инфомация об объекте">
<?php echo $value['name_type']; ?><br />
 <?php echo $value['name_settlement']; ?>
, <?php if ($value['street_adding']) { ?>улица <?php } echo $value['name_street']; ?>
<?php if ($value['house_number']) 
{ 
    ?>, дом&nbsp;<?php echo $value['house_number'];
}   ?>
<?php if ($value['building_number']) 
{ 
    ?>, корпус&nbsp;<?php echo $value['building_number'];
}   ?>
<?php if ($value['room'] and $value['type'] == 1) 
{ 
    ?>, квартира&nbsp;<?php echo $value['room'];
}  else if ($value['room']) { 
    ?>, номер&nbsp;<?php echo $value['room'];    
} ?>
</a>
</h4>

<p class="one-object-in-list-info">
<?php
if (!$value['params_enemy']['read'])
{ ?>
<a class="talk-status-message-new" href="/user/contact/user_<?php echo $this->interlocutor_id; ?>/topic_<?php echo $value['id']; ?>/<?php echo $edge?>" title="Новое сообщение"><span>новое</span></a>
<?php } else if ($count){?>    
<a class="talk-status-message-new-no" href="/user/contact/user_<?php echo $this->interlocutor_id; ?>/topic_<?php echo $value['id']; ?>/<?php echo $edge?>"  title="Нет новых сообщений"><span>нет новых</span></a>
<?php } else { ?>
<a class="talk-status-no-message-no" href="/user/contact/user_<?php echo $this->interlocutor_id; ?>/topic_<?php echo $value['id']; ?>/" title="Нет сообщений"><span>нет сообщений вообще</span></a>
<?php } ?>


<a href="/user/contact/user_<?php echo $this->interlocutor_id; ?>/topic_<?php echo $value['id']; ?>/<?php echo $edge?>"  class="one-object-in-list-more-info">
Обсуждение объекта
</a>
</p>


</div>
</div>
<?php
if ($count_in_float == 2)
{
  ?></div><?php  
  $count_in_float == 0;
}
else 
    $count_in_float++;
}
?>


<?php
// Блокируе слишком много на вывод
$count_max = 10;
$count_run = 0;
foreach ($array_no_one as $value) { 
    if ($count_run == $count_max and !$this->show_all)
    {
        break;
    }
    $count_run++;
     ?>

<?php
$count_in_float++;
if ($count_in_float == 1)
{
  ?><div class="two-object-in-list"><?php  
}
?><div class="one-object-in-list">

<a href="/catalogue/type/<?php echo $value['type']; ?>/object/<?php echo $value['id']; ?>/" title="Подробная инфомация об объекте">
<?php
$module = new Module_File_Catalogue_PreviewOnly();
$module->size = 100;
$module->id = $value['id'];
$module->pics = $value['pics'];
$module->time = $value['time_insert'];
$module->make();
if ($module->getResult('preview')) {?>
<img src="<?php echo $module->getResult('preview');?>" height="100" width="100" />
<?php } else {?>
<img src="<?php echo $this->view_folder?>/img/house-100.png" height="100" width="100" />
<?php } ?>
</a>

<div class="one-object-in-list-text">

<?php 
    $count = $value['params_enemy']['count'] + $value['params_i']['count'];
    if ($count > 5)
        $edge = '#edge';
    else 
        $edge = '';
?>


<h4>
<a href="/catalogue/type/<?php echo $value['type']; ?>/object/<?php echo $value['id']; ?>/" title="Подробная инфомация об объекте">
<?php echo $value['name_type']; ?><br />
 <?php echo $value['name_settlement']; ?>
, <?php if ($value['street_adding']) { ?>улица <?php } echo $value['name_street']; ?>
<?php if ($value['house_number']) 
{ 
    ?>, дом&nbsp;<?php echo $value['house_number'];
}   ?>
<?php if ($value['building_number']) 
{ 
    ?>, корпус&nbsp;<?php echo $value['building_number'];
}   ?>
<?php if ($value['room'] and $value['type'] == 1) 
{ 
    ?>, квартира&nbsp;<?php echo $value['room'];
}  else if ($value['room']) { 
    ?>, номер&nbsp;<?php echo $value['room'];    
} ?>
</a>
</h4>

<p class="one-object-in-list-info">
<?php
if (!$value['params_enemy']['read'])
{ ?>
<a class="talk-status-message-new" href="/user/contact/user_<?php echo $this->interlocutor_id; ?>/topic_<?php echo $value['id']; ?>/<?php echo $edge?>" title="Новое сообщение"><span>новое</span></a>
<?php } else if ($count){?>    
<a class="talk-status-message-new-no" href="/user/contact/user_<?php echo $this->interlocutor_id; ?>/topic_<?php echo $value['id']; ?>/<?php echo $edge?>"  title="Нет новых сообщений"><span>нет новых</span></a>
<?php } else { ?>
<a class="talk-status-no-message-no" href="/user/contact/user_<?php echo $this->interlocutor_id; ?>/topic_<?php echo $value['id']; ?>/" title="Нет сообщений"><span>нет сообщений вообще</span></a>
<?php } ?>


<a href="/user/contact/user_<?php echo $this->interlocutor_id; ?>/topic_<?php echo $value['id']; ?>/<?php echo $edge?>"  class="one-object-in-list-more-info">
Обсуждение объекта
</a>
</p>


</div>
</div>

<?php
if ($count_in_float == 2)
{
  ?></div><?php  
  $count_in_float == 0;
}
else 
    $count_in_float++;
    
}

if ($count_in_float)
{
  ?></div><?php  
}

?>

<?php } ?>
<div style="clear:both">&nbsp;</div>













