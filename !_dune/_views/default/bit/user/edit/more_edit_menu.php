<div id="user-activity-part"> 
<h1>��� ��������������</h1>
        <table>
        
<?php if ($this->current != 'changepassword') { ?>        
        <tr><td>
        <a href="/user/changepassword/">����� ������</a>
        </td></tr>
<?php } else {?>
        <tr><td>
        <span>����� ������</span>
        </td></tr>
<?php } ?>


<?php if ($this->current != 'edit') { ?>
        <tr><td>
        <a href="/user/edit/">���������� � ������������</a>
        </td></tr>
<?php } else {?>
        <tr><td>
        <span>���������� � ������������</span>
        </td></tr>

<?php } ?>


<?php if ($this->current != 'basket' and $this->have_basket) { ?>
        <tr><td>
        <a href="/user/basket/">�������</a>
        </td></tr>
<?php } else {?>
        <tr><td>
        <span>�������</span>
        </td></tr>

<?php } ?>

<?php if ($this->current != 'salelist') { ?>
        <tr><td>
        <a href="/user/salelist/">������� ������������</a>
        </td></tr>
<?php } else {?>
        <tr><td>
        <span>������� ������������</span>
        </td></tr>
<?php } ?>


        </table>
</div>