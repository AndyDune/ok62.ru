<h1>�������� � ���� ������</h1>
<ul class="class-add-links">
<li></li>
</ul>
<?php 
if (is_int($this->count))
{
    ?><hr /><p>��������� �����: <strong><?php echo $this->count; ?></strong><?php 
if (is_int($this->count_success))
{
    ?> �������: <strong><?php echo $this->count_success; ?></strong></p><?php
}
?></p><?php
}
?>
<hr />
<table>


<tr>
<form method="post">
<input type="hidden" name="_do_" value="reset_have_situa_zero" />

<td>
����� ����� ���������� ������������� �����:
</td>
<td>
<input type="submit" name="go" value="����!">
</td>
<td>
&nbsp;
</td>

</form>
</tr>


<tr>
<form method="post">
<input type="hidden" name="_do_" value="object_remont" />

<td>
������ ������ ������� :
<input type="text" name="id" value="" size="5" />
</td>
<td>
<input type="submit" name="go" value="����!">
</td>
<td>
&nbsp;
</td>

</form>
</tr>



<tr>
<form method="post">
<input type="hidden" name="_do_" value="reset_district_plus" />
<td>
����� ��������������� �������:
</td>
<td>
<input type="submit" name="go" value="����!">
</td>
<td>
&nbsp;
</td>

</form>
</tr>


<tr>
<form method="post">
<input type="hidden" name="_do_" value="set_district_plus" />

<td>
����������� ������ ��� ������� �� �����������:
</td>
<td>
<input type="submit" name="go" value="����!">
</td>

<td>
 ��������� �������: 
<input type="text" name="limit" value="50" size="3" />
������� �: 
<input type="text" name="shift" value="0" size="3" />

</td>
</form>
</tr>




<tr>
<form method="post">
<input type="hidden" name="_do_" value="sub_house_to_edit" />

<td>
���������� ���� ������� ���������� � ����:
</td>
<td>
<input type="submit" name="go" value="����!">
</td>
<td>
&nbsp;
</td>

</form>
</tr>






</table>

