<div id="user-info-page">
<!-- ћега бегин -->
<table>
<tr>
<td><!-- ќб. начало €чейки с инфой о пользователе -->
<div id="info-part">
<h1>ќбъекты, продаваемые пользователем <a href="/user/info/">Ђ<?php echo $this->user->name;?>ї</a></h1>

<p id="system-message"><?php echo $this->message;?></p>
<?php 
echo $this->data;
?>

</div>
</td><!-- ќб. конец €чейки с инфой о пользователе -->


<td>

<!-- ≈щЄ что отредактируем  -->
<?php echo $this->more_edit_menu;?>

<!-- /≈щЄ что отредактируем  -->

<td>
</tr></table>
<!-- ћега конец-->
</div>