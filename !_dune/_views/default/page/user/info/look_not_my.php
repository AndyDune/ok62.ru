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
</tr>

<tr>
<td class="prompting">��������� � �������</td>
<td>
<?php echo $this->user->name;?>
</td>
</tr>

<tr>
<td class="prompting">���������� ���</td>
<td>
<?php echo $this->user->contact_name;?>
</td>
</tr>


<?php
if ($this->user_info_allow->contact_surname_allow)
{
?>
<tr>
<td class="prompting">�.�.�.</td>
<td>
<?php echo $this->user->contact_surname;?>
</td>
</tr>
<?php
}
?>

<?php
if ($this->user_info_allow->mail_allow)
{
?>
<tr>
<td class="prompting">e-mail</td>
<td>
<?php echo $this->user->mail;?>
</td>
</tr>
<?php
}
?>


<?php
if ($this->user_info_allow->phone_allow)
{
?>
<tr>
<td class="prompting">�������</td>
<td>
<?php echo $this->user->phone;?>
</td>
</tr>
<?php
}
?>

<?php
if ($this->user_info_allow->icq_allow)
{
?>
<tr>
<td class="prompting">����� ICQ</td>
<td>
<?php echo $this->user->icq;?>
</td>
</tr>
<?php
}
?>

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


<tr>
<td class="prompting">���� ���������� ���������</td>
<td>
<?php echo $this->user->time;?>
</td>
<td>
</td>
</tr>


</table>

<ul>
<li><a href="/user/">��������</a></li>
</ul>

</div>
</td><!-- ��. ����� ������ � ����� � ������������ -->
<td>
<div id="user-activity-part">
<h1>����������</h1>
<table>

<tr>
<td class="prompting">�������� ���������� �� �������</td>
<td>
0
</td>

</tr>
<tr>
<td class="prompting">�������� ��������</td>
<td>
0
</td>
</tr>


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