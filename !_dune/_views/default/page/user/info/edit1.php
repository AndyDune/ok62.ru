<div id="user-info-page">
<!-- ���� ����� -->
<table>

<tr>
<th class="object-prompting"></th>
<th>
��������
</th>
</th>
<th>��������</th>
</tr>



<tr>
<td class="object-prompting">�����</td>
<td>
<?php echo $this->user->name;?>
</td>
<td>-</td>
</tr>

<tr>
<td class="object-prompting">���������� ���</td>
<td>
<?php echo $this->user->contact_name;?>
</td>
<td>-</td>
</tr>


<tr>
<td class="object-prompting">�������</td>
<td>
<?php echo $this->user->contact_surname;?>
</td>
<td>

<input type="checkbox" name="contact_surname_allow" checked="checked" /> 
</td>
</tr>



</table>

<!-- ���� �����-->
</div>