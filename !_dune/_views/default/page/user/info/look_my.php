<div id="user-info-page">
<!-- ���� ����� -->

<table>
<tr>
<td><!-- ��. ������ ������ � ����� � ������������ -->
<div id="info-part">
<h1>���������� � ������������ �<?php echo $this->user->name;?>�</h1>

<h2>��������</h2>
<table>

<tr>
<th class="prompting"></th>
<th>
</th>
<th>��������</th>
</tr>

<tr>
<td class="prompting">��������� � �������</td>
<td>
<?php echo $this->user->name;?>
</td>
<td class="td-shot">-</td>
</tr>

<tr>
<td class="prompting">���������� ���</td>
<td>
<?php echo $this->user->contact_name;?>
</td>
<td class="td-shot">-</td>
</tr>


<tr>
<td class="prompting">�������</td>
<td>
<?php echo $this->user->contact_surname;?>
</td>
<td class="td-shot">
<?php if ($this->user_info_allow->contact_surname_allow) { ?>��<?php } else { ?>���<?php }
?>
</td>
</tr>

<tr>
<td class="prompting">e-mail</td>
<td>
<?php echo $this->user->mail;?>
</td>
<td class="td-shot">
<?php if ($this->user_info_allow->mail_allow) { ?>��<?php } else { ?>���<?php }
?>
</td>
</tr>


<tr>
<td class="prompting">�������</td>
<td>
<?php echo $this->user->phone;?>
</td>
<td class="td-shot">
<?php if ($this->user_info_allow->phone_allow) { ?>��<?php } else { ?>���<?php }
?>
</td>
</tr>


<tr>
<td class="prompting">����� ICQ</td>
<td>
<?php echo $this->user->icq;?>
</td>
<td class="td-shot">
<?php if ($this->user_info_allow->icq_allow) { ?>��<?php } else { ?>���<?php }
?>
</td>
</tr>

</table>

<h2>�������������</h2>
<table>

<tr>
<th class="prompting"></th>
<th>

</th>
<th></th>
</tr>

<tr>
<td class="prompting">���� �����������</td>
<td>
<?php echo $this->user->time;?>
</td>
<td>
</td>
</tr>


</table>

<ul>
<li><a href="/user/edit/">�������������</a></li>
<li><a href="/user/changepassword/">������� ������</a></li>
<li><a href="/user/enter/exittotal/">����� ���� �������</a></li>
</ul>

</div>
</td><!-- ��. ����� ������ � ����� � ������������ -->
<td>
<div id="user-activity-part">
<h1>����������</h1>
<table>

<?php if ($this->objects_in_busket) {?>
<tr>
<td class="prompting"><a href="/user/basket/">�������� � �������</a></td>
<td>
<a href="/user/basket/"><?php echo $this->objects_in_busket; ?></a>
</td>
<?php } ?>

<?php if ($this->objects_in_sale) {?>
<tr>
<td class="prompting"><a href="/user/salelist/">�������� ���������</a></td>
<td>
<a href="/user/salelist/"><?php echo $this->objects_in_sale; ?></a>
</td>
<?php } ?>


</tr>
<tr>
<td class="prompting">������������</td>
<td>
0
</td>
</tr>


</table>


</div>
<td>
</tr></table>
<!-- ���� �����-->
</div>