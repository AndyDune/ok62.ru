<dl id="saler-short-info">
<dt>
��������� ������������:
</dt>
<dd>
<a href="/user/<?php echo $this->user_info->id; ?>/" title="����"><img src="<?php echo $this->view_folder; ?>/img/user/default.jpg" /></a>
</dd>
<dd>
<a href="/user/info/<?php echo $this->user_info->id; ?>/" title="������������ ��������"><?php echo $this->user_info->contact_name; ?></a>
<?php
// ����� �������
if ($this->user_info_allow->contact_surname)
{
?> <?php echo $this->user_info->contact_surname;
} ?>

<?php
// ����� ������ ���������� �����
if ($this->user_info_allow->phone) {?>
<dd>
�������: <?php echo $this->user_info->phone; ?>
</dd>
<?php } ?>

<?php
// ����� ������ ���������� �����
if ($this->user_info_allow->mail) {?>
<dd>
e-mail: <?php echo $this->user_info->mail; ?>
</dd>
<?php } ?>

</dl>