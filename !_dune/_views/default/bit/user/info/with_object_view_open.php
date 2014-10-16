<dl id="saler-short-info">
<dt>
Разместил пользователь:
</dt>
<dd>
<a href="/user/<?php echo $this->user_info->id; ?>/" title="Фото"><img src="<?php echo $this->view_folder; ?>/img/user/default.jpg" /></a>
</dd>
<dd>
<a href="/user/info/<?php echo $this->user_info->id; ?>/" title="Персональная страница"><?php echo $this->user_info->contact_name; ?></a>
<?php
// Показ фамилии
if ($this->user_info_allow->contact_surname)
{
?> <?php echo $this->user_info->contact_surname;
} ?>

<?php
// Показ адреса электроной почты
if ($this->user_info_allow->phone) {?>
<dd>
Телефон: <?php echo $this->user_info->phone; ?>
</dd>
<?php } ?>

<?php
// Показ адреса электроной почты
if ($this->user_info_allow->mail) {?>
<dd>
e-mail: <?php echo $this->user_info->mail; ?>
</dd>
<?php } ?>

</dl>