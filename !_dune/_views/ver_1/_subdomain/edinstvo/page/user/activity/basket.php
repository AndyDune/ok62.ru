<div id="user-info-page">
<!-- ���� ����� -->
<table>
<tr>
<td><!-- ��. ������ ������ � ����� � ������������ -->
<div id="info-part">
<h1>�������� ������� ������������ <a href="/user/info/">�<?php echo $this->user->name;?>�</a></h1>

<p id="system-message"><?php echo $this->message;?></p>
<?php 
echo $this->data;
?>

</div>
</td><!-- ��. ����� ������ � ����� � ������������ -->


<td id="td-edit-panel-right">

<!-- ��� ��� �������������  -->
<?php echo $this->more_edit_menu;?>

<!-- /��� ��� �������������  -->

<td>
</tr></table>
<!-- ���� �����-->
</div>