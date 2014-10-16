<div id="user-info-page">
<!-- Мега бегин -->
<table>
<tr>
<td><!-- Об. начало ячейки с инфой о пользователе -->
<div id="info-part">
<h1>Просмотр корзины пользователя <a href="/user/info/">«<?php echo $this->user->name;?>»</a></h1>

<p id="system-message"><?php echo $this->message;?></p>
<?php 
echo $this->data;
?>

</div>
</td><!-- Об. конец ячейки с инфой о пользователе -->


<td id="td-edit-panel-right">

<!-- Ещё что отредактируем  -->
<?php echo $this->more_edit_menu;?>

<!-- /Ещё что отредактируем  -->

<td>
</tr></table>
<!-- Мега конец-->
</div>