
<div id="users-list">
<h3>��� ���������</h3>

<?php if (count($this->list)) { ?>
<table id="users-list">
<?php foreach ($this->list as $value) {
    
    if ($value['name_user_contact'])
        $name = $value['name_user_contact'];
    else 
        $name = $value['name_user'];
        
    if (!$value['topic_code'])
        $topic = $value['topic_id'];
    else 
        $topic = 'dif';
    
    
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
<p class="p-general-info"><a class="user-link" href="/user/info/<?php echo $value['user_id']; ?>/"><?php echo $value['name_user'];  ?></a></p>
<p>
<?php
if (!$value['read'])
{
    ?>
<a class="talk-status-message-new" href="/user/contact/user_<?php echo $value['user_id'] ?>/topic_<?php echo $topic; ?>/#edge" title="����� ���������"><span>�����</span></a>

<?php } else {?>    
<a class="talk-status-message-new-no" href="/user/contact/user_<?php echo $value['user_id'] ?>/topic_<?php echo $topic; ?>/#edge"  title="��� ����� ���������"><span>��� �����</span></a>
<?php } ?>


&nbsp; <a href="/user/contact/user_<?php echo $value['user_id'] ?>/topic_<?php echo $topic; ?>/#edge">������ ���������</a></p>
&nbsp;<p>�������:
<?php echo (int)substr($value['time'], 8, 2);?>
<?php
switch ((int)substr($value['time'], 5, 2))
{
    case 1:
        ?> ������ <?php
    break;
    case 2:
        ?> ������� <?php
    break;
    case 3:
        ?> ����� <?php
    break;
    case 4:
        ?> ������ <?php
    break;
    case 5:
        ?> ��� <?php
    break;
    case 6:
        ?> ���� <?php
    break;
    case 7:
        ?> ���� <?php
    break;
    case 8:
        ?> ������� <?php
    break;
    case 9:
        ?> �������� <?php
    break;
    case 10:
        ?> ������� <?php
    break;
    case 11:
        ?> ������ <?php
    break;
    case 12:
        ?> ������� <?php
    break;
    
}
?>

<?php echo substr($value['time'], 0, 4);?>, <?php echo substr($value['time'], 11) ?>


</td>
</tr>
<?php } ?>

</table>
<hr />
<?php echo $this->navigator; ?>

<?php } else{?>
���
<?php } ?>


</div>
